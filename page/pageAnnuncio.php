<?php
    //include_once ("user.php");
    include_once("views/viewHome.php");
    include_once("views/viewAnnuncio.php");
    include_once("views/viewPreventivo.php");
    
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

            $header = intestazioneInsAnnuncio($annuncio);
            $modal .= modal(modalEditAnnuncio($annuncio), 'modalEditAnnuncio');
            $modal .= modal(modalEraseAnnuncio($annuncio), 'modalEraseAnnuncio');
            $body .= viewAnnuncio($annuncio, false);
            $preventivi = $annuncio->getPreventivi();

            $body .= viewPreventivi($preventivi);

            break;
        }
        case EUserType::Professionista->value:{
            $header = intestazioneProAnnuncio($annuncio);
            $modal .= modal(modalAddPreventivoAnnuncio($annuncio), 'modalPreventivoAnnuncio');
            $body .= viewAnnuncio($annuncio, false);
            $preventivi = $annuncio->getPreventivi();
            $body .= viewPreventivi($preventivi);

        break;}
    }

    
    
    


    echo home($title, $header, $body, $modal, $cssStr);
?>
