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
                    require_once("calendar_invitation_accept.php");
                    errorWrite($version,"Something went wrong in invitaion accept");
                }
            #

            /*----------------------------------------------------------------------
                Checks if handle is decline
            ----------------------------------------------------------------------*/
                if($eventHandle == "decline"){
                    require_once("calendar_invitation_decline.php");
                    errorWrite($version,"Something went wrong in invitaion decline");
                }
            #

            /*----------------------------------------------------------------------
                Checks if handle is cancel
            ----------------------------------------------------------------------*/
                if($eventHandle == "cancel"){
                    require_once("calendar_invitation_cancel.php");
                    errorWrite($version,"Something went wrong in invitaion cancel");
                }
            #
            errorWrite($version,"Not a valid action, either accept, decline or cancel");
        }
        errorWrite($version,"Specify handle");
    #
?>
