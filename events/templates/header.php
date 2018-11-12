<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Header</title>
</head>
<body>
    <header>
        <div class="main_width">
            <div id="headerBox">
                <section class="menu">
                    <ol id="menu">
                        <?php
                            if ($_SESSION['level']=='0')
                            {
                                echo '<li><a href="#"><div></div></a>';
                            }
                            else
                            {
                                echo '<li><a href="../../index.php"><div></div></a>';
                            }
                        ?>
                        
                            <ul>
                                <?php
                                    if ($_SESSION['level']=='0')
                                    {
                                        echo '<li><a href="modules/mainModules/events.php">Znajdź wydarzenie</a></li>';
                                        echo '<li><a href="modules/mainModules/events.php?dataType=archive">Archiwum wydarzeń</a></li>';
                                        echo '<li><a href="modules/mainModules/rules.php">Regulamin</a></li>';
                                    } 
                                    elseif ($_SESSION['level']=='1.2') 
                                    {
                                        echo '<li><a href="events.php">Znajdź wydarzenie</a></li>';
                                        echo '<li><a href="events.php?dataType=archive">Archiwum wydarzeń</a></li>';
                                        echo '<li><a href="rules.php">Regulamin</a></li>';
                                    }
                                    else
                                    {
                                        echo '<li><a href="../mainModules/events.php">Znajdź wydarzenie</a></li>';
                                        echo '<li><a href="../mainModules/events.php?dataType=archive">Archiwum wydarzeń</a></li>';
                                        echo '<li><a href="../mainModules/rules.php">Regulamin</a></li>';
                                    }
                                ?>
                            </ul>
                        </li>
                        <?php
                            if ($_SESSION['level']=='0')
                            {
                                echo '<li><a href="modules/userModules/welcome.php"><div></div></a>';
                            }
                            elseif ($_SESSION['level']=='1.3')
                            {
                                echo '<li><a href="welcome.php"><div></div></a>';
                            }
                            else
                            {
                                echo '<li><a href="../userModules/welcome.php"><div></div></a>';
                            }
                        ?>
                        
                            <ul>
                                <?php
                                    if ($_SESSION['level']=='0')
                                    {
                                        if (!isset($_SESSION['userLoggedIn']))
                                        {
                                            echo '<li><a href="modules/userModules/login.php">Zaloguj się</a></li>';
                                            echo '<li><a href="modules/userModules/register.php">Zarejestruj się</a></li>';
                                        }
                                        else
                                        {
                                            echo '<li><a href="modules/userModules/addEvent.php">Dodaj wydarzenie</a></li>';
                                            echo '<li><a href="modules/userModules/userEvents.php">Twoje wydarzenia</a></li>';
                                            echo '<li><a href="modules/userModules/changeUserData.php">Zmień swoje dane</a></li>';
                                            echo '<li><a href="modules/userModules/userActions/logout.php">Wyloguj się</a></li>';
                                        }
                                    }
                                    elseif ($_SESSION['level']=='1.3')
                                    {
                                        if (!isset($_SESSION['userLoggedIn']))
                                        {
                                            echo '<li><a href="login.php">Zaloguj się</a></li>';
                                            echo '<li><a href="register.php">Zarejestruj się</a></li>';
                                        }
                                        else
                                        {
                                            echo '<li><a href="addEvent.php">Dodaj wydarzenie</a></li>';
                                            echo '<li><a href="userEvents.php">Twoje wydarzenia</a></li>';
                                            echo '<li><a href="changeUserData.php">Zmień swoje dane</a></li>';
                                            echo '<li><a href="userActions/logout.php">Wyloguj się</a></li>';
                                        }
                                    }
                                    else
                                    {
                                        if (!isset($_SESSION['userLoggedIn']))
                                        {
                                            echo '<li><a href="../userModules/login.php">Zaloguj się</a></li>';
                                            echo '<li><a href="../userModules/register.php">Zarejestruj się</a></li>';
                                        }
                                        else
                                        {
                                            echo '<li><a href="../userModules/addEvent.php">Dodaj wydarzenie</a></li>';
                                            echo '<li><a href="../userModules/userEvents.php">Twoje wydarzenia</a></li>';
                                            echo '<li><a href="../userModules/changeUserData.php">Zmień swoje dane</a></li>';
                                            echo '<li><a href="../userModules/userActions/logout.php">Wyloguj się</a></li>';
                                        }
                                    }
                                    if (isset($_SESSION['admin']))
                                    {
                                        if ($_SESSION['level']==0)
                                        {
                                            echo '<li><a href="modules/adminModules/adminPanel.php"><strong>Panel administratora</strong></a>';
                                        }
                                        elseif ($_SESSION['level']=='1.1')
                                        {
                                            echo '<li><a href="adminPanel.php"><strong>Panel administratora</strong></a>';
                                        }
                                        else
                                        {
                                            echo '<li><a href="../adminModules/adminPanel.php"><strong>Panel administratora</strong></a>';
                                        }
                                            echo '<ol>';
                                                if ($_SESSION['level']=='0')
                                                {
                                                    echo '<li><a href="modules/adminModules/users.php">Użytkownicy</a></li>';
                                                    echo '<li><a href="modules/adminModules/categories.php">Kategorie wydarzeń</a></li>';
                                                    echo '<li><a href="modules/adminModules/blockedEvents.php">Zablokowane wydarzenia</a></li>';
                                                }
                                                elseif ($_SESSION['level']=='1.1')
                                                {
                                                    echo '<li><a href="users.php">Użytkownicy</a></li>';
                                                    echo '<li><a href="categories.php">Kategorie wydarzeń</a></li>';
                                                    echo '<li><a href="blockedEvents.php">Zablokowane wydarzenia</a></li>';
                                                }
                                                else
                                                {
                                                    echo '<li><a href="../adminModules/users.php">Użytkownicy</a></li>';
                                                    echo '<li><a href="../adminModules/categories.php">Kategorie wydarzeń</a></li>';
                                                    echo '<li><a href="../adminModules/blockedEvents.php">Zablokowane wydarzenia</a></li>';
                                                }
                                            echo '</ol>';
                                        echo '</li>';
                                        
                                    }
                                
                                ?>
                            </ul>
                        </li>
                    </ol>
                </section>
                <section id="hamburger">
                    <ol id="menu">
                        <li><div></div>
                            <ul>
                                <?php
                                    if ($_SESSION['level']=='0')
                                    {
                                        echo '<li><a href="modules/mainModules/events.php">Znajdź wydarzenie</a></li>';
                                        echo '<li><a href="modules/mainModules/events.php?dataType=archive">Archiwum wydarzeń</a></li>';
                                        if (!isset($_SESSION['userLoggedIn']))
                                            {
                                                echo '<li><a href="modules/userModules/login.php">Zaloguj się</a></li>';
                                                echo '<li><a href="modules/userModules/register.php">Zarejestruj się</a></li>';
                                            }
                                            else
                                            {
                                                echo '<li><a href="modules/userModules/addEvent.php">Dodaj wydarzenie</a></li>';
                                                echo '<li><a href="modules/userModules/userEvents.php">Twoje wydarzenia</a></li>';
                                                echo '<li><a href="modules/userModules/welcome.php">Panel użytkownika</a></li>';
                                                if (isset($_SESSION['admin']))
                                                {
                                                    echo '<li><strong><a href="modules/adminModules/adminPanel.php">Panel admin.</a></strong></li>';
                                                }
                                                
                                                echo '<li><em><a href="modules/userModules/logout.php">Wyloguj się</a></em></li>';
                                            }
                                        echo '<li><a href="modules/mainModules/rules.php">Regulamin</a></li>';
                                    }
                                    elseif ($_SESSION['level']=='1.1')
                                    {
                                        echo '<li><a href="../../index.php">Strona główna</a></li>';
                                        echo '<li><a href="../mainModules/events.php">Znajdź wydarzenie</a></li>';
                                        echo '<li><a href="../mainModules/events.php?dataType=archive">Archiwum wydarzeń</a></li>';
                                        if (!isset($_SESSION['userLoggedIn']))
                                            {
                                                echo '<li><a href="../userModules/login.php">Zaloguj się</a></li>';
                                                echo '<li><a href="../userModules/register.php">Zarejestruj się</a></li>';
                                            }
                                            else
                                            {
                                                echo '<li><a href="../userModules/addEvent.php">Dodaj wydarzenie</a></li>';
                                                echo '<li><a href="../userModules/userEvents.php">Twoje wydarzenia</a></li>';
                                                echo '<li><a href="../userModules/welcome.php">Panel użytkownika</a></li>';
                                                if (isset($_SESSION['admin']))
                                                {
                                                    echo '<li><strong><a href="adminPanel.php">Panel admin.</a></strong></li>';
                                                }
                                                
                                                echo '<li><em><a href="../userModules/logout.php">Wyloguj się</a></em></li>';
                                            }
                                        echo '<li><a href="../mainModules/rules.php">Regulamin</a></li>';
                                    }
                                    elseif ($_SESSION['level']=='1.2')
                                    {
                                        echo '<li><a href="../../index.php">Strona główna</a></li>';
                                        echo '<li><a href="events.php">Znajdź wydarzenie</a></li>';
                                        echo '<li><a href="events.php?dataType=archive">Archiwum wydarzeń</a></li>';
                                        if (!isset($_SESSION['userLoggedIn']))
                                            {
                                                echo '<li><a href="../userModules/login.php">Zaloguj się</a></li>';
                                                echo '<li><a href="../userModules/register.php">Zarejestruj się</a></li>';
                                            }
                                            else
                                            {
                                                echo '<li><a href="../userModules/addEvent.php">Dodaj wydarzenie</a></li>';
                                                echo '<li><a href="../userModules/userEvents.php">Twoje wydarzenia</a></li>';
                                                echo '<li><a href="../userModules/welcome.php">Panel użytkownika</a></li>';
                                                if (isset($_SESSION['admin']))
                                                {
                                                    echo '<li><strong><a href="../adminModules/adminPanel.php">Panel admin.</a></strong></li>';
                                                }
                                                
                                                echo '<li><em><a href="../userModules/logout.php">Wyloguj się</a></em></li>';
                                            }
                                        echo '<li><a href="rules.php">Regulamin</a></li>';
                                    }
                                    else
                                    {
                                        echo '<li><a href="../../index.php">Strona główna</a></li>';
                                        echo '<li><a href="../mainModules/events.php">Znajdź wydarzenie</a></li>';
                                        echo '<li><a href="../mainModules/events.php?dataType=archive">Archiwum wydarzeń</a></li>';
                                        if (!isset($_SESSION['userLoggedIn']))
                                            {
                                                echo '<li><a href="login.php">Zaloguj się</a></li>';
                                                echo '<li><a href="register.php">Zarejestruj się</a></li>';
                                            }
                                            else
                                            {
                                                echo '<li><a href="addEvent.php">Dodaj wydarzenie</a></li>';
                                                echo '<li><a href="userEvents.php">Twoje wydarzenia</a></li>';
                                                echo '<li><a href="welcome.php">Panel użytkownika</a></li>';
                                                if (isset($_SESSION['admin']))
                                                {
                                                    echo '<li><strong><a href="../adminModules/adminPanel.php">Panel admin.</a></strong></li>';
                                                }
                                                
                                                echo '<li><em><a href="logout.php">Wyloguj się</a></em></li>';
                                            }
                                        echo '<li><a href="../mainModules/rules.php">Regulamin</a></li>';
                                    }
                                ?>
                                
                            </ul>
                        </li>
                    </ol>
                </section>
                <section class="appName">
                    <div class="appName">EVENTownia</div>
                   
                </section>
                
            </div>
        </div>
    </header>
</body>
</html>