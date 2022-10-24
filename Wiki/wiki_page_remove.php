<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");
?>

<?php
/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/

    $user = $_REQUEST["user"];      // user = user ID
    $page = $_GET["page"];          // wiki_entry ID
    $user = $_GET["uID"];
    $token = $_GET["token"];

/*-----------------------------------------------------------
        Is the user allowed to remove?
-----------------------------------------------------------*/
    checkToken($token, $user, "100", $version, $conn);

    $sql = "SELECT user.admin, user.endUser, wiki_entry.uID FROM user, wiki_entry WHERE user.ID = $user AND wiki_entry.uID = $user AND wiki_entry.ID = $page";       // gets the user for purposes to check if they are allowed to use the service 
    $result = $conn->query($sql);                       // Sends question to database

    if ($result->num_rows > 0) {
        $res = $result->fetch_assoc();        // output data of each row
    } else{
        // JSON Return
        errorWrite($version,"we can not find the page you are looking for");
    }

    if($res["admin"][0] == "1" ){   // If you are a admin
        $sql = "DELETE FROM wiki_entry WHERE wiki_entry.ID = $page";
        $conn->query($sql);

        // JSON Return
        $data = ["Result"=>"wiki deleted"];
        jsonWrite($version,$data);
    } else if ($res["endUser"][0] == "1"){  // If you are a enduser
        $sql = "DELETE FROM wiki_entry WHERE wiki_entry.ID = $page";
        $conn->query($sql);

        // JSON Return
        $data = ["Result"=>"wiki deleted"];
        jsonWrite($version,$data);
    }else{          // Basicly if something went very wrong

        // JSON Return
        errorWrite($version,"you are not allowed to remove this entry");
    } 
?>
