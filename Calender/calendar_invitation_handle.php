<?php
    /*----------------------------------------------------------------------
        Checks if handle is set
    ----------------------------------------------------------------------*/
        if(!empty($_GET['handle'])){ 
            $eventHandle = $_GET['handle'];

            /*----------------------------------------------------------------------
                Checks if handle is accept
            ----------------------------------------------------------------------*/
                if($eventHandle == "accept"){
                    require_once("calender_invitation_accept.php");
                    errorWrite($version,"Something went wrong in invitaion accept");
                }
            #

            /*----------------------------------------------------------------------
                Checks if handle is decline
            ----------------------------------------------------------------------*/
                if($eventHandle == "decline"){
                    require_once("calender_invitation_decline.php");
                    errorWrite($version,"Something went wrong in invitaion decline");
                }
            #

            /*----------------------------------------------------------------------
                Checks if handle is cancel
            ----------------------------------------------------------------------*/
                if($action == "cancel"){
                    require_once("calender_invitation_cancel.php");
                    errorWrite($version,"Something went wrong in invitaion cancel");
                }
            #
            errorWrite($version,"Not a valid action, either accept or decline");
        }
        errorWrite($version,"Specify handle");
    #
?>
