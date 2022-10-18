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
        
        
        $startDate = date("Y-m-d H:i:s", mktime(date("H"), date("i"), 0, date("m"), date("d"), date("Y")));
        if(isset($_GET['startDate'])){
            if(@$_GET['startDate'] != "0000-00-00 00:00:00"){
                $startDate = $_GET['startDate'];
            }
        }
        
        
        $changeHour = substr($startDate,11,2);
        $changeMinute = substr($startDate,14,2);
        $endDate = date("Y-m-d H:i:s", mktime($changeHour+1, $changeMinute, 0, date("m"), date("d"), date("Y")));
        if(isset($_GET['description'])){
            if(@$_GET['endDate'] != "0000-00-00 00:00:00"){
                $endDate = $_GET['endDate'];
                
            }
        }
        $datecheckStart = preg_replace($pattern, "", $startDate);
        $datecheckEnd = preg_replace($pattern, "", $endDate);
        echo $datecheckStart."<br>";
        echo $datecheckEnd."<br>";
        if($datecheckStart < $datecheckEnd){
            $endDate = date("Y-m-d H:i:s", mktime($changeHour+1, $changeMinute, 0, date("m"), date("d"), date("Y")));
        }
        $datecheckStart = preg_replace($pattern, "", $startDate);
        $datecheckEnd = preg_replace($pattern, "", $endDate);
        echo $datecheckStart."<br>";
        echo $datecheckEnd."<br>";
        echo $uID."<br>";
        echo $title."<br>";
        echo $description."<br>";
        echo $startDate."<br>";
        echo $endDate."<br>";
        die();
        $stmt = $conn->prepare("INSERT INTO `event` (uID, title, description, startDate, endDate) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $uID, $title, $description, $startDate, $endDate);

        $stmt->execute();
    }
    else{

    }
    
    
?>