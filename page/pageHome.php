<?php
    //include_once ("user.php");
    include_once("views/viewHome.php");
    include_once("views/viewAnnuncio.php");

    $user->fetchAnnunci();
    $user->fetchNotifiche();
    // var_dump($user->getNotifiche()->notifiche);
//    var_dump($user);


    $title  = "Home";
    $body   =  "";
    $modal  = "";


    switch($user->getTipo()) {
        case EUserType::Inserzionista->value:{

            [$header, $nav] = intestazioneInsHome($user);
            $modal  = modalCreaAnnuncio();

            $annunciIns = [];
            $inserzionista = Inserzionista::withID($user->getID());
            $inserzionista->fetchAnnunci();
            array_push($annunciIns, $inserzionista->getAnnunciPreventivabili());
            array_push($annunciIns, $inserzionista->getAnnunciPreventivati());
            array_push($annunciIns, $inserzionista->getAnnunciAccettati());
            array_push($annunciIns, $inserzionista->getAnnunciPagati());
            $body .= wrapperAnnunci($annunciIns, ["Miei annunci", "Già preventivati", "Accettati", "Pagati"]);
            
            break;
        }
        case EUserType::Professionista->value:{
            [$header, $nav] = intestazioneProHome($user);

            $annunciPro = [];
            $professionista = Professionista::withID($user->getID());
            $professionista->fetchAnnunci();
            array_push($annunciPro, $professionista->getAnnunciPreventivabili());
            array_push($annunciPro, $professionista->getAnnunciPreventivati());
            array_push($annunciPro, $professionista->getAnnunciAccettati());
            array_push($annunciPro, $professionista->getAnnunciPagati());
            $body .= wrapperAnnunci($annunciPro, ["Annunci", "Preventivati" ,"Accettati", "Pagati"]);

        break;}
    }

    echo home($title, $header, $nav ,$body, $modal, ['css/main.css']);
?>

