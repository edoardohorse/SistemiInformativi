<?php
    //include_once ("user.php");
    include_once("views/home.php");
    include_once("views/annuncio.php");

    $user->fetchAnnunci();
//    var_dump($user);


    $title  = "Home";
    $body   =  "";
    $modal  = "";


    switch($user->getTipo()) {
        case EUserType::Inserzionista->value:{

            $header = intestazioneIns($user);
            $modal = modal(viewAddAnnuncio(), 'modalNewAnnuncio');


            foreach ($user->getAnnunci() as $annuncio) {
                $body .= viewAnnuncio($annuncio, True);
            }

            break;
        }
        case EUserType::Professionista->value:{
            $header = intestazionePro($user);

            foreach ($user->getAnnunci() as $annuncio) {
                $body .= viewAnnuncio($annuncio, false, true );
            }

        break;}
    }

    echo home($title, $header, $body, $modal);
?>

