<?php
    /*----------------------------------
        Variables
    ----------------------------------*/
    if (isset($_REQUEST['wID'])){ // Input check
        $ID = $_REQUEST["wID"];
    }
    if (empty($ID)){ // Input check
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
        while ($row = $result->fetch_assoc()){
            $emparray[] = $row;
        }
    } else{
        errorWrite($version,"We could not find the page you were looking for");
    }

    $stmt = $conn->prepare("SELECT private FROM wiki where wiki.ID = ?");
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

    $stmt = $conn->prepare("SELECT * FROM wiki_entry where (wID) = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();

    /*----------------------------------
        Fetch entries
    ----------------------------------*/
    $entryArray =[];
    while ($row = $result->fetch_assoc()){
        $entryArray[] = $row;
    }
    $data = ["wiki"=>$emparray, "wiki_entry"=>$entryArray];
    jsonWrite($version,$data);
?>