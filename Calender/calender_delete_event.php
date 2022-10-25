<?php
    if(empty($_GET['eventID'])){
        errorWrite($version,"Didn't specify what event to delete");
    }
    $ID = $_GET['eventID'];
    $stmt = $conn->prepare("SELECT `ID` FROM `event` WHERE `ID`=? AND `uID`=?");
    $stmt->bind_param("ii", $ID,$uID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        $stmt = $conn->prepare("DELETE FROM `event` WHERE `ID`=? AND `uID`=?");

        $stmt->bind_param("ii", $ID,$uID);
    
        $stmt->execute();
        $result = $stmt->get_result();
        echo $result;
        if ($result == 0) {
            $data = ["Action"=>"Deleted event nr. ".$ID];
            jsonWrite($version,$data);  
        } 
        else{
            errorWrite($version,"Selected event doesn't exist");
        }
    }
    errorWrite($version,"Selected event doesn't exist");
?>