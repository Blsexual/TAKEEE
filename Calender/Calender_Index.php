<?php
    require_once("../db.php");
?>

<?php
    $sql = "SELECT `uID`, `title`, `description`, `startDate`, `endDate` FROM `event`";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $Arr = array();
        while($row = $result->fetch_assoc()) {
            array_push($Arr,$row);
        }
    } 
    else {
        $Res = array("0 Results");
        echo json_encode($Res);
    }
    echo json_encode($Arr);
?>