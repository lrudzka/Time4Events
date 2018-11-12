<?php
    session_start();
    
    $_SESSION['level']='1.1';

    if (!isset($_SESSION['admin']))
    {
        header ('Location: ../../index.php');
    }
    
    require_once '../configModules/database.php';
    
    $usersQuery = $db->query('SELECT u.login as user, count(e.id) as liczbaWydarzen, count(e.blocked) as liczbaBlokad, u.registeredOn as dataRejestracji, u.admin as admin, u.bann as bann from events_users as u LEFT JOIN events_events as e ON u.login = e.createdBy group by u.login ORDER BY admin desc, liczbaWydarzen desc, liczbaBlokad');
    $users = $usersQuery->fetchAll();
    
    if (isset($_POST['userType']))
    {
        if ($_POST['userType']=='all')
        {
           $usersQuery = $db->query('SELECT u.login as user, count(e.id) as liczbaWydarzen, count(e.blocked) as liczbaBlokad, u.registeredOn as dataRejestracji, u.admin as admin, u.bann as bann from events_users as u LEFT JOIN events_events as e ON u.login = e.createdBy group by u.login ORDER BY admin desc, liczbaWydarzen desc, liczbaBlokad');
        $users = $usersQuery->fetchAll(); 
        }
        elseif ($_POST['userType']=='admin')
        {
           $usersQuery = $db->query('SELECT u.login as user, count(e.id) as liczbaWydarzen, count(e.blocked) as liczbaBlokad, u.registeredOn as dataRejestracji, u.admin as admin, u.bann as bann from events_users as u LEFT JOIN events_events as e ON u.login = e.createdBy WHERE u.admin=1 group by u.login ORDER BY admin desc, liczbaWydarzen desc, liczbaBlokad');
           $users = $usersQuery->fetchAll(); 
        }
        elseif ($_POST['userType']=='blockedEvents')
        {
            $usersQuery = $db->query('SELECT u.login as user, count(e.id) as liczbaWydarzen, count(e.blocked) as liczbaBlokad, u.registeredOn as dataRejestracji, u.admin as admin, u.bann as bann from events_users as u LEFT JOIN events_events as e ON u.login = e.createdBy group by u.login HAVING liczbaBlokad>0 ORDER BY admin desc, liczbaWydarzen desc, liczbaBlokad');
            $users = $usersQuery->fetchAll(); 
        }
        else
        {
            $usersQuery = $db->query('SELECT u.login as user, count(e.id) as liczbaWydarzen, count(e.blocked) as liczbaBlokad, u.registeredOn as dataRejestracji, u.admin as admin, u.bann as bann from events_users as u LEFT JOIN events_events as e ON u.login = e.createdBy WHERE u.bann=1 group by u.login ORDER BY admin desc, liczbaWydarzen desc, liczbaBlokad');
            $users = $usersQuery->fetchAll();    
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
    <link href="https://fonts.googleapis.com/css?family=Kalam" rel="stylesheet">
</head>

<body>
<?php include "../../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <h2>Lista użytkowników serwisu:</h2>
            <input type="text" class="form-control searchUser" placeholder="Wyszukaj użytkownika">
            <div class="usersSearch col-sm-6">
                    <form method="post" class="form-horizontal" >   
                        
                            <div class="form-group col-md-6">
                                <input type="radio" name="userType" value="all" <?php
                                    if (!isset($_POST['userType']))
                                    {
                                        echo "checked";
                                    }
                                    elseif ($_POST['userType']=='all')
                                    {
                                        echo "checked";
                                    }
                                ?>
                                > wszyscy<br>
                                <input type="radio" name="userType" value="admin" <?php
                                    if (isset($_POST['userType']))
                                    {
                                        if ($_POST['userType']=='admin')
                                        {
                                            echo "checked";
                                        }
                                    }
                                ?>> Z uprawnieniami administratora<br>
                                <input type="radio" name="userType" value="blockedEvents" <?php
                                    if (isset($_POST['userType']))
                                    {
                                        if ($_POST['userType']=='blockedEvents')
                                        {
                                            echo "checked";
                                        }
                                    }
                                ?>> Z zablokowanymi wydarzeniami<br>
                                <input type="radio" name="userType" value="blockedUsers" <?php
                                    if (isset($_POST['userType']))
                                    {
                                        if ($_POST['userType']=='blockedUsers')
                                        {
                                            echo "checked";
                                        }
                                    }
                                ?>> użytkownicy zablokowani 
                            </div> 
                            <input  type="submit" class="btn btn-primary col-sm-2" value="Filtruj">  </input>
                    </form>
                </div>
            <table class="table table-responsive" id='usersTable'>
                <thead>
                    <tr>
                        <th><span class="sort">Login</span>   <button class='sortUp sort sortBy0 btn-large'></button></th>
                        <th class="center" <span class="sort">Data rejestracji</span>   <button class='sortUp sort sortBy1 btn-large'></button></th>
                        <th class="number" <span class="sort">Liczba wydarzeń</span>   <button class='sortUp sort sortBy2 btn-large'></button></th>
                        <th class="number" <span class="sort">Liczba blokad</span>   <button class='sortUp sort sortBy3 btn-large'></button></th>
                        <th class="center">Uprawnienia admin.</th>
                        <th class="center">Blokuj / Usuń użytk.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!$users)
                        {
                            echo "<tr class=".'"user"'.">";
                            echo "<td colspan=".'"6 "'.">Brak pozycji</td>";
                            echo "</tr>";
                        }
                        foreach ($users as $user)
                        {
                            $dataRej = substr($user['dataRejestracji'],0,10);
                            if ($user['admin']==1)
                            {
                                echo "<tr class=".'"admin"'.">";
                            }
                            elseif ($user['bann']==1)
                            {
                                echo "<tr class=".'"banned"'.">";
                            }
                            elseif ($user['liczbaBlokad']>0)
                            {
                                echo "<tr class=".'"dangerUser"'.">";
                            }
                            else
                            {
                                echo "<tr class=".'"user"'.">";
                            }
                                echo "<td>{$user['user']}</td>";
                                echo "<td class=".'"center"'.">".$dataRej."</td>";
                                echo "<td class=".'"number"'.">{$user['liczbaWydarzen']}</td>";
                                if ($user['liczbaBlokad']==0)
                                {
                                    echo "<td></td>";
                                }
                                else
                                {
                                   echo "<td class=".'"number"'.">{$user['liczbaBlokad']}</td>"; 
                                }
                                if ($user['admin']==1)
                                {
                                    echo "<td class=".'"center"'."><a href=".'"adminActions/delAdmin.php?user='.$user['user'].'"'." class=".'"blok"'.">Usuń uprawnienie</a></td>";
                                }
                                else
                                {
                                    if ($user['liczbaBlokad']==0 AND $user['bann']<>1)
                                    {
                                        echo "<td class=".'"center"'."><a href=".'"adminActions/addAdmin.php?user='.$user['user'].'"'." class=".'"add"'.">Dodaj uprawnienie</a></td>";
                                    }
                                    else
                                    {
                                        echo "<td></td>";
                                    }
                                    
                                }
                                if ($user['bann']==1)
                                {
                                    echo "<td class=".'"center"'."><a href=".'"adminActions/unblockUser.php?user='.$user['user'].'"'." class=".'"add"'.">Odblokuj użytk.</a></td>";
                                }
                                else
                                {
                                    if ($user['liczbaBlokad']>0)
                                    {
                                        echo "<td class=".'"center"'."><a href=".'"adminActions/blockUser.php?user='.$user['user'].'"'." class=".'"blok"'.">Zablokuj użytk.</a></td>";
                                    }
                                    elseif ($user['liczbaWydarzen']==0)
                                    {
                                       echo "<td class=".'"center"'."><a href=".'"adminActions/deleteUser.php?user='.$user['user'].'"'." class=".'"delete deleteUser"'.">Usuń użytkownika</a></td>"; 
                                    }
                                    else
                                    {
                                        echo "<td></td>";
                                    }
                                }
                                
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
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