<?php
    session_start();
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>About Events</title>

    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Eagle+Lake" rel="stylesheet">
</head>

<body>
<?php include "templates/header.php"; ?>
	
    <div class="background">
        <section class="main_width">
            <h1 class="welcomeText">Nie czekaj na przygodę, po prostu weź w niej udział</h1>
            <h2><a href="events.php">Znajdź wydarzenie</a></h2>
            <?php
                if (isset($_SESSION['userLoggedIn']))
                {
                   echo '<h2><a href="welcome.php">Panel użytkownika</a></h2>';
                   echo '<h2><a href="logout.php">Wyloguj się</a></h2>' ;
                }
                else
                {
                    echo '<h2><a href="login.php">Zaloguj się, by dodawać i zmieniać swoje wydarzenia</a></h2>';
                }
            ?>
            <br/>
        </section>
    </div>
    <?php include "templates/footer.php"; ?>
</body>
</html>