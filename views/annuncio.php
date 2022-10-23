<?php

include_once("php/annuncio.php");
include_once("home.php");



function viewAnnuncio(Annuncio $annuncio, bool $showTitle = true) {
    $title = "<h2>Dettagli</h2>";

    if( $showTitle ) {
        $title= "
            <header>
                <h2>
                    <a href='./annuncio/view?id={$annuncio->getId()}'>{$annuncio->getTitolo()}</a>
                </h2></span>
            </header>";
    }

    return "        
        <section class='annuncio'>
            <input type='hidden' name='idannuncio' value {$annuncio->getId()}>
            {$title}
            <main>
                <div>
                    <label>Creato il:</label>
                    <span>{$annuncio->getTimestamp()}</span>
                </div>
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
        </section>";
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
       <form method='POST' action='./edit'>
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

function viewEraseAnnuncio(Annuncio $annuncio){

    return "
       <form method='POST' action='./delete' id='form{$annuncio->getId()}'>
            <input type='hidden' name='idannuncio' value={$annuncio->getId()}>
                <h3>Sei sicuro di voler eliminare l'annuncio '{$annuncio->getTitolo()}'? </h3>
                <input type='submit' value='Si'>
        </form>
    ";

}

function viewAddPreventivoAnnuncio(Annuncio $annuncio){
    $settimana = $annuncio->getTempisticaUnita()=='settimana'?'selected':'';
    $mese = $annuncio->getTempisticaUnita()=='mese'?'selected':'';
    return "
        <form method='POST' action='./preventiva'>
            <div>
                <input type='hidden' name='idannuncio' value='{$annuncio->getId()}'>
                
                <label for='descrizione'>Descrizione</label>
                <textarea  name='descrizione'></textarea>
                   
                <label for='compenso'>Compenso</label>
                <input type='number' name='compenso'>€
            </div>
            
            
            <div>
                <label for='titolo'>titolo</label><br>
                <span>{$annuncio->getTitolo()}</span>
                <br>
                <label for='descrizione'>Descrizione</label><br>
                <span>{$annuncio->getDescrizione()}</span>
                <br>
                <label for='luogo_lavoro'>Luogo lavoro</label><br>
                <span>{$annuncio->getLuogolavoro()}</span>
                <br>
                <label for='dimensione_giardino'>Dimensione giardino</label><br>
                <span>{$annuncio->getDimensioneGiardino()}</span>
                <br>
                <label for='tempistica'>tempistica</label><br>
                <span>{$annuncio->getTempistica()}{$annuncio->getTempisticaUnita()}</span>            
            </div>
            
            <input type='submit'>
        </form>
    ";
}


function viewPreventivi($preventivi){

    $n = count($preventivi);
    $html = "";

    if($n == 0){
        $html = "<h3>Non ci sono preventivi per questo annuncio</h3>";
    }


    foreach ($preventivi as $preventivo) {

        $html .= "
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

    return "
        <section class='preventivo-wrapper'>
            <h2>Preventivi ($n)</h2>
            <div class='preventivo-content'>
                {$html}
            </div>
        </section>
    ";

}

?>