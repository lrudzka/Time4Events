<?php

session_start();

if (!isset($_SESSION['admin']))
{
    header ('Location: ../../../index.php');
    exit;
}

if (!isset($_GET['id']))
{
    header ('Location: ../../../index.php');
    exit;
}

   
 require_once '../../configModules/database.php';

//odblokowujemy event
$event = $db->prepare('UPDATE events_events SET blocked=NULL, blockedOn=NULL WHERE id='.$_GET['id']);
$event->execute();

//pobieramy informacje o evencie
$eventQuery = $db->query('SELECT e.name as name, e.description as description, u.email as email, e.createdOn as createdOn from events_events as e JOIN events_users as u ON e.createdBy=u.login WHERE id='.$_GET['id']);
$event = $eventQuery->fetch();

// informacje potrzebne do wysyłki maila o odblokowaniu wydarzenia
$mailRecipient = array();
array_push($mailRecipient, $event['email']);
$mailContent = '<div style="font-size: 25px;">Uwaga!</div><br/>
                <div style="font-size: 20px;"> Informujemy, iż Pana/Pani wydarzenie zostało odblokowane </div><br/>
                <div style="font-size: 20px;"> <strong>Informacje dotyczące odblokowanego wydarzenia </strong> </div><br/>
                <div style="font-size: 20px;"> <em>Nazwa</em>: '.$event['name'].' </div><br/>
                <div style="font-size: 20px;"> <em>Opis:</em> '.$event['description'].' </div><br/>
                <div style="font-size: 20px;"> <em>Data utworzenia:</em> '.$event['createdOn'].' </div>';
$mailSubject = 'EVENTownia - informacja o odblokowaniu wydarzenia';
    
require_once '../../configModules/mailing.php';
            
sendEmail($mailRecipient, $mailContent, $mailSubject);



$_SESSION['info'] = "Wybrane wydarzenie zostało odblokowane";

header ('Location: ../adminPanel.php');
