<?php
    if(!empty($_GET['handle'])){ 
        $eventHandle = $_GET['handle'];
        if($eventHandle == "accept"){
            require("calender_event_accept.php");
        }
        if($eventHandle == "decline"){
            require("calender_event_decline.php");
        }
        errorWrite($version,"Not a valid action, either accept or decline");
    }
    errorWrite($version,"Specify handle");
?>