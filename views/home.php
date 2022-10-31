<?php


if(isset($_REQUEST['id'])){
    include_once("page\annuncio.php");
}

function home($title, $header,$body,$modal ="", $cssFiles = []){
    global $rootDir;
    $cssStr = "";

    foreach($cssFiles as $css){
        $cssStr .= "<link rel='stylesheet' href='$css'>";
    }

    
    return
        "<html lang='it'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                {$cssStr}
                <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
                <meta http-equiv='cache-control' content='max-age=0' />
                <meta http-equiv='cache-control' content='no-cache' />
                <title>{$title}</title>
                <script src='{$rootDir}/js/main.js'></script>
            </head>
            <body>
                <div id='modal_wrapper'>
                    <span class='closeBtn' onclick='closeModal()'>&#10008;</span>
                    {$modal}
                </div>
                <header>
                    <button id='btn-back' onclick='navigation.back()'><span class='material-icons md-18'>arrow_back</span></button>
                    {$header}
                </header>
                <main>{$body}</main>
            </body>
        </html>";
}

function intestazioneInsHome($user){
    return "
    <div class='header-info'>
        <h1>Benvenuto {$user->getNome()} {$user->getCognome()} ({$user->getTipo()})</h1> 
        <a href='./logout'><button>Logout</button></a>
    </div>
    <nav>
        <button onclick='openModal(`modalNewAnnuncio`)'>Aggiungi annuncio</button>
    </nav>
    ";
}

function intestazioneInsAnnuncio($user, Annuncio $annuncio){
    return "
    <div class='header-info'>
        <h1>{$annuncio->getTitolo()}</h1> 
        <a href='./logout'><button>Logout</button></a>
    </div>
    <nav>
        <button onclick='openModal(`modalEditAnnuncio`)'>Modifica annuncio</button>
        <button onclick='openModal(`modalEraseAnnuncio`)'>Elimina annuncio</button>
    </nav>
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
                {$content}
            </div>";
}

?>