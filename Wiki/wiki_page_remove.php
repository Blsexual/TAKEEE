<?php
    require_once("../db.php");

/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/

    $user = $_REQUEST["user"];      // user = user ID
    $page = $_GET["page"];          // wiki_entry ID
    $return = [
        
    ];

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
        // JSON Return
        $data = ["error"=>"we can not find the page you are looking for"];
        $type = "error";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    }

    if($res["admin"][0] == "1" ){   // If you are a admin
        $sql = "DELETE FROM wiki_entry WHERE wiki_entry.ID = $page";
        $conn->query($sql);

        // JSON Return
        $data = ["ok"=>"succsess"];
        $type = "ok";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    } else if ($res["endUser"][0] == "1"){  // If you are a enduser
        $sql = "DELETE FROM wiki_entry WHERE wiki_entry.ID = $page";
        $conn->query($sql);

        // JSON Return
        $data = ["ok"=>"succsess"];
        $type = "ok";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    }else{          // Basicly if something went very wrong

        // JSON Return
        $data = ["error"=>"you are not allowed to remove this entry"];
        $type = "error";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    } 
?>
