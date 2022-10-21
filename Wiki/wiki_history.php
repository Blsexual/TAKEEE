<?php
    require_once("../db.php");
    /*----------------------------------
        Variables
    ----------------------------------*/
    $ver = "0.1"; // WILL DELETE THIS
    $ID = $_REQUEST["ID"];
    if (!isset($_REQUEST['ID'])){
        die("Error: Inget ID data har identifierats");
    }
    $sql = "SELECT * FROM wiki_entry_history where (ID) = $ID";
    $result = mysqli_query($conn, $sql);

    $emparray = [];
    /*----------------------------------
        Fetch data
    ----------------------------------*/
    while ($row = mysqli_fetch_assoc($result)){
        $emparray[] = $row;
    }
    
    if (!empty($emparray)){
        $WikiData = array("Version"=>"$ver", "Type"=>"OK", "Data" => $emparray);
    } else{
        $WikiData = array("Version"=>"$ver", "Type"=>"ERROR");
    }
    echo json_encode($WikiData); // Send data as json
?>