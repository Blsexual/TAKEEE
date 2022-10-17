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

    $sql = "SELECT user.admin, user.endUser, wiki_entry.uID FROM user, wiki_entry WHERE user.ID = $user AND wiki_entry.uID = $user AND wiki_entry.ID = $page";       // gets the user for purposes to check if they are allowed to use the service 
    $result = $conn->query($sql);                       // Sends question to database

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {          // output data of each row
            $res = $row;
        }
    } else{
        die("We can not find the page in question");
    }

    if($res["admin"][0] == "1" ){
        echo "hej admin";
        $sql = "DELETE FROM wiki_entry WHERE wiki_entry.ID = $page";
        $conn->query($sql);
    } else if ($res["endUser"][0] == "1"){
        echo "hej inte admin";
        $sql = "DELETE FROM wiki_entry WHERE wiki_entry.ID = $page";
        $conn->query($sql);
    }else{
        echo "Du har inte rätt att tabort den här sidan";
    }

//DELETE FROM wiki_entry WHERE ID = $page
/*-----------------------------------------------------------
        Connection
-----------------------------------------------------------*/


    
?>
