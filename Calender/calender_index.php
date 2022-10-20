<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
?>

<?php   //comment
    if(!empty($_GET['uID'])){
        $uID = $_GET['uID'];
        $_SESSION['uID'] = $uID;
    }
    elseif(!empty($_SESSION['uID'])){
        $uID = $_SESSION['uID'];
    }
    else{
        errorWrite($version,"No selected user");
    }

    if(!is_numeric($uID)){
        errorWrite($version,"Not a valid user");
    }

    $sql = "SELECT `ID` FROM user WHERE `ID`=$uID";
    $result = $conn->query($sql);
    

    if ($result->num_rows == 0) {
        errorWrite($version,"User doesn't exist");
    }
?>

<?php
    if(!empty($_GET['createEvent'])){
        require_once("calender_create_event.php");
    }

    if(!empty($_GET['deleteEvent'])){
        require_once("calender_delete_event.php");
    }

    if(!empty($_GET['eventInvite'])){
        require_once("calender_event_invite.php");
    }

    if(!empty($_GET['eventHandle'])){
        require_once("calender_event_handle.php");
    }

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
