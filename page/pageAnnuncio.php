<?php
    //include_once ("user.php");
    include_once("views/viewHome.php");
    include_once("views/viewAnnuncio.php");
    
    $annuncio = $user->getAnnunci()[$_REQUEST['id']];
    $annuncio->fetchPreventivi();
    
    // $user->fetchAnnunci();
//    var_dump($user);


    $title  = $annuncio->getTitolo();
    $body   =  "";
    $modal  = "";
    $cssStr = ["../css/main.css","../css/annuncio.css"];


    switch($user->getTipo()) {
        case EUserType::Inserzionista->value:{

            $header = intestazioneInsAnnuncio($user, $annuncio);
            $modal .= modal(viewEditAnnuncio($annuncio), 'modalEditAnnuncio');
            $modal .= modal(viewEraseAnnuncio($annuncio), 'modalEraseAnnuncio');
            $body .= viewAnnuncio($annuncio, false);
            $preventivi = $annuncio->getPreventivi();
            // var_dump($preventivi);
            $body .= viewPreventivi($preventivi);

            break;
        }
        case EUserType::Professionista->value:{
            $header = intestazioneProAnnuncio($user, $annuncio);
            $modal .= modal(viewAddPreventivoAnnuncio($annuncio), 'modalPreventivoAnnuncio');
            $body .= viewAnnuncio($annuncio, false);

        break;}
    }

    
    
    


    echo home($title, $header, $body, $modal, $cssStr);
?>
