<?php
    session_start();

    if (!isset($_SESSION['userLoggedIn']))
    {
        header ('Location: login.php');
    }

   
     require_once '../configModules/database.php';

    //pobieramy eventy z bazy danych
    $eventQuery = $db->query('SELECT * FROM events_events WHERE id='.$_GET['id']);
    //odbieramy dane 
    $event = $eventQuery->fetch(PDO::FETCH_ASSOC);

    $eventStartTime = substr($event['startTime'], 0, 5);
    $eventEndTime = substr($event['endTime'], 0, 5);

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
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<?php include "../../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <section id="warning">
                <h2><span>Czy na pewno chcesz usunąć poniższe wydarzenie?</span></h2>
                <?php
                    echo "<p class=".'"btn btn-danger"'."><a href=".'"'."deleting.php?id=".$_GET['id'].'"'." target=".'"_blank"'.">Tak - usuń wydarzenie</a></p>"
                ?>
                <p class="btn btn-success"><a href="welcome.php">Powrót do panelu użytkownia</a></p>
            </section>
            <section>
                <?php
                        echo "<div class=".'"event"'.">
                            <h1>{$event['name']}</h1>
                            <p><em>kategoria: </em>{$event['category']}</p>
                            <p><em>start: </em>{$event['startDate']}, <em>godz. </em>{$eventStartTime}</p>
                            <p><em>koniec: </em>{$event['endDate']}, <em>godz. </em>{$eventEndTime}</p>
                            <p><em>adres: </em><span>woj.: </em>{$event['province']}, {$event['city']}, {$event['address']} </span></p>
                            <br/>
                            <p><em>SZCZEGÓŁY:</em></p>
                            <p class=".'"description"'.">{$event['description']}</p>
                            <p><a href=".'"'."{$event['www']}".'"'."target=".'"_blank"'.">{$event['www']}</a></p>
                            <p class=".'"singleImage"'."><img src=".'"'."{$event['picture']}".'"'." alt=".'"image illustrating event"'."></p>
                            <p><em>dodane przez: </em>{$event['createdBy']};  <em>data dodania: </em>{$event['createdOn']}</p>
                            </div>";
                        
                ?>
                
            </section>
                    
            
            <br/>
        </section>
    </div>

    
    <?php include "../../templates/footer.php"; ?>
</body>
</html>