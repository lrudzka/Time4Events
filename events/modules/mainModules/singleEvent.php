<?php
    session_start();
    
    $_SESSION['level']='1.2';

    if (!isset($_GET['id']))
    {
        header ('Location: ../../index.php');
    }
   
     require_once '../configModules/database.php';

    //pobieramy eventy z bazy danych
    $eventQuery = $db->query('SELECT * FROM events_events WHERE id='.$_GET['id']);
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

    <title>EVENTownia</title>
    
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/main.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<?php include "../../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <section>
                <?php
                    if (isset($_GET['deleteOption']))
                    {
                        echo '<section id="warning">';
                            if ($_GET['deleteOption'] == 'delete')
                                {
                                    echo "<h2><span>Czy na pewno chcesz usunąć poniższe wydarzenie?</span></h2>";
                                    echo "<p class=".'"btn btn-danger"'."><a href=".'"'."../userModules/userActions/deleteEvent.php?id=".$_GET['id'].'"'." target=".'"_blank"'.">Tak - usuń wydarzenie</a></p>";
                                    echo '<p class="btn btn-success"><a href="../userModules/welcome.php">Przejdź do panelu użytkownika</a></p>';
                                }
                                elseif ($_GET['deleteOption'] == 'block')
                                {
                                    echo "<h2><span>Czy na pewno chcesz zablokować poniższe wydarzenie?</span></h2>";
                                    echo "<p class=".'"btn btn-danger"'."><a href=".'"'."../adminModules/adminActions/blockEvent.php?id=".$_GET['id'].'"'." target=".'"_blank"'.">Tak - zablokuj wydarzenie</a></p>"; 
                                    echo '<p class="btn btn-success"><a href="../adminModules/adminPanel.php">Przejdź do panelu administratora</a></p>';
                                }
                                else
                                {
                                    echo "<h2><span>Czy na pewno chcesz odblokować poniższe wydarzenie?</span></h2>";
                                    echo "<p class=".'"btn btn-warning"'."><a href=".'"'."../adminModules/adminActions/unblockEvent.php?id=".$_GET['id'].'"'." target=".'"_blank"'.">Tak - odblokuj wydarzenie</a></p>"; 
                                    echo '<p class="btn btn-success"><a href="../adminModules/adminPanel.php">Przejdź do panelu administratora</a></p>';
                                }
                            
                        echo '</section>';
                    }
                
                        if (isset($_SESSION['abuseReportInfo']))
                        {
                            echo '<span class="info">'.$_SESSION['abuseReportInfo'].'</span>';
                            unset($_SESSION['abuseReportInfo']);
                        }
                        
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
                                
                                <div class=".'"buttons"'.">
                                    <p><em>dodane przez: </em>{$event['createdBy']};  <em>data dodania: </em>{$event['createdOn']}</p>
                                    <span title=".'"'."zgłoś nadużycie".'"'." ><a href=".'"'."../userModules/userActions/abuseReport.php?id={$event['id']}&source=../../mainModules/singleEvent.php?id={$event['id']}".'"'." target=".'"_blank"'.">zgłoś</a></span>
                                </div>    
                            </div>";
                            
                        if (isset($_SESSION['admin']))
                        {
                            
                            if ($event['blocked']==1)
                            {
                                echo '<div class="event"><p><strong>Data blokady: '.$event['blockedOn'].'</strong></p></div>';
                                echo "<p class=".'"btn btn-warning"'."><a href=".'"'."singleEvent.php?id={$event['id']}&deleteOption=unblock".'"'." target=".'"_blank"'.">Odblokuj</a></p>";
                            }
                            else
                            {
                                echo "<p class=".'"btn btn-danger"'."><a href=".'"'."singleEvent.php?id={$event['id']}&deleteOption=block".'"'." target=".'"_blank"'.">Zablokuj</a></p>";
                            }
                        }
                        
                ?>
                
            </section>
                    
            <br/>
            <h4><a class="inRow" href="../../index.php">Strona główna</a><a class="inRow" href="../userModules/welcome.php">Panel użytkownika</a><?php
                if (isset($_SESSION['admin']))
                {
                    echo '<a  href="../adminModules/adminPanel.php">Panel administratora</a>';
                }
            ?></h4>
            <br/>
        </section>
    </div>

    
    <?php include "../../templates/footer.php"; ?>
</body>
</html>