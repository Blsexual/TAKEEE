<?php
    require_once("db.php");
    require_once("json_exempel.php");
?>

<?php
    if(!empty($_GET['uID'])){
        $uID = $_GET['uID'];
        $stmt = $conn->prepare("SELECT `ID` FROM `user` WHERE `ID`=?");
        $stmt->bind_param("i",$uID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {   
            $stmt = $conn->prepare("DELETE FROM `blog` WHERE `blog`.`uID`=?");
            $stmt->bind_param("i",$uID);
            $stmt->execute();
            $stmt->close();
                 
            $stmt = $conn->prepare("DELETE FROM `blog_entry` WHERE `blog_entry`.`uID`=?");
            $stmt->bind_param("i",$uID);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM `event` WHERE `event`.`uID`=?");
            $stmt->bind_param("i",$uID);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM `event_invitation` WHERE `event_invitation`.`rID`=?");
            $stmt->bind_param("i",$uID);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM `user` WHERE `user`.`ID`=?");
            $stmt->bind_param("i",$uID);
            $stmt->execute();
            $stmt->close();

            $data = ["Action"=>"Deleted user ".$uID];
            jsonWrite($version,$data);  
        }
        errorWrite($version,"Could not find user");
    }
    errorWrite($version,"No user selected");
?>