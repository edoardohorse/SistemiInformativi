<?php

require_once("connect.php");
require_once("annuncio.php");
require_once("recensione.php");
require_once("notifica.php");

$user = null;

enum EUserType: string{
    case Inserzionista = 'ins';
    case Professionista = 'pro';
    case Entrambi = 'both';
}

enum EUserLoginResult: string{
    case UserNotExists  = 'Non è stato trovato alcun account con questa mail';
    case LoginFailed    = 'Reinserire la password correttamente';
    case LoginSuccess   = 'Login eseguito con successo';
    case LoggedAlready  = 'Login già eseguito';
    case LogoutSuccess  = 'Logout eseguito con successo';
    case AccountAlreadyExists  = 'Questa account è già esistente';
    case SignupFailed   = 'Iscrizione fallita';
    case SignupSuccess  = 'Iscrizione avvenuta con successo';
}

class User{
    protected $idutente;
    protected $email;
    protected $codice_fiscale;
    protected $nome;
    protected $cognome;
    protected $citta;
    protected $cap;
    protected $indirizzo;
    protected $numero_civico;
    protected $telefono;
    protected $partita_iva;
    protected $isLogged = false;
    protected $annunci = [];
    protected $recensioni = [];
    protected ?Notifiche $wrapperNotifiche = null;

    public function getID(){ return $this->idutente; }
    public function getEmail() {return $this->email;}
    public function getCodiceFiscale() {return $this->codice_fiscale;}
    public function getNome() {return $this->nome;}
    public function getCognome() {return $this->cognome;}
    public function getCitta() {return $this->citta;}
    public function getCap() {return $this->cap;}
    public function getIndirizzo() {return $this->indirizzo;}
    public function getNumeroCivico() {return $this->numero_civico;}
    public function getTelefono() {return $this->telefono;}
    public function getPartitaIva() {return $this->partita_iva;}
    public function getAnnunci(){return $this->annunci;}
    public function getRecensioni(){return $this->recensioni;}
    public function getNotifiche(){return $this->wrapperNotifiche;}

    public function getAnnunciPreventivabili(){
        return array_filter($this->annunci, function($annuncio){return !$annuncio->isPreventivato();});
    }

    public function getAnnunciPreventivati(){
        return array_filter($this->annunci, function ($annuncio) {return $annuncio->isPreventivato() && !$annuncio->isPagato();});
    }
    public function getAnnunciAccettati(){
        return array_filter($this->annunci, function ($annuncio) { return $annuncio->isPreventivato() && $annuncio->isPagato();});
    }

    protected function __construct($idutente, $email = null){
        $this->idutente = $idutente;
        if($email) $this->$email   = $email;
    }

    public static function withID(int $idutente){
        $instance = new self($idutente);
        $instance->fetchInfo();
        return $instance;
    }

    public static function exists($email): bool{
        global $conn;
        $idutente = null; $tipo = null;

        $query = $conn->prepare("SELECT idutente FROM utente WHERE email LIKE ?");
        $query->bind_param('s', $email);
        $query->execute();
        // var_dump($query);
        $res = $query->fetch() == true? true: false ;
        return $res;        
    }

    //login
    public static function login($email, $pass): EUserLoginResult{
        global $conn;
        $idutente = null; $tipo = null;

        // Se già loggato ritorna
        if(User::isLogged()) return EUserLoginResult::LoggedAlready;
        
        // Se non esiste ritorna null
        if(!User::exists($email)) return EUserLoginResult::UserNotExists;

        $query = $conn->prepare("SELECT idutente, tipo FROM utente WHERE email LIKE ? AND pass LIKE ? ");
        $query->bind_param('ss', $email, $pass);
        $query->execute();
        $query->bind_result($idutente, $tipo);

        if($query->fetch()){
            // var_dump($idutente, $tipo);
            
            $user = new User($idutente, $email);
            $user->isLogged = true;
            
            $_SESSION = [];            
            $_SESSION["user"] = &$user;
            $_SESSION["tipo"] = &$tipo;

            return EUserLoginResult::LoginSuccess;
        }

        return EUserLoginResult::LoginFailed;
    
    
        
    }

    public static function signin($email, $pass, $codice_fiscale, $nome, $cognome, $citta, $cap, $indirizzo, $numero_civico, $telefono, $partita_iva, $tipo) : EUserLoginResult{
        global $conn;
        
        if(User::exists($email)) return EUserLoginResult::AccountAlreadyExists;

        $query = $conn->prepare("INSERT INTO utente(email, pass, codice_fiscale, nome, cognome, citta,
                                                    cap, indirizzo, numero_civico, telefono, partita_iva, tipo )
                                VALUES (?,MD5(?),?,?,?,?,?,?,?,?,?,?)");
        $query->bind_param("ssssssssisss", $email, $pass, $codice_fiscale, $nome, $cognome, $citta, $cap, $indirizzo, $numero_civico, $telefono, $partita_iva, $tipo);
        
        if($query->execute()) return EUserLoginResult::SignupSuccess;

        return EUserLoginResult::SignupFailed;
    }

    public static function isLogged(): bool{
        session_start();
        return isset($_SESSION['user']) && $_SESSION['user']->isLogged;
    }

    protected function fetchInfo(){
        global $conn;

        $query = $conn->prepare("SELECT
                        codice_fiscale, email, nome,cognome,citta,cap,indirizzo,numero_civico,telefono,partita_iva
                        FROM utente WHERE idutente=?");
        $query->bind_param("i", $this->idutente);
        $query->execute();
        $query->bind_result(
            $this->codice_fiscale,
            $this->email,
            $this->nome,
            $this->cognome,
            $this->citta,
            $this->cap,
            $this->indirizzo,
            $this->numero_civico,
            $this->telefono,
            $this->partita_iva
        );

        $query->fetch();

    }


    public function logout(){
        session_destroy();
    }

    public function __toString(): string{
        return "
        {$this->idutente}\n
        {$this->email}\n
        {$this->codice_fiscale}\n
        {$this->nome}\n
        {$this->cognome}\n
        {$this->citta}\n
        {$this->cap}\n
        {$this->indirizzo}\n
        {$this->numero_civico}\n
        {$this->telefono}\n
        {$this->partita_iva}\n
        {$this->isLogged}";
    }
    
    public function fetchRecensioni(){
         global $conn;

        $this->recensioni = [];

        $query = $conn->prepare("SELECT idrecensione FROM recensione WHERE idrecensito = ?");
        $query->bind_param("i", $this->idutente);
        $query->execute();
        $res = $query->get_result();
        while($idrecensione = $res->fetch_column()){
            $this->recensioni[$idrecensione] = new Recensione($idrecensione);
        }
    }

    public function recensisce($idrecensito, $idpreventivo, $descrizione, $voto){
        return Recensione::crea($this->idutente, $idrecensito, $idpreventivo, $descrizione, (int) $voto);
    }

    public function fetchNotifiche(){
        $this->wrapperNotifiche->fetchNotifiche();
        return $this->wrapperNotifiche;
    }
}


class Inserzionista extends User {
    
    private $tipo = EUserType::Inserzionista;


    /*getter*/
    public function getTipo(){return $this->tipo->value;}

    public static function withID(int $idInserzionista){
        $instance = new self();
        $instance->idutente = $idInserzionista;
        $instance->fetchInfo();
        return $instance;
    }

    public function __construct(){

        $this->idutente = $_SESSION["user"]?->idutente;
        $this->isLogged = $_SESSION["user"]?->isLogged;
        $this->wrapperNotifiche = new Notifiche($this->idutente);
        $this->fetchInfo();
    }
    
    public function creaAnnuncio($titolo, $descrizione, $luogo_lavoro, $dimensione_giardino, $tempistica, $tempistica_unita){
        return Annuncio::crea($this->idutente,$titolo, $descrizione, $luogo_lavoro, $dimensione_giardino, $tempistica, $tempistica_unita);
    }

    public function aggiornaAnnuncio($idannuncio, $titolo, $descrizione, $luogo_lavoro, $dimensione_giardino, $tempistica, $tempistica_unita) {
        return $this->annunci[$idannuncio]->aggiorna(
            $this->idutente, $titolo, $descrizione, $luogo_lavoro, $dimensione_giardino, $tempistica, $tempistica_unita);
    }

    public function eliminaAnnuncio($idannuncio){
        return $this->annunci[$idannuncio]->elimina($this->idutente);
    }

    // Fetch annunci create da se stesso
    public function fetchAnnunci(){
        global $conn;

        $this->annunci = [];

        $query = $conn->prepare("SELECT idannuncio FROM annuncio WHERE idinserzionista = ? ORDER BY timestamp DESC");
        $query->bind_param("i", $this->idutente);
        $query->execute();
        $res = $query->get_result();
        while($idannuncio = $res->fetch_column()){
//            var_dump($idannuncio);
            $this->annunci[$idannuncio] = new Annuncio($idannuncio);
        }

//        var_dump($this->annunci);
    }

    public function accettaPreventivo(int $idAnnuncio, int $idpreventivo){
        return $this->annunci[$idAnnuncio]->accettaPreventivo($idpreventivo);
    }
    public function rifiutaPreventivo(int $idAnnuncio, int $idpreventivo){
        return $this->annunci[$idAnnuncio]->rifiutaPreventivo($idpreventivo);
    }
    public function pagaPreventivo(int $idAnnuncio, int $idpreventivo){
        return $this->annunci[$idAnnuncio]->pagaPreventivo($idpreventivo);
    }
    

}

class Professionista extends User{
    private $tipo = EUserType::Professionista;

    private $preventivi = [];

    public function getTipo(){return $this->tipo->value;}
 

    // seleziono gli annunci preventivati da questo professionista (non ancora accettati ed eventualmente già preventivati da altri)
    public function getAnnunciPreventivati(){
        // var_dump($this->annunci);
        return array_filter($this->annunci, function (Annuncio $annuncio) {
            $annuncio->fetchPreventivi();
            return array_filter($annuncio->getPreventivi(), function (Preventivo $preventivo) {
                return $preventivo->getProfessionista()->getId() == $this->idutente;
            }) != [];
        });
    }

    // seleziono gli annunci che può preventivare questo professionista (eventualmente già preventivati da altri ma non accettati)
    public function getAnnunciPreventivabili(){
        /* return array_filter($this->annunci, function (Annuncio $annuncio) {
            return !$annuncio->isPreventivato();
        }); */
        return array_filter($this->annunci, function (Annuncio $annuncio) {
            $annuncio->fetchPreventivi();
            return array_filter($annuncio->getPreventivi(), function (Preventivo $preventivo) {
                return $preventivo->getProfessionista()->getId() == $this->idutente;
            }) == [];
        });
    }

    public function getPreventivoEmesso($idannuncio): Preventivo | null{
        $res =  array_filter($this->annunci[$idannuncio]->getPreventivi(), function (Preventivo $preventivo) {
            return $preventivo->getProfessionista()->getId() == $this->idutente;
        });
        if($res == null) return null;
        return array_shift($res);
    }

    public function __construct(){  
        $this->idutente = $_SESSION["user"]?->idutente;
        $this->isLogged = $_SESSION["user"]?->isLogged;     
        $this->wrapperNotifiche = new Notifiche($this->idutente);
        $this->fetchInfo();
    }

    public static function withID(int $idProfessionista){
        $instance = new self();
        $instance->idutente = $idProfessionista;
        $instance->fetchInfo();
        return $instance;
    }

    // Fetch annunci pubblicati dagli altri utenti
    public function fetchAnnunci(){
        global $conn;

        $this->annunci = [];

        // seleziono tutti gli annunci che non sono stati accettati
        $query = $conn->prepare("SELECT a.idannuncio FROM annuncio as a
                                WHERE a.idannuncio NOT IN (SELECT s.idannuncio FROM preventivo as s WHERE s.accettato = true)
                                ORDER BY a.timestamp DESC");
        $query->execute();
        $res = $query->get_result();
        while($idannuncio = $res->fetch_column()){
            //            var_dump($idannuncio);
            $this->annunci[$idannuncio] = new Annuncio($idannuncio);
        }
    }

    public function creaPreventivo(int $idannuncio, int $compenso, string $descrizione): bool{
        return $this->annunci[$idannuncio]->preventiva($this->idutente, $compenso, $descrizione);
    }
    
    public function aggiornaPreventivo(int $idannuncio, int $idpreventivo, int $compenso, string $descrizione): bool{
        $preventivo = $this->annunci[$idannuncio]->getPreventivi()[$idpreventivo];
        // var_dump($preventivo);
        if($preventivo->isAccettato()) return false;  // se è già accettato non posso più modificarlo

        return $preventivo->aggiorna($compenso, $descrizione);
    }
    
    public function eliminaPreventivo(int $idannuncio, int $idpreventivo): bool{
        $preventivo = $this->annunci[$idannuncio]->getPreventivi()[$idpreventivo];
        if($preventivo->isAccettato()) return false;  // se è gia accettato non posso più eliminarlo

        return $preventivo->elimina($this->idutente);
    }

}



?>
