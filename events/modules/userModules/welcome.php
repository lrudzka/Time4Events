<?php
    session_start();
    
    $_SESSION['level']='1.3';

    if (!isset($_SESSION['userLoggedIn']))
    {
        header ('Location: login.php');
    }
    
     require_once '../configModules/database.php';
    
    $userEventsQuery = $db->query('SELECT count(*) as liczba from events_events WHERE createdBy="'.$_SESSION['userLoggedIn'].'"');
    $userEvents = $userEventsQuery->fetch();
    
    $userBlockedEventsQuery = $db->query('SELECT count(*) as liczba from events_events WHERE blocked=1 AND createdBy="'.$_SESSION['userLoggedIn'].'"');
    $userBlockedEvents = $userBlockedEventsQuery->fetch();
    
    
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EVENTownia</title>
    
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Kalam" rel="stylesheet">
</head>

<body>
<?php include "../../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <?php
                echo '<h1>Witaj, '.$_SESSION['userLoggedIn'].'</h1>';
                echo '<br/>';

                if (isset($_SESSION['info']))
                {
                    echo "<h4 class=".'"info"'."><span class=".'"info"'."><em>".$_SESSION['info']."</em></span></h4>";
                    unset($_SESSION['info']);
                    echo '<br>';
                }
            
                echo '<h4><em>Liczba Twoich wydarzeń: </em>'.$userEvents['liczba'].'</h4>';
                if ($userBlockedEvents['liczba']>0)
                {
                    echo '<h4><em>Liczba Twoich zablokowanych wydarzeń: </em>'.$userBlockedEvents['liczba'].'</h4>';
                }
            ?>
            <br>
            <h3><a href="addEvent.php">Dodaj wydarzenie</a></h3>
            <h3><a href="userEvents.php">Zarządzaj wydarzeniami</a></h3>
            <h3><a href="changeUserData.php">Zmiana danych</a></h3>
            <h3><a href="../../index.php">Strona główna</a></h3>
            <h3><a href="userActions/logout.php"><em>Wyloguj się</em></a></h3>
            <br/>
        </section>
    </div>

    
    <?php include "../../templates/footer.php"; ?>
</body>
</html>