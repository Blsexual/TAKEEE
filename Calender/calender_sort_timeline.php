<?php
    if(empty($_GET['startDate'])){
        errorWrite($version,"Must provide a start date");
    }
    $startDate = $_GET['startDate'];

    if(empty($_GET['endDate'])){
        errorWrite($version,"Must provide an end date");
    }
    $endDate = $_GET['endDate'];

    $stmt = $conn->prepare("SELECT `ID`,`uID`, `title`, `description`, `startDate`, `endDate` FROM `event` WHERE `startDate` BETWEEN '0000-00-00 00:00:00' AND ? AND `endDate` BETWEEN ? AND '9999-12-30 23:59:59' ORDER BY `startDate` asc");
    $stmt->bind_param("ss", $endDate,$startDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $eventList = [];
        while($row = $result->fetch_assoc()) {
            $eventList[] = $row;
        }
    } 
    else {
        errorWrite($version,"No events found for the user between those times");
    }
    $data = ["My events"=>$eventList];
    jsonWrite($version,$data);

?>