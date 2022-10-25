<?php
    if(!empty($_GET['action'])){ 
        /*----------------------------------------------------------------------
            Sets the title of the event
        ----------------------------------------------------------------------*/
            $title = "My event";
            if(!empty($_GET['title'])){
                $title = $_GET['title'];
            }
        #
            
        /*----------------------------------------------------------------------
            Sets the description of the event
        ----------------------------------------------------------------------*/
            $description = "Test";
            if(!empty($_GET['description'])){
                $description = $_GET['description'];
            }
        #
        
        /*----------------------------------------------------------------------
            Sets the starting date of the event
        ----------------------------------------------------------------------*/
            $startDate = date("Y-m-d H:i:s", mktime(date("H"), date("i"), 00, date("m"), date("d"), date("Y")));
            if(!empty($_GET['startDate'])){
                if(@$_GET['startDate'] != "0000-00-00 00:00:00"){
                    $startDate = $_GET['startDate'];
                }
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
            $endDate = date("Y-m-d H:i:s", mktime($changeHour+1, $changeMinute, 00, $changeMonth, $changeDay, $changeYear));
            if(!empty($_GET['endDate'])){
                if(@$_GET['endDate'] != "0000-00-00 00:00:00"){
                    $endDate = $_GET['endDate'];
                    
                }
            }
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
            $stmt = $conn->prepare("INSERT INTO `event` (uID, title, description, startDate, endDate) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $uID, $title, $description, $startDate, $endDate);
            $stmt->execute();
            $data = ["Action"=>"Created 1 new event"];
            jsonWrite($version,$data);
        #
    }
?>