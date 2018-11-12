<?php

    session_start();
    
    if (!isset($_SESSION['admin']))
    {
        header ("location: ../../../index.php");
        exit;
    }
    
    require_once '../../configModules/database.php';
    
    $dataOk = true;
    
    if (isset($_POST['categoryName']))
    {
        $categoryName = $_POST['categoryName'];
        if ( $categoryName == 'Wybierz kategorię' )
        {
            $dataOk = false;
            $_SESSION['updateCategoryNameInfo'] = "Wybierz kategorię z listy";
        }
        $categoryId = $_POST['categoryId'];
        if ( (strlen($categoryId)==0) )
        {
            $dataOk = false;
            $_SESSION['updateCategoryIdInfo'] = "Nr porządkowy nie może być pusty";
        }
        if ($dataOk)
        {
            $categoryIdQuery = $db->query('SELECT * from events_eventCategory WHERE id='.$categoryId);
            $categoryIdData = $categoryIdQuery->fetch();
            if ($categoryIdData)
            {
                $dataOk = false;
                $_SESSION['updateCategoryIdInfo'] = "Podany nr jest już w bazie";
            }
        }
        
        if ($dataOk)
        {
            $categoryUpdate = $db->prepare('UPDATE events_eventCategory set id=:id WHERE category="'.$categoryName.'"');
            $categoryUpdate->bindValue(':id', $categoryId, PDO::PARAM_STR);
            $categoryUpdate->execute();
        }
        else
        {
            $_SESSION['updateCategoryNameValue']=$categoryName;
            $_SESSION['updateCategoryIdValue=']=$categoryId; 
        }
        
    }

   
    header ("location: ../categories.php");