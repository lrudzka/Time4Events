<?php

    session_start();
    
    if (!isset($_GET['source']))
    {
        header ('Location: ../../../index.php');
    }
    
    if (!isset($_GET['id']))
    {
        header ('Location: ../../../index.php');
    }
    
    //sprawdzamy, czy użytkownik jest zalogowany - jeśli nie to odsyłamy do źródła z odpowiednią informacją
    
    if (!isset($_SESSION['userLoggedIn']))
    {
        $_SESSION['abuseReportInfo']='  Aby zgłosić nadużycie musisz być zalogowany  ';
        header ('Location: '.$_GET['source']);
        exit();
    }
    
    //pobieramy informacje o użytkowniku
    require_once '../../configModules/database.php';
   
    $login = $_SESSION['userLoggedIn'];

    $userQuery = $db->query('SELECT * FROM events_users WHERE login="'.$login.'"');
    $user = $userQuery->fetch();
        
    $userEmail = $user['email'];
    
    
    
       
    // uzupełniamy informacje potrzebne do wysyłki maila
    
    // dane administratorów
    
    $adminQuery = $db->query('SELECT email from events_users WHERE admin=1');
    $admins = $adminQuery->fetchAll();
    
    $mailRecipient = array();
    
    foreach ($admins as $admin)
    {
        array_push($mailRecipient, $admin['email']);
    }
    
    $mailContent = '<div style="font-size: 25px;">Uwaga!</div><br/>
                    <div style="font-size: 20px;"> Użytkownik '.$login.' / '.$userEmail.' zgłasza nadużycie w serwisie. </div><br/>
                    <a style="font-size: 20px;" href="http://localhost/events/modules/mainModules/singleEvent.php?id='.$_GET['id'].'" target="_blank">Szczegóły zgłoszonego wydarzenia pod tym linkiem</a>';
    $mailSubject = 'zgłoszenie nadużycia';
    
    require_once '../../configModules/mailing.php';
            
    sendEmail($mailRecipient, $mailContent, $mailSubject);
    
    
    $_SESSION['abuseReportInfo']='  Informacja o nadużyciu została wysłana do administratora serwisu. Dziękujemy!  ';
    header ('Location: '.$_GET['source']);


    
    