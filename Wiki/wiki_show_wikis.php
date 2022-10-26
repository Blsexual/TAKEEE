<?php
    /*----------------------------------
        Variables
    ----------------------------------*/

    $stmt = $conn->prepare("SELECT * FROM `wiki`");
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
        errorWrite($version,"No wiki's found"); //Output json error message
    }

    $data = ["Wiki entry"=>$emparray];
    jsonWrite($version,$data); //Output json message with data
?>