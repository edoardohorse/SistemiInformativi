<?php

require_once("connect.php");
require_once("annuncio.php");

$user = null;

enum EUserType: string{
    case Inserzionista = 'ins';
    case Professionista = 'pro';
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

    protected function __construct($idutente, $email){
        $this->idutente = $idutente;
        $this->$email   = $email;
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

        if(!$this->isLogged) return;

        $query = $conn->prepare("SELECT
                        codice_fiscale,nome,cognome,citta,cap,indirizzo,numero_civico,telefono,partita_iva
                        FROM utente WHERE idutente=?");
        $query->bind_param("i", $this->idutente);
        $query->execute();
        $query->bind_result(
            $this->codice_fiscale,
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
    

}


class Inserzionista extends User {
    
    private $tipo = EUserType::Inserzionista;


    /*getter*/
    public function getTipo(){return $this->tipo->value;}


    public function __construct(){

        $this->idutente = $_SESSION["user"]?->idutente;
        $this->isLogged = $_SESSION["user"]?->isLogged;
        $this->fetchInfo();
    }
    
    public function creaAnnuncio($titolo, $descrizione, $luogo_lavoro, $dimensione_giardino, $tempistica, $tempistica_unita) : bool{
        $res =  Annuncio::creaAnnuncio($this->idutente,$titolo, $descrizione, $luogo_lavoro, $dimensione_giardino, $tempistica, $tempistica_unita);
        if($res) $this->fetchAnnunci();
        return $res;
    }

    public function aggiornaAnnuncio($idannuncio, $titolo, $descrizione, $luogo_lavoro, $dimensione_giardino, $tempistica, $tempistica_unita) : bool{
        return $this->annunci[$idannuncio]->aggiorna(
            $this->idutente, $titolo, $descrizione, $luogo_lavoro, $dimensione_giardino, $tempistica, $tempistica_unita);
    }

    public function deleteAnnuncio($idannuncio){
        return $this->annunci[$idannuncio]->delete($this->idutente);
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

    

}

class Professionista extends User{
    private $tipo = EUserType::Professionista;

    public function getTipo(){return $this->tipo->value;}


    public function __construct(){  
        $this->idutente = $_SESSION["user"]?->idutente;
        $this->isLogged = $_SESSION["user"]?->isLogged;     
        $this->fetchInfo();
    }

    // Fetch annunci pubblicati dagli altri utenti
    public function fetchAnnunci(){
        global $conn;

        $this->annunci = [];

        $query = $conn->prepare("SELECT idannuncio FROM annuncio ORDER BY timestamp DESC");
        $query->execute();
        $res = $query->get_result();
        while($idannuncio = $res->fetch_column()){
            //            var_dump($idannuncio);
            $this->annunci[$idannuncio] = new Annuncio($idannuncio);
        }
    }

    public function creaPreventivo($idannuncio, $descrizione, $compenso){
        return $this->annunci[$idannuncio]->preventiva($this->idutente, $descrizione, $compenso);
    }

}



?>
