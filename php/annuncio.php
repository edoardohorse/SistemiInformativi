<?php

include_once("php/connect.php");

class Annuncio
{
    private $idannuncio;
    private $idinserzionista;
    private $titolo;
    private $descrizione;
    private $luogo_lavoro;
    private $dimensione_giardino;
    private $tempistica;
    private $tempistica_unita;
    private $timestamp;
    private $accettato;
    private $pagato;
    private $isPreventivato;

    public function getId()                 { return $this->idannuncio; }
    public function getTitolo()             { return $this->titolo; }
    public function getDescrizione()        { return $this->descrizione; }
    public function getLuogolavoro()        { return $this->luogo_lavoro; }
    public function getDimensioneGiardino() { return $this->dimensione_giardino; }
    public function getTempistica()         { return $this->tempistica; }
    public function getTempisticaUnita()    { return $this->tempistica_unita; }
    public function getTimestamp()          { return $this->timestamp; }
    public function getAccettato()          { return $this->accettato; }
    public function getPagato()             { return $this->pagato; }
    public function isPreventivato()        { return $this->isPreventivato; }

    public function __construct($idannuncio) {

        global $conn;

        $query = $conn->prepare(
            "SELECT a.*, s.accettato, s.pagato FROM annuncio as a LEFT JOIN  servizio as s
                          ON s.idannuncio = a.idannuncio               
                          WHERE a.idannuncio = ?");
        $query->bind_param('i', $idannuncio);
        $query->execute();
        $res = $query->get_result();
//        var_dump($res);
        if($annuncio = $res->fetch_assoc()){
//          var_dump($annuncio);
            $this->idannuncio           = $annuncio["idannuncio"];
            $this->idinserzionista      = $annuncio["idinserzionista"];
            $this->titolo               = $annuncio["titolo"];
            $this->descrizione          = $annuncio["descrizione"];
            $this->luogo_lavoro         = $annuncio["luogo_lavoro"];
            $this->dimensione_giardino  = $annuncio["dimensione_giardino"];
            $this->tempistica           = $annuncio["tempistica"];
            $this->tempistica_unita     = $annuncio["tempistica_unita"];
            $this->timestamp            = $annuncio["timestamp"];


            if(isset($this->accettato) && isset($this->pagato)){
                $this->isPreventivato = true;
                $this->accettato            = $annuncio["accettato"];
                $this->pagato               = $annuncio["pagato"];
            }
            else
                $this->isPreventivato = false;
        }
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

    public function preventiva($idprofessionista, $descrizione, $compenso): bool{
        global $conn;

        $query = $conn->prepare(
            "INSERT INTO servizio(idannuncio, idprofessionista, compenso, descrizione)
                                VALUES({$this->idannuncio},?, ?, ?)");
        $query->bind_param("ids",
            $idprofessionista,
            $compenso,
            $descrizione);
        return $query->execute();
    }
}