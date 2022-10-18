<?php
    require_once("../db.php");
?>

<?php
    if(isset($_GET['insertuID'])){ 
        $uID = $_GET['insertuID'];
        
        $pattern = array('/:/i','/-/i','/ /i');

        $title = "My event";
        if(isset($_GET['title'])){
            if(strlen($_GET['title'])){
                $title = $_GET['title'];
            }
        }

        $description = "Test";
        if(isset($_GET['description'])){
            if(strlen($_GET['description'])){
                $description = $_GET['description'];
            }
        }
        
        $startDate = date("Y-m-d H:i:s", mktime(date("H"), date("i"), 00, date("m"), date("d"), date("Y")));
        if(isset($_GET['startDate'])){
            if(@$_GET['startDate'] != "0000-00-00 00:00:00"){
                $startDate = $_GET['startDate'];
            }
        }

        $changeYear = substr($startDate,0,4);
        $changeMonth = substr($startDate,5,2);
        $changeDay = substr($startDate,8,2);
        $changeHour = substr($startDate,11,2);
        $changeMinute = substr($startDate,14,2);

        $endDate = date("Y-m-d H:i:s", mktime($changeHour+1, $changeMinute, 00, $changeMonth, $changeDay, $changeYear));
        if(isset($_GET['endDate'])){
            if(@$_GET['endDate'] != "0000-00-00 00:00:00"){
                $endDate = $_GET['endDate'];
                
            }
        }

        $datecheckStart = preg_replace($pattern, "", $startDate);
        $datecheckStart = (int)$datecheckStart;

        $datecheckEnd = preg_replace($pattern, "", $endDate);
        $datecheckEnd = (int)$datecheckEnd;

        if($datecheckStart > $datecheckEnd){
            $endDate = date("Y-m-d H:i:s", mktime($changeHour+1, $changeMinute, 00, $changeMonth, $changeDay, $changeYear));
        }

        $datecheckEnd = preg_replace($pattern, "", $endDate);

        //echo $uID."<br>";
        //echo $title."<br>";
        //echo $description."<br>";
        //echo $startDate."<br>";
        //echo $endDate."<br>";
        $stmt = $conn->prepare("INSERT INTO `event` (uID, title, description, startDate, endDate) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $uID, $title, $description, $startDate, $endDate);

        $stmt->execute();
    }
    else{

    }
    
    
?>