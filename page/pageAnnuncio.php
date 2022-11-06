<?php
    //include_once ("user.php");
    include_once("views/viewHome.php");
    include_once("views/viewAnnuncio.php");
    include_once("views/viewPreventivo.php");
    
    // $user->fetchAnnunci();
    $annuncio = $user->getAnnunci()[$_REQUEST['id']];
    $annuncio->fetchPreventivi();
    $preventivoAccettato    = $annuncio->getPreventivoAccettato();
    $preventiviNonAccettati = $annuncio->getPreventiviNonAccettati();
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
            $preventivo = $user->getPreventivoEmesso($annuncio->getId());

            // var_dump($preventivo);
            $header = intestazioneProPreventivo($annuncio, $preventivo);
            $body .= viewAnnuncio($annuncio, false, $annuncio->getInserzionista()->getTelefono());

            $titleView = "Preventivo emesso";
            if($preventivo->isAccettato()){
                $titleView = "Preventivo accettato";
            }
            else{
                $modal .= modalAggiornaPreventivo($preventivo);
                $modal .= modalErasePreventivo($preventivo);
            }

            $body .= viewPreventivi([$preventivo], $titleView , false);

            break;
        }
    }
    


    echo home($title, $header, $body, $modal, $cssStr);
?>
