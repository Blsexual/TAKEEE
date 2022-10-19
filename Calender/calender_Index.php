<?php
    require_once("../db.php");
    $version = "0.1.0";
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
        $data = "No selected user";
        $type = "Error";
        $return = ["Version"=>$version,"Type"=>$type,"Data"=>$data];
        die(json_encode($return));
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
        $data = "User doesn't exist";
        $type = "Error";
        $return = ["Version"=>$version,"Type"=>$type,"Data"=>$data];
        die(json_encode($return));
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
        $data = "No events found for user";
        $type = "Error";
        $return = ["Version"=>$version,"Type"=>$type,"Data"=>$data];
        die(json_encode($return));
    }
    $Contents = array("Type"=>"Ok","My events"=>$eventList);
    echo json_encode($Contents);
?>
