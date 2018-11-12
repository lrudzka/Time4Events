<?php
    session_start();
    
    $_SESSION['level']='1.2';

   
    require_once '../configModules/database.php';

    $now = new DateTime();
    $now = $now->format('Y-m-d');
    
    if (!isset($_GET['dataType']))
    {
         
        //pobieramy eventy z bazy danych
        $eventsQuery = $db->query('SELECT * FROM events_events WHERE blocked is NULL AND endDate >= "'.$now.'" ORDER BY startDate, startTime');
        //odbieramy dane -> do tablicy dwuwymiarowej
        $events = $eventsQuery->fetchAll();
    
    }
    else
    {
        if ($_GET['dataType']=='archive')
        {
            
            //pobieramy eventy z bazy danych
            $eventsQuery = $db->query('SELECT * FROM events_events WHERE blocked is NULL AND endDate < "'.$now.'" ORDER BY blockedOn desc, startDate, startTime');
            //odbieramy dane -> do tablicy dwuwymiarowej
            $events = $eventsQuery->fetchAll();
            
        }    
    }
    
   
    

    //pobieramy województwa z bazy danych
    $provincesQuery = $db->query('SELECT * FROM events_province');
    //odbieramy dane -> w tym wypadku do tablicy dwuwymiarowej
    $provinces = $provincesQuery->fetchAll();
    //tabelę użyjemy poniżej, w tagu select w formularzu wyszukiwania

    //i to samo robimy z kategoriamy zdarzeń
    $categoriesQuery = $db->query('SELECT * FROM events_eventCategory ORDER BY id');
    $categories = $categoriesQuery->fetchAll();

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    
   

    if (isset($_POST['province']))
    {
        $allOk = true;

        if ($_POST['province']=='')
        {
            $province = '%';
        }
        else
        {
            $province = $_POST['province'];
        }

        if ($_POST['category']=='')
        {
            $category = '%';
        }
        else
        {
            $category = $_POST['category'];
        }

        if ($_POST['city']=='')
        {
            $city = '%';
        }
        else
        {
            $city = '%'.$_POST['city'].'%';
        }
        if ($_POST['keyWord']=='')
        {
            $keyWord = '%';
        }
        else
        {
            $keyWord = '%'.$_POST['keyWord'].'%';
        }
        if ($_POST['from']=='')
        {
            $startingFrom = '1000-01-01';
        }
        else
        {
            $startingFrom = $_POST['from'];
        }
        if ($_POST['to']=='')
        {
            
            $endingTo = '9999-01-01';
        }
        else
        {
            $endingTo = $_POST['to'];
        }

        //walidacja dat

        if (!validateDate($startingFrom))
        {
            $allOk = false;
            $_SESSION['e_date'] = true;
        }

        if (!validateDate($endingTo))
        {
            $allOk = false;
            $_SESSION['e_date'] = true;
        }

        if ($allOk)
        {
            
            if (!isset($_GET['dataType']))
            {

                //pobieramy eventy z bazy danych z ograniczeniami
                $eventsQuery = $db->query('SELECT * FROM events_events WHERE blocked is NULL AND endDate >= "'.$now.'" AND province like "'.$province.'" AND category like "'.$category.'" AND city like "'.$city.'" AND (name like "'.$keyWord.'" OR description like "'.$keyWord.'" OR city like "'.$keyWord.'") AND startDate > "'.$startingFrom.'" AND endDate < "'.$endingTo.'" ORDER BY startDate, startTime');
                //odbieramy dane -> do tablicy dwuwymiarowej
                $events = $eventsQuery->fetchAll();

            }
            else
            {
                if ($_GET['dataType']=='archive')
                {
                   
                    //pobieramy eventy z bazy danych z ograniczeniami
                    $eventsQuery = $db->query('SELECT * FROM events_events WHERE blocked is NULL AND endDate < "'.$now.'" AND province like "'.$province.'" AND category like "'.$category.'" AND city like "'.$city.'" AND (name like "'.$keyWord.'" OR description like "'.$keyWord.'" OR city like "'.$keyWord.'") AND startDate > "'.$startingFrom.'" AND endDate < "'.$endingTo.'" ORDER BY blockedOn, startDate, startTime');
                    //odbieramy dane -> do tablicy dwuwymiarowej
                    $events = $eventsQuery->fetchAll();
                    
                }
            }
            
        }
        
    }

    if (!$events)
    {
        $_SESSION['noData'] = true;
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
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<?php include "../../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <?php
                if (isset($_SESSION['abuseReportInfo']))
                {
                    echo '<span class="info">'.$_SESSION['abuseReportInfo'].'</span>';
                    unset($_SESSION['abuseReportInfo']);
                }
                           
                if (!isset($_GET['dataType']))
                {
                    echo '<h4><a href="events.php?dataType=archive">Przejdź do wydarzeń archiwalnych</a></h4>';
                }
                else
                {
                    if ($_GET['dataType']=='archive')
                    {
                        echo '<h4><a href="events.php">Przejdź do wydarzeń aktualnych</a></h4>';
                    }
                }
            
            ?>
                
            <div class="row title">
                <?php
                    if (!isset($_GET['dataType']))
                    {
                        echo '<h3>WYDARZENIA NADCHODZĄCE</h3>';
                    }
                    else
                    {
                        if ($_GET['dataType']=='archive')
                        {
                            echo '<h3>WYDARZENIA ARCHIWALNE</h3>';
                        }
                    }
                ?>
            </div>
            <div class="row">
                <div class="search col-sm-6">
                    <h4>FILTR</h4>
                    <form method="post" class="form-horizontal">   
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="province">Województwo: </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="province" name="province" >
                                    <option value="">Wybierz z listy</option>                        
                                        <?php
                                            //pętla
                                            foreach ($provinces as $province)
                                            {
                                                echo "<option value={$province['province']}>{$province['province']}</option>";
                                            }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="category">Kategoria: </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="category" name="category" >
                                    <option value="">Wybierz z listy</option>                        
                                        <?php
                                            //pętla
                                            foreach ($categories as $category)
                                            {
                                                echo "<option value=".'"'."{$category['category']}".'"'.">{$category['category']}</option>";
                                            }
                                        ?>
                                </select>
                            </div>
                        </div>    
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="city">Miejscowość: </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="city" name="city">
                            </div>
                        </div>   
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="keyWord">Słowo klucz: </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="keyWord" name="keyWord">
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="from">Termin od: </label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="YYYY-MM-DD" class="form-control date-picker" id="from" name="from" value=<?php
                                    if (isset($_POST['from']) && isset($_SESSION['e_date']))
                                    {
                                        echo '"'.$_POST['from'].'"';
                                    }
                                
                                ?>
                                >
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="to">do: </label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="YYYY-MM-DD" class="form-control date-picker" id="to" name="to" value=<?php
                                    if (isset($_POST['to']) && isset($_SESSION['e_date']))
                                    {
                                        echo '"'.$_POST['to'].'"';
                                    }
                                
                                ?>
                                >
                            </div>
                        </div>       
                        <button type="submit" class="btn btn-default"> Filtruj / Resetuj filtr </button>
                    </form>
                </div>
                <div class="searchInfo search col-sm-5">
                    <h4> KRYTERIA WYSZUKIWANIA </h4>
                    <section class="searchInfo">
                        <?php
                            if (!isset($_POST['province']) || ($_POST['province']=='' &&
                                $_POST['category']=='' &&
                                $_POST['city']=='' &&
                                $_POST['keyWord'] == '' &&
                                $_POST['from'] == '' && 
                                $_POST['to'] == '' ) )
                            {
                                echo "<h5> brak kryteriów </h5>";
                            }
                            else
                            {
                                if (isset($_SESSION['e_date']))
                                {
                                    echo "<h4> podano błędną datę / daty </h4>";
                                    echo "<h4> prawidłowy format to YYYY-MM-DD</h4>"; 
                                    unset($_SESSION['e_date']);
                                }
                                else
                                {
                                    if ($_POST['province']<>'')
                                    {
                                        echo "<h4> <em> województwo: </em>".$_POST['province']."</h4>";
                                    }
                                    if ($_POST['category']<>'')
                                    {
                                        echo '<h4><em> kategoria: </em>'.$_POST['category'].'</h4>';
                                    }
                                    if ($_POST['city']<>'')
                                    {
                                        echo "<h4><em> miejscowość: </em>".$_POST['city']."</h4>";
                                    }
                                    if ($_POST['keyWord']<>'')
                                    {
                                        echo "<h4><em> słowo kluczowe: </em>".$_POST['keyWord']."</h4>";
                                    }
                                    if ($_POST['from']<>'')
                                    {
                                        echo "<h4><em> Termin od: </em>".$startingFrom."</h4>";
                                    }
                                    if ($_POST['to']<>'')
                                    {
                                        echo "<h4><em> Termin do: </em>".$endingTo."</h4>";
                                    }
                                }

                                
                                unset($_POST['province']);
                                
                                unset($_POST['category']);
                                
                                unset($_POST['city']);
                                
                                unset($_POST['keyWord']);
                                
                                unset($_POST['from']);
                                
                                unset($_POST['to']);  
                            }
                            
                        ?>
                    </section>    
                </div>
            </div>
            <div class="row events">
                <?php
                    
                    if (isset($_SESSION['noData']))
                    {
                        echo "<h3>Nie znaleziono danych</h3>";
                        unset($_SESSION['noData']);
                    }
                    foreach ($events as $event)
                        {
                            $startTime = substr($event['startTime'], 0,5);
                            $endTime = substr($event['endTime'], 0, 5);
                            echo "<div class=".'"col-sm-4 item"'.">
                                <p class=".'"name"'.">{$event['name']}</p>
                                <p><em>{$event['category']}</em></p>
                                <p><em>Start: </em>{$event['startDate']}, <em>godz.</em> {$startTime}</p>
                                <p><em>Koniec: </em>{$event['endDate']}, <em>godz.</em> {$endTime}</p>
                                <p><span>{$event['city']}, woj.: </em>{$event['province']}</span></p>";
                                if (isset($_GET['dataType']))
                                {
                                    if ($_GET['dataType']=="blocked")
                                    {
                                        echo "<p><em>Data blokady: </em>{$event['blockedOn']}</p>";
                                    }
                                }
                            echo "<p class=".'"img"'."><img src=".'"'."{$event['picture']}".'"'." alt=".'"image illustrating event"'."></p>
                                <div class=".'"buttons"'.">
                                    <span class=".'"btn btn-primary"'."><a href=".'"'."singleEvent.php?id={$event['id']}".'"'." target=".'"_blank"'.">Szczegóły</a></span>
                                    <span title=".'"'."zgłoś nadużycie".'"'." ><a href=".'"'."../userModules/userActions/abuseReport.php?id={$event['id']}&source=../../mainModules/events.php".'"'." target=".'"_blank"'.">zgłoś</a></span>
                                </div>
                                </div>";
                        }
                ?>
                
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src='../../js/script.js'></script>
</body>
</html>

