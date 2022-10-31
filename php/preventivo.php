<?php

include_once("php/connect.php");
require_once("user.php");

class Preventivo
{
    
    private int $idservizio;
    private Annuncio $annuncio;
    private int $compenso;
    private string $descrizione;
    private bool $accettato      = false;
    private bool $pagato         = false;
    private DateTime $timestamp;
    private User $professionista;

    public function getIdservizio()      {return $this->idservizio;}
    public function getAnnuncio()        {return $this->annuncio;}
    public function getCompenso()        {return $this->compenso;}
    public function getDescrizione()     {return $this->descrizione;}
    public function getAccettato()       {return $this->accettato;}
    public function getPagato()          {return $this->pagato;}
    public function getTimestamp()       {return $this->timestamp;}
    public function getProfessionista()  {return $this->professionista;}

    public function __construct(Annuncio& $annuncio) {

        $this->annuncio = $annuncio;
        global $conn;

        $query = $conn->prepare(
            "SELECT s.compenso, s.descrizione, u.nome, u.cognome, u.idutente, s.accettato, s.pagato
                FROM servizio as s INNER JOIN utente u ON u.idutente = s.idprofessionista
                WHERE s.idannuncio  = ?"
        );
        $query->bind_param('i', $this->annuncio->getId());
        $query->execute();
        $res = $query->get_result();
        //        var_dump($res);
        if ($preventivo = $res->fetch_assoc()) {
            //            var_dump($annuncio);
            $this->idservizio       = $preventivo["idservizio"];
            $this->idprofessionista = $preventivo["idprofessionista"];
            $this->idannuncio       = $preventivo["idannuncio"];
            $this->compenso         = $preventivo["compenso"];
            $this->descrizione      = $preventivo["descrizione"];
            $this->timestamp        = $preventivo["timestamp"];


            $this->accettato        = isset($preventivo["accettato"]) && (bool)$preventivo["accettato"];
            $this->pagato           = isset($preventivo["pagato"]) && (bool)$preventivo["pagato"];
        }
            // var_dump($this);
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
                                WHERE idservizio={$this->idservizio}");
        $query->bind_param(
            "is",
            $compenso,
            $descrizione
        );
        return  $query->execute();
    }

    public function delete(): bool{
        global $conn;

        $query = $conn->prepare("DELETE FROM servizio WHERE idservizio={$this->idservizio}");
        return  $query->execute();
    }

    public function accetta(bool $value = true){
        global $conn;

        $query = $conn->prepare("UPDATE servizio
                                SET accetato = {$value}
                                WHERE idservizio={$this->idservizio}");
        return  $query->execute();
    }

    public function paga(){
        global $conn;

        $query = $conn->prepare("UPDATE servizio
                                SET pagato = true
                                WHERE idservizio={$this->idservizio}");
        return  $query->execute();
    }

    private function creaFattura(){} // TODO

}

