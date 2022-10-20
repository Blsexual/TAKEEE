<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    
/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/
    $user = $_REQUEST["user"];      // user = user ID
    $wiki = $_GET["wiki"];          // wiki = wiki ID
    $title = $_GET["title"];
    $contents = $_GET["contents"];  // html?

    $date = getdate();              // get the date in a array 
    $todayDate = $date["year"]."-".$date["mon"]."-".$date["mday"];      // Creates a date variable the database can handle (yyyy-mm-dd)

/*-----------------------------------------------------------
        Connection
-----------------------------------------------------------*/
    $sql = "INSERT INTO wiki_entry (wID,uID,title,contents,date) VALUES($wiki,$user,'$title','$contents','$todayDate')";

    $result = $conn->query($sql);       // Sends question to database
    
?>
