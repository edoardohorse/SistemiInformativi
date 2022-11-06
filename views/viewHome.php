<?php


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
        <button onclick='openModal(`modalCreaAnnuncio`)'>Aggiungi annuncio</button>
    </nav>
    ";
}

function intestazioneProHome($user){
    return "
    <div class='header-info'>
        <h1>Benvenuto {$user->getNome()} {$user->getCognome()} ({$user->getTipo()})</h1> 
        <a href='./logout'><button>Logout</button></a>
    </div>
    <nav>
    </nav>
    ";
}

function modal($content, $id){
    return "<div class='modal hide' id='{$id}'>
                {$content}
            </div>";
}

function campo($label, $value, $divWrapper = true){
    if($divWrapper){
        $value = "<div class='content'>{$value}</div>";
    }

    return "<div class='campo'>
                <label>{$label}</label>
                {$value}
            </div>";
}

?>