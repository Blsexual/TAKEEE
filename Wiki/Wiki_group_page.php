<?php
    require_once("../db.php");
    /*----------------------------------
        Variables
    ----------------------------------*/
    $ID = $_REQUEST["ID"];
    if (empty($_GET)){
        die("Error: Inget ID data har identifierats");
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

    echo json_encode($emparray); // Send data as json
?>