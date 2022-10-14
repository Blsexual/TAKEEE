<?php
    session_start();
    require_once("../db.php");

    $user = $_REQUEST["user"];  // user = user ID
    $page = $_GET["page"];      // wiki_entry ID

    $sql = "INSERT INTO wiki_entry (wID,uID,title,contents,date) VALUES($wiki,$user,'$title','$contents','$todayDate')";

    $result = $conn->query($sql);
    echo $result;
    
?>
