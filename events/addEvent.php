<?php
    session_start();

    if (!isset($_SESSION['userLoggedIn']))
    {
        header ('Location: login.php');
    }

    require_once 'database.php';

    //pobieramy województwa z bazy danych
    $provincesQuery = $db->query('SELECT * FROM province');
    //odbieramy dane -> w tym wypadku do tablicy dwuwymiarowej
    $provinces = $provincesQuery->fetchAll();
    //tabelę użyjemy poniżej, w tagu select w formularzu

    //i to samo robimy z kategoriamy zdarzeń
    $categoriesQuery = $db->query('SELECT * FROM eventCategory ORDER BY id');
    $categories = $categoriesQuery->fetchAll();

    

    if (isset($_POST['name']))
    {

        //walidacja danych

        $everythingOK = true;

        // 1. nazwa
        $name = $_POST['name'];

        if ( (strlen($name)<5) )
        {
            $everythingOK = false;
            $_SESSION['e_name'] = "Nazwa jest za krótka (wymagane min. 5 znaków)";
        }

        if ( (strlen($name)>50) )
        {
            $everythingOK = false;
            $_SESSION['e_name'] = "Nazwa jest za długa (może mieć max. 50 znaków)";
        }

        // 2. kategoria
        $category = $_POST['category'];

        if ($category == 'Wybierz kategorię')
        {
            $everythingOK = false;
            $_SESSION['e_category'] = "Wybierz kategorię";
        }

        // 3. opis
        $description = $_POST['description'];

        if ( (strlen($description)<10) )
        {
            $everythingOK = false;
            $_SESSION['e_description'] = "Opis jest za krótki (wymagane min. 10 znaków)";
        }

        if ( (strlen($description)>10000) )
        {
            $everythingOK = false;
            $_SESSION['e_description'] = "Opis jest za długi (może miec max. 10000 znaków)";
        }

        // 5. Data i godzina rozpoczęcia

        function validateDate($date, $format = 'Y-m-d')
        {
            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) == $date;
        }


        $startDate = $_POST['startDate'];
        $startTime = $_POST['startTime'];


        $today = new DateTime();
        $today = $today->format('Y-m-d H:i');

        if ((strlen($startDate)<1))
        {
            $everythingOK = false;
            $_SESSION['e_startDate'] = "Data nie może być pusta";
        }
        else
        {
            if (!validateDate($startDate))
            {
                $everythingOK = false;
                $_SESSION['e_startDate'] = "Niepoprawna data, prawidłowy format to YYYY-MM-DD";
            }
        }

        if ((strlen($startTime)<1))
        {
            $everythingOK = false;
            $_SESSION['e_startTime'] = "Godzina nie może być pusta";
        }
        else
        {
            if (!validateDate($startTime, 'H:i'))
            {
                $everythingOK = false;
                $_SESSION['e_startTime'] = "Niepoprawna godzina, prawidłowy format to hh:mm";
            }
        }
        

        
        // 6. Data zakończenia
        $endDate = $_POST['endDate'];
        $endTime = $_POST['endTime'];

        if ((strlen($endDate)<1))
        {
            $everythingOK = false;
            $_SESSION['e_endDate'] = "Data nie może być pusta";
        }
        else
        {
            if (!validateDate($endDate))
            {
                $everythingOK = false;
                $_SESSION['e_endDate'] = "Niepoprawna data, prawidłowy format to YYYY-MM-DD";
            }
        }

        if ((strlen($endTime)<1))
        {
            $everythingOK = false;
            $_SESSION['e_endTime'] = "Godzina nie może być pusta";
        }
        else
        {
            if (!validateDate($endTime, 'H:i'))
            {
                $everythingOK = false;
                $_SESSION['e_endTime'] = "Niepoprawna godzina, prawidłowy format to hh:mm";
            }
            else
            {
                if ( $endDate.$endTime <= $startDate.$startTime)
                    {
                        $everythingOK = false;
                        $_SESSION['e_endTime'] = "Data zakończenia musi być większa od daty rozpoczęcia, popraw datę lub godzinę";
                    }
                if ( $endDate.$endTime <= $today)
                    {
                        $everythingOK = false;
                        $_SESSION['e_endTime'] = "Data zakończenia nie może być nieaktualna, popraw datę lub godzinę";
                    }    
                
            }
        }

        

        // 7. Województwo
        $province = $_POST['province'];

        if ($province == 'Wybierz województwo')
        {
            $everythingOK = false;
            $_SESSION['e_province'] = "Wybierz województwo";
        }

        // 8. Miasto
        $city = $_POST['city'];

        if ( (strlen($city)<1) )
        {
            $everythingOK = false;
            $_SESSION['e_city'] = "Miejscowość nie może być pusta";
        }

        // 9. Adres
        $address = $_POST['address'];

        if ( (strlen($address)<1) )
        {
            $everythingOK = false;
            $_SESSION['e_address'] = "Adres nie może być pusty";
        }

        // 10. Sprawdzamy bot
        $secret = "6Le9r2sUAAAAAASvE-8A2rdMthK9Z2iz58i8Dbdq";

        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $answer = json_decode($check);

        if ($answer->success==false)
        {
            $everythingOK = false;
            $_SESSION['e_bot'] = "Potwierdź, że nie jesteś robotem";
        }

        $picture = $_POST['picture'];
        $www = $_POST['www'];


        // gdy adres obrazka jest pusty - podstawiamy obrazek domyślny
        if  ( (strlen($picture)<1) )
        {
            $picture = "https://zapodaj.net/images/3180de80994b5.jpg";
        }
              

        if ($everythingOK == true)
        {
            $queryCheck = $db->prepare('INSERT INTO events (id, name, description, category, startDate, startTime, endDate, endTime, createdBy, createdOn, picture, www, province, city, address) 
            VALUES (NULL, :name, :description, :category, :startDate, :startTime, :endDate, :endTime, :user, now(), :picture, :www, :province, :city, :address )');
            $queryCheck->bindValue(':name', $name, PDO::PARAM_STR);
            $queryCheck->bindValue(':description', $description, PDO::PARAM_STR);
            $queryCheck->bindValue(':category', $category, PDO::PARAM_STR);
            $queryCheck->bindValue(':startDate', $startDate, PDO::PARAM_STR);
            $queryCheck->bindValue(':startTime', $startTime, PDO::PARAM_STR);
            $queryCheck->bindValue(':endDate', $endDate, PDO::PARAM_STR);
            $queryCheck->bindValue(':endTime', $endTime, PDO::PARAM_STR);
            $queryCheck->bindValue(':user', $_SESSION['userLoggedIn'], PDO::PARAM_STR);
            $queryCheck->bindValue(':picture', $picture, PDO::PARAM_STR);
            $queryCheck->bindValue(':www', $www, PDO::PARAM_STR);
            $queryCheck->bindValue(':province', $province, PDO::PARAM_STR);
            $queryCheck->bindValue(':city', $city, PDO::PARAM_STR);
            $queryCheck->bindValue(':address', $address, PDO::PARAM_STR);
            $queryCheck->execute();
            $_SESSION['info'] = "Twoje wydarzenie zostało dodane";
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

	<title>About Events</title>

    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<?php include "templates/header.php"; ?>
	
    <div class="background">
        <section class="main_width">
            <h3>Dodaj wydarzenie</h3>
            <span><em>Pola oznaczone * są obowiązkowe</em></span>
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Nazwa wydarzenia*</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="name" placeholder="Podaj nazwę" name="name" value=<?php
                        if (isset($_POST['name']))
                        {
                            echo '"'.$_POST['name'].'"';
                        }
                    ?>
                    >
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_name']))
                            {
                                echo '<span class="error"><strong>'.$_SESSION['e_name'].'</strong></span>';
                                unset($_SESSION['e_name']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="category">Kategoria wydarzenia*</label>
                    <div class="col-sm-6">
                    <select class="form-control" id="category" name="category">
                        <?php
                            if (isset($_POST['category']))
                            {
                                if ($_POST['category']=="Wybierz kategorię")
                                {
                                    echo '<option value="Wybierz kategorię">Wybierz z listy</option>'; 
                                }
                                else
                                {
                                echo '<option value='.$_POST['category'].'>'.$_POST['category'].'</option>';
                                }
                            }
                            else
                            {
                                echo '<option value="Wybierz kategorię">Wybierz z listy</option>'; 
                            }
                            //pętla
                            foreach ($categories as $category)
                            {
                                echo "<option value=".'"'."{$category['category']}".'"'.">{$category['category']}</option>";
                            }
                        ?>
                    </select>
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_category']))
                            {
                                echo '<span class="error"><strong>'.$_SESSION['e_category'].'</strong></span>';
                                unset($_SESSION['e_category']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="description">Opis wydarzenia*</label>
                    <div class="col-sm-6">
                    <textarea rows="5" class="form-control" id="description" name="description" ><?php 
                    if (isset($_POST['description']))
                        {
                            echo $_POST['description'];
                        }
                    ?></textarea>
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_description']))
                            {
                                echo '<span class="error"><strong>'.$_SESSION['e_description'].'</strong></span>';
                                unset($_SESSION['e_description']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="picture">Zdjęcie </label>
                    <div class="col-sm-6">
                    <input type="url" class="form-control" id="picture" placeholder="Zdjęcie (adres URL)" name="picture" value=<?php
                        if (isset($_POST['picture']))
                        {
                            echo '"'.$_POST['picture'].'"';
                        }
                    ?>
                    >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="www">Strona www </label>
                    <div class="col-sm-6">
                    <input type="url" class="form-control" id="www" placeholder="Strona wydarzenia" name="www" value=<?php
                        if (isset($_POST['www']))
                        {
                            echo '"'.$_POST['www'].'"';
                        }
                    ?>
                    >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="startDate">Data rozpoczęcia*</label>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="startDate"  name="startDate" value=<?php
                        if (isset($_POST['startDate']))
                        {
                            echo '"'.$_POST['startDate'].'"';
                        }
                    ?>
                    >
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_startDate']))
                            {
                                echo '<span class="error"><strong>'.$_SESSION['e_startDate'].'</strong></span>';
                                unset($_SESSION['e_startDate']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="startTime">godzina*</label>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder = "hh:mm" id="startTime"  name="startTime" value=<?php
                        if (isset($_POST['startTime']))
                        {
                            echo '"'.$_POST['startTime'].'"';
                        }
                    ?>
                    >
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_startTime']))
                            {
                                echo '<span class="error"><strong>'.$_SESSION['e_startTime'].'</strong></span>';
                                unset($_SESSION['e_startTime']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="endDate">Data zakończenia*</label>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="endDate"  name="endDate" value=<?php
                        if (isset($_POST['endDate']))
                        {
                            echo '"'.$_POST['endDate'].'"';
                        }
                    ?>
                    >
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_endDate']))
                            {
                                echo '<span class="error"><strong>'.$_SESSION['e_endDate'].'</strong></span>';
                                unset($_SESSION['e_endDate']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="endTime">godzina*</label>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder = "hh:mm" id="endTime"  name="endTime" value=<?php
                        if (isset($_POST['endTime']))
                        {
                            echo '"'.$_POST['endTime'].'"';
                        }
                    ?>
                    >
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_endTime']))
                            {
                                echo '<span class="error"><strong>'.$_SESSION['e_endTime'].'</strong></span>';
                                unset($_SESSION['e_endTime']);
                            }
                        ?>
                    </div>
                </div>
                <h4>Adres wydarzenia:</h4>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Województwo*</label>
                    <div class="col-sm-6">
                    <select class="form-control" id="province" name="province" >
                        <?php
                            if (isset($_POST['province']))
                            {
                                if ($_POST['province']=="Wybierz województwo")
                                {
                                    echo '<option value="Wybierz województwo">Wybierz z listy</option>'; 
                                }
                                else
                                {
                                echo '<option value='.$_POST['province'].'>'.$_POST['province'].'</option>';
                                }
                            }
                            else
                            {
                                echo '<option value="Wybierz województwo">Wybierz z listy</option>'; 
                            }
                            //pętla
                            foreach ($provinces as $province)
                            {
                                echo "<option value={$province['province']}>{$province['province']}</option>";
                            }
                        ?>
                    </select>
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_province']))
                            {
                                echo '<span class="error"><strong>'.$_SESSION['e_province'].'</strong></span>';
                                unset($_SESSION['e_province']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="city">Miejscowość*</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="city" placeholder="Podaj miejscowość" name="city" value=<?php
                        if (isset($_POST['city']))
                        {
                            echo '"'.$_POST['city'].'"';
                        }
                    ?>
                    >
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_city']))
                            {
                                echo '<span class="error"><strong>'.$_SESSION['e_city'].'</strong></span>';
                                unset($_SESSION['e_city']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="address">Adres*</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="address" placeholder="Podaj adres (ulica / nr)" name="address" value=<?php
                        if (isset($_POST['address']))
                        {
                            echo '"'.$_POST['address'].'"';
                        }
                    ?>
                    >
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_address']))
                            {
                                echo '<span class="error"><strong>'.$_SESSION['e_address'].'</strong></span>';
                                unset($_SESSION['e_address']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                    <div class="g-recaptcha" data-sitekey="6Le9r2sUAAAAAHoOfgE2C0pGmnnFAjkQcOD3bgeb"></div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-6">
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
                    <div class="col-sm-offset-2 col-sm-6">
                    <button type="submit" class="btn btn-default">Zapisz</button>
                    </div>
                </div>
            </form>
            <h4><a href="welcome.php">Panel użytkownika</a></h4>
            <br/><br/>
        </section>
    </div>
    <?php include "templates/footer.php"; ?>
</body>
</html>