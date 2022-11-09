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

    case '/annuncio/creaAnnuncio':
    {
        // echo "qui annuncio/creaAnnuncio";
        global $user;
        checkLogin(EUserType::Inserzionista);
        //var_dump($user);
        if(!$user->getTipo() == EUserType::Inserzionista->value)
            exit("Non hai diritto di creare un annuncio");


        //        var_dump($_POST);
        $res = $user->creaAnnuncio(
            $_POST["titolo"],
            $_POST["descrizione"],
            $_POST["luogo_lavoro"],
            $_POST["dimensione_giardino"],
            $_POST["tempistica"],
            $_POST["tempistica_unita"]
        );

        header("Location: $rootDir/home");
        //        var_dump($res);


        break;
    }
    case '/annuncio/aggiornaAnnuncio':{
        // echo "qui annuncio/aggiornaAnnuncio";
        checkLogin(EUserType::Inserzionista);
        global $user;
    //    var_dump($_POST);
        
        $user->fetchAnnunci();
        $user->aggiornaAnnuncio(
            $_POST["idannuncio"],
            $_POST["titolo"],
            $_POST["descrizione"],
            $_POST["luogo_lavoro"],
            $_POST["dimensione_giardino"],
            $_POST["tempistica"],
            $_POST["tempistica_unita"]
        );

        $user->fetchAnnunci();
        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);

        break;
    }

    case '/annuncio/eliminaAnnuncio':{
        echo "qui annuncio/eliminaAnnuncio";
        global $user;
        checkLogin(EUserType::Inserzionista);

        $user->fetchAnnunci();
        $user->deleteAnnuncio($_POST["idannuncio"]);

        header("Location: $rootDir/home");

        break;
    }

    case '/annuncio/view':{
//        echo "qui annuncio/view";
        global $user;
        checkLogin(EUserType::Entrambi);

        
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
        $user->creaPreventivo($_POST["idannuncio"] , $_POST["compenso"] , $_POST["descrizione"]);

        header("Location: $rootDir/home");

        break;
    }
    
    case '/annuncio/accettaPreventivo':{
        // echo "qui annuncio/accettaPreventivo";
        global $user;
        checkLogin(EUserType::Inserzionista);
        // var_dump($_POST);

        $res = $user->accettaPreventivo($_POST["idannuncio"] , $_POST["idservizio"]);
        // var_dump($res);

        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);

        break;
    }
   
    case '/annuncio/rifiutaPreventivo':{
        // echo "qui annuncio/rifiutaPreventivo";
        global $user;
        checkLogin(EUserType::Inserzionista);
        // var_dump($_POST);

        $res = $user->rifiutaPreventivo($_POST["idannuncio"] , $_POST["idservizio"]);
        // var_dump($res) ;
        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);

        break;
    }
    
    case '/annuncio/pagaPreventivo':{
        echo "qui annuncio/pagaPreventivo";
        global $user;
        checkLogin(EUserType::Inserzionista);
        // var_dump($_POST);
        // $user->fetchAnnunci();
        $res = $user->pagaPreventivo($_POST["idannuncio"] , $_POST["idservizio"]);
        // var_dump($res);

        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);

        break;
    }

    case '/annuncio/aggiornaPreventivo':{
        echo "qui annuncio/aggiornaPreventivo";
        global $user;
        checkLogin(EUserType::Professionista);
        // var_dump($_POST);
        $res = $user->aggiornaPreventivo($_POST["idannuncio"], $_POST["idservizio"], $_POST["compenso"], $_POST["descrizione"]);
        // var_dump($res);

        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);

        break;
    }
    
    case '/annuncio/eliminaPreventivo':{
        echo "qui annuncio/eliminaPreventivo";
        global $user;
        checkLogin(EUserType::Professionista);
        // var_dump($_POST);
        // $user->fetchAnnunci();
        $res = $user->eliminaPreventivo($_POST["idannuncio"], $_POST["idservizio"]);
        // var_dump($res);

        header("Location: $rootDir/annuncio/view?id=". $_POST["idannuncio"]);

        break;
    }

    case '/utente':{
        echo "qui/user";
        global $user;
        checkLogin(EUserType::Entrambi);

        include("page/pageUser.php");

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
        // include("index.html");       // TODO da togliere commento
        break;
    }

}



// Signin

/* $result = User::signin("edoardo.cavallo@gmail.com", "ciao", "CODICE___FISCALE","Edoardo","Cavallo",
                        "Grottaglie","74023","via Dante Alighieri" ,3,"3926013815","PARTITA_IVA",'ins');

var_dump($result); */

?>