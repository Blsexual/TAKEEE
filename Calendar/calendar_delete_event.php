<?php
    if(empty($_GET['eID'])){
        errorWrite($version,"Didn't specify what event to delete");
    }
    $ID = $_GET['eID'];
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
        if ($result == 0) {
            $stmt->close();
            $stmt = $conn->prepare("DELETE FROM `event_invitation` WHERE `eID`=?");
            $stmt->bind_param("i", $ID);
            $stmt->execute();
            $data = ["Action"=>"Deleted event nr. ".$ID];
            jsonWrite($version,$data);  
        } 
        else{
            errorWrite($version,"Selected event doesn't exist");
        }
    }
    errorWrite($version,"Selected event doesn't exist");
?>
