<?php
    if(!empty($_GET['invitationID'])){
        $iID = $_GET['invitationID'];
    }
    else{
        errorWrite($version,"Didn't specify which invitation to accept");
    }

    $stmt = $conn->prepare("SELECT `ID` FROM `event_invitation` WHERE `ID`=?");
    $stmt->bind_param("i", $iID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {           
        errorWrite($version,"Could not find invitation");
    }
    $stmt->close();

    $stmt = $conn->prepare("SELECT `ID` FROM `event_invitation` WHERE `ID`=? AND `accepted`=1");
    $stmt->bind_param("i", $iID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {           
        errorWrite($version,"Invitation already accepted");
    }
    $stmt->close();
    
    $stmt = $conn->prepare("UPDATE `event_invitation` SET `accepted`=1 WHERE `ID`=?");
    $stmt->bind_param("i", $iID);
    $stmt->execute();

    $data = ["Action"=>"Invitation accepted"];
    jsonWrite($version,$data);
?>