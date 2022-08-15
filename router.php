<?php

include_once("php/user.php");

$request = $_SERVER['REQUEST_URI'];
$rootDir = explode("\\",__DIR__);
$rootDir = "/".$rootDir[count($rootDir)-1];
$request = str_replace($rootDir, "", $request );
 var_dump($rootDir,$request);


function checkLogin(){
    global $user;
    if(!User::isLogged()) exit("Devi loggarti prima!");

    $GLOBALS['user'] = &$_SESSION["user"];
}


switch ($request) {
    case '/home' :
    {
        checkLogin();

        include("php/home.php");

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

    case '/annuncio/new':
    {
        echo "qui annuncio/new";
        checkLogin();
        global $user;
        //        var_dump($user);
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
    case '/annuncio/edit':{
        echo "qui annuncio/edit";
        checkLogin();
        global $user;
        var_dump($_POST);

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


        header("Location: $rootDir/home");

        break;
    }

    case '/annuncio/delete':{
        echo "qui annuncio/delete";
        checkLogin();

        $user->fetchAnnunci();
        $user->deleteAnnuncio($_POST["idannuncio"]);

        header("Location: $rootDir/home");

        break;
    }

    case '/logout':
    {
        session_start();
        session_destroy();
    }
    default:
    {
//        header("Location: $rootDir/index");
        include("index.html");
        break;
    }

}



// Signin

/* $result = User::signin("edoardo.cavallo@gmail.com", "ciao", "CODICE___FISCALE","Edoardo","Cavallo",
                        "Grottaglie","74023","via Dante Alighieri" ,3,"3926013815","PARTITA_IVA",'ins');

var_dump($result); */

?>