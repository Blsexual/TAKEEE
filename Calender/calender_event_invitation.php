<?php
    if(!empty($_GET['eventID'])){
        $eID = $_GET['eventID'];
    }
    else{
        errorWrite($version,"Didn't specify which event to invite to");
    }
    
    $stmt = $conn->prepare("SELECT `ID` FROM `event` WHERE `ID`=? AND `uID`=?");
    $stmt->bind_param("ii", $eID,$uID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {           
        errorWrite($version,"Could not find event");
    }
    $stmt->close();

    if(!empty($_GET['recipientID'])){
        $rID = $_GET['recipientID'];
    }
    else{
        errorWrite($version,"Didn't specify which recipient to invite");
    }

    $stmt = $conn->prepare("SELECT `ID`, `name` FROM `user` WHERE `ID`=?");
    $stmt->bind_param("i", $rID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {           
        errorWrite($version,"Could not find recipient");
    }
    elseif($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $name = $row['name'];
    }
    $stmt->close();

    $stmt = $conn->prepare("SELECT `ID` FROM `event_invitation` WHERE `rID`=? AND `eID`=?");
    $stmt->bind_param("ii", $rID,$eID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {           
        errorWrite($version,"Have already invited recipient");
    }
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO `event_invitation` (rID, eID) VALUES (?,?)");
    $stmt->bind_param("ii", $rID, $eID);
    $stmt->execute();

    $data = ["Action"=>"Invited $name to event"];
    jsonWrite($version,$data);
?>