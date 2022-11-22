<?php
    $data = [];
    $stmt = $conn->prepare("SELECT `event_invitation`.`ID`, `event_invitation`.`rID`, `event_invitation`.`eID`, `event_invitation`.`accepted` FROM `event_invitation` INNER JOIN `event` ON `event`.`uID` = ? AND `event_invitation`.`eID` = `event`.`ID`");
    $stmt->bind_param("i", $uID);
    $stmt->execute();
    $result = $stmt->get_result();

    $eventList = [];
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $eventList[] = $row;
        }
    } 
    $data["My sent invitations"] = $eventList;

    jsonWrite($version,$data);
?>