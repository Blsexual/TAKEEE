<?php
/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/

    $page = $_GET["page"];          // wiki_entry ID

/*-----------------------------------------------------------
        Is the user allowed to remove?
-----------------------------------------------------------*/

    if($res["userType"] != "admin"){
        $stmt = $conn->prepare("SELECT wiki_entry.uID FROM user, wiki_entry WHERE user.ID = ? AND wiki_entry.uID = ? AND wiki_entry.ID = ?");
        $stmt->bind_param("iii", $user, $user, $page);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $res = $result->fetch_assoc();        // output data of each row
        } else{
            // JSON Return
            errorWrite($version,"We can not find the page you are looking for");
        }
    }



/*----------------------------------------------------------------------------
        Delete the entry in wiki entry
----------------------------------------------------------------------------*/
    $stmt = $conn->prepare("DELETE FROM wiki_entry WHERE wiki_entry.ID = ?");
    $stmt->bind_param("i", $page);
    $stmt->execute();
    $result = $stmt->get_result();

/*----------------------------------------------------------------------------
        Deletes all the history
----------------------------------------------------------------------------*/
    $stmt = $conn->prepare("DELETE FROM wiki_entry_history WHERE oID = ?");
    $stmt->bind_param("i", $page);
    $stmt->execute();
    $stmt->get_result();

    $data = ["Result"=>"Wiki entry deleted"];
    jsonWrite($version,$data);

?>
