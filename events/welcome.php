<?php
    session_start();

    if (!isset($_SESSION['userLoggedIn']))
    {
        header ('Location: login.php');
    }
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
    <link href="https://fonts.googleapis.com/css?family=Kalam" rel="stylesheet">
</head>

<body>
<?php include "templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <?php
                echo '<h1>Witaj, '.$_SESSION['userLoggedIn'].'</h1>';

                if (isset($_SESSION['info']))
                {
                    echo "<h4 class=".'"info"'."><em>".$_SESSION['info']."</em></h4>";
                    unset($_SESSION['info']);
                }
            ?>
            <h3><a href="addEvent.php">Dodaj wydarzenie</a></h3>
            <h3><a href="userEvents.php">Zarządzaj wydarzeniami</a></h3>
            <h3><a href="index.php">Strona główna</a></h3>
            <h3><a href="logout.php">Wyloguj się</a></h3>
            <br/>
        </section>
    </div>

    
    <?php include "templates/footer.php"; ?>
</body>
</html>