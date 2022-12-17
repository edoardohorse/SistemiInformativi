<?php

include_once("php/connect.php");
require_once("user.php");

class Notifiche{
    public int $idutente; 
    public array $notifiche = ['new'=>[], 'old'=>[]];

    public function __construct($idutente){
        $this->idutente = $idutente;
    }

    public function fetchNotifiche(){
        $this->notifiche = ['new'=>[], 'old'=>[]];
        global $conn;

        $query = $conn->prepare("SELECT * FROM notifica WHERE idutente = $this->idutente ORDER BY timestamp DESC");
        $query->execute();
        $res = $query->get_result();
        
        // var_dump($res);
        while($row = $res->fetch_assoc()){
            // var_dump($row);
            $notifica = new Notifica(
                $row['idnotifica'],
                $row['idutente'],
                $row['letta'],
                $row['messaggio'],
                $row['redirectUrl'],
                $row['timestamp']
            );
            // var_dump($notifica);
            if($notifica->getLetta() == true){
                $this->notifiche['old'][$notifica->getID()] = $notifica;
            }
            else{
                $this->notifiche['new'][$notifica->getID()] = $notifica;
            }
        }
        // var_dump($this->notifiche);
    }

    public function creaNotifica($idutente, $messaggio, $redirectUrl = ""){
        return Notifica::crea($idutente, $messaggio, $redirectUrl);
    }

    public static function leggiTutte(int $idutente){
        global $conn;

        $query = $conn->prepare("UPDATE notifica SET letta = true WHERE idutente = ?");
        $query->bind_param("i", $idutente);
        return $query->execute();
    } 
    
    public static function cancellaNotificheLette(int $idutente){
        global $conn;

        $query = $conn->prepare("DELETE FROM notifica WHERE letta = true AND idutente = ?");
        $query->bind_param("i", $idutente);
        return $query->execute();
    }   

}

class Notifica{

    protected int $idnotifica;
    protected int $idutente;
    protected bool $letta;
    protected string $messaggio;
    protected string $redirectUrl = "";
    protected $timestamp;

    public function getID()  {return $this->idnotifica;}
    public function getIdutente()    {return $this->idutente;}
    public function getLetta()       {return $this->letta;}
    public function getMessaggio()   {return $this->messaggio;}
    public function getRedirectUrl() {return $this->redirectUrl;}
    public function getTimestamp()   {return $this->timestamp;}

    public function __construct($idnotifica, $idutente, $letta, $messaggio, $redirectUrl, $timestamp){
        $this->idnotifica = $idnotifica;
        $this->idutente = $idutente;
        $this->letta = $letta;
        $this->messaggio = $messaggio;
        $this->redirectUrl = $redirectUrl;
        $this->timestamp = $timestamp;

    }

    public static function crea($idutente, $messaggio, $redirectUrl){
         global $conn;
        // var_dump($idprofessionista, $idannuncio, $compenso, $descrizione);
        $query = $conn->prepare("INSERT INTO notifica(idutente, messaggio, redirectUrl) VALUES(?, ?, ?)");
        $query->bind_param(
            "iss",
            $idutente,
            $messaggio,
            $redirectUrl
        );
        $res = $query->execute();
        $idNotifica = $query->insert_id;

        if($res && $redirectUrl != ""){
            $redirectUrl .= "&idnotifica=$idNotifica";
            $query = $conn->prepare("UPDATE notifica SET redirectUrl = ? WHERE idnotifica = $idNotifica ");
            $query->bind_param(
                "s",
                $redirectUrl
            );
            $query->execute();
        }

        return $res;
    }

    public static function leggi($idnotifica){
         global $conn;
        // var_dump($idprofessionista, $idannuncio, $compenso, $descrizione);
        $query = $conn->prepare("UPDATE notifica SET letta = true WHERE idnotifica = ?");
        $query->bind_param("i",$idnotifica);
        return $query->execute();
    }

}

?>