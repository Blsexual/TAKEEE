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
        Checks each character of the start date and reconsctructs them into a valid string. Must be formatted as: 0000-00-00 00:00
    ----------------------------------------------------------------------*/
        $newStartDate = NULL;
        if(is_numeric(substr($startDate,0,4))){
            $newStartDate = $newStartDate.(substr($startDate,0,4));
        }
        else{
            errorWrite($version,"Year must be 4 numbers (2003)");
        }
        if(substr($startDate,4,1) == "-"){
            $newStartDate = $newStartDate.(substr($startDate,4,1));
        }
        else{
            errorWrite($version,'Must be a "-" between Year and Month');
        }
        if(is_numeric(substr($startDate,5,2))){
            if((substr($startDate,5,2) < 1) or ((substr($startDate,5,2) > 12))){
                errorWrite($version,"Month must be 2 numbers (12)");
            }
            $newStartDate = $newStartDate.(substr($startDate,5,2));
            $dateString = $newStartDate;
            $date = strtotime($dateString);
            $lastdate = strtotime(date("Y-m-t", $date ));
        }
        else{
            errorWrite($version,"Month must be 2 numbers (04)");
        }
        if(substr($startDate,7,1) == "-"){
            $newStartDate = $newStartDate.(substr($startDate,7,1));
        }
        else{
            errorWrite($version,'Must be a "-" between Month and Day');
        }
        if(is_numeric(substr($startDate,8,2))){
            $day = date("d", $lastdate);
            if((substr($startDate,8,2) < 1) or ((substr($startDate,8,2) > $day))){
                errorWrite($version,"Day must be 2 numbers (24)");
            }
            $newStartDate = $newStartDate.(substr($startDate,8,2));
        }
        else{
            errorWrite($version,"Day must be 2 numbers (24)");
        }
        if((substr($startDate,10,1) == "T") or (substr($startDate,10,1) == " ")){
            $newStartDate = $newStartDate.(substr($startDate,10,1));
        }
        else{
            errorWrite($version,'Must be a " " or "T" between Day and Hour');
        }
        if(is_numeric(substr($startDate,11,2))){
            if((substr($startDate,11,2) < 0) or ((substr($startDate,11,2) > 23))){
                errorWrite($version,"Hour must be 2 numbers (18)");
            }
            $newStartDate = $newStartDate.(substr($startDate,11,2));
        }
        else{
            errorWrite($version,"hour must be 2 numbers (18)");
        }
        if(substr($startDate,13,1) == ":"){
            $newStartDate = $newStartDate.(substr($startDate,13,1));
        }
        else{
            errorWrite($version,'Must be a ":" between Hour and Minute');
        }
        if(is_numeric(substr($startDate,14,2))){
            if((substr($startDate,14,2) < 0) or ((substr($startDate,14,2) > 59))){
                errorWrite($version,"Minute must be 2 numbers (59)");
            }
            $newStartDate = $newStartDate.(substr($startDate,14,2));
        }
        else{
            errorWrite($version,"Minute must be 2 numbers (59)");
        }
        $startDate = $newStartDate;
    #

    /*----------------------------------------------------------------------
        Checks each character of the end date and reconsctructs them into a valid string. Must be formatted as: 0000-00-00 00:00
    ----------------------------------------------------------------------*/
        $newEndDate = NULL;
        if(is_numeric(substr($endDate,0,4))){
            $newEndDate = $newEndDate.(substr($endDate,0,4));
        }
        else{
            errorWrite($version,"Year must be 4 numbers (2003)");
        }
        if(substr($endDate,4,1) == "-"){
            $newEndDate = $newEndDate.(substr($endDate,4,1));
        }
        else{
            errorWrite($version,'Must be a "-" between Year and Month');
        }
        if(is_numeric(substr($endDate,5,2))){
            if((substr($endDate,5,2) < 1) or ((substr($endDate,5,2) > 12))){
                errorWrite($version,"Month must be 2 numbers (12)");
            }
            $newEndDate = $newEndDate.(substr($endDate,5,2));
            $dateString = $newEndDate;
            $date = strtotime($dateString);
            $lastdate = strtotime(date("Y-m-t", $date ));
        }
        else{
            errorWrite($version,"Month must be 2 numbers (04)");
        }
        if(substr($endDate,7,1) == "-"){
            $newEndDate = $newEndDate.(substr($endDate,7,1));
        }
        else{
            errorWrite($version,'Must be a "-" between Month and Day');
        }
        if(is_numeric(substr($endDate,8,2))){
            $day = date("d", $lastdate);
            if((substr($endDate,8,2) < 1) or ((substr($endDate,8,2) > $day))){
                errorWrite($version,"Day must be 2 numbers (24)");
            }
            $newEndDate = $newEndDate.(substr($endDate,8,2));
        }
        else{
            errorWrite($version,"Day must be 2 numbers (24)");
        }
        if((substr($endDate,10,1) == "T") or (substr($endDate,10,1) == " ")){
            $newEndDate = $newEndDate.(substr($endDate,10,1));
        }
        else{
            errorWrite($version,'Must be a " " or "T" between Day and Hour');
        }
        if(is_numeric(substr($endDate,11,2))){
            if((substr($endDate,11,2) < 0) or ((substr($endDate,11,2) > 23))){
                errorWrite($version,"Hour must be 2 numbers (18)");
            }
            $newEndDate = $newEndDate.(substr($endDate,11,2));
        }
        else{
            errorWrite($version,"hour must be 2 numbers (18)");
        }
        if(substr($endDate,13,1) == ":"){
            $newEndDate = $newEndDate.(substr($endDate,13,1));
        }
        else{
            errorWrite($version,'Must be a ":" between Hour and Minute');
        }
        if(is_numeric(substr($endDate,14,2))){
            if((substr($endDate,14,2) < 0) or ((substr($endDate,14,2) > 59))){
                errorWrite($version,"Minute must be 2 numbers (59)");
            }
            $newEndDate = $newEndDate.(substr($endDate,14,2));
        }
        else{
            errorWrite($version,"Minute must be 2 numbers (59)");
        }
        $endDate = $newEndDate;
    #

    /*----------------------------------------------------------------------
        Checks the dates to make sure they're valid
    ----------------------------------------------------------------------*/ 
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

        $eventList = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $eventList[] = $row;
            }
        } 
        $data["My events"] = $eventList;
    #
    require_once("calendar_sort_timeline_invited.php");
    require_once("calendar_sort_timeline_accepted.php");
    
    jsonWrite($version,$data); 
?>
