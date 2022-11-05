<?php
    //include_once ("user.php");
    include_once("views/viewHome.php");
    include_once("views/viewAnnuncio.php");
    include_once("views/viewPreventivo.php");

    $annnucio   = $user->getAnnunci()[$_REQUEST['idAnnuncio']];
    $preventivo = $user->getPreventivo($_REQUEST['idAnnuncio'], $_REQUEST['idPreventivo']);
    
    // $user->fetchAnnunci();
//    var_dump($user);


    $title  = $annuncio->getTitolo();
    $body   =  "";
    $modal  = "";
    $cssStr = ["../css/main.css","../css/annuncio.css"];


    switch($user->getTipo()) {
        case EUserType::Inserzionista->value:{

            $header = intestazioneInsAnnuncio($user, $annuncio);
            $modal .= modal(modalEditAnnuncio($annuncio), 'modalEditAnnuncio');
            $modal .= modal(modalEraseAnnuncio($annuncio), 'modalEraseAnnuncio');
            $body .= viewAnnuncio($annuncio, false);
            $preventivi = $annuncio->getPreventivi();
            // var_dump($preventivi);
            $body .= viewPreventivi($preventivi);

            break;
        }
        case EUserType::Professionista->value:{
            $header = intestazioneProAnnuncio($user, $annuncio);
            $modal .= modal(modalAddPreventivoAnnuncio($annuncio), 'modalPreventivoAnnuncio');
            $body .= viewAnnuncio($annuncio, false);
            $preventivi = $user->getPreventivi();
            $body .= viewPreventivi($preventivi);

        break;}
    }

    
    
    


    echo home($title, $header, $body, $modal, $cssStr);
