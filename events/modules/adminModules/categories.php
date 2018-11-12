<?php
    session_start();
    
    $_SESSION['level']='1.1';

    if (!isset($_SESSION['admin']))
    {
        header ('Location: ../../index.php');
        exit;
    }
    
    require_once '../configModules/database.php';
    
    $categoriesQuery = $db->query('SELECT c.category as category, c.id as orderId, count(e.id) as liczbaWydarzen from events_eventCategory as c LEFT JOIN events_events as e ON c.category = e.category GROUP BY c.category ORDER BY orderId');
    $categories = $categoriesQuery->fetchAll();
    

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
            <h3>Lista kategorii dla wydarzeń w serwisie</h3>
            <table class="table-responsive table" id="categoriesTable">
                <thead>
                    <tr>
                        <th><span class="sort">Nazwa kategorii</span>   <button class='sortUp sort sortBy0 btn-large'></button></th>
                        <th class="number"><span class="sort">Numer porządkowy</span>   <button class='sortUp sort sortBy1 btn-large'></button></th>
                        <th class="number"><span class="sort">Liczba wydarzeń</span>   <button class='sortUp sort sortBy2 btn-large'></button></th>
                        <th class="center">Usuwanie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($categories as $category)
                    {
                        echo "<tr>";
                        echo "<td>".$category['category']."</td>";
                        echo "<td class=".'"number"'.">".$category['orderId']."</td>";
                        echo "<td class=".'"number"'.">".$category['liczbaWydarzen']."</td>";
                        if ($category['liczbaWydarzen']==0)
                        {
                            echo "<td class=".'"center"'."><a href=".'"adminActions/deleteCategory.php?id='.$category['orderId'].'"'." class=".'"delete"'.">Usuń kategorię</a></td>";
                        }
                        else
                        {
                            echo "<td></td>";
                        }
                        echo "</tr>";
                    }
                    
                    ?>
                    
                </tbody>
            </table>
            <br>
            <div class="row categories">
                <div class="col-sm-6">
                    <form method="POST" action="adminActions/addCategory.php" class="form-horizontal">
                        <h4>Dodaj nową kategorię</h4>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="categoryName">Nazwa</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="Wpisz nową kategorię" id="categoryName"  name="categoryName" value=<?php
                                if (isset($_SESSION['newCategoryNameValue']))
                                {
                                    echo '"'.$_SESSION['newCategoryNameValue'].'"';
                                    unset($_SESSION['newCategoryNameValue']);
                                }
                            ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="categoryId">Numer porządkowy</label>
                            <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="Numer porządkowy" id="categoryId"  name="categoryId" value=<?php
                                if (isset($_SESSION['newCategoryIdValue']))
                                {
                                    echo $_SESSION['newCategoryIdValue'];
                                    unset($_SESSION['newCategoryIdValue']);
                                }
                            ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-2">
                            <input type="submit" class="btn btn-primary" value="Dodaj">
                            </div>
                        </div>
                    </form>
                    <?php
                        if (isset($_SESSION['newCategoryNameInfo']))
                        {
                            echo '<p><span class="info">'.$_SESSION['newCategoryNameInfo'].'</span></p>';
                            unset($_SESSION['newCategoryNameInfo']);
                        }
                        if (isset($_SESSION['newCategoryIdInfo']))
                        {
                            echo '<p><span class="info">'.$_SESSION['newCategoryIdInfo'].'</span></p>';
                            unset($_SESSION['newCategoryIdInfo']);
                        }
                    ?>
                </div>    
                <div class="col-sm-6">
                    <form method="POST" action="adminActions/updateCategory.php" class="form-horizontal">
                        <h4>Zmień numer porządkowy wybranej kategorii</h4>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="categoryName">Nazwa</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="category" name="categoryName">
                                <?php
                                    if (isset($_SESSION['updateCategoryNameValue']))
                                    {
                                        echo '<option value="'.$_SESSION['updateCategoryNameValue'].'">"'.$_SESSION['updateCategoryNameValue'].'"</option>';
                                        unset($_SESSION['updateCategoryNameValue']);
                                    }
                                    else
                                    {
                                        echo '<option value="Wybierz kategorię">Wybierz z listy</option>';
                                    }
                                    foreach ($categories as $category)
                                    {
                                        echo "<option value=".'"'.$category['category'].'">'.$category['category']."</option>";
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="categoryId">Nowy numer</label>
                            <div class="col-sm-4">
                            <input type="number" class="form-control" placeholder="Numer porządkowy" id="categoryId"  name="categoryId" value=<?php
                                if (isset($_SESSION['updateCategoryIdValue']))
                                {
                                    echo $_SESSION['updateCategoryIdValue'];
                                    unset($_SESSION['updateCategoryIdValue']);
                                }
                            ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-4">
                            <input type="submit" class="btn btn-primary" value="Zmień">
                            </div>
                        </div>
                    </form>
                    <?php
                        if (isset($_SESSION['updateCategoryNameInfo']))
                        {
                            echo '<p><span class="info">'.$_SESSION['updateCategoryNameInfo'].'</span></p>';
                            unset($_SESSION['updateCategoryNameInfo']);
                        }
                        if (isset($_SESSION['updateCategoryIdInfo']))
                        {
                            echo '<p><span class="info">'.$_SESSION['updateCategoryIdInfo'].'</span></p>';
                            unset($_SESSION['updateCategoryIdInfo']);
                        }
                    ?>
                </div> 
            </div>
            <br/>
            <div class="bottomMenu">
                <a class="inRow" href="../userModules/welcome.php">Panel użytkownika</a>
                <a class="inRow" href="adminPanel.php">Panel administratora</a>
                <a href="../../index.php">Strona główna</a>
            </div>
            <br/>
        </section>
    </div>

    
    <?php include "../../templates/footer.php"; ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src='../../js/script.js'></script>
</body>
</html>