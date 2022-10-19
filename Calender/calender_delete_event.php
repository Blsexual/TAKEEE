<?php
    require_once("../db.php");
?>

<?php
    if(isset($_SESSION['uID'])){ 
        $uID = $_SESSION['uID'];
        
        $ID = $_GET['eventID'];
        $stmt = $conn->prepare("DELETE FROM `event` WHERE `ID`=? AND `uID`=?");
        $stmt->bind_param("si", $ID,$uID);

        $stmt->execute();

        // $stmt = $conn->prepare("DELETE FROM `event` WHERE `ID`=?");
        // $stmt->bind_param("s", $ID);

        // $stmt->execute();
    }
?>