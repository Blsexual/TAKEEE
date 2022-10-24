<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    
    /*----------------------------------
        Variables
    ----------------------------------*/

    $sql = "SELECT * FROM `wiki`";
    $result = $conn->query($sql);

    $emparray = [];
    /*----------------------------------
        Fetch data
    ----------------------------------*/
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $emparray[] = $row;
        }
    } else{
        errorWrite($version,"No wiki's found");
    }

    $data = ["Wiki entry"=>$emparray];
    jsonWrite($version,$data);
?>