<?php
    session_start();
    
    $_SESSION['level']='1.1';

    if (!isset($_SESSION['admin']))
    {
        header ('Location: ../userModules/welcome.php');
    }
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
                }
            ?>
            <h2>PANEL ADMINISTRATORA</h2>
            <h3><a href="blockedEvents.php">Lista zablokowanych wydarzeń</a></h3>
            <h3><a href="categories.php">Lista kategorii wydarzeń</a></h3>
            <h3><a href="users.php">Lista użytkowników serwisu</a></h3>
            <br>
            <h2>INNE</h2>
            <h3><a href="../userModules/welcome.php">Panel użytkownika</a></h3>
            <h3><a href="../../index.php">Strona główna </a></h3>
            <h3><a href="../userModules/logout.php"><em>Wyloguj się</em></a></h3>
            <br/>
        </section>
    </div>

    
    <?php include "../../templates/footer.php"; ?>
</body>
</html>