<?php

    session_start();
    
    if (!isset($_SESSION['admin']))
    {
        header ("location: ../../../index.php");
        exit;
    }
    
    require_once '../../configModules/database.php';

    // dodajemy uprawnienie administratora
    $admin = $db->prepare('DELETE from events_eventCategory WHERE id="'.$_GET['id'].'"');
    $admin-> execute();
    
    header ("location: ../categories.php");