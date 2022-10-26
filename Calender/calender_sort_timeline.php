<?php
    /*----------------------------------------------------------------------
        Gets the start and end date
    ----------------------------------------------------------------------*/ 
        if(empty($_GET['startDate'])){
            errorWrite($version,"Must provide a start date");
        }
        $startDate = $_GET['startDate'];

        if(empty($_GET['endDate'])){
            errorWrite($version,"Must provide an end date");
        }
        $endDate = $_GET['endDate'];
    #

    /*----------------------------------------------------------------------
        Checks the dates to make sure they're valid
    ----------------------------------------------------------------------*/ 
        #Returns an error if an end date has been set without a start date
            if((!empty($_GET['endDate'])) and (empty($_GET['startDate']))){
                errorWrite($version,"Cannot set an end date without a start date");
            }   
        #

        #Specifies what characters to remove from a string
            $pattern = ['/:/i','/-/i','/ /i']; 
        #

        #Removes specified characters from selected string
            $datecheckStart = preg_replace($pattern, "", $startDate); 
            $datecheckEnd = preg_replace($pattern, "", $endDate);
        #
        
        #Converts the string to an integer
            $datecheckStart = (int)$datecheckStart; 
            $datecheckEnd = (int)$datecheckEnd;
        #

        #Gives an error if the end date is earlier than the start date
            if($datecheckStart > $datecheckEnd){
                errorWrite($version,"The end date cannot be earlier than the start date");
            }
        #
    #

    /*----------------------------------------------------------------------
        Shows all of the end users events between those dates
    ----------------------------------------------------------------------*/ 
        $stmt = $conn->prepare("SELECT `ID`, `uID`, `title`, `description`, `startDate`, `endDate` FROM `event` WHERE `uID` = ? AND `startDate` BETWEEN '0000-00-00 00:00:00' AND ? AND `endDate` BETWEEN ? AND '9999-12-30 23:59:59' ORDER BY `startDate` asc");
        $stmt->bind_param("iss",$uID,$endDate,$startDate);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $eventList = [];
            while($row = $result->fetch_assoc()) {
                $eventList[] = $row;
            }
            $data["My events"] = $eventList;
        } 
    #
    
    require_once("calender_sort_timeline_accepted.php");
    
    if(!empty($data)){
        jsonWrite($version,$data); 
    }
    errorWrite($version,"No events found for the user");
?>