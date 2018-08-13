<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
       
            define('APP_ROOT','e-Limites'); //Pasta raiz do sistema
        
            require_once 'lib\System.php';
            require_once 'helper/Bootstrap.php';
                
            use lib\System;
            
            $System = new System();
            $System->Run();