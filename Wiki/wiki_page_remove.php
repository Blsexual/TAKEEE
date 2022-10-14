<?php
    session_start();
    require_once("../db.php");

    $user = $_REQUEST["user"]; // user = user ID
    $wiki = $_GET["wiki"]; // wiki = wiki ID
    $title = $_GET["title"];
    $contents = $_GET["contents"]; // html?

    $date = getdate(); // get the date in a array 
    $todayDate = $date["year"]."-".$date["mon"]."-".$date["mday"]; // Creates a date variable the database can handle (yyyy-mm-dd)

    $sql = "INSERT INTO wiki_entry (wID,uID,title,contents,date) VALUES($wiki,$user,'$title','$contents','$todayDate')";

    $result = $conn->query($sql);
    echo $result;
    
?>
