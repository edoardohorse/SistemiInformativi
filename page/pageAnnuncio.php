<?php
    //include_once ("user.php");
    include_once("views/viewHome.php");
    include_once("views/viewAnnuncio.php");
    include_once("views/viewPreventivo.php");
    
    $user->fetchAnnunci();
    $user->fetchNotifiche();
    $annuncio = $user->getAnnunci()[$_REQUEST['id']];
    $annuncio->fetchPreventivi();
    ;
    // var_dump($annuncio);
//    var_dump($user);


    $title  = $annuncio->getTitolo();
    $body   =  "";
    $modal  = "";
    $cssStr = ["../css/main.css","../css/annuncio.css"];


    switch($user->getTipo()) {
        case EUserType::Inserzionista->value:{

            $preventivoAccettato    = $annuncio->getPreventivoAccettato();
            $preventiviNonAccettati = $annuncio->getPreventiviNonAccettati();

            [$header, $nav] = intestazioneInsAnnuncio($annuncio);
            $modal .= modalAggiornaAnnuncio($annuncio);
            $modal .= modalEliminaAnnuncio($annuncio);            

            $body .= viewAnnuncio($annuncio, false);


            if($preventivoAccettato){
                if($preventivoAccettato->isPagato()){
                    // $modal .= modalMostraFattura($preventivoAccettato);
                    // var_dump($preventivoAccettato->isRecensito());
                    if($preventivoAccettato->isRecensito()){
                        // TODO modifica ed elimina recensione 
                        // $modal .= modalAggiornaRecensione($preventivoAccettato, $preventivoAccettato->getProfessionista());
                        // $modal .= modalEliminaRecensione($preventivoAccettato, $preventivoAccettato->getProfessionista());
                    }
                    else{
                        $modal .= modalCreaRecensione($preventivoAccettato, $preventivoAccettato->getProfessionista());
                    }
                }
                else{
                    $modal .= modalRifiutaPreventivo($preventivoAccettato);
                    $modal .= modalPagaPreventivo($preventivoAccettato);
                }
                        
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
            [$header, $nav] = intestazioneProPreventivo($annuncio, $preventivo);
            $body .= viewAnnuncio($annuncio, false, true, $annuncio->getInserzionista()->getTelefono());

            if($preventivo){

                $titleView = "Preventivo emesso";
                if($preventivo->isAccettato()){
                    $titleView = "Preventivo accettato";
                    if($preventivo->isPagato()){
                        $titleView = "Preventivo pagato";
                        // $modal .= modalMostraFattura($preventivoAccettato);
                        if($preventivo->isRecensito()){
                            // TODO modifica ed elimina recensione 
                        }
                        else{
                            $recensito = $annuncio->getInserzionista();
                            $modal .= modalCreaRecensione($preventivo, $recensito);
                        }
                    }   
                }
                else{
                    $modal .= modalAggiornaPreventivo($preventivo);
                    $modal .= modalEliminaPreventivo($preventivo);
                }
                
                $body .= viewPreventivi([$preventivo], $titleView , false);
            }
            else{
                $modal .= modalCreaPreventivo($annuncio);
            }
            // var_dump($body);
            break;
        }
    }
    


    echo home($title, $header, $nav, $body, $modal, $cssStr);
?>
