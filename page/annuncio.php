<?php
    //include_once ("user.php");
    include_once("views/home.php");
    include_once("views/annuncio.php");
    
    $annuncio = $user->getAnnunci()[$_REQUEST['id']];
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
           

            break;
        }
        case EUserType::Professionista->value:{
            $header = intestazionePro($user);
            $modal .= modal(viewAddPreventivoAnnuncio($annuncio), 'modalPreventivoAnnuncio');


        break;}
    }

    
    $body.= "<div>
            <label>Descrizione:</label>
            <span>{$annuncio->getDescrizione()}</span>
        </div>
        <div>
            <label>Luogo:</label>
            <span>{$annuncio->getLuogolavoro()}</span>
        </div>
        <div>
            <label>Dimensione giardino:</label>
            <span>{$annuncio->getDimensioneGiardino()}</span>m&#178;
        </div>
        <div>
            <label>Tempistica:</label>
            <span>{$annuncio->getTempistica()} {$annuncio->getTempisticaUnita()}</span>
        </div>";


    $body.="<div id='preventivi'>";
    
    if($annuncio->isPreventivato()){

        $annuncio->fetchPreventivi();
        $n  =count($annuncio->getPreventivi());
        $body.= "<h2>Ci sono {$n} preventivi</h2>";
        foreach($annuncio->getPreventivi() as $preventivo){
        
            $body .="
            <div class='preventivo'>
                <div>
                    <label>Descrizione:</label>
                    <span>{$preventivo['descrizione']}</span>
                </div>
                <div>
                    <label>Luogo:</label>
                    <span>{$preventivo['compenso']}</span>
                </div>
            </div>";
        }
        
        
    }
    else $body.= "<h2>Non ci sono ancora preventivi per questo annuncio.</h2>";
    $body .= "</div>";

    echo home($title, $header, $body, $modal, $cssStr);
?>
