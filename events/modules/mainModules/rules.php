<?php
    session_start();
    
    $_SESSION['level']='1.2';


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
            <div id="rules">
                <h3>Regulamin serwisu EVENTownia</h3>
                <ul >
                    <li>Lista wydarzeń jest dostępna dla każdego użytkownika serwisu</li>
                    <li>Żeby dodać nowe wydarzenie trzeba się zalogować</li>
                    <li>Administrator systemu ma prawo zablokować wydarzenie, jeżeli jego treść jest nieodpowiednia / nieprzyzwoita / wulgarna / obrażająca</li>
                    <li>Zalogowany użytkownik ma prawo zgłoszenia naruszenia zasady przy wybranym wydarzeniu - poprzez kliknięcie przycisku <em>zgłoś</em></li>
                    <li>Zalogowany użytkownik może usunąć lub zmienić wprowadzone przez siebie wydarzenie - jeżeli jest ono jeszcze aktualne</li>
                </ul>
            </div>
            
            <br/>
            <div class="bottomMenu">
                <a class="inRow" href="../../index.php">Strona główna</a><a class="inRow" href="../userModules/welcome.php">Panel użytkownika</a><?php
                if (isset($_SESSION['admin']))
                {
                    echo '<a  href="../adminModules/adminPanel.php">Panel administratora</a>';
                }
            ?></div>
            <br/>
        </section>
    </div>

    
    <?php include "../../templates/footer.php"; ?>
</body>
</html>