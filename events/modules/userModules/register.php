<?php
    session_start();
    
    $_SESSION['level']='1.3';

    if(isset($_POST['login']))
    {
        //zmienna do sprawdzania, czy wszystko OK
        $everythingOk = true;
        
        // 1. walidacja loginu

        $login = $_POST['login'];

        // 1.1. sprawdzamy długość loginu
        if ( (strlen($login)<3) || (strlen($login)>20) )
        {
            $everythingOk = false;
            $_SESSION['e_login']="Login powinien zawierać od 3 do 20 znaków";
        }
        else
        {
            // 1.2. sprawdzamy czy znaki są alfanumeryczne
            if ( ctype_alnum($login)== false )
            {
                $everythingOk = false;
                $_SESSION['e_login']= "Login może się składać tylko z liter i liczb, bez znaków specjalnych";
            }
        }

        // 2. Sprawdzamy poprawność hasła
        $pwd1 = $_POST['pwd1'];
        $pwd2 = $_POST['pwd2'];

        if ( (strlen($pwd1)<8) || (strlen($pwd1)>20) )
        {
            $everythingOk = false;
            $_SESSION['e_pwd']="Hasło powinno zawierać od 8 do 20 znaków";
        }
        if ($pwd1!=$pwd2)
        {
            $everythingOk = false;
            $_SESSION['e_pwd']="Wprowadzone hasła nie są identyczne";
        }
        // 2.2. hashujemy hasło!***MUST HAVE***
        $pwd_hash = password_hash($pwd1, PASSWORD_DEFAULT);

        // 3. sprawdzamy poprawność adresu e-mail
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
        {
            $everythingOk = false;
            $_SESSION['e_email']="Wprowadzony adres e-mail nie jest poprawy";
        }

        //bot or not? Sprawdzamy, czy użytkownik nie jest robotem
        $secret = "6Le9r2sUAAAAAASvE-8A2rdMthK9Z2iz58i8Dbdq";

        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $answer = json_decode($check);

        if ($answer->success==false)
        {
            $everythingOk=false;
            $_SESSION['e_bot'] = "Potwierdź, że nie jesteś robotem";
        }




        if ($everythingOk == true)
        {
             require_once '../configModules/database.php';
            //sprawdzamy czy login jest już w bazie
            $queryCheck = $db->prepare('SELECT * FROM events_users WHERE login=:login');
            $queryCheck->bindValue(':login', $login, PDO::PARAM_STR);
            $queryCheck->execute();
            $loginAlreadyExists = $queryCheck->fetch();
            
            if ($loginAlreadyExists)
            {
                $everythingOk = false;
                $_SESSION['e_login'] = "Podany login jest już zajęty";
            }

            //sprawdzamy, czy email jest już w bazie
            $queryCheck = $db->prepare('SELECT * FROM events_users WHERE email=:email');
            $queryCheck->bindValue(':email', $email, PDO::PARAM_STR);
            $queryCheck->execute();
            $emailAlreadyExists = $queryCheck->fetch();
            
            if ($emailAlreadyExists)
            {
                $everythingOk = false;
                $_SESSION['e_email'] = "Podany adres jest już zarejestrowany w naszej bazie";
            }

        }

        if ($everythingOk == true)
        {
            //insert z użyciem PDO
                //wykorzystujemy stworzony przez nas obiekt - db (w pliku database.php)
                //krok pierwszy - definiujemy zapytanie
                $query = $db->prepare('INSERT INTO events_users (login, password, email, admin, bann) VALUES (:login, :password, :email, null, null)');
                //krok drugi - przypisujemy wartość do zmiennych
                $query->bindValue(':login', $login, PDO::PARAM_STR);
                $query->bindValue(':password', $pwd_hash, PDO::PARAM_STR);
                $query->bindValue(':email', $email, PDO::PARAM_STR);
                //krok trzeci - uruchamiamy zapytanie
                $query->execute();
                $_SESSION['userLoggedIn'] = $login;
                header('Location: welcome.php');
        }


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
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<?php include "../../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <h1>Utwórz nowe konto</h1>
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="login">Login:</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="login" placeholder="Wprowadź login" name="login" value=<?php
                    if (isset($_POST['login']))
                    {
                        echo $_POST['login'];
                    }
                    ?> 
                    >
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_login']))
                            {
                                echo '<span class="error"><strong>'.$_SESSION['e_login'].'</strong></span>';
                                unset($_SESSION['e_login']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd1">Hasło:</label>
                    <div class="col-sm-6">
                    <input type="password" class="form-control" id="pwd1" placeholder="Wprowadź hasło" name="pwd1" value=<?php
                        if (isset($_POST['pwd1']))
                        {
                            echo $_POST['pwd1'];
                        }
                    ?>
                    >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd2">Powtórz hasło:</label>
                    <div class="col-sm-6">
                    <input type="password" class="form-control" id="pwd2" placeholder="Powtórz hasło" name="pwd2" value=<?php
                        if (isset($_POST['pwd2']))
                        {
                            echo $_POST['pwd2'];
                        }
                    
                    ?>
                    >
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_pwd']))
                            {
                                echo '<br/><span class="error"><strong>'.$_SESSION['e_pwd'].'</strong></span>';
                                unset($_SESSION['e_pwd']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">E-mail:</label>
                    <div class="col-sm-6">
                    <input type="email" class="form-control" id="email" placeholder="Podaj adres e-mail" name="email" value=<?php
                        if (isset($_POST['email']))
                        {
                            echo $_POST['email'];
                        }
                    ?>
                    >
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_email']))
                            {
                                echo '<br/><span class="error"><strong>'.$_SESSION['e_email'].'</strong></span>';
                                unset($_SESSION['e_email']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <div class="g-recaptcha" data-sitekey="6Le9r2sUAAAAAHoOfgE2C0pGmnnFAjkQcOD3bgeb"></div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php
                            if (isset($_SESSION['e_bot']))
                            {
                                echo '<br/><span class="error"><strong>'.$_SESSION['e_bot'].'</strong></span>';
                                unset($_SESSION['e_bot']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Zarejestruj się</button>
                    </div>
                </div>
            </form>
            <h3><a href="../../index.php">Strona główna</a></h3>
            <br/>
        </section>
    </div>

    
    <?php include "../../templates/footer.php"; ?>
</body>
</html>

