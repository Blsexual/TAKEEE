<?php
    $data = [];
    $stmt = $conn->prepare("SELECT `ID`,`uID`, `title`, `description`, `startDate`, `endDate` FROM `event` WHERE `uID` = ?");
    $stmt->bind_param("i", $uID);
    $stmt->execute();
    $result = $stmt->get_result();

    $eventList = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $eventList[] = $row;
        }
    } 
    $data["My events"] = $eventList;
    
    require_once("calender_show_event_invited.php");
    require_once("calender_show_event_accepted.php");
    
    jsonWrite($version,$data);
?>