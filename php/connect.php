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


global $conn, $request, $rootDir;

if(str_contains($_SERVER['SERVER_NAME'], 'altervista')){
    $conn = new mysqli($servername_altervista, $username_altervista, $password_altervista, $db_altervista);
}
else{
    $conn = new mysqli($servername, $username, $password, $db);
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if(str_contains($_SERVER['SERVER_NAME'], 'altervista')){
    $request = $_SERVER['REQUEST_URI'];
    $rootDir = "https://".$_SERVER["HTTP_HOST"]."/";
    // $rootDir = "/".$rootDir[count($rootDir)-1];
    // $request = str_replace($rootDir, "", $request ); 
}
else{
    $request = $_SERVER['REQUEST_URI'];
    $rootDir = explode("\\",__DIR__);
    $rootDir = "/".$rootDir[count($rootDir)-1];
    $request = str_replace($rootDir, "", $request );
    // $rootDir = $rootDir."/";
}


?>