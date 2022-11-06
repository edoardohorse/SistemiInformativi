<?php

include_once("php/annuncio.php");
include_once("php/preventivo.php");
include_once("viewHome.php");

// ------------------------------ INTESTAZIONI

function intestazioneProPreventivo(Annuncio $annuncio, Preventivo $preventivo = null){
    $btnHtml = "";
    // var_dump($preventivo);
    if($preventivo != null){
        if ($preventivo->isAccettato()) {
            $btnHtml .= "<button disabled onclick='openModal(`modalModificaPreventivo`)'>Modificare preventivo</button>";
            $btnHtml .= "<button disabled onclick='openModal(`modalEliminaPreventivo`)'>Elimina preventivo</button>";
        } else {
            $btnHtml .= "<button onclick='openModal(`modalAggiornaPreventivo`)'>Modificare preventivo</button>";
            $btnHtml .= "<button onclick='openModal(`modalEliminaPreventivo`)'>Elimina preventivo</button>";
        }   
    }
    else{
        $btnHtml .= "<button onclick='openModal(`modalCreaPreventivo`)'>Crea preventivo</button>";
    }  

    return "
    <div class='header-info'>
        <h1>Preventivo di {$annuncio->getTitolo()}</h1> 
        <a href='./logout'><button>Logout</button></a>
    </div>
    <nav>
        {$btnHtml}
    </nav>
    ";
}


// ------------------------------ VIEWS

function wrapperPreventivi($preventivoAccettato, $preventiviNonAccettati, $titles = ["Preventivo accettato", "Preventivi disponibili"]){
    // var_dump($preventivoAccettato, $preventiviNonAccettati);
    
    $html = "<section class='wrapper_preventivi'>";
    if($preventivoAccettato != null){
        if($preventivoAccettato->isPagato()){
            $html .= viewPreventivi([$preventivoAccettato], "Servizio completato", true);
        }
        else{
            $html .= viewPreventivi([$preventivoAccettato],$titles[0], true);
            $html .= viewPreventivi($preventiviNonAccettati, $titles[1], false);
        }
    }
    else{
        $html .= viewPreventivi([], $titles[0], false);
        $html .= viewPreventivi($preventiviNonAccettati, $titles[1], true);
    }
    
    $html .= "</section>";
    return $html;
}

function viewPreventivi($preventivi, $title = "Preventivi", $showActions = true){

    $n = count($preventivi);
    $html = "";

    if($n == 0){
        $html = "<h3>Alcun preventivo ancora qui</h3>";
        $n = "";
    }
    else if($n > 1){
        $title .= " ({$n})";
    }

    foreach ($preventivi as $preventivo) {
        $html .= viewPreventivo($preventivo, $showActions);
    }

    return "
        <section class='preventivi'>
            <h2>{$title}</h2>
            <div class='preventivi_content'>
                {$html}
            </div>
        </section>
    ";

}

function viewPreventivo(Preventivo $preventivo, $actions = false){
    global $rootDir;
    // var_dump($preventivo);

    $actionsHTML = "";
    if($actions){
        $actionsHTML = "<div class='preventivo_actions'>";
            
        if($preventivo->isAccettato()){
            if($preventivo->isPagato()){
                $actionsHTML .= "<button onclick='openModal(`modalFatturaPreventivo`)'>Mostra fattura</button>";
            } else {
                $actionsHTML .= "<button onclick='openModal(`modalRifiutaPreventivo`)'>Rifiuta preventivo</button>";
                $actionsHTML .= "<button onclick='openModal(`modalPagaPreventivo`)'>Paga preventivo</button>";
            }
        } else {
            $actionsHTML .= "<button onclick='openModal(`modalAccettaPreventivo{$preventivo->getId()}`)'>Accetta preventivo</button>";
        }

        $actionsHTML .= "</div>";
    }

    $state = "preventivo--selected";
    if(!$preventivo->isAccettato()){
        $state = "";
    }

    $fields = "";

    $fields .= campo("Descrizione", "{$preventivo->getDescrizione()}");
    $fields .= campo("Compenso", "{$preventivo->getCompenso()}");
    $fields .= campo("Telefono", "{$preventivo->getProfessionista()->getTelefono()}");

    return "
        <div class='preventivo {$state}'>
            <div class='preventivo_content'>
                <div>
                    <h3>Professionista: <a href='{$rootDir}/utente?id={$preventivo->getProfessionista()->getId()}'>
                            {$preventivo->getProfessionista()->getNome()} {$preventivo->getProfessionista()->getCognome()}
                        </a></h3>
                </div>
                
                {$fields}
            </div>
            {$actionsHTML}
        </div>
    ";
}


// ------------------------------ MODALS


function modalAccettaPreventivo(Preventivo $preventivo){
    $idServizio = $preventivo->getId();
    $idAnnuncio = $preventivo->getAnnuncio()->getId();
    // var_dump($idServizio);
    $modal =  "
       <form method='POST' action='./accettaPreventivo'>
            <input type='hidden' name='idservizio' value={$idServizio}>
            <input type='hidden' name='idannuncio' value={$idAnnuncio}>
                <h3>Accettare il preventivo?</h3>
                <p>Descrizione: {$preventivo->getDescrizione()}</p>
                <p>Descrizione: {$preventivo->getCompenso()}</p>
                <input type='submit' value='Si'>
        </form>
    ";

    return modal($modal, "modalAccettaPreventivo{$idServizio}");
}

function modalRifiutaPreventivo(Preventivo $preventivo){
    $idServizio = $preventivo->getId();
    $idAnnuncio = $preventivo->getAnnuncio()->getId();
    $modal = "
       <form method='POST' action='./rifiutaPreventivo'>
            <input type='hidden' name='idservizio' value={$idServizio}>
            <input type='hidden' name='idannuncio' value={$idAnnuncio}>
                <h3>Vuoi rifiutare il preventivo?</h3>
                <p>In tal caso, potrai riaccettare questo preventivo in futuro.</p>
                <input type='submit' value='Si'>
        </form>
    ";

    return modal($modal, 'modalRifiutaPreventivo');
}

function modalPagaPreventivo(Preventivo $preventivo){
    $idServizio = $preventivo->getId();
    $idAnnuncio = $preventivo->getAnnuncio()->getId();
    $modal = "
       <form method='POST' action='./pagaPreventivo'>
            <input type='hidden' name='idservizio' value={$idServizio}>
            <input type='hidden' name='idannuncio' value={$idAnnuncio}>
                <h3>Vuoi pagare il preventivo accettando questo servizio?</h3>
                <div class='cartacredito'>
                    <input type='password' disable length='4' value='6145'>
                    <input type='password' disable length='4' value='6145'>
                    <input type='password' disable length='4' value='6145'>
                    <input type='text' disable length='4' value='6145'>
                </div>
                <input type='submit' value='Si'>
        </form>
    ";
    return modal($modal, 'modalPagaPreventivo');
}

function modalAggiornaPreventivo(Preventivo $preventivo){
    $idServizio = $preventivo->getId();
    $idAnnuncio = $preventivo->getAnnuncio()->getId();

    $fields = "";

    $fields .= campo("Descrizione","<textarea name='descrizione'rows=4  required >{$preventivo->getDescrizione()}</textarea>");
    $fields .= campo("Titolo","<input type='number' name='compenso' value='{$preventivo->getCompenso()}'>€");

    $modal = "
       <form method='POST' action='./aggiornaPreventivo'>
            <input type='hidden' name='idservizio' value='{$idServizio}'>
            <input type='hidden' name='idannuncio' value='{$idAnnuncio}'>
            
            {$fields}
            <input type='submit'>
        </form>
    ";

    return modal($modal, 'modalAggiornaPreventivo');
}

function modalEliminaPreventivo(Preventivo $preventivo){
    $idServizio = $preventivo->getId();
    $idAnnuncio = $preventivo->getAnnuncio()->getId();
    $modal = "
       <form method='POST' action='./eliminaPreventivo'>
            <input type='hidden' name='idservizio' value='{$idServizio}'>
            <input type='hidden' name='idannuncio' value='{$idAnnuncio}'>
            <h3>Sei sicuro di voler eliminare il preventivo? </h3>
            <input type='submit' value='Si'>
        </form>
    ";

    return modal($modal, 'modalEliminaPreventivo');

}

