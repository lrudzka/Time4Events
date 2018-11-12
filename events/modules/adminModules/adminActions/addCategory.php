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
        if ( (strlen($categoryName)<5) )
        {
            $dataOk = false;
            $_SESSION['newCategoryNameInfo'] = "Nazwa jest za krótka (wymagane min. 5 znaków)";
        }
        $categoryId = $_POST['categoryId'];
        if ( (strlen($categoryId)==0) )
        {
            $dataOk = false;
            $_SESSION['newCategoryIdInfo'] = "Nr porządkowy nie może być pusty";
        }
        if ($dataOk)
        {
            $categoryNameQuery = $db->query('SELECT * from events_eventCategory WHERE category="'.$categoryName.'"');
            $categoryNameData = $categoryNameQuery->fetch();
            if ($categoryNameData)
            {
                $dataOk = false;
                $_SESSION['newCategoryNameInfo'] = "Podana nazwa jest już w bazie";
            }
            $categoryIdQuery = $db->query('SELECT * from events_eventCategory WHERE id='.$categoryId);
            $categoryIdData = $categoryIdQuery->fetch();
            if ($categoryIdData)
            {
                $dataOk = false;
                $_SESSION['newCategoryIdInfo'] = "Podany nr jest już w bazie";
            }
        }
        
        if ($dataOk)
        {
            $categoryInsert = $db->prepare('INSERT into events_eventCategory (id, category) VALUES (:id, :name)');
            $categoryInsert->bindValue(':id', $categoryId, PDO::PARAM_STR);
            $categoryInsert->bindValue(':name', $categoryName, PDO::PARAM_STR);
            $categoryInsert->execute();
        }
        else
        {
            $_SESSION['newCategoryNameValue']=$categoryName;
            $_SESSION['newCategoryIdValue=']=$categoryId; 
        }
        
    }

   
    header ("location: ../categories.php");