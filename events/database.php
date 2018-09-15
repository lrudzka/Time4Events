<?php

    $connect = require_once 'connect.php';

    try
    {
        //nawiasami klamrowymi otaczamy zmienne
        $db = new PDO("mysql:host={$connect['host']};dbname={$connect['database']};charset=utf8", $connect['user'], $connect['password'],[
            //ochrona przed wstrzykiwaniem mySQL
            PDO::ATTR_EMULATE_PREPARES => false, 
            // w razie błędów wyrzucamy wyjątki i kod jest przerywany
            PDO::ATTR_ERRMODE => 'ERRMODE_EXCEPTION'
            ]);
    }
    catch(PDOException $error)
    {
        //wersja deweloperska:
        echo $error;

        //wersja widoczna dla końcowych użytkowników:
        exit('Database error');
        
    }