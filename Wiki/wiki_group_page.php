<?php
    /*----------------------------------
        Variables
    ----------------------------------*/
    if (isset($_REQUEST['ID'])){
        $ID = $_REQUEST["ID"];
    }
    if (empty($ID)){
        errorWrite($version,"No ID was given");
    }

    $stmt = $conn->prepare("SELECT * FROM wiki where (ID) = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();

    $emparray = [];
    /*----------------------------------
        Fetch data
    ----------------------------------*/
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $emparray[] = $row;
        }
    } else{
        errorWrite($version,"We could not find the page you were looking for");
    }

    $stmt = $conn->prepare("SELECT * FROM wiki_entry where (wID) = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();

    /*----------------------------------
        Fetch entries
    ----------------------------------*/
    $entryArray =[];
    while ($row = mysqli_fetch_assoc($result)){
        $entryArray[] = $row;
    }
    $data = ["wiki"=>$emparray, "wiki_entry"=>$entryArray];
    jsonWrite($version,$data);
?>