<?php

include_once("php/user.php");
include_once("views/viewHome.php");


global $request, $rootDir;

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
    $rootDir = $rootDir."/";
}

if(User::isLogged()){
    header("Location: {$rootDir}home");
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/main.css">
    </head>

    <body>
        <main class="main--centered">
            <form action="/login" method="POST" class="formLogin">
                <?php
                    $fields = "";
                    $fields .= campo("Email","<input type='email' name='email'>");
                    $fields .= campo("Password","<input type='password' name='pass'>");
                    echo $fields;
                ?>
                <div class="formBtn">
                    <a href="/signin" id="registrati">Registrati</a>
                    <button>Login</button>
                </div>
            </form>
        </main>
            
    </body>
</html>