<?php
    //include_once ("user.php");
    include_once("php/user.php");
    include_once("views/viewHome.php");
    include_once("views/viewUser.php");
    include_once("php/recensione.php");
    
    $user = $_SESSION["user"];
    // var_dump($_REQUEST);
    $user->fetchNotifiche();
    $id = (int) $_REQUEST['id'];
    $recensito = User::withID($id);
    $recensito->fetchRecensioni();

    


    $title  = "Recensioni";
    $body   =  "";
    $modal  = modalAggiornaProfilo($user);




    [$header, $nav] = intestazioneUser($recensito);
    
    $recensioni = [];
    if($id == $user->getID()){
        $recensioni = array_filter($recensito->getRecensioni(), function (Recensione $recensione) {
            global $user, $id, $recensito;
            // var_dump($recensione->getRecensore()->getID());
            // return $recensione->getRecensore()->getID() == $user->getID();
            
            if($recensito->getTipo() == "ins"){
                return $recensione->getRecensore()->getID() == $id;
            }
            return $recensione->getRecensito()->getID() == $id;
        });
    }
    else{
        $recensioni = array_filter($recensito->getRecensioni(), function (Recensione $recensione) {
            global $user,$id, $recensito;
            // var_dump($recensione->getRecensore()->getID());
            if($recensito->getTipo() == "ins"){
                return $recensione->getRecensore()->getID() == $id;
            }
            return $recensione->getRecensito()->getID() == $id;
        });
    }


    $body .= wrapperRecensioni($recensioni);
    


    echo home($title, $header, $nav, $body, $modal, ['css/main.css']);
?>

