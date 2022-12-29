<?php

include_once("php/user.php");

$request = $_SERVER['REQUEST_URI'];
$rootDir = explode("\\",__DIR__);
$rootDir = "/".$rootDir[count($rootDir)-1];
$request = str_replace($rootDir, "", $request );

if(count($_REQUEST) > 0 )
    $request =  explode("?",$request)[0];

// $refer = $_SERVER['HTTP_REFERER'];
// global $backPage;
// $backPage = substr($refer, strpos($refer, $rootDir)+strlen($rootDir),strlen($refer));
// $backPage = $_SERVER['HTTP_REFERER'];

/*
echo "DEBUG Inizio --- <br>";
 var_dump($rootDir,$request, $_REQUEST, $backPage);
echo "DEBUG fine --- <br>";
*/

function logout(){
    session_start();
    session_unset();
    setcookie("PHPSESSID", null);
    session_destroy();
}

// Check se loggato e se ha i diritti per una determinata azione
function checkLogin(EUserType $tipoRichiesto = null){
    global $user, $rootDir;
    if(!User::isLogged()){
//        logout();
        exit("Devi loggarti prima! <br><a href='$rootDir'>Torna indietro</a>");

    }

//    var_dump($_SESSION,$tipoRichiesto);
    
    if( $tipoRichiesto      != null
        && $tipoRichiesto   != EUserType::Entrambi
        && $_SESSION["user"]->getTipo() != $tipoRichiesto->value){
            exit("Non hai i diritti per eseguire questa azione");
    }

    $GLOBALS['user'] = &$_SESSION["user"];

}

function returnMessage($message, bool $success, string $redirectUrl = null){
    return json_encode(array(
        "message" => $message,
        "success" => $success,
        "redirectUrl" => $redirectUrl
    ));
}


switch ($request) {
    case '/home' :
    {
        checkLogin();

        include("page/pageHome.php");

        break;
    }
    case '/login' :
    {
        echo "qui /login";
        $result = User::login($_POST["email"], $_POST["pass"]);

        if ($result == EUserLoginResult::LoginSuccess || $result == EUserLoginResult::LoggedAlready) {
            switch ($_SESSION["tipo"]) {
                case EUserType::Inserzionista->value:
                {
                    $_SESSION["user"] = new Inserzionista();
                    break;
                }
                case EUserType::Professionista->value:
                {
                    $_SESSION["user"] = new Professionista();
                    break;
                }
            }
        }

        //        var_dump($_SESSION,$result);
        header("Location: $rootDir/home");
        break;
    }

    case '/signin':
    {
        $result = User::signin($_POST["email"],
            $_POST["pass"],
            $_POST["codice_fiscale"],
            $_POST["nome"],
            $_POST["cognome"],
            $_POST["citta"],
            $_POST["cap"],
            $_POST["indirizzo"],
            $_POST["numero_civico"],
            $_POST["telefono"],
            $_POST["partita_iva"],
            $_POST["tipo"]);

        var_dump($result);
        //        echo $result;
    }

    case '/legginotifica':{
        global $user;
        checkLogin(EUserType::Entrambi);

        
        if(isset($_REQUEST["idnotifica"])){
            $idNotifica = $_REQUEST["idnotifica"];
            Notifica::leggi($idNotifica);
        }
        else if(isset($_REQUEST["tutte"])){
            Notifiche::leggiTutte($user->getID());
        }

        // var_dump($_SERVER["HTTP_REFERER"]);
        $referer = $_SERVER["HTTP_REFERER"];
        header("Location: $referer");
        
        break;
    }
    case '/cancellanotifica':{
        global $user;
        checkLogin(EUserType::Entrambi);


        if(isset($_REQUEST["tutte"])){
            Notifiche::cancellaNotificheLette($user->getID());
        }

        // var_dump($_SERVER["HTTP_REFERER"]);
        $referer = $_SERVER["HTTP_REFERER"];
        header("Location: $referer");
        
        break;
    }

    case '/annuncio/creaAnnuncio':
    {
        // echo "qui annuncio/creaAnnuncio";
        global $user;
        checkLogin(EUserType::Inserzionista);
        //var_dump($user)

        //        var_dump($_POST);
        [$res, $idAnnuncio] = $user->creaAnnuncio(
            $_POST["titolo"],
            $_POST["descrizione"],
            $_POST["luogo_lavoro"],
            $_POST["dimensione_giardino"],
            $_POST["tempistica"],
            $_POST["tempistica_unita"]
        );

        // var_dump($user->getNotifiche(),$res,$idAnnuncio);

        $messaggio = EAnnuncioResult::CreaSuccess->value;
        if($res){
            $redirect = "$rootDir/annuncio/view?id=$idAnnuncio";
        }
        else{
            $messaggio =  EAnnuncioResult::CreaFailed->value;
        }

        $messaggio .= ": " . $_POST["titolo"];
        
        $user->getNotifiche()->creaNotifica($user->getID(),$messaggio, $redirect);
        
        header("Location: $rootDir/home");
        

        break;
    }
    case '/annuncio/aggiornaAnnuncio':{
        // echo "qui annuncio/aggiornaAnnuncio";
        checkLogin(EUserType::Inserzionista);
        global $user;
    //    var_dump($_POST);

            $idAnnuncio = $_POST["idannuncio"]; 
        $user->fetchAnnunci();
        [$res, $var] = $user->aggiornaAnnuncio(
            $_POST["idannuncio"],
            $_POST["titolo"],
            $_POST["descrizione"],
            $_POST["luogo_lavoro"],
            $_POST["dimensione_giardino"],
            $_POST["tempistica"],
            $_POST["tempistica_unita"]
        );

        // $user->fetchAnnunci();
        // $user->fetchNotifiche();
        
        $messaggio = EAnnuncioResult::AggiornaSuccess->value;
        if($res){
            $redirect = "$rootDir/annuncio/view?id=$idAnnuncio";
        }
        else{
            $messaggio =  EAnnuncioResult::AggiornaFailed->value;
        }

        $messaggio .= ": " . $_POST["titolo"];
        
        $user->getNotifiche()->creaNotifica($user->getID(),$messaggio, $redirect);
        
        header("Location: $rootDir/annuncio/view?id=". $idAnnuncio);

        break;
    }

    case '/annuncio/eliminaAnnuncio':{
        echo "qui annuncio/eliminaAnnuncio";
        global $user;
        checkLogin(EUserType::Inserzionista);

        $user->fetchAnnunci();
        [$res, $titolo] = $user->eliminaAnnuncio($_POST["idannuncio"]);

        
        $messaggio = EAnnuncioResult::EliminaSuccess->value;
        if(!$res) $messaggio =  EAnnuncioResult::EliminaFailed->value;

        $messaggio .= ": " . $titolo;
        
        $user->getNotifiche()->creaNotifica($user->getID(),$messaggio);
        
        // $user->fetchNotifiche();
        header("Location: $rootDir/home");

        break;
    }

    case '/annuncio/view':{
//        echo "qui annuncio/view";
        global $user;
        checkLogin(EUserType::Entrambi);

        if(isset($_REQUEST["idnotifica"])){
            $idNotifica = $_REQUEST["idnotifica"];
            Notifica::leggi($idNotifica);
        }
//        var_dump($annuncio);
        include("page/pageAnnuncio.php");
//        annuncioPage($user->getAnnunci()[$_REQUEST['id']]);

        break;
    }

    case '/annuncio/preventiva':{
        // echo "qui annuncio/preventiva";
        global $user;
        checkLogin(EUserType::Professionista);
        // var_dump($_POST);
        
        $_POST["compenso"] = (int) $_POST["compenso"];
        $res = $user->creaPreventivo($_POST["idannuncio"] , $_POST["compenso"] , $_POST["descrizione"]);

        
        $messaggio = "Preventivo inviato";
        if(!$res) $messaggio =  "Preventivo non inviato";
        
        $annuncio = new Annuncio($_POST["idannuncio"]);
        $titolo = $annuncio->getTitolo();
        $messaggio .= ": " . $titolo;
        $redirect = "$rootDir/annuncio/view?id=".$_POST["idannuncio"];
        
        $user->getNotifiche()->creaNotifica($user->getID(),$messaggio, $redirect);
        
        
        if($res){
            $inserzionista = $annuncio->getInserzionista(); 
            $messaggio = "Hai ricevuto un preventivo da parte di {$user->getNome()} {$user->getCognome()}";
            $messaggio .= ": " . $titolo;
            $redirect = "$rootDir/annuncio/view?id=".$_POST["idannuncio"];
            
            Notifica::crea($inserzionista->getID(),$messaggio, $redirect);
        }
        
        header("Location: $rootDir/home");

        break;
    }
    
    case '/annuncio/accettaPreventivo':{
        // echo "qui annuncio/accettaPreventivo";
        global $user;
        checkLogin(EUserType::Inserzionista);
        // var_dump($_POST);

        $res = $user->accettaPreventivo($_POST["idannuncio"] , $_POST["idpreventivo"]);
        // var_dump($res);

        $messaggio = "Preventivo accettato";
        if(!$res) $messaggio =  "Preventivo non accettato";
        $annuncio = new Annuncio($_POST["idannuncio"]);
        $titolo = $annuncio->getTitolo();
        $messaggio .= ": " . $titolo;
        $redirect = "$rootDir/annuncio/view?id=".$_POST["idannuncio"];
        $user->getNotifiche()->creaNotifica($user->getID(),$messaggio, $redirect);

        
        if($res){
            $professionista = $annuncio->getPreventivoAccettato()->getProfessionista(); 
            $messaggio = "{$user->getNome()} {$user->getCognome()} ha accettato il tuo preventivo";
            $messaggio .= ": " . $titolo;
            $redirect = "$rootDir/annuncio/view?id=".$_POST["idannuncio"];
            
            Notifica::crea($professionista->getID(),$messaggio, $redirect);
        }
                

        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);

        break;
    }
   
    case '/annuncio/rifiutaPreventivo':{
        // echo "qui annuncio/rifiutaPreventivo";
        global $user;
        checkLogin(EUserType::Inserzionista);
        // var_dump($_POST);
        
        $annuncio = new Annuncio($_POST["idannuncio"]);
        $preventivoRifiutato = $annuncio->getPreventivoAccettato();
        $res = $user->rifiutaPreventivo($_POST["idannuncio"] , $_POST["idpreventivo"]);
        // $res = true;
        // var_dump($res) ;

        $messaggio = "Preventivo rifiutato";
        if(!$res) $messaggio =  "Preventivo non rifiutato";
        $titolo = $annuncio->getTitolo();
        $messaggio .= ": " . $titolo;
        $redirect = "$rootDir/annuncio/view?id=".$_POST["idannuncio"];
        $user->getNotifiche()->creaNotifica($user->getID(),$messaggio, $redirect);

        if($res){
            // var_dump($annuncio);
            var_dump($preventivoRifiutato->getProfessionista());
            // var_dump($preventivoRifiutato->getPreventivoAccettato());
            $professionista = $preventivoRifiutato->getProfessionista(); 
            $messaggio = "{$user->getNome()} {$user->getCognome()} ha rifiutato il tuo preventivo";
            $messaggio .= ": " . $titolo;
            $redirect = "$rootDir/annuncio/view?id=".$_POST["idannuncio"];
            
            Notifica::crea($professionista->getID(),$messaggio, $redirect);
        }

        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);

        break;
    }
    
    case '/annuncio/pagaPreventivo':{
        echo "qui annuncio/pagaPreventivo";
        global $user;
        checkLogin(EUserType::Inserzionista);
        // var_dump($_POST);
        // $user->fetchAnnunci();
        $res = $user->pagaPreventivo($_POST["idannuncio"] , $_POST["idpreventivo"]);
        // var_dump($res);

        $messaggio = "Preventivo pagato";
        if(!$res) $messaggio =  "Preventivo non pagato";
        $annuncio = new Annuncio($_POST["idannuncio"]);
        $titolo = $annuncio->getTitolo();
        $messaggio .= ": " . $titolo;
        $redirect = "$rootDir/annuncio/view?id=".$_POST["idannuncio"];
        $user->getNotifiche()->creaNotifica($user->getID(),$messaggio, $redirect);

        if($res){
            $professionista = $annuncio->getPreventivoAccettato()->getProfessionista(); 
            $messaggio = "{$user->getNome()} {$user->getCognome()} ha pagato il tuo preventivo";
            $messaggio .= ": " . $titolo;
            $redirect = "$rootDir/annuncio/view?id=".$_POST["idannuncio"];
            
            Notifica::crea($professionista->getID(),$messaggio, $redirect);
        }

        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);

        break;
    }

    case '/annuncio/aggiornaPreventivo':{
        echo "qui annuncio/aggiornaPreventivo";
        global $user;
        checkLogin(EUserType::Professionista);
        // var_dump($_POST);
        $res = $user->aggiornaPreventivo($_POST["idannuncio"], $_POST["idpreventivo"], $_POST["compenso"], $_POST["descrizione"]);
        // var_dump($res);


        $messaggio = "Preventivo aggiornato";
        if(!$res) $messaggio =  "Preventivo non aggiornato";
        $annuncio = new Annuncio($_POST["idannuncio"]);
        $titolo = $annuncio->getTitolo();
        $messaggio .= ": " . $titolo;
        $redirect = "$rootDir/annuncio/view?id=".$_POST["idannuncio"];
        $user->getNotifiche()->creaNotifica($user->getID(),$messaggio, $redirect);
        
        
        if($res){
            $inserzionista = $annuncio->getInserzionista(); 
            $messaggio = "È stato aggiornato il preventivo da parte di {$user->getNome()} {$user->getCognome()}";
            $messaggio .= ": " . $titolo;
            $redirect = "$rootDir/annuncio/view?id=".$_POST["idannuncio"];
            
            Notifica::crea($inserzionista->getID(),$messaggio, $redirect);
        }
        
        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);

        break;
    }
    
    case '/annuncio/eliminaPreventivo':{
        echo "qui annuncio/eliminaPreventivo";
        global $user;
        checkLogin(EUserType::Professionista);
        // var_dump($_POST);
        // $user->fetchAnnunci();
        $res = $user->eliminaPreventivo($_POST["idannuncio"], $_POST["idpreventivo"]);
        // var_dump($res);

        $messaggio = "Preventivo eliminato";
        if(!$res) $messaggio =  "Preventivo non eliminato";
        $annuncio = new Annuncio($_POST["idannuncio"]);
        $titolo = $annuncio->getTitolo();
        $messaggio .= ": " . $titolo;
        $redirect = "$rootDir/annuncio/view?id=".$_POST["idannuncio"];
        $user->getNotifiche()->creaNotifica($user->getID(),$messaggio, $redirect);

        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);

        break;
    }

    case '/utente':{
        // echo "qui/utente";
        global $user;
        checkLogin(EUserType::Entrambi);

        if( $user->getTipo() == 'ins' || $_REQUEST["id"] == $user->getID()){
            include("page/pageUtente.php");
        }
        else{
            header("Location: $rootDir/home");
        }


        break;
    }

    case '/utente/recensisce':{
        // echo "qui/utente/recensisce";
        global $user;
        checkLogin(EUserType::Entrambi);

        // var_dump($_POST);

        $res = $user->recensisce( $_POST["idrecensito"], $_POST["idpreventivo"],
                         $_POST["descrizione"],  $_POST["voto"]);
        // var_dump($res);

        $messaggio = "Recensione aggiunta";
        if(!$res) $messaggio =  "Preventivo non aggiunta";
        $titolo = (new Annuncio($_POST["idannuncio"]))->getTitolo();
        $messaggio .= ": " . $titolo;
        $redirect = "$rootDir/utente?id=".$_POST["idrecensito"];
        $user->getNotifiche()->creaNotifica($user->getID(),$messaggio, $redirect);

        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);
        $user->fetchAnnunci();
        break;
    }

    case '/pdf':{ // TODO: da eliminare
        include_once("page/pdf.php");
        break;
    }
    
    case '/fattura':{
        echo "qui/fattura";
        global $user;
        checkLogin(EUserType::Entrambi);
        var_dump($_REQUEST);
        $preventivo = Preventivo::withID($_REQUEST["id"]);
        $preventivo->creaFattura();

        break;
    }
    case '/annuncio/logout':
    case '/logout':
    {
        logout();
        header("Location: $rootDir/index");
    }
    default:
    {
    //    header("Location: $rootDir/index");
        include("index.html");
        break;
    }

}



// Signin

/* $result = User::signin("edoardo.cavallo@gmail.com", "ciao", "CODICE___FISCALE","Edoardo","Cavallo",
                        "Grottaglie","74023","via Dante Alighieri" ,3,"3926013815","PARTITA_IVA",'ins');

var_dump($result); */

?>