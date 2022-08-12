<?php
    //include_once ("user.php");
    include_once("views/home.php");
    include_once("views/annuncio.php");
    $user = &$_SESSION["user"];
    $user->fetchAnnunci();
//    var_dump($user);


    $title = "Home";
    $header = intestazione($user);
    $body =  "";

    foreach ($user->getAnnunci() as $annuncio) {
        $body.= viewAnnuncio($annuncio);
    }
    $modal = modal( viewAddAnnuncio(), 'modalNewAnnuncio');

    echo home($title,$header, $body, $modal);
?>

