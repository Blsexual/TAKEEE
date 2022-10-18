<?php
    require_once("../db.php");
?>

<?php
if(isset($_GET['insertuID'])){
    require("calender_create_event.php");
}
if(isset($_GET['deleteuID'])){
    require("calender_delete_event.php");
}
?>

<?php
    $sql = "SELECT `ID`,`uID`, `title`, `description`, `startDate`, `endDate` FROM `event`";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $Arr = array();
        while($row = $result->fetch_assoc()) {
            array_push($Arr,$row);
        }
        $Data = array("Events" => $Arr);
        echo json_encode($Data);
    } 
    else {
        $Res = array("Error"=>"0 Results");
        echo json_encode($Res);
    }
?>