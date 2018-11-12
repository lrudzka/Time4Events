<?php
    session_start();
    
    $_SESSION['level'] = '0';
    
    //pobieramy informacje z bazy
    require_once 'modules/configModules/database.php';
    
    $nowNotFormated = new DateTime();
    $now = $nowNotFormated->format('Y-m-d');

    // NAJBLIŻSZE WYDARZENIA
    $nextEventsQuery = $db->query('SELECT * FROM events_events WHERE blocked is NULL AND startDate>="'.$now.'" ORDER BY startDate limit 10');
    $nextEvents = $nextEventsQuery->fetchAll();
    
    // OSTATNIO DODANE WYDARZENIA
    $lastEventsQuery = $db->query('SELECT * FROM events_events WHERE blocked is NULL ORDER BY createdOn desc limit 10');
    $lastEvents = $lastEventsQuery->fetchAll();
    
    //pobieramy województwa z bazy danych
    $provincesQuery = $db->query('SELECT * FROM events_province');
    //odbieramy dane -> w tym wypadku do tablicy dwuwymiarowej
    $provinces = $provincesQuery->fetchAll();
    //tabelę użyjemy poniżej, w tagu select w formularzu wyszukiwania

    //i to samo robimy z kategoriamy zdarzeń
    $categoriesQuery = $db->query('SELECT * FROM events_eventCategory ORDER BY id');
    $categories = $categoriesQuery->fetchAll();
    
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>EVENTownia</title>

    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">    
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Eagle+Lake" rel="stylesheet">
</head>

<body>
<?php include "templates/header.php"; ?>
	
    <div class="background">
        <section class="main_width">
            <h3 class="onlyBigScreen"><em>Najbliższe wydarzenia:</em></h3>
            <div class="nextEventsBox">
                <div class="goLeftNext"></div>
                <div class="nextEventsItems">
                    <?php
                        $counter = 0;
                        foreach ($nextEvents as $nextEvent)
                        {
                            $style = "'"."background-image: url(".'"'.$nextEvent['picture'].'"'.');'."'";
                            
                            if ( $counter<4 )
                                
                            { 
                                echo "<div title=".'"'.$nextEvent['name'].', '.$nextEvent['startDate'].'"'."class=".'"nextEvent"'.">"
                                        . "<a href=".'"modules/mainModules/singleEvent.php?id='.$nextEvent['id'].'"'.">"
                                            . "<div style=".$style." class=".'"nextEventImg"'.">"
                                            ."</div>"
                                        . "</a>"
                                    . "</div>";
                            } 
                            else
                            {
                                echo "<div title=".'"'.$nextEvent['name'].', '.$nextEvent['startDate'].'"'."class=".'"nextEvent invisible"'.">"
                                        . "<a href=".'"modules/mainModules/singleEvent.php?id='.$nextEvent['id'].'"'.">"
                                            . "<div style=".$style." class=".'"nextEventImg"'.">"
                                            ."</div>"
                                        . "</a>"
                                    . "</div>";
                            } 
                            
                            $counter++;
                        }
                    ?>
                </div>
                <div class="goRightNext"></div>
            </div>
            <br/>
            
            <h3 class="onlyBigScreen"><em>Ostatnio dodane:</em></h3>
            <div class="lastEventsBox">
                <div class="goLeftLast"></div>
                <div class="lastEventsItems">
                    <?php
                        $counter = 0;
                        foreach ($lastEvents as $lastEvent)
                        {
                            $style = "'"."background-image: url(".'"'.$lastEvent['picture'].'"'.');'."'";
                            
                            if ( $counter<4 )
                                
                            { 
                                echo "<div title=".'"'.$lastEvent['name'].', '.$lastEvent['startDate'].'"'."class=".'"lastEvent"'.">"
                                        . "<a href=".'"modules/mainModules/singleEvent.php?id='.$lastEvent['id'].'"'.">"
                                            . "<div style=".$style." class=".'"lastEventImg"'.">"
                                            ."</div>"
                                        . "</a>"
                                    . "</div>";
                            } 
                            else
                            {
                                echo "<div title=".'"'.$lastEvent['name'].', '.$lastEvent['startDate'].'"'."class=".'"lastEvent invisible"'.">"
                                        . "<a href=".'"modules/mainModules/singleEvent.php?id='.$lastEvent['id'].'"'.">"
                                            . "<div style=".$style." class=".'"lastEventImg"'.">"
                                            ."</div>"
                                        . "</a>"
                                    . "</div>";
                            } 
                            
                            $counter++;
                        }
                    ?>
                </div>
                <div class="goRightLast"></div>
            </div>
            
            <br/>
            <br/>
            
            <div class="row">
                <div class="mainPageSearch col-sm-12">
                    <span class="col-sm-offset-4 col-sm-4">ZNAJDŹ WYDARZENIE</span>
                    <form method="post" action = "modules/mainModules/events.php" class="form-horizontal" >   
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="province">Województwo:</label>
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
                            
                            <div class="form-group col-md-6">
                                <label for="category">Kategoria:</label>
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
                        <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="city">Miejscowość</label>
                              <input type="text" class="form-control" id="city" name="city" placeholder="Miejscowość">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="keyWord">Słowo klucz</label>
                              <input type="text" class="form-control" id="keyWord" name="keyWord" placeholder="Słowo klucz">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="from">Termin od: </label>
                                <input type="text" placeholder="YYYY-MM-DD" class="form-control date-picker" id="from" name="from">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="to">Termin do: </label>
                                <input type="text" placeholder="YYYY-MM-DD" class="form-control date-picker" id="to" name="to">
                            </div>
                          </div>
                        <input  type="submit" class="btn btn-success col-sm-2 col-sm-offset-5" value="Szukaj">  </input>
                       
                    </form>
                </div>
           
            
            <br/>
            <div class="bottomMenu">
                <span><a class="inRow" href="modules/userModules/welcome.php">Panel użytkownika</a></span><?php
                if (isset($_SESSION['admin']))
                {
                    echo '<span><a href="modules/adminModules/adminPanel.php">Panel administratora</a></span>';
                }
            
            ?>
            </div>
        </section>
    </div>
                
    <?php include "templates/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src='js/script.js'></script>
</body>
</html>