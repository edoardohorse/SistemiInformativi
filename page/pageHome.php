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
            $modal = modal(modalCreaAnnuncio(), 'modalNewAnnuncio');

            $annunciIns = [];
            array_push($annunciIns, $user->getAnnunciPreventivabili());
            array_push($annunciIns, $user->getAnnunciPreventivati());
            array_push($annunciIns, $user->getAnnunciAccettati());
            $body .= wrapperAnnunci($annunciIns, ["Miei annunci", "Già preventivati", "Accettati"]);
            
            break;
        }
        case EUserType::Professionista->value:{
            $header = intestazioneProHome($user);

            $annunciPro = [];
            array_push($annunciPro, $user->getAnnunciPreventivabili());
            array_push($annunciPro, $user->getAnnunciPreventivati());
            array_push($annunciPro, $user->getAnnunciAccettati());
            $body .= wrapperAnnunci($annunciPro, ["Preventivabili", "I miei preventivi" ,"Accettati"]);

        break;}
    }

    echo home($title, $header, $body, $modal, ['css/main.css']);
?>

