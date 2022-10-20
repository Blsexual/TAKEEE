<?php
    if(!empty($_GET['eventInvitation'])){ 
        $uID = 
        $eID = $_GET['eventID']

        $stmt = $conn->prepare("INSERT INTO `event_invitation` (uID, eID, accepted) VALUES (?,?,?)");
        $stmt->bind_param("iii", $uID, $eID, $accepted);
        $stmt->execute();
    }
?>