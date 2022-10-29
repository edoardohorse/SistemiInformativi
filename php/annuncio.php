<?php

include_once("php/connect.php");
include_once("preventivo.php");

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
    private $accettato      = false;
    private $pagato         = false;
    private $isPreventivato = false;
    private array $preventivi = [];

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
    public function getPreventivi()         { return $this->preventivi; }

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
//            var_dump($annuncio);
            $this->idannuncio           = $annuncio["idannuncio"];
            $this->idinserzionista      = $annuncio["idinserzionista"];
            $this->titolo               = $annuncio["titolo"];
            $this->descrizione          = $annuncio["descrizione"];
            $this->luogo_lavoro         = $annuncio["luogo_lavoro"];
            $this->dimensione_giardino  = $annuncio["dimensione_giardino"];
            $this->tempistica           = $annuncio["tempistica"];
            $this->tempistica_unita     = $annuncio["tempistica_unita"];
            $this->timestamp            = $annuncio["timestamp"];


            $this->accettato            = isset($annuncio["accettato"]) && (bool)$annuncio["accettato"];
            $this->pagato               = isset($annuncio["pagato"]) && (bool)$annuncio["pagato"];
            $this->isPreventivato       = isset($annuncio["idservizio"]) && (bool)$annuncio["idservizio"];
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
        if($this->isPreventivato) { return false;}

        return Preventivo::creaPreventivo($idprofessionista, $this->idannuncio, $descrizione, $compenso);
    }

    public function fetchPreventivi(){
        global $conn;
        $this->preventivi = [];
        $query = $conn->prepare(
            "SELECT s.compenso, s.descrizione, u.nome, u.cognome, u.idutente, s.accettato, s.pagato
                FROM servizio as s INNER JOIN utente u ON u.idutente = s.idprofessionista
                WHERE idannuncio = ? ");
        $query->bind_param('i', $this->idannuncio);
        $query->execute();
        $res = $query->get_result();
//        var_dump($res);
        while($preventivo = $res->fetch_assoc()){
//            var_dump($annuncio);
            array_push($this->preventivi, $preventivo);
        }
        return $this->preventivi;
    }
}
