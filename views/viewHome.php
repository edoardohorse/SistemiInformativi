<?php


function home($title, $header, $nav, $body,$modal ="", $cssFiles = []){
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
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>{$title}</title>
                <script src='{$rootDir}/js/main.js'></script>
            </head>
            <body>
                <div id='modal_wrapper'>
                    <span class='closeBtn' onclick='closeModal()'>&#10008;</span>
                    {$modal}
                </div>
                <header>
                    {$header}
                </header>
                <main>
                    {$nav}
                    <section class='wrapper'>
                        {$body}
                    </section>
                </main>
            </body>
        </html>";
}

function intestazioneInsHome($user){
    return [
    "<div class='header-info'>
        <h1>Benvenuto {$user->getNome()} {$user->getCognome()} ({$user->getTipo()})</h1> 
        <a href='./logout'><button>Logout</button></a>
    </div>",
    "<nav>
        <button onclick='openModal(`modalCreaAnnuncio`)'>Aggiungi annuncio</button>
    </nav>
    "];
}

function intestazioneProHome($user){
    return ["
    <div class='header-info'>
        <h1>Benvenuto {$user->getNome()} {$user->getCognome()} ({$user->getTipo()})</h1> 
        <a href='./logout'><button>Logout</button></a>
    </div>",
    "<nav>
    </nav>
    "];
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

function viewVoto($value = 1, $readonly = false){
    
    if($readonly){$readonly = 'readonly';}
    else{$readonly = '';
    }
    $html = "<ul class='voto {$readonly}'  ><input type=hidden name='voto' value=$value>";

    for($i = 5; $i>= 1; $i--){
        $html .= "<li class='stella ".($i <= $value ? "selected" : "")."' data-value='{$i}'></li>";
    }
    $html .= "</ul>";
    return $html;  
}
?>