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
    <script>
        function mostraPartitaIva(){
            const partita_iva = document.getElementById("partita_iva");
            if(event.target.value == "ins"){
                partita_iva.style.display = "none"
                partita_iva.required = true
            }
            else{
                partita_iva.style.display = "inline-flex"
                partita_iva.required = false
            }
        }
    </script>
    <body>
            <!-- <a href="./home">Vai alla home</a> -->
        <main class="main--centered">
            
            <form action="/signin" method="POST" class="formSignin">
            <?php
                $fields = "";
                $fields .= campo("Email","<input type='email' name='email' required>");
                $fields .= campo("Password","<input type='password' name='pass' required>");
                $fields .= campo("Codice Fiscale","<input type='text' name='codice_fiscale' required>");
                $fields .= campo("Nome","<input type='text' name='nome' required>");
                $fields .= campo("Cognome","<input type='text' name='cognome' required>");
                $fields .= campo("Città","<input type='text' name='citta' required>");
                $fields .= campo("CAP","<input type='text' name='cap' required>");
                $fields .= campo("Indirizzo","<input type='text' name='indirizzo' required>");
                $fields .= campo("Numero Civico","<input type='number' name='numero_civico' required>");
                $fields .= campo("Telefono","<input type='cel' name='telefono' required>");
                $fields .= campo("Tipo",
                "<select name='tipo' required onChange='mostraPartitaIva(this)'>
                    <option value='ins'>Inserzionista</option>
                    <option value='pro'>Professionista</option>
                </select>");
                echo $fields;
                ?>
                <div class="campo" id="partita_iva" style='display:none;'>
                    <label>Partita IVA</label>
                    <div class="content">
                        <input type='text' name='partita_iva' size='11' >   
                    </div>  
                </div>
                <div class="formBtn">
                    <a href="/login" id="login">Login</a>
                    <button>Registrati</button>
                </div>
        </form>
    </main>
          
    </body>
</html>