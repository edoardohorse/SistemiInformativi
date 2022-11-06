<?php

include_once("php/connect.php");
include_once("user.php");
include_once("preventivo.php");

class Annuncio{
    private $idannuncio;
    private Inserzionista $inserzionista;
    private $titolo;
    private $descrizione;
    private $luogo_lavoro;
    private $dimensione_giardino;
    private $tempistica;
    private $tempistica_unita;
    private $timestamp;

    private array $preventivi = [];


    public function getId()                 { return $this->idannuncio;         }
    public function getTitolo()             { return $this->titolo;             }
    public function getDescrizione()        { return $this->descrizione;        }
    public function getLuogolavoro()        { return $this->luogo_lavoro;       }
    public function getDimensioneGiardino() { return $this->dimensione_giardino;}
    public function getTempistica()         { return $this->tempistica;         }
    public function getTempisticaUnita()    { return $this->tempistica_unita;   }
    public function getTimestamp()          { return $this->timestamp;          }
    public function isPreventivato(){ 
        return count($this->preventivi) > 0;
    }
    public function isPagato(){ 
        if($this->getPreventivoAccettato())  return $this->getPreventivoAccettato()->isPagato();
        else return false;
    }

    public function getInserzionista()      { return $this->inserzionista;      } 

    public function getPreventivi()         { return $this->preventivi;         }

    public function getPreventivoAccettato(){
        $res = array_filter($this->preventivi, function(Preventivo $preventivo){
            return $preventivo->isAccettato();
        });
        if($res == null) return null;
        return array_shift($res);
    }

    public function getPreventiviNonAccettati(){
        return array_filter($this->preventivi, function(Preventivo $preventivo){
            return !$preventivo->isAccettato();
        });
    }

    public function __construct($idannuncio) {

        global $conn;

        $query = $conn->prepare(
            "SELECT a.*, s.accettato, s.pagato, s.idservizio
                    FROM annuncio as a LEFT JOIN  servizio as s
                          ON s.idannuncio = a.idannuncio               
                          WHERE a.idannuncio = ?");
        $query->bind_param('i', $idannuncio);
        $query->execute();
        $res = $query->get_result();
//        var_dump($res);
        if($annuncio = $res->fetch_assoc()){
        //    var_dump($annuncio);

            $this->idannuncio           = $annuncio["idannuncio"];
            $this->inserzionista        = Inserzionista::withID((int) $annuncio["idinserzionista"]);
            $this->titolo               = $annuncio["titolo"];
            $this->descrizione          = $annuncio["descrizione"];
            $this->luogo_lavoro         = $annuncio["luogo_lavoro"];
            $this->dimensione_giardino  = $annuncio["dimensione_giardino"];
            $this->tempistica           = $annuncio["tempistica"];
            $this->tempistica_unita     = $annuncio["tempistica_unita"];
            $this->timestamp            = $annuncio["timestamp"];


        } 
        $this->fetchPreventivi();
//        var_dump($this);
    }

    public static function creaAnnuncio($idinserzionista, $titolo, $descrizione, $luogo_lavoro, $dimensione_giardino, $tempistica, $tempistica_unita): bool{
        global $conn;

        $query = $conn->prepare("INSERT INTO annuncio(idinserzionista, titolo, descrizione, luogo_lavoro, dimensione_giardino, tempistica, tempistica_unita)
                                VALUES(?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param("isssiis",
                                    $idinserzionista,
                                    $titolo,
                                    $descrizione,
                                    $luogo_lavoro,
                                    $dimensione_giardino,
                                    $tempistica,
                                    $tempistica_unita);
        return $query->execute();
    }

    public function aggiorna($idinserzionista, $titolo, $descrizione, $luogo_lavoro, $dimensione_giardino, $tempistica, $tempistica_unita): bool{
        global $conn;

        $query = $conn->prepare("UPDATE annuncio
                                SET titolo = ?, descrizione = ?, luogo_lavoro = ?, dimensione_giardino = ?, tempistica = ?, tempistica_unita = ?
                                WHERE idannuncio={$this->idannuncio} AND idinserzionista=?");
        $query->bind_param("sssiisi",
                                    $titolo,
                                    $descrizione,
                                    $luogo_lavoro,
                                    $dimensione_giardino,
                                    $tempistica,
                                    $tempistica_unita,
                                    $idinserzionista);
        return  $query->execute();

    }

    public function delete($idinserzionista): bool{
        global $conn;

        $query = $conn->prepare("DELETE FROM annuncio WHERE idannuncio={$this->idannuncio} AND idinserzionista=?");
        $query->bind_param("i", $idinserzionista);
        return  $query->execute();
    }

    public function preventiva(int $idprofessionista, int $compenso, string $descrizione): bool{
        if($this->isPreventivato()) { return false;}

        return Preventivo::creaPreventivo($idprofessionista, $this->idannuncio, $compenso, $descrizione);
    }

    public function accettaPreventivo(int $idPreventivo): bool{
        // var_dump($this);
        if($this->isPreventivato()) { return false;}

        return $this->preventivi[$idPreventivo]->accetta();
    }

    public function rifiutaPreventivo(int $idPreventivo): bool{
        if(!$this->isPreventivato()) { return false;}
        if($this->getPreventivoAccettato()->getId() != $idPreventivo){ return false;}

        return $this->preventivi[$idPreventivo]->rifiuta();
    }
    
    public function pagaPreventivo(int $idPreventivo): bool{
        if(!$this->isPreventivato() && !$this->isPagato()) { return false;}
        if($this->getPreventivoAccettato()->getId() != $idPreventivo){ return false;}
        
        return $this->preventivi[$idPreventivo]->paga();
    }

    public function fetchPreventivi(){
        global $conn;
        $this->preventivi = [];
        $query = $conn->prepare(
            "SELECT idservizio FROM servizio WHERE idannuncio = ? ORDER BY timestamp DESC");
        $query->bind_param('i', $this->idannuncio);
        $query->execute();
        $res = $query->get_result();
        while($row = $res->fetch_assoc()){
            // var_dump($row);
            $idPreventivo = $row['idservizio']; 
            // array_push($this->preventivi, $preventivo);
            $this->preventivi[$idPreventivo] = new Preventivo($this, $idPreventivo);
        }
        return $this->preventivi;
    }
}
