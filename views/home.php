<?php

function home($title, $header,$body,$modal =""){
    return
        "<html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <link rel='stylesheet' href='css/main.css'>
                <title>{$title}</title>
            </head>
            <body>
                {$modal}
                <header>{$header}</header>
                <main>{$body}</main>
            </body>
        </html>";
}

function intestazione($user){
    return "
    <h1>Benvenuto {$user->getNome()} {$user->getCognome()} ({$user->getTipo()})</h1> 
    <a href='./logout'><button>Logout</button></a>
    <button onclick='document.getElementById(`modalNewAnnuncio`).classList.remove(`hide`)'>
        Aggiungi annuncio</button>
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