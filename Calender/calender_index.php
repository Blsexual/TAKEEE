<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
?>

<?php
    if(!empty($_GET['uID'])){
        $uID = $_GET['uID'];
        $_SESSION['uID'] = $uID;
    }
    elseif(isset($_SESSION['uID'])){
        $uID = $_SESSION['uID'];
    }
    else{
        errorWrite($version,"No selected user");
    }

    if(!is_numeric($uID)){
        $data = "Not a valid user";
        $type = "Error";
        $return = ["Version"=>$version,"Type"=>$type,"Data"=>$data];
        die(json_encode($return));
    }

    $sql = "SELECT `ID` FROM user WHERE `ID`=$uID";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {

      }
    } 
    else{
        errorWrite($version,"User doesn't exist");
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
        $eventList = [];
        while($row = $result->fetch_assoc()) {
            array_push($eventList,$row);
        }
    } 
    else {
        errorWrite($version,"No events found for the user");
    }
    calendarWrite($version,$eventList);
?>
