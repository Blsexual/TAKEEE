<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");
?>

<?php
    if(!empty($_GET)){
        if(!empty($_GET['action'])){
            $action = $_GET['action'];
            if($action == "login"){
                require_once("calendar_login.php");
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
                        require_once("calendar_show_event.php");
                        errorWrite($version,"Something went wrong in show event");
                    }
                #
                /*----------------------------------------------------------------------
                    Allows the user to create a new event
                ----------------------------------------------------------------------*/
                    if($action == "createEvent"){
                        require_once("calendar_create_event.php");
                        errorWrite($version,"Something went wrong in create event");
                    }
                #
                /*----------------------------------------------------------------------
                    Allows the user to edit one of their events
                ----------------------------------------------------------------------*/
                if($action == "editEvent"){
                    require_once("calendar_edit_event.php");
                    errorWrite($version,"Something went wrong in edit event");
                }
                #
                /*----------------------------------------------------------------------
                    Allows the user to delete one of their events
                ----------------------------------------------------------------------*/
                    if($action == "deleteEvent"){
                        require_once("calendar_delete_event.php");
                        errorWrite($version,"Something went wrong in delete event");
                    }
                #
                /*----------------------------------------------------------------------
                    Shows all events on the timeline
                ----------------------------------------------------------------------*/
                    if($action == "sortTimeline"){
                        require_once("calendar_sort_timeline.php");
                        errorWrite($version,"Something went wrong in sort timeline");
                    }
                #
                /*----------------------------------------------------------------------
                    Allows a user to send an ivitation to another user to see a specified event
                ----------------------------------------------------------------------*/
                    if($action == "eventInvitation"){
                        require_once("calendar_event_invitation.php");
                        errorWrite($version,"Something went wrong in event invitation");
                    }
                #
                /*----------------------------------------------------------------------
                    Allows a user to either accept decline or cancel an invite
                ----------------------------------------------------------------------*/
                    if($action == "invitationHandle"){
                        require_once("calendar_invitation_handle.php");
                        errorWrite($version,"Something went wrong in event handle");
                    }
                #
                /*----------------------------------------------------------------------
                    Allows a user to leave an accepted invitation
                ----------------------------------------------------------------------*/
                    if($action == "invitationLeave"){
                        require_once("calendar_invitation_leave.php");
                        errorWrite($version,"Something went wrong in invitaion leave");
                    }
                #
                
                /*----------------------------------------------------------------------
                    Allows a user to revoke an accepted invitation
                ----------------------------------------------------------------------*/
                    if($action == "invitationRevoke"){
                        require_once("calendar_invitation_revoke.php");
                        errorWrite($version,"Something went wrong in invitaion revoke");
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
