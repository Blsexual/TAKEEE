<?php
    $data = [];
    $stmt = $conn->prepare("SELECT `ID`,`uID`, `title`, `description`, `startDate`, `endDate` FROM `event` WHERE `uID` = ?");
    $stmt->bind_param("i", $uID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $eventList = [];
        while($row = $result->fetch_assoc()) {
            $eventList[] = $row;
        }
        $data["My events"] = $eventList;
    } 
    
    require_once("calender_show_event_accepted.php");
    
    if(!empty($data)){
        jsonWrite($version,$data); 
    }
    errorWrite($version,"No events found for the user");
?>