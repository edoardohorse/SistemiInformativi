<?php
    //include_once ("user.php");
    include_once("views/viewHome.php");
    include_once("views/viewAnnuncio.php");
    include_once("views/viewPreventivo.php");
    
    // $user->fetchAnnunci();
    $annuncio = $user->getAnnunci()[$_REQUEST['id']];
    // var_dump($annuncio);
//    var_dump($user);


    $title  = $annuncio->getTitolo();
    $body   =  "";
    $modal  = "";
    $cssStr = ["../css/main.css","../css/annuncio.css"];


    switch($user->getTipo()) {
        case EUserType::Inserzionista->value:{

            $header = intestazioneInsAnnuncio($annuncio);
            $modal .= modalAggiornaAnnuncio($annuncio);
            $modal .= modalEliminaAnnuncio($annuncio);            
            

            $body .= viewAnnuncio($annuncio, false);

            $annuncio->fetchPreventivi();
            $preventivoAccettato = $annuncio->getPreventivoAccettato();
            $preventiviNonAccettati = $annuncio->getPreventiviNonAccettati();

            if($preventivoAccettato){
                $modal .= modalRifiutaPreventivo($preventivoAccettato);
                $modal .= modalPagaPreventivo($preventivoAccettato);
                    
            }
            else{
                foreach($preventiviNonAccettati as $preventivo){
                    $modal .= modalAccettaPreventivo($preventivo);
                }    
            }
            
            // var_dump($preventivoAccettato, $preventiviNonAccettati);
            $body .= wrapperPreventivi($preventivoAccettato, $preventiviNonAccettati);

            break;
        }
        case EUserType::Professionista->value:{
            $header = intestazioneProAnnuncio($annuncio);
            $modal .= modal(modalAddPreventivoAnnuncio($annuncio), 'modalPreventivoAnnuncio');
            $body .= viewAnnuncio($annuncio, false);

        break;}
    }
    


    echo home($title, $header, $body, $modal, $cssStr);
?>
