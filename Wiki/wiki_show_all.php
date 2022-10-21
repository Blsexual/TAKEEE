<?php
    require_once("../db.php");
    require_once("../json_exempel.php");

    $ver = "0.1"; // WILL DELETE THIS
    $sql = "SELECT * FROM `wiki`";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $Arr = array();
        while($row = $result->fetch_assoc()) {
            array_push($Arr,$row);
        }
        $Data = array("Wikis" => $Arr);
        echo json_encode($Data);
    } 
    else {
        $Res = array("Error"=>"0 Results");
        echo json_encode($Res);
    }
?>