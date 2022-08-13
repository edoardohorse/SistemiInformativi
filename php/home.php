<?php
    //include_once ("user.php");
    include_once("views/home.php");
    include_once("views/annuncio.php");
    $user = &$_SESSION["user"];
    $user->fetchAnnunci();
//    var_dump($user);


    $title = "Home";
    $body =  "";

    foreach ($user->getAnnunci() as $annuncio) {
        $body .= viewAnnuncio($annuncio);
    }

    switch($user->getTipo()) {
        case EUserType::Inserzionista->value:{

            $header = intestazioneIns($user);

            $modal = modal(viewAddAnnuncio(), 'modalNewAnnuncio');

            echo home($title, $header, $body, $modal);
            break;
        }
        case EUserType::Professionista->value:{
            $header = intestazionePro($user);

            echo home($title, $header, $body);
        break;}
    }
?>

