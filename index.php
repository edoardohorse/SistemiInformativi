<?php
include_once("php/user.php");

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
            <!-- <a href="./home">Vai alla home</a> -->
            <main>
                <form action="./login" method="POST" class="formLogin">
                    <input type="email" name="email" value="giando.monopoli@gmail.com">
                    <input type="password" name="pass" value="ciao">
                    <button>Login</button>
                </form>
            </main>

            <!-- <form action="php/signin.php" method="POST">
                <input type="email" name="email">
                <input type="password" name="pass">
                <input type="password" name="pass2">
    
                <input type="text" name="codice_fiscale">
                <input type="text" name="nome">
                <input type="text" name="cognome">
                <input type="text" name="citta">
                <input type="text" name="cap">
                <input type="text" name="indirizzo">
                <input type="number" name="numero_civico">
                <input type="cel" name="telefono">
                <input type="text" name="partita_iva" size="11">
                <select name="tipo" >
                    <option value="ins">Inserzionista</option>
                    <option value="pro">Professionista</option>
                </select>
            </form> -->
    
    </body>
</html>