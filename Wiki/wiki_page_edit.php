<?php
    session_start();
    require_once("../db.php");

/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/
    $user = $_REQUEST["user"];      // user = user ID
    $wiki = $_GET["wiki"];          // wiki = wiki ID
    $title = $_GET["title"];
    $contents = $_GET["contents"];  // html?
    $page = $_GET["page"];

    $date = getdate();              // get the date in a array 
    $todayDate = $date["year"]."-".$date["mon"]."-".$date["mday"];      // Creates a date variable the database can handle (yyyy-mm-dd)

/*-----------------------------------------------------------
        Connection
-----------------------------------------------------------*/
    $sql = "SELECT date FROM wiki_entry WHERE ID = $page";
    $date = $conn->query($sql);
    
    $sql = "INSERT INTO wiki_entry_history (oID,wID,uID,title,contents,date,editDate) VALUES($page,$wiki,$user,'$title','$contents','$date','$todayDate')";

    $result = $conn->query($sql);       // Sends question to database
    echo $result;
    
?>