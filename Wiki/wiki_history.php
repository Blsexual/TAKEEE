<?php
    /*----------------------------------
        Variables
    ----------------------------------*/
    if (isset($_REQUEST['eID'])){
        $eID = $_REQUEST["eID"];
    }
    if (empty($eID)){
        errorWrite($version,"No eID was given");
    }

    $stmt = $conn->prepare("SELECT * FROM wiki_entry_history where (oID) = ?");
    $stmt->bind_param("i", $eID);
    $stmt->execute();
    $result = $stmt->get_result();

    $emparray = [];
    /*----------------------------------
        Fetch data
    ----------------------------------*/
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()){
            $emparray[] = $row;
        }
    } else{
        errorWrite($version,"We could not find the page you were looking for");
    }

    $data = ["Wiki entry"=>$emparray];
    jsonWrite($version,$data);
?>