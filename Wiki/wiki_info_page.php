<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    
    /*----------------------------------
        Variables
    ----------------------------------*/
    if (isset($_REQUEST['ID'])){
        $ID = $_REQUEST["ID"];
    }
    if (empty($ID)){
        errorWrite($version,"No ID was given");
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
        while ($row = mysqli_fetch_assoc($resultInfoPage)){
            $emparray[] = $row;
        }
    } else{
        errorWrite($version,"We could not find the page you were looking for");
    }

    $stmt = $conn->prepare("SELECT * FROM wiki_entry_history where (oID) = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $resultHistory = $stmt->get_result();

    $test = [];
    $nullData = false;
    $highestID = 0;
    if ($resultHistory->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($resultHistory)){
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
