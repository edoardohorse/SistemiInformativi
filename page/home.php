<?php
    //include_once ("user.php");
    include_once("views/viewHome.php");
    include_once("views/viewAnnuncio.php");

    $user->fetchAnnunci();
//    var_dump($user);


    $title  = "Home";
    $body   =  "";
    $modal  = "";


    switch($user->getTipo()) {
        case EUserType::Inserzionista->value:{

            $header = intestazioneInsHome($user);
            $modal = modal(viewAddAnnuncio(), 'modalNewAnnuncio');


            foreach ($user->getAnnunci() as $annuncio) {
                $body .= viewAnnuncio($annuncio, True);
            }

            break;
        }
        case EUserType::Professionista->value:{
            $header = intestazioneProHome($user);

            foreach ($user->getAnnunci() as $annuncio) {
                $body .= viewAnnuncio($annuncio, True );
            }

        break;}
    }

    echo home($title, $header, $body, $modal, ['css/main.css']);
?>

