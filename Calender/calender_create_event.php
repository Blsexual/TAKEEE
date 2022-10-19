<?php
    require_once("../db.php");
?>

<?php
    if(isset($_GET['createEvent'])){ 
        
        #Event title
            $title = "My event";
            if(isset($_GET['title'])){
                if(!empty($_GET['title'])){
                    $title = $_GET['title'];
                }
            }
        #
            
        #Event description
            $description = "Test";
            if(isset($_GET['description'])){
                if(!empty($_GET['description'])){
                    $description = $_GET['description'];
                }
            }
        #
        
        #Event start
            $startDate = date("Y-m-d H:i:s", mktime(date("H"), date("i"), 00, date("m"), date("d"), date("Y")));
            if(isset($_GET['startDate'])){
                if(@$_GET['startDate'] != "0000-00-00 00:00:00"){
                    $startDate = $_GET['startDate'];
                }
            }
        #
        
        #Gets the individual values of the start date
            $changeYear = substr($startDate,0,4);
            $changeMonth = substr($startDate,5,2);
            $changeDay = substr($startDate,8,2);
            $changeHour = substr($startDate,11,2);
            $changeMinute = substr($startDate,14,2);
        #
        
        #Event end
            $endDate = date("Y-m-d H:i:s", mktime($changeHour+1, $changeMinute, 00, $changeMonth, $changeDay, $changeYear));
            if(isset($_GET['endDate'])){
                if(@$_GET['endDate'] != "0000-00-00 00:00:00"){
                    $endDate = $_GET['endDate'];
                    
                }
            }
        #

        #Checks if the end date is before the start date
            $pattern = array('/:/i','/-/i','/ /i');
            $datecheckStart = preg_replace($pattern, "", $startDate);
            $datecheckEnd = preg_replace($pattern, "", $endDate);
            
            $datecheckStart = (int)$datecheckStart;
            $datecheckEnd = (int)$datecheckEnd;
        
            #Sets the end date to be 1 hour after start date
                if($datecheckStart > $datecheckEnd){
                    $endDate = date("Y-m-d H:i:s", mktime($changeHour+1, $changeMinute, 00, $changeMonth, $changeDay, $changeYear));
                }
            #
        #

        #Showing the values that are being inserted for debugging purpouses
            // echo $uID."<br>";
            // echo $title."<br>";
            // echo $description."<br>";
            // echo $startDate."<br>";
            // echo $endDate."<br>";
        #

        #Inserting the data into the table
            $stmt = $conn->prepare("INSERT INTO `event` (uID, title, description, startDate, endDate) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $uID, $title, $description, $startDate, $endDate);

            $stmt->execute();
        #
    }
    else{

    }
    
    
?>