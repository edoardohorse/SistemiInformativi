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

    return [
    "<div class='header-info'>
        <h1>Preventivo di {$annuncio->getTitolo()}</h1> 
        <a href='./logout'><button>Logout</button></a>
    </div>",
    "<nav>
        {$btnHtml}
    </nav>
    "];
}


// ------------------------------ VIEWS

function wrapperPreventivi($preventivoAccettato, $preventiviNonAccettati, $titles = ["Preventivo accettato", "Preventivi disponibili"]){
    // var_dump($preventivoAccettato, $preventiviNonAccettati);
    
    $html = "<section class='wrapper_preventivi'>";
    $textNoPreventivoAccettato = "Non è stato accettato ancora nessun preventivo";
    $textNoPreventiviDisponibili = "Non ci sono preventivi disponibili";

    if($preventivoAccettato != null){
        if($preventivoAccettato->isPagato()){
            $html .= viewPreventivi([$preventivoAccettato], "Servizio completato", true);
        }
        else{
            $html .= viewPreventivi([$preventivoAccettato],$titles[0], true, $textNoPreventivoAccettato);
            $html .= viewPreventivi($preventiviNonAccettati, $titles[1], false, $textNoPreventiviDisponibili);
        }
    }
    else{
        $html .= viewPreventivi([], $titles[0], false, $textNoPreventivoAccettato);
        $html .= viewPreventivi($preventiviNonAccettati, $titles[1], true, $textNoPreventiviDisponibili);
    }
    
    $html .= "</section>";
    return $html;
}

function viewPreventivi($preventivi, $title = "Preventivi", $showActions = true, $textNoPreventivi = "Alcun preventivo ancora qui"){

    $n = count($preventivi);
    $html = "";

    if($n == 0){
        $html = "<h3>${textNoPreventivi}</h3>";
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
                $actionsHTML .= "<button><a href='{$rootDir}/fattura?id={$preventivo->getId()}' target='_blank'> Mostra fattura</a></button>";
                if($preventivo->isRecensito()){
                    $actionsHTML .= "<button onclick='openModal(`modalAggiornaRecensione`)'>Aggiorna recensione</button>";
                    $actionsHTML .= "<button onclick='openModal(`modalEliminaRecensione`)'>Elimina recensione</button>";
                }
                else{
                    $actionsHTML .= "<button onclick='openModal(`modalCreaRecensione`)'>Recensisci servizio</button>";
                }
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

function viewMesi(){
    $mesi = [
        "Gennaio",
        "Febbraio",
        "Marzo",
        "Aprile",
        "Maggio",
        "Giugno",
        "Luglio",
        "Agosto",
        "Settembre",
        "Ottobre",
        "Novembre",
        "Dicembre"
    ];

    $html = "";
    foreach($mesi as $mese){
        $html .= "<option>{$mese}</option>";
    }

    return $html;
}

function viewAnni(){
    $html = "";
    for($i = 2022; $i < 2030; $i++){
        $html .= "<option>{$i}</option>";
    }

    return $html;
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
    global $rootDir;
    $idServizio = $preventivo->getId();
    $idAnnuncio = $preventivo->getAnnuncio()->getId();
    $inserzionista = "{$preventivo->getAnnuncio()->getInserzionista()->getNome()} {$preventivo->getAnnuncio()->getInserzionista()->getCognome()}";
    
    $fields = "";
    $mesi   = viewMesi();
    $anni   = viewAnni();

    $fields .= campo("Proprietario Carta", "<input type='text' value='{$inserzionista}'>");
    $fields .= campo("Numero carta", "<div id='carta'>
                        <input type='password' length='4' value='6145' readonly>
                        <input type='password' length='4' value='6145' readonly>
                        <input type='password' length='4' value='6145' readonly>
                        <input type='text' length='4' value='6145' readonly>
                    </div>");
    $campoScadenza = campo("Scadenza", "<div id='scadenzacarta'>
                        <select id='mesi'>{$mesi}</select>
                        <select id='anni'>{$anni}</select></div>");

    $campoCVV = campo("CVV", "<input type='text' length='3' value='614' id='cvv' readonly>
     <img id='mastercard' src='{$rootDir}/img/mastercard.png'>");
    
    $fields .= campo("", "{$campoScadenza} {$campoCVV}");

    $modal = "
       <form method='POST' action='./pagaPreventivo'>
            <input type='hidden' name='idservizio' value={$idServizio}>
            <input type='hidden' name='idannuncio' value={$idAnnuncio}>
                <h3>Vuoi pagare il preventivo accettando questo servizio?</h3>
                <div class='cartacredito'>
                    {$fields}                 
                   
                </div>
                <input type='submit' value='Paga'>
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


function modalCreaRecensione(Preventivo $preventivo, User $recensito){
    global $rootDir;
    $idServizio = $preventivo->getId();
    $idAnnuncio = $preventivo->getAnnuncio()->getId();
    $votoHtml = viewVoto();

    $fields = "";

    $fields .= "";
    $fields .= campo("Descrizione","<textarea rows=4  name='descrizione'></textarea>");
    $fields .= campo("Voto","<div class='voto'>{$votoHtml}</div>");
    $modal = "
       <form method='POST' action='{$rootDir}/utente/recensisce'>
            <input type='hidden' name='idservizio' value='{$idServizio}'>
            <input type='hidden' name='idannuncio' value='{$idAnnuncio}'>
            <input type='hidden' name='idrecensito' value='{$recensito->getId()}'>
        
            {$fields}
            <input type='submit' value='Si'>
        </form>
    ";

    return modal($modal, 'modalCreaRecensione');
}