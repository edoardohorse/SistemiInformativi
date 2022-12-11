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
            array_push($annunciIns, $user->getAnnunciPreventivabili());
            array_push($annunciIns, $user->getAnnunciPreventivati());
            array_push($annunciIns, $user->getAnnunciAccettati());
            $body .= wrapperAnnunci($annunciIns, ["Miei annunci", "Già preventivati", "Accettati"]);
            
            break;
        }
        case EUserType::Professionista->value:{
            [$header, $nav] = intestazioneProHome($user);

            $annunciPro = [];
            array_push($annunciPro, $user->getAnnunciPreventivabili());
            array_push($annunciPro, $user->getAnnunciPreventivati());
            array_push($annunciPro, $user->getAnnunciAccettati());
            $body .= wrapperAnnunci($annunciPro, ["Preventivabili", "Preventivati da me" ,"Accettati"]);

        break;}
    }

    echo home($title, $header, $nav ,$body, $modal, ['css/main.css']);
?>

