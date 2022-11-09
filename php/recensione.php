<?php

include_once("php/connect.php");
require_once("user.php");
require_once("Servizio.php");

class Recensione
{
    
    private int $id;
    private Preventivo $preventivo;
    private string $descrizione;
    private number $voto;
    private $timestamp;
    private User $recensore;
    private User $recensito;

    public function getId()         {return $this->id;}
    public function getDescrizione(){return $this->descrizione;}
    public function getRecensore() { return $this->recensore;}
    public function getRecensito() { return $this->recensito;}
    public function getPreventivo() { return $this->preventivo;}
    public function getVoto()       {return $this->voto;}

    public function __construct(int $idrecensione) {
        global $conn;

        $this->id = $idrecensione;

        $query = $conn->prepare(
            "SELECT r.*
                FROM recensione r, utente recensore, utente recensito, servizio s
                WHERE r.idrecensione = ? 
                AND recensore.idrecensore   = recensore.idutente
                AND recensito.idrecensito   = recensito.idutente
                AND r.idservizio            = s.idservizio");

        $query->bind_param('i', $this->id);
        $query->execute();
        $res = $query->get_result();
        // var_dump($res);
        if($recensione = $res->fetch_assoc()) {
            // var_dump($preventivo);
            $this->recensito        = User::withID((int) $recensione["idrecensito"]);
            $this->recensore        = User::withID((int) $recensione["idrecensore"]);
            $this->preventivo       = Preventivo::withID((int) $recensione["idservizio"]);
            $this->descrizione      = $recensione["descrizione"];
            $this->voto             = $recensione["voto"];
            $this->timestamp        = $recensione["timestamp"];
        }

        // var_dump($this);
    }

    public static function creaRecensione($idrecensore, $idrecensito, $idservizio, string $descrizione, int $voto): bool{
        global $conn;
        // var_dump($idrecensore, $idrecensito, string $descrizione, int $voto);
        $query = $conn->prepare(
            "INSERT INTO recensione(idrecensore, idrecensito, idservizio, descrizione, voto) VALUES(?, ?, ?, ?)");
        $query->bind_param(
            "iiisi",
            $idrecensore,
            $idrecensito,
            $idservizio,
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

