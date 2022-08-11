<?php

include_once("php/annuncio.php");

function viewAnnuncio(Annuncio $annuncio){
    $html = "        
        <article class='annuncio'>
            <header>
                <h2>{$annuncio->getTitolo()}</h2> &#8901; {$annuncio->getTimestamp()}
            </header>
            <main>
                <label>Descrizione:</label>
                <span>{$annuncio->getDescrizione()}</span>
                <br>
                <label>Dimensione giardino:</label>
                <span>{$annuncio->getDimensioneGiardino()}m&#178;</span>
                <br>
                <label>Tempistica:</label>
                <span>{$annuncio->getTempistica()} {$annuncio->getTempisticaUnita()}</span>                        
            </main>
        </article>";

    return $html;
}


?>