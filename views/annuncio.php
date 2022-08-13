<?php

include_once("php/annuncio.php");



function viewAnnuncio(Annuncio $annuncio, $editable = false){
    if($editable){
        $editStr = "
                <button onclick='document.getElementById(`modalEditAnnuncio{$annuncio->getId()}`).classList.remove(`hide`)'>
                    <span class='material-icons md-18'>edit</span>    
                </button>
                
                <span class='material-icons md-18'>delete</span>
        ";
    }
    else{
        $editStr = "";
    }
    return "        
        <article class='annuncio'>
            <input type='hidden' name='idannuncio' value {$annuncio->getId()}>
            <header>
                <h2>{$annuncio->getTitolo()}</h2> &#8901; <span>{$annuncio->getTimestamp()}</span>
                {$editStr}
            </header>
            <main>
                <div>
                    <label>Descrizione:</label>
                    <span>{$annuncio->getDescrizione()}</span>
                </div>
                <div>
                    <label>Luogo:</label>
                    <span>{$annuncio->getLuogolavoro()}</span>
                </div>
                <div>
                    <label>Dimensione giardino:</label>
                    <span>{$annuncio->getDimensioneGiardino()}m&#178;</span>
                </div>
                <div>
                    <label>Tempistica:</label>
                    <span>{$annuncio->getTempistica()} {$annuncio->getTempisticaUnita()}</span>
                </div>                        
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

function viewEditAnnuncio(Annuncio $annuncio){
    $settimana = $annuncio->getTempisticaUnita()=='settimana'?'selected':'';
    $mese = $annuncio->getTempisticaUnita()=='mese'?'selected':'';
    return "
       <form method='POST' action='./annuncio/edit'>
                 <input type='hidden' name='idannuncio' value='{$annuncio->getId()}'>
                <label for='titolo'>titolo</label><br>
                <input type='text' name='titolo' required value='{$annuncio->getTitolo()}'>
                <br>
                <label for='descrizione'>Descrizione</label><br>
                <textarea name='descrizione' required placeholder='{$annuncio->getDescrizione()}'>Ho bisogno di una mano per piantare</textarea>
                <br>
                <label for='luogo_lavoro'>Luogo lavoro</label><br>
                <input type='text' name='luogo_lavoro' required value='{$annuncio->getLuogolavoro()}'>
                <br>
                <label for='dimensione_giardino'>Dimensione giardino</label><br>
                <input type='number' min=1 name='dimensione_giardino' required style='text-align: right;' value='{$annuncio->getDimensioneGiardino()}'> m&#178
                <br>
                <label for='tempistica'>tempistica</label><br>
                <input type='number' min=1 max=6 name='tempistica' required value='{$annuncio->getTempistica()}'>
                <select name='tempistica_unita' required>
                    <option value='settimana' {$settimana}>settimana</option>
                    <option value='mese' {$mese}>mese</option>
                </select>
            
            <input type='submit'>
        </form>
    ";

}

?>