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
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {          // output data of each row
            $date = $row;
        }
    } else{

        // JSON Return
        $data = ["error"=>"we cant find the page you are looking for"];
        $type = "error";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    }

    $sql = "INSERT INTO wiki_entry_history (oID,wID,uID,title,contents,date,editDate) VALUES($page,$wiki,$user,'$title','$contents','$date','$todayDate')";

    $result = $conn->query($sql);       // Sends question to database
    
    
?>