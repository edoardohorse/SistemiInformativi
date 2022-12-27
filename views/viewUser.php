<?php

include_once("views/viewHome.php");

function intestazioneUser(User $utente){
    global $user;

    $htmlNotification = viewNotifiche($user->getNotifiche());

    return [
    "<div class='header-info'>
        <img id='logo' src='./img/logo-white.png'>
        <h1>{$utente->getNome()} {$utente->getCognome()}</h1> 
        {$htmlNotification}
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

    $voto = viewVoto($recensione->getVoto(), true);
    $fields .= campo("Descrizione", $recensione->getDescrizione());
    $fields .= campo("Voto",        $voto);

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