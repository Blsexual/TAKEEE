<?php
    /*----------------------------------
        Variables
    ----------------------------------*/
    if (isset($_REQUEST['eID'])){
        $ID = $_REQUEST["eID"];
    }
    if (empty($ID)){
        errorWrite($version,"No eID was given");
    }

    $stmt = $conn->prepare("SELECT * FROM wiki_entry where (ID) = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $resultInfoPage = $stmt->get_result();

    $emparray = [];
    /*----------------------------------
        Fetch data
    ----------------------------------*/
    if ($resultInfoPage->num_rows > 0) {
        while ($row = $resultInfoPage->fetch_assoc()){
            $emparray[] = $row;
        }
    } else{
        errorWrite($version,"We could not find the page you were looking for");
    }

    $stmt = $conn->prepare("SELECT private FROM wiki,wiki_entry where wiki.ID = wiki_entry.wID AND wiki_entry.ID = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $resultInfoPage = $stmt->get_result();

    if ($resultInfoPage->num_rows > 0) {
        $res = $resultInfoPage->fetch_assoc();
        if ($res["private"] == 1){
            if(empty($_GET["uID"])){
                errorWrite($version, "You need to be logged in to use this. No uID given");
            }
            if(empty($_GET["token"])){
                errorWrite($version, "You need to be logged in to use this. No uID given");
            }
            $uID = $_GET["uID"];
            $token = $_GET["token"];
            checkToken($token,$uID,"100",$version,$conn);
        }
    }

    $stmt = $conn->prepare("SELECT * FROM wiki_entry_history where (oID) = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $resultHistory = $stmt->get_result();

    $test = [];
    $nullData = false;
    $highestID = 0;
    if ($resultHistory->num_rows > 0) {
        while ($row = $resultHistory->fetch_assoc()){
            if ((int)$row['ID'] > (int)$highestID){
                $highestID = $row['ID'];
                $test = $row;
            }
        }
    } else{
        $nullData = true; // If no history exists, this will prepare for wiki_entry to output
    }

    if ($nullData == true){
        $data = ["Wiki entry"=>$emparray]; // Wiki entry gets output (wiki_entry)
        jsonWrite($version,$data);
    } else{
        $data = ["Wiki entry"=>$test]; // Edited wiki gets output (wiki_entry_history)
        jsonWrite($version,$data);
    }
    
    
?>
