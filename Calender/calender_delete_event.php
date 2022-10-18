<?php
    require_once("../db.php");
?>

<?php
    if(isset($_GET['deleteuID'])){ 
        $uID = $_GET['deleteuID'];
        $ID = $_GET['eventID'];
        $sql = "DELETE FROM `event` WHERE `ID`=$ID";
        $stmt = $conn->prepare("DELETE FROM `event` WHERE `ID`=?");
        $stmt->bind_param("s", $ID);

        $stmt->execute();
    }
?>