<?php
    //include_once ("user.php");
    include_once("views/viewHome.php");
    include_once("views/viewUser.php");
    
    // var_dump($_REQUEST);
    $id = (int) $_REQUEST['id'];
    $recensito = User::withID($id);
    $recensito->fetchRecensioni();

    // var_dump($recensito);


    $title  = "Recensioni";
    $body   =  "";
    $modal  = "";




    [$header, $nav] = intestazioneUser($recensito);

    $body .= wrapperRecensioni($recensito->getRecensioni());
    


    echo home($title, $header, $nav, $body, $modal, ['css/main.css']);
?>

