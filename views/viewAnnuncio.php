<?php

include_once("php/annuncio.php");
include_once("php/preventivo.php");
include_once("viewHome.php");

// ------------------------------ INTESTAZIONI

function intestazioneInsAnnuncio(Annuncio $annuncio){
    return "
    <div class='header-info'>
        <h1>{$annuncio->getTitolo()}</h1> 
        <a href='./logout'><button>Logout</button></a>
    </div>
    <nav>
        <button onclick='openModal(`modalAggiornaAnnuncio`)'>Modifica annuncio</button>
        <button onclick='openModal(`modalEliminaAnnuncio`)'>Elimina annuncio</button>
    </nav>
    ";
}

function intestazioneProAnnuncio(Annuncio $annuncio, $daPreventivare = true){
    return "
    <div class='header-info'>
        <h1>{$annuncio->getTitolo()}</h1> 
        <a href='./logout'><button>Logout</button></a>
    </div>
    <nav>
        <button onclick='openModal(`modalPreventivoAnnuncio`)'>Preventiva</button>
    </nav>
    ";
}

// ------------------------------ VIEWS

function wrapperAnnunci($annunci, $titles){
    $htmlTitles = "";
    $first = true;
    foreach($titles as $title){
        if($first){
            $htmlTitles .= "<h2 class='title--selected' title='$title'>$title</h2>";
            $first = false;
            continue;
        }
        $htmlTitles .= "<h2 title='$title'>$title</h2>";
    }


    $htmlAnnunci = "";
    $first = true;
    $index = 0;
    foreach ($annunci as $annuncio) {
        if ($first) {
            $htmlAnnunci .= viewAnnunci($annuncio, $titles[$index++] ,true);
            $first = false;
            continue;
        }
        $htmlAnnunci .= viewAnnunci($annuncio, $titles[$index++], false);
    }

    return "
        <section id='wrapper_annunci'>
            <div class='titles'>
                $htmlTitles
            </div>
            
            $htmlAnnunci
            
            
        </section>
    ";
}

function viewAnnunci($annunci, $title, $selected = false){
    $html = "";
    if($selected){
        $html = "<div class='annunci annunci--selected' title='$title'>";
    }
    else{
        $html = "<div class='annunci' title='$title'>";
    }
    if(count($annunci) == 0){
        $html .= "<h3>Nessun annuncio</h3>";
    }
    else{
        foreach ($annunci as $annuncio) {
            $html .= viewAnnuncio($annuncio);
        }
    }
    
    $html .= "</div>";
    return $html;
}

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

// ------------------------------ MODALS

function modalCreaAnnuncio(){
    return "
       <form method='POST' action='./annuncio/creaAnnuncio'>
            
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

function modalAggiornaAnnuncio(Annuncio $annuncio){
    $settimana = $annuncio->getTempisticaUnita()=='settimana'?'selected':'';
    $mese = $annuncio->getTempisticaUnita()=='mese'?'selected':'';
    $modal = "
       <form method='POST' action='./aggiornaAnnuncio'>
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

    return modal($modal, 'modalAggiornaAnnuncio');

}

function modalEliminaAnnuncio(Annuncio $annuncio){

    $modal = "
       <form method='POST' action='./eliminaAnnuncio' id='form{$annuncio->getId()}'>
            <input type='hidden' name='idannuncio' value={$annuncio->getId()}>
                <h3>Sei sicuro di voler eliminare l'annuncio '{$annuncio->getTitolo()}'? </h3>
                <input type='submit' value='Si'>
        </form>
    ";

    return modal($modal, 'modalEliminaAnnuncio');

}

function modalCreaPreventivo(Annuncio $annuncio){
    $settimana = $annuncio->getTempisticaUnita()=='settimana'?'selected':'';
    $mese = $annuncio->getTempisticaUnita()=='mese'?'selected':'';

    $preventivo = viewAnnuncio($annuncio, false);
    return "
        <form method='POST' action='./preventiva'>
            <div>
                <input type='hidden' name='idannuncio' value='{$annuncio->getId()}'>
                
                <label for='descrizione'>Descrizione</label>
                <textarea  name='descrizione'></textarea>
                   
                <label for='compenso'>Compenso</label>
                <input type='number' name='compenso'>€
            </div>
            
            
            <input type='submit'>
        </form>
    ";
}



?>