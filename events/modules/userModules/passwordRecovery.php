<?php
    session_start();
    
     if (isset($_SESSION['userLoggedIn']))
    {
        header ('Location: userPanel.php');
    }
        
    function randLetter()
{
    $int = rand(0,51);
    $a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $rand_letter = $a_z[$int];
    return $rand_letter;
}
    
    
    
    require_once '../configModules/database.php';
    
        
    
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
        
        //sprawdzamy, czy email jest w bazie
        $queryCheck = $db->prepare('SELECT * FROM events_users WHERE email=:email');
        $queryCheck->bindValue(':email', $email, PDO::PARAM_STR);
        $queryCheck->execute();
        $emailAlreadyExists = $queryCheck->fetch();
         
        if (!$emailAlreadyExists)
        {
            $emailOk = false;
            $_SESSION['e_email'] = "Podany adres nie jest zarejestrowany w naszej bazie";
        }
        
        if ($emailOk)
        {
            
            //nowe hasło
            $randomNum1 = rand(100,999);
            $randomNum2 = rand(1000,9999);
            $newPwd = $randomNum1.randLetter().randLetter().randLetter().randLetter().randLetter().randLetter().randLetter().randLetter().$randomNum2;
            $newPwd_hash = password_hash($newPwd, PASSWORD_DEFAULT);
            $queryPwd = $db->prepare('UPDATE events_users set password=:password WHERE email=:email');
            $queryPwd->bindValue(':password', $newPwd_hash, PDO::PARAM_STR);
            $queryPwd->bindValue(':email', $email, PDO::PARAM_STR);
            $queryPwd->execute();
            
            
            //wysyłka maila
             
            require_once '../configModules/mailing.php';
            
            $passwordInfo = "Twoje tymczasowe hasło do naszego serwisu to <b>$newPwd</b>, użyj go do zalogowania się do serwisu i następnie zmień hasło na nowe.";
            
            sendEmail($email, $passwordInfo, "Zmiana hasła");
            
            $_SESSION['emailInfo'] = "E-mail z nowym hasłem został wysłany";
            unset($_POST['email']);
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
</head>

<body>
<?php include "../../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <h2>Odzyskiwanie dostępu do konta</h2>
            <br/>
            <h4>Podaj swój adres e-mail zarejestrowany w naszej bazie i kliknij 'Wyślij' - </h4>
            <h4>- w ten sposób otrzymasz na maila nowe - tymczasowe - hasło do konta.</h4>
            <h4>Po zalogowaniu się do konta nowym hasłem wejdź w ustawienia i zmień hasło na nowe.</h4>
            <br/>
            <br/>
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Twój adres e-mail:</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" id="emal" name="email" value=<?php
                            if (isset($_POST['email'])) {
                                echo $_POST['email'];
                            }
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
                    <input type="submit" class="btn btn-success" value="Wyślij">
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
            <br/>
            <h3><a href="../../index.php">Strona główna</a></h3>
            <h3><a href="welcome.php">Panel użytkownika</a></h3>
            <br/>
        </section>
    </div>

    
    <?php include "../../templates/footer.php"; ?>
</body>
</html>