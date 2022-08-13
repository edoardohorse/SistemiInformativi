<?php

$request = $_SERVER['REQUEST_URI'];
$rootDir = explode("\\",__DIR__);
$rootDir = "/".$rootDir[count($rootDir)-1];
$request = str_replace($rootDir, "", $request );
 var_dump($rootDir,$request);

switch($request) {
    case '/index':{
//        echo "qui '/index'";
        include("index.html");
        break;
    }
    case '/home':
    case '/annuncio/new':
    case '/annuncio/edit':
    case '/login':
    case '/logout':
    {
        require_once("php/user.php");break;
    }
    default:{
        // echo "qui default";
        header("Location: $rootDir/index");
        break;
    }

}



// Signin

/* $result = User::signin("edoardo.cavallo@gmail.com", "ciao", "CODICE___FISCALE","Edoardo","Cavallo",
                        "Grottaglie","74023","via Dante Alighieri" ,3,"3926013815","PARTITA_IVA",'ins');

var_dump($result); */

?>