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

    public function getId()                 { return $this->idannuncio; }
    public function getTitolo()             { return $this->titolo; }
    public function getDescrizione()        { return $this->descrizione; }
    public function getLuogolavoro()        { return $this->luogo_lavoro; }
    public function getDimensioneGiardino() { return $this->dimensione_giardino; }
    public function getTempistica()         { return $this->tempistica; }
    public function getTempisticaUnita()    { return $this->tempistica_unita; }
    public function getTimestamp()          { return $this->timestamp; }

    public function __construct($idannuncio) {

        global $conn;

        $query = $conn->prepare("SELECT * FROM annuncio WHERE idannuncio = ?");
        $query->bind_param('i', $idannuncio);
        $query->execute();
        $res = $query->get_result();
//        var_dump($annuncio);
        if($annuncio = $res->fetch_assoc()){
                $this->idannuncio           = $annuncio["idannuncio"];
                $this->idinserzionista      = $annuncio["idinserzionista"];
                $this->titolo               = $annuncio["titolo"];
                $this->descrizione          = $annuncio["descrizione"];
                $this->luogo_lavoro         = $annuncio["luogo_lavoro"];
                $this->dimensione_giardino  = $annuncio["dimensione_giardino"];
                $this->tempistica           = $annuncio["tempistica"];
                $this->tempistica_unita     = $annuncio["tempistica_unita"];
                $this->timestamp            = $annuncio["timestamp"];
        }
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
}