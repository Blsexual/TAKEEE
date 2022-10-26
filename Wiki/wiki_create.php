<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");

    /*-----------------------------------------------------------
            Variabels
    -----------------------------------------------------------*/
    
    if (isset($_REQUEST['user'])){ // user = user ID
        $user = $_REQUEST["user"];
    }
    if (empty($user)){
        errorWrite($version,"No user ID was found");
    }
    /*if (isset($_GET['wiki'])){ // wiki = wiki ID
        $wiki = $_GET["wiki"];
    }
    if (empty($wiki)){
        errorWrite($version,"No wiki ID was found");
    }*/
    if (isset($_GET['title'])){ // title
        $title = $_GET["title"];
    }
    if (empty($title)){
        errorWrite($version,"No title was found");
    }
    if (isset($_GET['token'])){ // token
        $token = $_GET["token"];
    }
    if (empty($token)){
        errorWrite($version,"No token was found");
    }
    
    $adminCheck = checkToken($token, $user, "100", $version, $conn);

    if ($adminCheck["UserType"] != "admin"){ // Check if admin is true for user
        errorWrite($version,"You are not allowed to create this wiki");
    }

    $date = getdate();              // get the date in a array 
    $todayDate = $date["year"]."-".$date["mon"]."-".$date["mday"];      // Creates a date variable the database can handle (yyyy-mm-dd)

    $stmt = $conn->prepare("INSERT INTO wiki_entry (wID,uID,title,date) VALUES($wiki,$user,'$title','$todayDate')");
    $stmt->execute();
    $resultHistory = $stmt->get_result(); 


    $stmt = $conn->prepare("SELECT ID FROM wiki_entry");
    $stmt->execute();
    $resultID = $stmt->get_result();

    $highestID = 0;
    if ($resultID->num_rows > 0) {
        while ($row = $resultID->fetch_assoc()){
            if ((int)$row['ID'] > (int)$highestID){
                $highestID = $row;
                //$test = $row;
            }
        }
    }

    /*-----------------------------------------------------------
        Connection
    -----------------------------------------------------------*/
    $stmt = $conn->prepare("INSERT INTO wiki (uID,wikiIndex,title) VALUES($user,'$wiki','$title')");
    $stmt->execute();
    $resultHistory = $stmt->get_result(); 

    jsonWrite($version,"Wiki was created");
?>