<?php
/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/

$page = $_GET["page"];          // wiki_entry ID

/*-----------------------------------------------------------
        Is the user allowed to remove?
-----------------------------------------------------------*/

    if($res["userType"] != "admin"){
        $stmt = $conn->prepare("SELECT * FROM wiki_entry_history WHERE uID = ? AND ID = ?");
        $stmt->bind_param("ii", $user, $page);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $stmt = $conn->prepare("SELECT * FROM wiki_entry_history,wiki_entry WHERE wiki_entry_history.ID = ? AND wiki_entry.uID = ? AND wiki_entry.ID = wiki_entry_history.oID");
            $stmt->bind_param("ii", $user, $page);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0){
                // JSON Return
                errorWrite($version,"We can either not find the page you are looking for or you are not allowed to remove the page");
            }
        }
    }

/*----------------------------------------------------------------------------
        Deletes all the history
----------------------------------------------------------------------------*/
    $stmt = $conn->prepare("DELETE FROM wiki_entry_history WHERE ID = ?");
    $stmt->bind_param("i", $page);
    $stmt->execute();
    $result = $stmt->get_result();
    // JSON Return
    $data = ["Result"=>"Wiki entry edit deleted"];
    jsonWrite($version,$data);
?>