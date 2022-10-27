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

            if(empty($_GET['token'])){
                errorWrite($version,"No set token");
            }
            $token = $_GET['token'];
            
            if(empty($_GET['uID'])){
                errorWrite($version,"No set user");
            }
            $uID = $_GET['uID'];

            $userType = checkToken($token,$uID,"001",$version,$conn);
            if($userType['userType'] == "endUser"){
                /*----------------------------------------------------------------------
                    Shows a list of all events for the user
                ----------------------------------------------------------------------*/
                    if($action == "showEvent"){
                        require_once("calender_show_event.php");
                        errorWrite($version,"Something went wrong in show event");
                    }
                #
                /*----------------------------------------------------------------------
                    Allows the user to create a new event
                ----------------------------------------------------------------------*/
                    if($action == "createEvent"){
                        require_once("calender_create_event.php");
                        errorWrite($version,"Something went wrong in create event");
                    }
                #
                /*----------------------------------------------------------------------
                    Allows the user to delete one of their events
                ----------------------------------------------------------------------*/
                    if($action == "deleteEvent"){
                        require_once("calender_delete_event.php");
                        errorWrite($version,"Something went wrong in delete event");
                    }
                #
                /*----------------------------------------------------------------------
                    Shows all events on the timeline
                ----------------------------------------------------------------------*/
                    if($action == "sortTimeline"){
                        require_once("calender_sort_timeline.php");
                        errorWrite($version,"Something went wrong in sort timeline");
                    }
                #
                /*----------------------------------------------------------------------
                    Allows a user to invite another user to see a specified event
                ----------------------------------------------------------------------*/
                    if($action == "eventInvitation"){
                        require_once("calender_event_invitation.php");
                        errorWrite($version,"Something went wrong in event invitation");
                    }
                #
                /*----------------------------------------------------------------------
                    
                ----------------------------------------------------------------------*/
                    if($action == "eventHandle"){
                        require_once("calender_event_handle.php");
                        errorWrite($version,"Something went wrong in event handle");
                    }
                #
            }
            else{
                
            }
            
            errorWrite($version,"No valid action made");
        }
        errorWrite($version,"Invalid action made");
    }
    errorWrite($version,"No action made");
?>
