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
    if (isset($_GET['wiki'])){ // wiki = wiki ID
        $wiki = $_GET["wiki"];
    }
    if (empty($wiki)){
        errorWrite($version,"No wiki ID was found");
    }
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

    /*-----------------------------------------------------------
        Connection
    -----------------------------------------------------------*/
    $stmt = $conn->prepare("INSERT INTO wiki (uID,wikiIndex,title) VALUES($user,'$wiki','$title')");
    $stmt->execute();
    $resultHistory = $stmt->get_result(); 

    jsonWrite($version,"Wiki was created");
?>