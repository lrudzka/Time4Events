<?php
    session_start();

    if (isset($_SESSION['userLoggedIn']))
    {
        header("Location: welcome.php");
    }

     require_once '../configModules/database.php';

   
    if (isset($_POST['login']))
    {
        $login = filter_input(INPUT_POST, 'login');
        $password = filter_input(INPUT_POST, 'password');

        $userQuery = $db->prepare('SELECT login, password FROM events_users WHERE login=:login');
        $userQuery -> bindValue(':login', $login, PDO::PARAM_STR);
        $userQuery-> execute();

        //wrzucamy dane do tabeli asocjacyjnej
        $user = $userQuery->fetch();

        //jeżeli tablica nie jest pusta... - mamy 1 rekord i hasło się zgadza
        if ($user && password_verify($password, $user['password']))
        {
            $_SESSION['userLoggedIn'] = $user['login'];
            unset($_SESSION['badAttempt']);
            header('Location: welcome.php');
        }
        else
        {
            $_SESSION['badAttempt'] = true;
        }

    }

?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <title>About Events</title>
    
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../../css/main.css">
</head>

<body>
<?php include "../../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <h1><a href="register.php">Zarejestruj się</a></h1>
            <br/>
            <h1>Zaloguj się</h1>
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="login">Login:</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="login" placeholder="Login" name="login" value=<?php
                        if (isset($_POST['login']))
                        {
                           echo $_POST['login'];
                        }
                    ?>
                    >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Hasło:</label>
                    <div class="col-sm-6">
                    <input type="password" class="form-control" id="pwd" placeholder="Hasło" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                    <button type="submit" class="btn btn-default">Zaloguj się</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['badAttempt']))
                            {
                                echo '<span class="error">Zły login lub hasło</span>';
                                unset($_SESSION['badAttempt']);
                            }
                        ?>
                    </div>
                </div>
            </form>
            <br/>
            <h1><a href="../../index.php">Strona główna</a></h1>
            <br/>
        </section>
    </div>

    
    <?php include "../../templates/footer.php"; ?>
</body>
</html>