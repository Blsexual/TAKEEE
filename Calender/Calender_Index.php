<?php
    require_once("../db.php");
?>

<?php
    if(isset($_GET['uID'])){
        $uID = $_GET['uID'];
        $_SESSION['uID'] = $uID;
    }
    else{
        $uID = $_SESSION['uID'];
    }
?>

<?php
    if(isset($_GET['createEvent'])){
        require("calender_create_event.php");
    }

    if(isset($_GET['deleteEvent'])){
        require("calender_delete_event.php");
    }

    $sql = "SELECT `ID`,`uID`, `title`, `description`, `startDate`, `endDate` FROM `event` WHERE `uID` = $uID";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $eventList = array();
        while($row = $result->fetch_assoc()) {
            array_push($eventList,$row);
        }
        $data = array("Events"=>$eventList);
        $type = "Ok";
    } 
    else {
        $data = array("Events"=>"No events found for user");
        $type = "Error";
    }
    $Contents = array("Type"=>$type,"Contents"=>$data);
    echo json_encode($Contents);
?>