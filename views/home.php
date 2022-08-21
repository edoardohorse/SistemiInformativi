<?php

function home($title, $header,$body,$modal ="", $cssFiles = []){
    $cssStr = "";

    foreach($cssFiles as $css){
        $cssStr .= "<link rel='stylesheet' href='$css'>";
    }

    return
        "<html lang='it'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <link rel='stylesheet' href='css/main.css'>
                {$cssStr}
                <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
                <meta http-equiv='cache-control' content='max-age=0' />
                <meta http-equiv='cache-control' content='no-cache' />
                
                <title>{$title}</title>
            </head>
            <body>
                <div>{$modal}</div>
                <header>
                    <button onclick='navigation.back()'><span class='material-icons md-18'>arrow_back</span></button>
                    {$header}
                </header>
                <main>{$body}</main>
            </body>
        </html>";
}

function intestazioneIns($user){
    return "
    <h1>Benvenuto {$user->getNome()} {$user->getCognome()} ({$user->getTipo()})</h1> 
    <a href='./logout'><button>Logout</button></a>
    <button onclick='document.getElementById(`modalNewAnnuncio`).classList.remove(`hide`)'>
        Aggiungi annuncio</button>
    ";
}

function intestazionePro($user){
    return "
    <h1>Benvenuto {$user->getNome()} {$user->getCognome()} ({$user->getTipo()})</h1> 
    <a href='./logout'><button>Logout</button></a>
    ";
}

function modal($content, $id){
    return "<div class='modal hide' id='{$id}'>
            <span style='right:2em;' class='closeBtn'
            onclick='document.getElementById(`{$id}`).classList.add(`hide`)'>X</span>
            {$content}
            </div>";
}

?>