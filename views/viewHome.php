<?php

include_once("php/notifica.php");

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
                    {$nav}
                </header>
                <main>
                    <section class='wrapper'>
                        {$body}
                    </section>
                </main>
                
            </body>
        </html>";
}

function intestazioneInsHome($user){
    global $rootDir;
    $tipo = viewTipo($user->getTipo());
    $htmlNotification = viewNotifiche($user->getNotifiche());

    return [
    "<div class='header-info'>
        <img id='logo' src='./img/logo-white.png'>
        <h1>{$user->getNome()} {$user->getCognome()}</h1>
        {$tipo}
        {$htmlNotification}
        <a href='./logout'><button>Logout</button></a>
    </div>",
    "<nav>
        <button onclick='openModal(`modalCreaAnnuncio`)'>Aggiungi annuncio</button>
        <button onclick='location.href=\"{$rootDir}/utente?id={$user->getID()}\"'>Visualizza profilo</button>
    </nav>
    "];
}

function intestazioneProHome($user){
    global $rootDir;
    $tipo = viewTipo($user->getTipo());
    $htmlNotification = viewNotifiche($user->getNotifiche());

    return ["
    <div class='header-info'>
        <img id='logo' src='./img/logo-white.png'>
        <h1>{$user->getNome()} {$user->getCognome()}</h1>
        {$tipo}
        {$htmlNotification}
        <a href='./logout'><button>Logout</button></a>
    </div>",
    "<nav>
        <button onclick='location.href=\"{$rootDir}/utente?id={$user->getID()}\"'>Visualizza profilo</button>
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

function viewTipo($tipo){
    if($tipo == "pro") return "<div class='tipo'>Professionista</div>";
    else               return "<div class='tipo'>Inserzionista</div>";
}

function viewNotifiche($wrapperNotifiche){
    $nNotification = 0;

    $nuoveNotificheMessage   = "<h2>Non ci sono nuove notifiche</h2>";
    $vecchieNotificheMessage = "<h2>Non ci sono notifiche vecchie</h2>";

    $nuoveNotifiche   = $wrapperNotifiche->notifiche["new"];
    $vecchieNotifiche = $wrapperNotifiche->notifiche["old"];
    
    $disabledLeggiNotifiche = "disabled";
    $disabledCancellaNotifiche = "disabled";
    
    if (isset($nuoveNotifiche) && count($nuoveNotifiche) > 0) {
        $disabledLeggiNotifiche = "";
        $nuoveNotificheMessage = "";
        $nNotification = count($nuoveNotifiche);
        foreach($nuoveNotifiche as $notifica){
            // var_dump($notifica);
            $nuoveNotificheMessage .= viewNotifica($notifica);
        }
    }
    
    if(isset($vecchieNotifiche) && count($vecchieNotifiche) > 0){
        $disabledCancellaNotifiche = "";
        $vecchieNotificheMessage = "";
        foreach($vecchieNotifiche as $notifica){
            $vecchieNotificheMessage .= viewNotifica($notifica);
        }
    }


    
    $html =
        "<div id='notifiche'>
            <span id='notifica_icon' data-counter='{$nNotification}'></span>
            <div id='notifica_content'>
                <div id='notifica_btns'>
                    <button id='notifiche_new' class='notifiche-selected' >Nuove</button>
                    <button id='notifiche_old'>Già lette</button>
                    <button onclick='leggiNotifiche()' $disabledLeggiNotifiche>Segna come letto</button>
                    <button onclick='cancellaNotificheLette()' $disabledCancellaNotifiche>Cancella notifiche lette</button>
                    <span class='closeBtn' onclick='toggleWrapperNotifiche()'>✘</span>
                </div>
                <div id='nuoveNotifiche_wrapper' class='notifiche_wrapper-selected'>
                    {$nuoveNotificheMessage}
                </div>
                <div id='vecchieNotifiche_wrapper'>
                    {$vecchieNotificheMessage}
                </div>
            </div>
        </div>";

    return $html;
}

function viewNotifica(Notifica $notifica){
    global $rootDir;

    $redirect = "";
    $cssClass = "vecchia";
    if($notifica->getLetta() == false){
        $cssClass = "nuova";

        if($notifica->getRedirectUrl() != ""){
            $redirect = "onclick='window.location.href=\"{$notifica->getRedirectUrl()}\"'";
        }
        else{
            $redirect = "onclick='window.location.href=\"$rootDir/legginotifica?idnotifica={$notifica->getID()}\"'";
        }
    }
  return "<div class='notifica $cssClass' $redirect>
            <span class='notifica_messaggio'>{$notifica->getMessaggio()}</span>
            <span class='notifica_date'>{$notifica->getTimestamp()}</span>
          </div>";  
}
?>