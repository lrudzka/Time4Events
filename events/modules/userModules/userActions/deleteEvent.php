<?php

session_start();

if (!isset($_SESSION['userLoggedIn']))
{
    header ('Location: ../login.php');
}

   
 require_once '../../configModules/database.php';

//usuwamy event z bazy danych
$event = $db->prepare('DELETE FROM events_events WHERE id='.$_GET['id']);
$event->execute();


$_SESSION['info'] = "Wybrane wydarzenie zostało usunięte";

header ('Location: ../welcome.php');
