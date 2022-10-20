<?php
    if(!empty($_GET['action'])){
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
            if ($result->num_rows > 0) {
                $stmt->close();
                $stmt = $conn->prepare("DELETE FROM `event` WHERE `ID`=? AND `uID`=?");
                $stmt->bind_param("ii", $ID,$uID);
            
                $result = $stmt->execute();
                $data = ["Action"=>"Deleted event nr. ".$ID];
                jsonWrite($version,$data);  
            } 
            else{
                errorWrite($version,"Selected event doesn't exist");
            }
        }
        errorWrite($version,"Didn't specify which event to delete");
    }
    errorWrite($version,"Didn't specify which event to delete");
?>