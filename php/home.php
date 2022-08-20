<?php
    //include_once ("user.php");
    include_once("views/home.php");
    include_once("views/annuncio.php");
    $user = &$_SESSION["user"];
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
                $modal.= modal(viewEditAnnuncio($annuncio), 'modalEditAnnuncio'.$annuncio->getId());
                $modal.= modal(viewEraseAnnuncio($annuncio), 'modalEraseAnnuncio'.$annuncio->getId());
            }

            break;
        }
        case EUserType::Professionista->value:{
            $header = intestazionePro($user);

            foreach ($user->getAnnunci() as $annuncio) {
                $body .= viewAnnuncio($annuncio, false, true );
                $modal.= modal(viewAddPreventivoAnnuncio($annuncio), 'modalPreventivoAnnuncio'.$annuncio->getId());
            }

        break;}
    }

    echo home($title, $header, $body, $modal);
?>

