<?php

include_once("views/viewHome.php");

function intestazioneUser(User $user){


    return [
    "<div class='header-info'>
        <h1>{$user->getNome()} {$user->getCognome()}</h1> 
        <a href='./logout'><button>Logout</button></a>
    </div>",
    ""];
}

function wrapperRecensioni($recensioni){
    $html = "<section class='wrapper-recensioni'>";
    if(count($recensioni) == 0){
        return "<h2>Non ci sono ancora recensioni</h2>";
    }

    foreach ($recensioni as $recensione) {
        $html .= viewRecensione($recensione);
    }
    $html .= "</section>";
    return $html;
}

function viewRecensione(Recensione $recensione){
    global $rootDir;
    $fields = "";
    $recensore = $recensione->getRecensore();


    $fields .= campo("Descrizione", $recensione->getDescrizione());
    $fields .= campo("Voto",        "<div class='voto' data-value='{$recensione->getVoto()}' />",false);

    return "
        <div class='recensione'>
            <div class='recensione_content'>
                <div>
                    <h3><a href='{$rootDir}/utente?id={$recensore->getId()}'>
                            {$recensore->getNome()} {$recensore->getCognome()}
                        </a></h3>
                </div>
                
                {$fields}
            </div>
        </div>
    ";
}

?>