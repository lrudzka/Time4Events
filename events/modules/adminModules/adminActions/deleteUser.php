<?php

    session_start();
    
    if (!isset($_SESSION['admin']))
    {
        header ("location: ../../../index.php");
        exit;
    }
    
    require_once '../../configModules/database.php';

    // dodajemy uprawnienie administratora
    $admin = $db->prepare('DELETE from events_users WHERE login="'.$_GET['user'].'"');
    $admin-> execute();
    
    header ("location: ../users.php");