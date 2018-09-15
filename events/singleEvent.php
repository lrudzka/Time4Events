<?php
    session_start();

   
    require_once 'database.php';

    //pobieramy eventy z bazy danych
    $eventQuery = $db->query('SELECT * FROM events WHERE id='.$_GET['id']);
    //odbieramy dane -> do tablicy dwuwymiarowej
    $event = $eventQuery->fetch(PDO::FETCH_ASSOC);

    $startHour = substr($event['startTime'], 0, 5);
    $endHour = substr($event['endTime'], 0, 5);

?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <title>About Events</title>
    
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<?php include "templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <section>
                <?php
                        echo "<div class=".'"event"'.">
                            <h1>{$event['name']}</h1>
                            <p><em>kategoria: </em>{$event['category']}</p>
                            <p><em>start: </em>{$event['startDate']}, <em>godz. </em>{$startHour}</p>
                            <p><em>koniec: </em>{$event['endDate']}, <em>godz. </em>{$endHour}</p>
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
            <?php
                if (isset($_SESSION['userLoggedIn']))
                {
                    echo '<h4> <a href="welcome.php">Panel użytkownika</a>';
                }
            ?>
            <h4><a href="index.php">Strona główna</a></h4>
            <br/>
        </section>
    </div>

    
    <?php include "templates/footer.php"; ?>
</body>
</html>