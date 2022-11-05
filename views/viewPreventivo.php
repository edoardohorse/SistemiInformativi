<?php

include_once("php/annuncio.php");
include_once("php/preventivo.php");
include_once("viewHome.php");

// ------------------------------ INTESTAZIONI

function intestazioneProPreventivo(Annuncio $annuncio, Preventivo $preventivo){
    $btnHtml = "";
    if ($preventivo->isAccettato()) {
        if ($preventivo->isPagato()) {
            $btnHtml .= "<button onclick='openModal(`modalFatturaPreventivo`)'>Mostra fattura</button>";
        }
    } else {
        $btnHtml .= "<button onclick='openModal(`modalModificaPreventivo`)'>Modificare preventivo</button>";
        $btnHtml .= "<button onclick='openModal(`modalEliminaPreventivo`)'>Elimina preventivo</button>";
    }

    return "
    <div class='header-info'>
        <h1>Preventivo {$annuncio->getTitolo()}</h1> 
        <a href='./logout'><button>Logout</button></a>
    </div>
    <nav>
        {$btnHtml}
    </nav>
    ";
}


// ------------------------------ VIEWS

function wrapperPreventivi($preventivi, $titles){
    // var_dump($preventivi);
    $html = "<section class='wrapper_preventivi'>";
    for($i=0; $i<count($preventivi); $i++){
        $html .= viewPreventivi($preventivi[$i], $titles[$i]);
    }
    $html .= "</section>";
    return $html;
}

function viewPreventivi($preventivi, $title = "Preventivi"){

    $n = count($preventivi);
    $html = "";

    if($n == 0){
        $html = "<h3>Alcun preventivo ancora qui</h3>";
        $n = "";
    }
    else if($n == 1){
        $n = "";
    }
    else{
        $title .= " ({$n})";
    }

    foreach ($preventivi as $preventivo) {
        $html .= viewPreventivo($preventivo, true);
    }

    return "
        <section class='preventivi'>
            <h2>{$title}</h2>
            <div class='preventivi-content'>
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
                $actionsHTML .= "<bu+tton onclick='openModal(`modalFatturaPreventivo`)'>Mostra fattura</button>";
            } else {
                $actionsHTML .= "<button onclick='openModal(`modalRifiutaPreventivo`)'>Rifiuta preventivo</button>";
                $actionsHTML .= "<button onclick='openModal(`modalPagaPreventivo`)'>Paga preventivo</button>";
            }
        } else {
            $actionsHTML .= "<button onclick='openModal(`modalAccettaPreventivo`)'>Accetta preventivo</button>";
        }

        $actionsHTML .= "</div>";
    }

    $state = "preventivo--selected";
    if(!$preventivo->isAccettato()){
        $state = "";
    }

    return "
        <div class='preventivo {$state}'>
            <div class='preventivo_content' >
                <div>
                    <h3>Professionista: <a href='{$rootDir}/utente?id={$preventivo->getProfessionista()->getId()}'>
                            {$preventivo->getProfessionista()->getNome()} {$preventivo->getProfessionista()->getCognome()}
                        </a></h3>
                </div>
                <div>
                    <label>Descrizione:</label>
                    <span>{$preventivo->getDescrizione()}</span>
                </div>
                <div>
                    <label>Compenso:</label>
                    <span>{$preventivo->getCompenso()}</span>
                </div>
            </div>
            {$actionsHTML}
        </div>
    ";
}


// ------------------------------ MODALS


function modalAccettaPreventivo(Preventivo $preventivo){
    $idServizio = $preventivo->getIdservizio();
    $idAnnuncio = $preventivo->getAnnuncio()->getId();
    return "
       <form method='POST' action='./accettapreventivo' id='form{$idServizio}'>
            <input type='hidden' name='idpreventivo' value={$idServizio}>
            <input type='hidden' name='idannuncio' value={$idAnnuncio}>
                <h3>Accettare il preventivo?</h3>
                <p>Descrizione: {$preventivo->getDescrizione()}</p>
                <p>Descrizione: {$preventivo->getCompenso()}</p>
                <input type='submit' value='Si'>
        </form>
    ";
}

function modalRifiutaPreventivo(Preventivo $preventivo){
    $idServizio = $preventivo->getIdservizio();
    $idAnnuncio = $preventivo->getAnnuncio()->getId();
    return "
       <form method='POST' action='./rifiutapreventivo' id='form{$idServizio}'>
            <input type='hidden' name='idpreventivo' value={$idServizio}>
            <input type='hidden' name='idannuncio' value={$idAnnuncio}>
                <h3>Vuoi rifiutare il preventivo?</h3>
                <p>In tal caso, potrai riaccettare questo preventivo in futuro.</p>
                <input type='submit' value='Si'>
        </form>
    ";
}

function modalPagaPreventivo(Preventivo $preventivo){
    $idServizio = $preventivo->getIdservizio();
    $idAnnuncio = $preventivo->getAnnuncio()->getId();
    return "
       <form method='POST' action='./pagapreventivo' id='form{$idServizio}'>
            <input type='hidden' name='idpreventivo' value={$idServizio}>
            <input type='hidden' name='idannuncio' value={$idAnnuncio}>
                <h3>Vuoi pagare il preventivo?</h3>
                <input type='submit' value='Si'>
        </form>
    ";
}

function modalEditPreventivo(Preventivo $preventivo){

}

function modalErasePreventivo(Preventivo $preventivo){

}

