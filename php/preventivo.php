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

    private int $idRecensione;

    public function getId()      { return $this->id;    }
    public function getAnnuncio()        { return $this->annuncio;      }
    public function getCompenso()        { return $this->compenso;      }
    public function getDescrizione()     { return $this->descrizione;   }
    public function isRecensito()        { return $this->recensito;     }
    public function isAccettato()       { return $this->accettato;     }
    public function isPagato()          { return $this->pagato;        }
    public function getTimestamp()       { return $this->timestamp;     }
    public function getProfessionista()  { return $this->professionista;}

    public function getIdRecensione(){ return $this->isRecensito()? $this->idRecensione: false;}

    public function __construct(Annuncio& $annuncio, $idpreventivo) {

        $this->annuncio = $annuncio;
        $this->id = $idpreventivo;
        global $conn;

        $query = $conn->prepare(
            "SELECT s.*, r.idrecensione
                FROM preventivo as s LEFT JOIN recensione r ON r.idpreventivo    = s.idpreventivo, utente u 
                WHERE s.idpreventivo  = ?
                AND u.idutente = s.idprofessionista"
        );
        $query->bind_param('i', $this->id);
        $query->execute();
        $res = $query->get_result();
        // var_dump($res, $idpreventivo);
        if($preventivo = $res->fetch_assoc()) {
            // var_dump($preventivo);
            $this->id               = $preventivo["idpreventivo"];
            $this->professionista   = Professionista::withID((int)$preventivo["idprofessionista"]);
            $this->compenso         = $preventivo["compenso"];
            $this->descrizione      = $preventivo["descrizione"];
            $this->timestamp        = $preventivo["timestamp"];


            $this->accettato        = isset($preventivo["accettato"]) && (bool)$preventivo["accettato"];
            $this->pagato           = isset($preventivo["pagato"])    && (bool)$preventivo["pagato"];
            $this->recensito        = isset($preventivo["idrecensione"]);
            if(isset($preventivo["idrecensione"])){
                $this->idRecensione       = $preventivo["idrecensione"];
            }
        }

        // var_dump($this);
    }

    public static function withID($idpreventivo){
        global $conn;
        $query = $conn->prepare(
            "SELECT s.idannuncio
                FROM preventivo as s INNER JOIN annuncio a ON a.idannuncio = s.idannuncio
                WHERE s.idpreventivo  = ?"
        );
        $query->bind_param('i', $idpreventivo);
        $query->execute();
        $res = $query->get_result();
        // var_dump($res);
        if($idannuncio = $res->fetch_assoc()) {
            // var_dump($preventivo);
            $annuncio = new Annuncio($idannuncio);
            return new self($annuncio, $idpreventivo);
        }
        return null;  

    }

    public static function crea($idprofessionista, $idannuncio, int $compenso, string $descrizione): bool{
        global $conn;
        // var_dump($idprofessionista, $idannuncio, $compenso, $descrizione);
        $query = $conn->prepare("INSERT INTO preventivo(idprofessionista, idannuncio, compenso, descrizione) VALUES(?, ?, ?, ?)");
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

        $query = $conn->prepare("UPDATE preventivo
                                SET compenso = ?, descrizione = ?
                                WHERE idpreventivo={$this->id}");
        $query->bind_param(
            "is",
            $compenso,
            $descrizione
        );
        return  $query->execute();
    }

    public function elimina($idprofessionista): bool{
        global $conn;

        $query = $conn->prepare("DELETE FROM preventivo WHERE idpreventivo={$this->id} AND idprofessionista={$idprofessionista}");
        return  $query->execute();
    }

    public function accetta(): bool{
        global $conn;

        $query = $conn->prepare("UPDATE preventivo
                                SET accettato = true
                                WHERE idpreventivo={$this->id}");
        return  $query->execute();
    }

    public function rifiuta(): bool{
        global $conn;

        $query = $conn->prepare("UPDATE preventivo
                                SET accettato = false
                                WHERE idpreventivo={$this->id}");
        return  $query->execute();
    }

    public function paga(): bool{
        global $conn;

        $query = $conn->prepare("UPDATE preventivo
                                SET pagato = true
                                WHERE idpreventivo={$this->id}");
        return $query->execute();
    }

    public function creaFattura(){
        require_once("pdf.php");
        
        initPdf($this->annuncio, $this);
        
    } 

    public function toArray(){
        return [
        "Inserzionista"=>"{$this->professionista->GetNome()} {$this->professionista->getCognome()}",
        "Descrizione"=>"{$this->descrizione}",
        "Compenso"=>"{$this->compenso}€",
        "Totale"=>"{$this->compenso}€",
        ];
    }
}
