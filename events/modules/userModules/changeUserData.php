<?php
    session_start();
    
    if (!isset($_SESSION['userLoggedIn']))
    {
        header ('Location: login.php');
    }
    
       
    require_once '../configModules/database.php';
    
        
    // zmiana adresu e-mail
    if (isset($_POST['email']))
    {
        // walidacja podanego adresu
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        $emailOk = true;

        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
        {
            $emailOk = false;
            $_SESSION['e_email']="Wprowadzony adres e-mail nie jest poprawy";
        } 
        
        //sprawdzamy, czy email jest już w bazie
        $queryCheck = $db->prepare('SELECT * FROM events_users WHERE email=:email');
        $queryCheck->bindValue(':email', $email, PDO::PARAM_STR);
        $queryCheck->execute();
        $emailAlreadyExists = $queryCheck->fetch();
         
        if ($emailAlreadyExists)
        {
            $emailOk = false;
            $_SESSION['e_email'] = "Podany adres jest już zarejestrowany w naszej bazie";
        }
        
        if ($emailOk)
        {
            $queryEmail = $db->prepare('UPDATE events_users set email=:email WHERE login="'.$_SESSION['userLoggedIn'].'"');
            $queryEmail->bindValue(':email', $email, PDO::PARAM_STR);
            $queryEmail->execute();
            $_SESSION['emailInfo'] = "Adres e-mail został zmieniony";
        }
        
    }
    
    // zmiana hasła 
    // najpierw sprawdzamy poprawność aktualnego hasła
    if (isset($_POST['pwdOld']))
    {
        $password = filter_input(INPUT_POST, 'pwdOld');

        $userPwdQuery = $db->prepare('SELECT login, password FROM events_users WHERE login="'.$_SESSION['userLoggedIn'].'"');
        $userPwdQuery-> execute();

        //wrzucamy dane do tabeli asocjacyjnej
        $user = $userPwdQuery->fetch();

        //jeżeli tablica nie jest pusta... - mamy 1 rekord i hasło się zgadza
        if ($user && password_verify($password, $user['password']))
        {
            // walidujemy nowe hasło
            $newPasswordOk = true;
            $pwd1 = $_POST['pwd1'];
            $pwd2 = $_POST['pwd2'];

            if ( (strlen($pwd1)<8) || (strlen($pwd1)>20) )
            {
                $newPasswordOk = false;
                $_SESSION['e_pwd']="Hasło powinno zawierać od 8 do 20 znaków";
            }
            if ($pwd1!=$pwd2)
            {
                $newPasswordOk = false;
                $_SESSION['e_pwd']="Wprowadzone hasła nie są identyczne";
            }
            
            if ($newPasswordOk)
            {
                // hashujemy hasło!***MUST HAVE***
                $pwd_hash = password_hash($pwd1, PASSWORD_DEFAULT);
                $queryPwd = $db->prepare('UPDATE events_users set password=:password WHERE login="'.$_SESSION['userLoggedIn'].'"');
                $queryPwd->bindValue(':password', $pwd_hash, PDO::PARAM_STR);
                $queryPwd->execute();
                unset($_POST['pwd1']);
                unset($_POST['pwd2']);
                $_SESSION['passwordInfo'] = "Hasło zostało zmienione";
            }
            
            
            
        }
        else
        {
            $_SESSION['e_pwdOld'] = "nieprawidłowe hasło";
        }

    }
    
    $userQuery = $db->query('SELECT * FROM events_users WHERE login="'.$_SESSION['userLoggedIn'].'"');
    $userData = $userQuery->fetch();
    
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
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kalam" rel="stylesheet">
    
</head>

<body>
<?php include "../../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <h2>Zmień swój adres e-mail</h2>
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Nowy adres e-mail:</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" id="emal" name="email" value=<?php
                            echo '"'.$userData['email'].'"';
                        ?>
                        >
                    </div>
                    <div class="col-sm-offset-3 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_email']))
                            {
                                echo '<br/><span class="wrongData"><strong>'.$_SESSION['e_email'].'</strong></span>';
                                unset($_SESSION['e_email']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                    <input type="submit" class="btn btn-success" value="Zapisz zmiany">
                    </div>
                </div>
            </form>
            <div class="col-sm-offset-3 col-sm-6">
                <?php
                    if (isset($_SESSION['emailInfo']))
                    {
                        echo '<br/><span><strong>'.$_SESSION['emailInfo'].'</strong></span>';
                        unset($_SESSION['emailInfo']);
                    }
                ?>
            </div>
            <br/>
            <h2>Zmień swoje hasło</h2>
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwdOld">Aktualne hasło:</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="pwdOld" placeholder="Podaj hasło" name="pwdOld">
                    </div>
                    <div class="col-sm-offset-3 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_pwdOld']))
                            {
                                echo '<br/><span class="wrongData"><strong>'.$_SESSION['e_pwdOld'].'</strong></span>';
                                unset($_SESSION['e_pwdOld']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd1">Nowe hasło:</label>
                    <div class="col-sm-6">
                    <input type="password" class="form-control" id="pwd1" placeholder="Wprowadź nowe hasło" name="pwd1" value=<?php
                        if (isset($_POST['pwd1']))
                        {
                            echo $_POST['pwd1'];
                        }
                    ?>
                    >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd2">Powtórz nowe hasło:</label>
                    <div class="col-sm-6">
                    <input type="password" class="form-control" id="pwd2" placeholder="Powtórz nowe hasło" name="pwd2" value=<?php
                        if (isset($_POST['pwd2']))
                        {
                            echo $_POST['pwd2'];
                        }
                    
                    ?>
                    >
                    </div>
                    <div class="col-sm-offset-3 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_pwd']))
                            {
                                echo '<br/><span class="wrongData"><strong>'.$_SESSION['e_pwd'].'</strong></span>';
                                unset($_SESSION['e_pwd']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                    <input type="submit" class="btn btn-success" value="Zapisz zmiany">
                    </div>
                </div>
            </form>
            <div class="col-sm-offset-3 col-sm-6">
                <?php
                    if (isset($_SESSION['passwordInfo']))
                    {
                        echo '<br/><span><strong>'.$_SESSION['passwordInfo'].'</strong></span>';
                        unset($_SESSION['passwordInfo']);
                    }
                ?>
            </div>
            <br/>
            <br/>
            <h3><a href="welcome.php">Panel użytkownika</a></h3>
            <br/>
        </section>
    </div>

    
    <?php include "../../templates/footer.php"; ?>
</body>
</html>

