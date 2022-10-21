<?php
    $sql = "SELECT `ID`,`uID`, `title`, `description`, `startDate`, `endDate` FROM `event` WHERE `uID` = $uID";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $eventList = [];
        while($row = $result->fetch_assoc()) {
            $eventList[] = $row;
        }
    } 
    else {
        errorWrite($version,"No events found for the user");
    }
    $data = ["My events"=>$eventList];
    jsonWrite($version,$data);
?>