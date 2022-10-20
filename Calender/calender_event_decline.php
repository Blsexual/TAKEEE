<?php
    if(!empty($_GET['invitationID'])){
        $iID = $_GET['invitationID'];
    }
    else{
        errorWrite($version,"Didn't specify which invitation that was declined");
    }

    $stmt = $conn->prepare("SELECT `ID` FROM `event_invitation` WHERE `ID`=? AND `accepted`=1");
    $stmt->bind_param("i", $iID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {           
        errorWrite($version,"Invitation does not exist");
    }
    $stmt->close();
    $stmt = $conn->prepare("DELETE FROM `event_invitation` WHERE `ID`=?");
    $stmt->bind_param("i", $iID);
    $stmt->execute();

    $data = ["Action"=>"Invite declined"];
    jsonWrite($version,$data);
?>