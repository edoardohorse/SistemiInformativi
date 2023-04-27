<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "giardinaggio";

$servername_altervista = "localhost";
$username_altervista = "civicsens";
$password_altervista = "giardinaggio30L";
$db_altervista = "my_civicsens";

// Create connection


global $conn;

if(str_contains($_SERVER['SERVER_NAME'], 'altervista')){
    $conn = new mysqli($servername_altervista, $username_altervista, $password_altervista, $db_altervista);
}
else{
    $conn = new mysqli($servername, $username, $password, $db);
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>