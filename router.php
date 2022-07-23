<?php

$request = $_SERVER['REQUEST_URI'];
$rootDir = explode("\\",__DIR__);
$rootDir = "/".$rootDir[count($rootDir)-1];
$request = str_replace($rootDir, "", $request );
var_dump($rootDir,$request);

switch($request) {
    case '/':{
        echo "qui '/'";
        require_once("public/index.html");break;
    }
    case '/user' :{
        require_once("/php/user.php");
        break;
    }

    default:{
        // echo "qui default";
        header("Location: $rootDir");
        break;
    }

}
// Login 

/*
$result = User::login("giando.monopoli@gmail.com","ciao");   // ins
// $result = User::login("carlo.derossi@gmail.com","ciao");     // pro


if($result == EUserLoginResult::LoginSuccess){
    
    switch($_SESSION["tipo"]){
        case EUserType::Inserzionista->value:{ $_SESSION["user"] = new Inserzionista();  break;}
        case EUserType::Professionista->value:{ $_SESSION["user"] = new Professionista(); break;}
    }

    
}


var_dump($_SESSION,$result);
*/

// Signin

/* $result = User::signin("edoardo.cavallo@gmail.com", "ciao", "CODICE___FISCALE","Edoardo","Cavallo",
                        "Grottaglie","74023","via Dante Alighieri" ,3,"3926013815","PARTITA_IVA",'ins');

var_dump($result); */

?>