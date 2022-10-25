<?php
/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/

    $user = $_REQUEST["user"];      // user = user ID
    $page = $_GET["page"];          // wiki_entry ID
    $user = $_GET["uID"];
    $token = $_GET["token"];

/*-----------------------------------------------------------
        Check Token
-----------------------------------------------------------*/
    checkToken($token, $user, "100", $version, $conn);
/*-----------------------------------------------------------
        Is the user allowed to remove?
-----------------------------------------------------------*/

    $stmt = $conn->prepare("SELECT user.admin, user.endUser, wiki_entry.uID FROM user, wiki_entry WHERE user.ID = ? AND wiki_entry.uID = ? AND wiki_entry.ID = ?");
    $stmt->bind_param("iii", $user, $user, $page);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $res = $result->fetch_assoc();        // output data of each row
    } else{
        // JSON Return
        errorWrite($version,"we can not find the page you are looking for");
    }

    if($res["admin"][0] == "1" ){   // If you are a admin
        $stmt = $conn->prepare("DELETE FROM wiki_entry WHERE wiki_entry.ID = $page");
        $stmt->bind_param("i", $page);
        $stmt->execute();
        $result = $stmt->get_result();

        // JSON Return
        $data = ["Result"=>"wiki deleted"];
        jsonWrite($version,$data);
    } else if ($res["endUser"][0] == "1"){  // If you are a enduser
        $stmt = $conn->prepare("DELETE FROM wiki_entry WHERE wiki_entry.ID = $page");
        $stmt->bind_param("i", $page);
        $stmt->execute();
        $result = $stmt->get_result();

        // JSON Return
        $data = ["Result"=>"wiki deleted"];
        jsonWrite($version,$data);
    }else{          // Basicly if something went very wrong

        // JSON Return
        errorWrite($version,"you are not allowed to remove this entry");
    } 
?>
