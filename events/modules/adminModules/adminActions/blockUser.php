<?php

    session_start();
    
    if (!isset($_SESSION['admin']))
    {
        header ("location: ../../../index.php");
        exit;
    }
    
    require_once '../../configModules/database.php';

    // dodajemy uprawnienie administratora
    $admin = $db->prepare('UPDATE events_users SET bann=true WHERE login="'.$_GET['user'].'"');
    $admin-> execute();
    
    header ("location: ../users.php");