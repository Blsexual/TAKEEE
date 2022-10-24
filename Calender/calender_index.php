<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");
?>

<?php   //comment
/* 
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
 */
?>

<?php
    if(!empty($_GET)){
        if(!empty($_GET['action'])){
            $action = $_GET['action'];
            if($action == "login"){
                require_once("calender_login.php");
            }

            $token = $_GET['token'];
            $uID = $_GET['uID'];
            checkToken($token,$uID,"001",$version,$conn);
            
            /*----------------------------------------------------------------------
                Shows a list of all events for the user
            ----------------------------------------------------------------------*/
                if($action == "showEvent"){
                    require_once("calender_show_event.php");
                }
            #
            /*----------------------------------------------------------------------
                Allows the user to create a new event
            ----------------------------------------------------------------------*/
                if($action == "createEvent"){
                    require_once("calender_create_event.php");
                }
            #
            /*----------------------------------------------------------------------
                Allows the user to delete one of their events
            ----------------------------------------------------------------------*/
                if($action == "deleteEvent"){
                    require_once("calender_delete_event.php");
                }
            #
            /*----------------------------------------------------------------------
                Allows a user to invite another user to see a specified event
            ----------------------------------------------------------------------*/
                if($action == "eventInvitation"){
                    require_once("calender_event_invitation.php");
                }
            #
            /*----------------------------------------------------------------------
                
            ----------------------------------------------------------------------*/
                if($action == "eventHandle"){
                    require_once("calender_event_handle.php");
                }
            #
            errorWrite($version,"Not a valid action");
        }
        errorWrite($version,"Wrong action made");
    }
    errorWrite($version,"No action made");
?>
