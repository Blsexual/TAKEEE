<?php
    if(empty($_GET['eID'])){
        errorWrite($version,"Must select an event");
    }

    $stmt = $conn->prepare("SELECT `ID`,`uID`, `title`, `description`, `startDate`, `endDate` FROM `event` WHERE `uID` = ? AND `ID` = ?");
    $stmt->bind_param("ii", $uID,$eID);
    $eID = $_GET['eID'];

    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $event = $result->fetch_assoc();
    }
    $stmt->close();
    /*----------------------------------------------------------------------
        Sets the title of the event
    ----------------------------------------------------------------------*/
        if(!empty($_GET['title'])){
            $title = $_GET['title'];
        }
        else{
            $title = $event['title'];
        }
    #
        
    /*----------------------------------------------------------------------
        Sets the description of the event
    ----------------------------------------------------------------------*/
        if(!empty($_GET['description'])){
            $description = $_GET['description'];
        }
        else{
            $description = $event['description'];
        }
    #
    
    /*----------------------------------------------------------------------
        Sets the starting date of the event
    ----------------------------------------------------------------------*/
        if(!empty($_GET['startDate'])){
            $startDate = $_GET['startDate'];
        }
        else{
            $startDate = $event['startDate'];
        }
    #

    /*----------------------------------------------------------------------
        Checks each character of the start date and reconsctructs them into a valid string
    ----------------------------------------------------------------------*/
        $newStartDate = NULL;
        if(is_numeric(substr($startDate,0,4))){
            $newStartDate = $newStartDate.(substr($startDate,0,4));
        }
        else{
            errorWrite($version,"Not a valid date 1");
        }
        if(substr($startDate,4,1) == "-"){
            $newStartDate = $newStartDate.(substr($startDate,4,1));
        }
        else{
            errorWrite($version,"Not a valid date 2");
        }
        if(is_numeric(substr($startDate,5,2))){
            if((substr($startDate,5,2) < 1) or ((substr($startDate,5,2) > 12))){
                errorWrite($version,"Not a valid date 3");
            }
            $newStartDate = $newStartDate.(substr($startDate,5,2));
            $dateString = $newStartDate;
            $date = strtotime($dateString);
            $lastdate = strtotime(date("Y-m-t", $date ));
        }
        else{
            errorWrite($version,"Not a valid date 4");
        }
        if(substr($startDate,7,1) == "-"){
            $newStartDate = $newStartDate.(substr($startDate,7,1));
        }
        else{
            errorWrite($version,"Not a valid date 5");
        }
        if(is_numeric(substr($startDate,8,2))){
            $day = date("d", $lastdate);
            if((substr($startDate,8,2) < 1) or ((substr($startDate,8,2) > $day))){
                errorWrite($version,"Not a valid date 6");
            }
            $newStartDate = $newStartDate.(substr($startDate,8,2));
        }
        else{
            errorWrite($version,"Not a valid date 7");
        }
        if((substr($startDate,10,1) == "T") or (substr($startDate,10,1) == " ")){
            $newStartDate = $newStartDate.(substr($startDate,10,1));
        }
        else{
            errorWrite($version,"Not a valid date 8");
        }
        if(is_numeric(substr($startDate,11,2))){
            if((substr($startDate,11,2) < 0) or ((substr($startDate,11,2) > 23))){
                errorWrite($version,"Not a valid date 9");
            }
            $newStartDate = $newStartDate.(substr($startDate,11,2));
        }
        else{
            errorWrite($version,"Not a valid date 10");
        }
        if(substr($startDate,13,1) == ":"){
            $newStartDate = $newStartDate.(substr($startDate,13,1));
        }
        else{
            errorWrite($version,"Not a valid date 11");
        }
        if(is_numeric(substr($startDate,14,2))){
            if((substr($startDate,14,2) < 0) or ((substr($startDate,14,2) > 59))){
                errorWrite($version,"Not a valid date 12");
            }
            $newStartDate = $newStartDate.(substr($startDate,14,2));

        }
        else{
            errorWrite($version,"Not a valid date 13");
        }
        $startDate = $newStartDate;
    #
    
    /*----------------------------------------------------------------------
        Extracts the different values of the starting date. Year, Month, etc
    ----------------------------------------------------------------------*/
        $changeYear = substr($startDate,0,4);
        $changeMonth = substr($startDate,5,2);
        $changeDay = substr($startDate,8,2);
        $changeHour = substr($startDate,11,2);
        $changeMinute = substr($startDate,14,2);
    #
    
    /*----------------------------------------------------------------------
        Sets the end date of the event
    ----------------------------------------------------------------------*/
        if(!empty($_GET['endDate'])){
            $endDate = $_GET['endDate'];
        }
        else{
            $endDate = $event['endDate'];
        }
    #


    /*----------------------------------------------------------------------
        Checks each character of the end date and reconsctructs them into a valid string
    ----------------------------------------------------------------------*/
        $newEndDate = NULL;
        if(is_numeric(substr($endDate,0,4))){
            $newEndDate = $newEndDate.(substr($endDate,0,4));
        }
        else{
            errorWrite($version,"Not a valid date 1");
        }
        if(substr($endDate,4,1) == "-"){
            $newEndDate = $newEndDate.(substr($endDate,4,1));
        }
        else{
            errorWrite($version,"Not a valid date 2");
        }
        if(is_numeric(substr($endDate,5,2))){
            if((substr($endDate,5,2) < 1) or ((substr($endDate,5,2) > 12))){
                errorWrite($version,"Not a valid date 3");
            }
            $newEndDate = $newEndDate.(substr($endDate,5,2));
            $dateString = $newEndDate;
            $date = strtotime($dateString);
            $lastdate = strtotime(date("Y-m-t", $date ));
        }
        else{
            errorWrite($version,"Not a valid date 4");
        }
        if(substr($endDate,7,1) == "-"){
            $newEndDate = $newEndDate.(substr($endDate,7,1));
        }
        else{
            errorWrite($version,"Not a valid date 5");
        }
        if(is_numeric(substr($endDate,8,2))){
            $day = date("d", $lastdate);
            if((substr($endDate,8,2) < 1) or ((substr($endDate,8,2) > $day))){
                errorWrite($version,"Not a valid date 6");
            }
            $newEndDate = $newEndDate.(substr($endDate,8,2));
        }
        else{
            errorWrite($version,"Not a valid date 7");
        }
        if((substr($endDate,10,1) == "T") or (substr($endDate,10,1) == " ")){
            $newEndDate = $newEndDate.(substr($endDate,10,1));
        }
        else{
            errorWrite($version,"Not a valid date 8");
        }
        if(is_numeric(substr($endDate,11,2))){
            if((substr($endDate,11,2) < 0) or ((substr($endDate,11,2) > 23))){
                errorWrite($version,"Not a valid date 9");
            }
            $newEndDate = $newEndDate.(substr($endDate,11,2));
        }
        else{
            errorWrite($version,"Not a valid date 10");
        }
        if(substr($endDate,13,1) == ":"){
            $newEndDate = $newEndDate.(substr($endDate,13,1));
        }
        else{
            errorWrite($version,"Not a valid date 11");
        }
        if(is_numeric(substr($endDate,14,2))){
            if((substr($endDate,14,2) < 0) or ((substr($endDate,14,2) > 59))){
                errorWrite($version,"Not a valid date 12");
            }
            $newEndDate = $newEndDate.(substr($endDate,14,2));
        }
        else{
            errorWrite($version,"Not a valid date 13");
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
        Displays the inserted data for debugging
    ----------------------------------------------------------------------*/ 
        // echo $uID."<br>";
        // echo $title."<br>";
        // echo $description."<br>";
        // echo $startDate."<br>";
        // echo $endDate."<br>";
    #

    /*----------------------------------------------------------------------
        Creates the event using all the inserted data
    ----------------------------------------------------------------------*/ 
        $stmt = $conn->prepare("UPDATE `event` SET `title` = ?, `description` = ?, `startDate` = ?, `endDate` = ? WHERE `ID` = ? AND `uID` = ?");
        $stmt->bind_param("ssssii", $title, $description, $startDate, $endDate, $eID, $uID);
        if($stmt->execute() === TRUE){

            $data = ["Action"=>"Event succesfully edited"];
            jsonWrite($version,$data);
        }
        else{
            errorWrite($version,"No");
        }
        
        $result = $stmt->get_result();
            
    #
?>