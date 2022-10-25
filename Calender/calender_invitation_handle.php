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
                    require("calender_event_accept.php");
                }
            #

            /*----------------------------------------------------------------------
                Checks if handle is decline
            ----------------------------------------------------------------------*/
                if($eventHandle == "decline"){
                    require("calender_event_decline.php");
                }
            #
            
            errorWrite($version,"Not a valid action, either accept or decline");
        }
        errorWrite($version,"Specify handle");
    #
?>