<?php
/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/

$page = $_GET["page"];          // wiki_entry ID

/*-----------------------------------------------------------
        Is the user allowed to remove?
-----------------------------------------------------------*/

    if($res["userType"] != "admin"){
        $stmt = $conn->prepare("SELECT wiki_entry_history WHERE uID = ? AND oID = ?");
        $stmt->bind_param("ii", $user, $page);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $res = $result->fetch_assoc();        // output data of each row
        } else{
            // JSON Return
            errorWrite($version,"we can not find the page you are looking for");
        }
    }

/*----------------------------------------------------------------------------
        Deletes all the history
----------------------------------------------------------------------------*/
    $stmt = $conn->prepare("DELETE FROM wiki_entry_history WHERE wiki_entry.ID = ?");
    $stmt->bind_param("i", $page);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result){
    // JSON Return
        $data = ["Result"=>"Wiki entry deleted"];
        jsonWrite($version,$data);
    } else{          // Basicly if something went very wrong
        errorWrite($version,"you are not allowed to remove this entry");
    } 
?>