<?php

include_once("php/connect.php");
require_once("user.php");
require_once("preventivo.php");

class Recensione
{
    
    private int $id;
    private Preventivo $preventivo;
    private string $descrizione;
    private int $voto;
    private $timestamp;
    private User $recensore;
    private User $recensito;
    private int $idannuncio;

    public function getId()         {return $this->id;}
    public function getDescrizione(){return $this->descrizione;}
    public function getRecensore() { return $this->recensore;}
    public function getRecensito() { return $this->recensito;}
    public function getPreventivo() { return $this->preventivo;}
    public function getVoto()       {return $this->voto;}
    public function getIdAnnuncio()       {return $this->idannuncio;}

    public function __construct(int $idrecensione) {
        global $conn;

        $this->id = $idrecensione;
        // var_dump($idrecensione);
        $query = $conn->prepare(
            "SELECT recensione.*, p.idannuncio
                FROM recensione recensione, utente as recensore, utente as recensito, preventivo p
                WHERE recensione.idrecensione = ?
                AND recensione.idrecensore   = recensore.idutente
                AND recensione.idrecensito   = recensito.idutente
                AND recensione.idpreventivo    = p.idpreventivo;");

        $query->bind_param('i', $this->id);
        $query->execute();
        $res = $query->get_result();
        // var_dump($res);
        if($recensione = $res->fetch_assoc()) {
            // var_dump($recensione);
            $this->recensito        = User::withID((int) $recensione["idrecensito"]);
            $this->recensore        = User::withID((int) $recensione["idrecensore"]);
            $this->preventivo       = Preventivo::withID((int) $recensione["idpreventivo"]);
            $this->descrizione      = $recensione["descrizione"];
            $this->voto             = $recensione["voto"];
            $this->timestamp        = $recensione["timestamp"];
            $this->idannuncio        = $recensione["idannuncio"];
        }

        // var_dump($this);
    }

    public static function crea(int $idrecensore, int $idrecensito, int $idpreventivo, string $descrizione, int $voto): bool{
        global $conn;
        // var_dump($idrecensore, $idrecensito,  $idpreventivo, $descrizione, $voto);
        $query = $conn->prepare(
            "INSERT INTO recensione(idrecensore, idrecensito, idpreventivo, descrizione, voto) VALUES(?, ?, ?, ?, ?)");
        $query->bind_param(
            "iiisi",
            $idrecensore,
            $idrecensito,
            $idpreventivo,
            $descrizione,
            $voto
        );
        return $query->execute();
    }

    public function aggiorna($descrizione, $voto): bool{
        global $conn;

        $query = $conn->prepare("UPDATE recensione
                                SET descrizione = ?, voto = ?
                                WHERE idrecensione ={$this->id}");
        $query->bind_param(
            "si",
            $descrizione,
            $voto
        );
        return  $query->execute();
    }

    public function elimina($idrecensore): bool{
        global $conn;

        $query = $conn->prepare("DELETE FROM recensione WHERE idrecensione={$this->id} AND idrecensore={$idrecensore}");
        return  $query->execute();
    }

}

