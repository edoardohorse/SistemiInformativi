<?php

include_once("php/annuncio.php");
include_once("php/preventivo.php");
include_once("viewHome.php");

// ------------------------------ INTESTAZIONI

function intestazioneInsAnnuncio(Annuncio $annuncio){
    global $user;
    $btns = "";

    $htmlNotification = viewNotifiche($user->getNotifiche());

    if(!$annuncio->getPreventivoAccettato() != null){
        $btns .= "<button onclick='openModal(`modalAggiornaAnnuncio`)'>Modifica annuncio</button>";
        $btns .= "<button onclick='openModal(`modalEliminaAnnuncio`)'>Elimina annuncio</button>";
    }

    return [
    "<div class='header-info'>
        <img id='logo' src='../img/logo-white.png'>
        <h1>{$annuncio->getTitolo()}</h1> 
        {$htmlNotification}
        <a href='./logout'><button>Logout</button></a>
    </div>",
    "<nav>
        {$btns}
    </nav>
    "];
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
                <div class='wrapperTitles'>
                    $htmlTitles
                </div>
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

function viewAnnuncio(Annuncio $annuncio, bool $showTitle = true, bool $showIns = false, $telefonoIns = null) {
    $title = "<h2>Dettagli Annuncio</h2>";
    $fields = "";

    if($showIns){
        global $rootDir;
        $fields .= campo("Inserzionista",  "<a href='{$rootDir}/utente?id={$annuncio->getInserzionista()->getId()}'>
                        {$annuncio->getInserzionista()->getNome()} {$annuncio->getInserzionista()->getCognome()}</a>", false);

    }

    if( $showTitle ) {
        $title= "
            <header>
                <h2>
                    <a href='./annuncio/view?id={$annuncio->getId()}'>{$annuncio->getTitolo()}</a>
                </h2></span>
            </header>";
    }

    if($telefonoIns){
        $telefonoIns = campo("Telefono inserzionista", $telefonoIns);  
    }

    
    $fields .= campo("Creato il",           "<div class='data'>{$annuncio->getTimestamp()}</div>");
    $fields .= campo("Descrizione",         "<div>{$annuncio->getDescrizione()}</div>");
    $fields .= campo("Luogo",               "<div class='luogo'>{$annuncio->getLuogolavoro()}</div>");
    $fields .= campo("Dimensione giardino", "<div>{$annuncio->getDimensioneGiardino()}m&#178</div>");
    $fields .= campo("Tempistica",          "<div class='tempistica'>{$annuncio->getTempistica()} {$annuncio->getTempisticaUnita()}</div>");

    return "        
        <section class='annuncio'>
            <input type='hidden' name='idannuncio' value {$annuncio->getId()}>
            {$title}
            <main>
                {$fields}
                {$telefonoIns}
            </main>
        </section>";
}

// ------------------------------ MODALS

function modalCreaAnnuncio(){
    $fields = "";

    $fields .= campo("Titolo","<input type='text' name='titolo' required value='Piantagione Pomodori'>");
    $fields .= campo("Descrizione","<textarea name='descrizione' rows=4 required placeholder='Scrivi...'>Ho bisogno di una mano per piantare</textarea>");
    $fields .= campo("Luogo lavoro","<input type='text' name='luogo_lavoro' required value='Grottaglie, Via Tacito'>");
    $fields .= campo("Dimensione giardino","<input type='text' name='dimensione_giardino' required value='3'>");
    $fields .= campo("Tempistica","
            <input type='number' min=1 max=6 name='tempistica' required value='3'>
            <select name='tempistica_unita' required>
                <option value='settimana'>settimana</option>
                <option value='mese'>mese</option>
            </select>");
    $modal = "
       <form method='POST' action='./annuncio/creaAnnuncio'>
            {$fields}
            <input type='submit'>
        </form>
    ";

    return modal($modal, 'modalCreaAnnuncio');
}

function modalAggiornaAnnuncio(Annuncio $annuncio){
    $settimana = $annuncio->getTempisticaUnita()=='settimana'?'selected':'';
    $mese = $annuncio->getTempisticaUnita()=='mese'?'selected':'';

    $fields = "";

    $fields .= campo("Titolo",      "<input type='text' name='titolo' required value='{$annuncio->getTitolo()}'>");
    $fields .= campo("Descrizione", "<textarea name='descrizione' rows=4  required placeholder='{$annuncio->getDescrizione()}'>Ho bisogno di una mano per piantare</textarea>");
    $fields .= campo("Luogo" ,      "<input type='text' name='luogo_lavoro' required value='{$annuncio->getLuogolavoro()}'>");
    $fields .= campo("Dimensione" , "<input type='number' min=1 name='dimensione_giardino' required style='text-align: right;' value='{$annuncio->getDimensioneGiardino()}'> m&#178");
    $fields .= campo("Tempistica",   
        "<input type='number' min=1 max=6 name='tempistica' required value='{$annuncio->getTempistica()}'>
        <select name='tempistica_unita' required>
            <option value='settimana' {$settimana}>settimana</option>
            <option value='mese' {$mese}>mese</option>
        </select>");

    // var_dump($fields);

    $modal = "
       <form method='POST' action='./aggiornaAnnuncio'>
                 <input type='hidden' name='idannuncio' value='{$annuncio->getId()}'>
                
                 {$fields}
            
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

    $fields = "";

    $fields .= campo("Descrizione","<textarea rows=4  name='descrizione'></textarea>");
    $fields .= campo("Compenso","<input type='number' name='compenso'>€");

    $modal = "
        <form method='POST' action='./preventiva'>
            <input type='hidden' name='idannuncio' value='{$annuncio->getId()}'>
                
            {$fields}
            
            <input type='submit'>
        </form>
    ";

    return modal($modal, 'modalCreaPreventivo');
}



?>