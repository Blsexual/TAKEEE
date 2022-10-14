<?php
    require_once("../db.php");

/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/

    $user = $_REQUEST["user"];      // user = user ID
    $page = $_GET["page"];          // wiki_entry ID

/*-----------------------------------------------------------
        Is the user allowed to remove?
-----------------------------------------------------------*/

    $sql = "SELECT * FROM user WHERE ID = $user";       // gets the user for purposes to check if they are allowed to use the service 
    $result = $conn->query($sql);                       // Sends question to database

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {          // output data of each row
            $user = $row;
        }
    }

    if($user["admin"][0] == "1" ){
        echo "hej admin";
    } else if ($user["endUser"][0] == "1"){
        echo "hej inte admin";
        $sql = "SELECT * FROM wiki_entry WHERE ID = $page";
        $result = $conn->query($sql); // Sends question to database
    
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {      // output data of each row
                $user = $row;
            }
        }
    }else{
        echo "du har inte rätt att tabort den här sidan";
    }


/*-----------------------------------------------------------
        Connection
-----------------------------------------------------------*/


    
?>
