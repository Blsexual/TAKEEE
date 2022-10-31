<?php
    /*----------------------------------------------------------------------
        Sets the title of the event
    ----------------------------------------------------------------------*/
        if(!empty($_GET['title'])){
            $title = $_GET['title'];
        }
        else{
            errorWrite($version,"No title given");
        }

    #
        
    /*----------------------------------------------------------------------
        Sets the description of the event
    ----------------------------------------------------------------------*/
        $description = "";
        if(!empty($_GET['description'])){
            $description = $_GET['description'];
        }
    #
    
    /*----------------------------------------------------------------------
        Sets the starting date of the event
    ----------------------------------------------------------------------*/
        if(!empty($_GET['startDate'])){
            $startDate = $_GET['startDate'];
        }
        else{
            errorWrite($version,"No start date given");
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
    Sets the end date of the event
    ----------------------------------------------------------------------*/
        if(!empty($_GET['endDate'])){
            $endDate = $_GET['endDate'];
        }
        else{
            errorWrite($version,"No end date given");
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
        // Given a date in string format 
    #

    /*----------------------------------------------------------------------
        Creates the event using all the inserted data
    ----------------------------------------------------------------------*/ 
        $stmt = $conn->prepare("INSERT INTO `event` (uID, title, description, startDate, endDate) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $uID, $title, $description, $startDate, $endDate);
        $stmt->execute();
        $data = ["Action"=>"Created a new event"];
        jsonWrite($version,$data);
    #
?>
