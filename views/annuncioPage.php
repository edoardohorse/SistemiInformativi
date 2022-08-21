<?php
    include_once("views/annuncio.php");

    $settimana = $annuncio->getTempisticaUnita()=='settimana'?'selected':'';
    $mese = $annuncio->getTempisticaUnita()=='mese'?'selected':'';
?>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='../css/main.css'>
    <link rel='stylesheet' href='../css/annuncio.css'>
    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <meta http-equiv='cache-control' content='max-age=0' />
    <meta http-equiv='cache-control' content='no-cache' />

    <title><?php echo $annuncio->getTitolo() ?></title>
</head>
    <body>
    <div>
    <?php
        switch($user->getTipo()){
            case EUserType::Inserzionista:{
                ?>
                <nav>
                    <button onclick="document.getElementById('modalEditAnnuncio').classList.remove('hide')">Modifica annuncio</button>
                    <button onclick="document.getElementById('modalEraseAnnuncio').classList.remove('hide')">Elimina annuncio</button>
                </nav>
                <?php
                break;
            }
            case EUserType::Professionista:{
                ?>
                <nav>
                    <button onclick="document.getElementById('modalEditAnnuncio').classList.remove('hide')">Pr annuncio</button>
                </nav>
                <?php
                break;
            }
        }
        ?>
        
    </div>
    <header>
        <button onclick="navigation.back()"><span class="material-icons md-18">arrow_back</span></button>
        <h1><?php echo $annuncio->getTitolo() ?></h1>
        <?php
        switch($user->getTipo()){
            case EUserType::Inserzionista:{
                ?>
                <div class='modal hide' id='modalEditAnnuncio'>
                    <span style='right:2em;' class='closeBtn'
                        onclick='document.getElementById(`modalEditAnnuncio`).classList.add(`hide`)'>X</span>
                    <?php
                        echo "<form method='POST' action='../annuncio/edit'>
                            <input type='hidden' name='idannuncio' value='{$annuncio->getId()}'>
                            <label for='titolo'>titolo</label><br>
                            <input type='text' name='titolo' required value='{$annuncio->getTitolo()}'>
                            <br>
                            <label for='descrizione'>Descrizione</label><br>
                            <textarea name='descrizione' required placeholder='{$annuncio->getDescrizione()}'>Ho bisogno di una mano per piantare</textarea>
                            <br>
                            <label for='luogo_lavoro'>Luogo lavoro</label><br>
                            <input type='text' name='luogo_lavoro' required value='{$annuncio->getLuogolavoro()}'>
                            <br>
                            <label for='dimensione_giardino'>Dimensione giardino</label><br>
                            <input type='number' min=1 name='dimensione_giardino' required style='text-align: right;' value='{$annuncio->getDimensioneGiardino()}'> m&#178
                            <br>
                            <label for='tempistica'>tempistica</label><br>
                            <input type='number' min=1 max=6 name='tempistica' required value='{$annuncio->getTempistica()}'>
                            <select name='tempistica_unita' required>
                                <option value='settimana' {$settimana}>settimana</option>
                                <option value='mese' {$mese}>mese</option>
                            </select>
                
                            <input type='submit'>
                        </form>";
                    ?>
                </div>

                <div class='modal hide' id='modalEraseAnnuncio'>
                    <span style='right:2em;' class='closeBtn'
                        onclick='document.getElementById(`modalEditAnnuncio`).classList.add(`hide`)'>X</span>

                    <?php echo "
                    <form method='POST' action='../annuncio/delete' id='form{$annuncio->getId()}'>
                            <input type='hidden' name='idannuncio' value={$annuncio->getId()}>
                                <h3>Sei sicuro di voler eliminare l'annuncio '{$annuncio->getTitolo()}'? </h3>
                                <input type='submit' value='Si'>
                        </form>
                    ";?>
                </div>
                <?php
                break;
            }
            case EUserType::Professionista:{
                ?>
                <nav>
                    <button onclick="document.getElementById('modalEditAnnuncio').classList.remove('hide')">Pr annuncio</button>
                </nav>
                <?php
                break;
            }
        }
        ?>
        
    </header>

    <main>


    </main>
    </body>
</html>