<?php

include_once("php/annuncio.php");

function viewAnnuncio(Annuncio $annuncio){
    return "        
        <article class='annuncio'>
        
                <input type='hidden' name='idannuncio' value {$annuncio->getId()}>
            <header>
                <h2>{$annuncio->getTitolo()}</h2> &#8901; {$annuncio->getTimestamp()}
            </header>
            <main>
                <label>Descrizione:</label>
                <span>{$annuncio->getDescrizione()}</span>
                <br>
                <label>Luogo:</label>
                <span>{$annuncio->getLuogolavoro()}</span>
                <br>
                <label>Dimensione giardino:</label>
                <span>{$annuncio->getDimensioneGiardino()}m&#178;</span>
                <br>
                <label>Tempistica:</label>
                <span>{$annuncio->getTempistica()} {$annuncio->getTempisticaUnita()}</span>                        
            </main>
        </article>";
}

function viewAddAnnuncio(){
    return "
       <form method='POST' action='./annuncio/new'>
            
                <label for='titolo'>titolo</label><br>
                <input type='text' name='titolo' required value='Piantagione Pomodori'>
                <br>
                <label for='descrizione'>Descrizione</label><br>
                <textarea name='descrizione' required placeholder='Scrivi...'>Ho bisogno di una mano per piantare</textarea>
                <br>
                <label for='luogo_lavoro'>Luogo lavoro</label><br>
                <input type='text' name='luogo_lavoro' required value='Grottaglie, Via Tacito'>
                <br>
                <label for='dimensione_giardino'>Dimensione giardino</label><br>
                <input type='number' min=1 name='dimensione_giardino' required style='text-align: right;' value='5'> m&#178
                <br>
                <label for='tempistica'>tempistica</label><br>
                <input type='number' min=1 max=6 name='tempistica' required value='3'>
                <select name='tempistica_unita' required>
                    <option value='settimana'>settimana</option>
                    <option value='mese'>mese</option>
                </select>
            
            <input type='submit'>
        </form>
    ";
}


?>