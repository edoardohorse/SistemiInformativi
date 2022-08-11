<?php

class Annuncio
{
    private $idannuncio;
    private $idinserzionista;
    private $titolo;
    private $descrizione;
    private $dimensione_giardino;
    private $tempistica;
    private $tempistica_unita;
    private $timestamp;

    public function getTitolo()             { return $this->titolo; }
    public function getDescrizione()        { return $this->descrizione; }
    public function getDimensioneGiardino() { return $this->dimensione_giardino; }
    public function getTempistica()         { return $this->tempistica; }
    public function getTempisticaUnita()    { return $this->tempistica_unita; }
    public function getTimestamp()          { return $this->timestamp; }

    public function __construct($idannuncio, $idinserzionista, $titolo,$descrizione,$dimensione_giardino,$tempistica,$tempistica_unita,$timestamp) {
        $this->$idannuncio          = $idannuncio;
        $this->$idinserzionista     = $idinserzionista;
        $this->titolo               = $titolo;
        $this->descrizione          = $descrizione;
        $this->dimensione_giardino  = $dimensione_giardino;
        $this->tempistica           = $tempistica;
        $this->tempistica_unita     = $tempistica_unita;
        $this->timestamp            = $timestamp;

    }

    public function aggiorna($idannuncio, $idinserzionista ,$titolo,$descrizione,$dimensione_giardino,$tempistica,$tempistica_unita,$timestamp){
        // todo
     /*   $query = $conn->prepare("up INTO annuncio(titolo, descrizione, luogo_lavoro, dimensione_giardino, tempistica, tempistica_unita)
                                VALUES(?, ?, ?, ?, ?, ?)
                                FROM utente WHERE idutente={$this->utente}");
        $query->bind_param("sssiis", $titolo, $descrizione, $luogo_lavoro, $dimensione_giardino, $tempistica_lavoro);
        return  $query->execute() == true? true:  false;*/

    }
}