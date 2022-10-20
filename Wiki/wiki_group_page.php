<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    /*----------------------------------
        Variables
    ----------------------------------*/
    $ID = $_REQUEST["ID"];
    if (empty($_GET)){
        $data = ["error"=>"wrong username or password was given"];
        $type = "error";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    }

    $sql = "SELECT * FROM wiki where (ID) = $ID";
    $result = mysqli_query($conn, $sql);

    $emparray = [];
    /*----------------------------------
        Fetch data
    ----------------------------------*/
    while ($row = mysqli_fetch_assoc($result)){
        $emparray[] = $row;
    }

    $sql = "SELECT * FROM wiki_entry where (wID) = $ID";
    $result = mysqli_query($conn, $sql);
    /*----------------------------------
        Fetch entries
    ----------------------------------*/
    $entryArray =[];
    while ($row = mysqli_fetch_assoc($result)){
        $entryArray[] = $row;
    }
    $data = ["wiki"=>$emparray, "wiki_entry"=>$entryArray];
    $return = ["Version" => $version, "type"=>"ok", "data"=>$data];

    echo json_encode($return); // Send data as json
?>
