<?php
    //include_once ("user.php");
    include_once("views/home.php");
    include_once("views/annuncio.php");
    $user = &$_SESSION["user"];
    $user->fetchAnnunci();
//    var_dump($user);


    $title = "Home";
    $body =  "<h1>Benvenuto {$user->getNome()} {$user->getCognome()} ({$user->getTipo()})</h1>";
    foreach ($user->getAnnunci() as $annuncio) {
        $body.= viewAnnuncio($annuncio);
    }

    echo home($title,$body);
?>

