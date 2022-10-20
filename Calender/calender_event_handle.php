<?php
    if(!empty($_GET['eventHandle'])){ 
        $eventHandle = $_GET['eventHandle'];
        if($eventHandle == "eventAccept"){
            require("calender_event_accept.php");
        }
        if($eventHandle == "eventDecline"){
            require("calender_event_decline.php");
        }
        errorWrite($version,"Not a valid action, either accept or decline");
    }
?>