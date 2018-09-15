<?php

session_start();

if (!isset($_SESSION['userLoggedIn']))
{
    header ('Location: login.php');
}

   
require_once 'database.php';

//usuwamy event z bazy danych
$event = $db->prepare('DELETE FROM events WHERE id='.$_GET['id']);
$event->execute();


$_SESSION['info'] = "Wybrane wydarzenie zostało usunięte";

header ('Location: welcome.php');
