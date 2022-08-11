<?php

function home($title, $body){
    return
        "<html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <link rel='stylesheet' href='css/main.css'>
                <title>{$title}</title>
            </head>
            <body>
                {$body}
            </body>
        </html>";
}

?>