<?php

include_once("php/annuncio.php");
include_once("php/preventivo.php");
include_once("viewHome.php");

// ------------------------------ INTESTAZIONI

function intestazioneInsPreventivo(Annuncio $annuncio, Preventivo $preventivo){
    $btnHtml = "";
    if ($preventivo->getAccettato()) {
        if ($preventivo->getPagato()) {
            $btnHtml .= "<button onclick='openModal(`modalFatturaPreventivo`)'>Mostra fattura</button>";
        } else {
            $btnHtml .= "<button onclick='openModal(`modalRifiutaPreventivo`)'>Rifiuta preventivo</button>";
            $btnHtml .= "<button onclick='openModal(`modalPagaPreventivo`)'>Paga preventivo</button>";
        }
    } else {
        $btnHtml .= "<button onclick='openModal(`modalAccettaPreventivo`)'>Accetta preventivo</button>";
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

function intestazioneProPreventivo(Annuncio $annuncio, Preventivo $preventivo){
    $btnHtml = "";
    if ($preventivo->getAccettato()) {
        if ($preventivo->getPagato()) {
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

function viewPreventivi($preventivi){

    $n = count($preventivi);
    $html = "";

    if($n == 0){
        $html = "<h3>Non ci sono preventivi per questo annuncio</h3>";
    }


    foreach ($preventivi as $preventivo) {
        
        $html .= viewPreventivo($preventivo);
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

function viewPreventivo(Preventivo $preventivo){
    global $rootDir;
    // var_dump($preventivo);
    return "
        <div class='preventivo'>
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
    ";
}


// ------------------------------ MODALS

function modalEditPreventivo(Preventivo $preventivo){

}

function modalErasePreventivo(Preventivo $preventivo){

}

