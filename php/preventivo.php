<?php

include_once("php/connect.php");
require_once("user.php");

class Preventivo
{
    
    private int $id;
    private Annuncio $annuncio;
    private int $compenso;
    private string $descrizione;
    private bool $accettato      = false;
    private bool $pagato         = false;
    private bool $recensito         = false;
    private $timestamp;
    private Professionista $professionista;

    public function getId()      { return $this->id;    }
    public function getAnnuncio()        { return $this->annuncio;      }
    public function getCompenso()        { return $this->compenso;      }
    public function getDescrizione()     { return $this->descrizione;   }
    public function isRecensito()        { return $this->recensito;     }
    public function isAccettato()       { return $this->accettato;     }
    public function isPagato()          { return $this->pagato;        }
    public function getTimestamp()       { return $this->timestamp;     }
    public function getProfessionista()  { return $this->professionista;}

    public function __construct(Annuncio& $annuncio, $idservizio) {

        $this->annuncio = $annuncio;
        $this->id = $idservizio;
        global $conn;

        $query = $conn->prepare(
            "SELECT s.*, r.idrecensione
                FROM servizio as s LEFT JOIN recensione r ON r.idservizio    = s.idservizio, utente u 
                WHERE s.idservizio  = ?
                AND u.idutente = s.idprofessionista"
        );
        $query->bind_param('i', $this->id);
        $query->execute();
        $res = $query->get_result();
        // var_dump($res, $idservizio);
        if($preventivo = $res->fetch_assoc()) {
            // var_dump($preventivo);
            $this->id               = $preventivo["idservizio"];
            $this->professionista   = Professionista::withID((int)$preventivo["idprofessionista"]);
            $this->compenso         = $preventivo["compenso"];
            $this->descrizione      = $preventivo["descrizione"];
            $this->timestamp        = $preventivo["timestamp"];


            $this->accettato        = isset($preventivo["accettato"]) && (bool)$preventivo["accettato"];
            $this->pagato           = isset($preventivo["pagato"])    && (bool)$preventivo["pagato"];
            $this->recensito        = isset($preventivo["idrecensione"]);
        }

        // var_dump($this);
    }

    public static function withID($idservizio){
        global $conn;
        $query = $conn->prepare(
            "SELECT s.idannuncio
                FROM servizio as s INNER JOIN annuncio a ON a.idannuncio = s.idannuncio
                WHERE s.idservizio  = ?"
        );
        $query->bind_param('i', $idservizio);
        $query->execute();
        $res = $query->get_result();
        // var_dump($res);
        if($idannuncio = $res->fetch_assoc()) {
            // var_dump($preventivo);
            $annuncio = new Annuncio($idannuncio);
            return new self($annuncio, $idservizio);
        }
        return null;  

    }

    public static function creaPreventivo($idprofessionista, $idannuncio, int $compenso, string $descrizione): bool{
        global $conn;
        // var_dump($idprofessionista, $idannuncio, $compenso, $descrizione);
        $query = $conn->prepare("INSERT INTO servizio(idprofessionista, idannuncio, compenso, descrizione) VALUES(?, ?, ?, ?)");
        $query->bind_param(
            "iiis",
            $idprofessionista,
            $idannuncio,
            $compenso,
            $descrizione
        );
        return $query->execute();
    }

    public function aggiorna($compenso, $descrizione): bool{
        global $conn;

        $query = $conn->prepare("UPDATE servizio
                                SET compenso = ?, descrizione = ?
                                WHERE idservizio={$this->id}");
        $query->bind_param(
            "is",
            $compenso,
            $descrizione
        );
        return  $query->execute();
    }

    public function elimina($idprofessionista): bool{
        global $conn;

        $query = $conn->prepare("DELETE FROM servizio WHERE idservizio={$this->id} AND idprofessionista={$idprofessionista}");
        return  $query->execute();
    }

    public function accetta(): bool{
        global $conn;

        $query = $conn->prepare("UPDATE servizio
                                SET accettato = true
                                WHERE idservizio={$this->id}");
        return  $query->execute();
    }

    public function rifiuta(): bool{
        global $conn;

        $query = $conn->prepare("UPDATE servizio
                                SET accettato = false
                                WHERE idservizio={$this->id}");
        return  $query->execute();
    }

    public function paga(): bool{
        global $conn;

        $query = $conn->prepare("UPDATE servizio
                                SET pagato = true
                                WHERE idservizio={$this->id}");
        return $query->execute();
    }

    public function creaFattura(){
        require_once("pdf.php");
        
        $pdf = initPdf($this->annuncio, $this);
        
    } 

    public function __toString(){
        return "
            Inserzionista: {$this->professionista->GetNome()} {$this->professionista->getCognome()}
            Descrizione: {$this->descrizione}
            Compenso: {$this->compenso}
            Totale: {$this->compenso}
        ";
    }
}
