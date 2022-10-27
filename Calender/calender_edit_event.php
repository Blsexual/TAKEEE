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