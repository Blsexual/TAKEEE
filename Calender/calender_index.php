<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");
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

    $stmt = $conn->prepare("SELECT `ID` FROM user WHERE `ID`=?");
    $stmt->bind_param("i", $uID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        errorWrite($version,"User doesn't exist");
    }

?>

<?php
    if(!empty($_GET)){
        checkToken();
        if(!empty($_GET['action'])){
            $action = $_GET['action'];
            if($action == "login"){
                require_once("calender_login.php");
            }

            if($action == "showEvent"){
                require_once("calender_show_event.php");
            }
            
            if($action == "createEvent"){
                require_once("calender_create_event.php");
            }
            
            if($action == "deleteEvent"){
                require_once("calender_delete_event.php");
            }

            if($action == "eventInvitation"){
                require_once("calender_event_invitation.php");
            }
            
            if($action == "eventHandle"){
                require_once("calender_event_handle.php");
            }
            errorWrite($version,"Not a valid action");
        }
        errorWrite($version,"Wrong action made");
    }
    errorWrite($version,"No action made");
?>
