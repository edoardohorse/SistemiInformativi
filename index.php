<?php
include_once("php/user.php");
include_once("views/viewHome.php");

$request = $_SERVER['REQUEST_URI'];
$rootDir = explode("\\",__DIR__);
$rootDir = "/".$rootDir[count($rootDir)-1];
$request = str_replace($rootDir, "", $request );

if(User::isLogged()){
    header("Location: $rootDir/home");
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./css/main.css">
    </head>

    <body>
        <main class="main--centered">
            <a href="./signin" id="registrati">Registrati</a>
            <form action="./login" method="POST" class="formLogin">
                <?php
                    $fields = "";
                    $fields .= campo("Email","<input type='email' name='email'>");
                    $fields .= campo("Password","<input type='password' name='pass'>");
                    echo $fields;
                ?>
                <button>Login</button>
            </form>
        </main>
            
    </body>
</html>