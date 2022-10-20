<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
?>

<?php   //comment

    if(!empty($_GET['token'])){

    }
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
    if (!empty($_GET['action'])){
        $action = $_GET['action'];
        if($action == "showEvent"){
            require("calender_show_event.php");
        }
        
        if($action == "createEvent"){
            require("calender_create_event.php");
        }
        
        if($action == "deleteEvent"){
            require("calender_delete_event.php");
        }
        
        if($action == "eventInvite"){
            require("calender_event_invite.php");
        }

        if($action == "eventInvitation"){
            require("calender_event_invitation.php");
        }

        if($action == "eventHandle"){
            require("calender_event_handle.php");
        }
        errorWrite($version,"Not a valid action");
    }
    errorWrite($version,"No action made");


?>
