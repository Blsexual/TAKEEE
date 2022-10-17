<?php
    require_once("../db.php");
?>

<?php
    if(isset($_GET['insertuID'])){ 
        $uID = $_GET['insertuID'];
        
        $pattern = array('/:/i','/-/i','/ /i');

        $title = "My event";
        if(strlen($_GET['title'])){
            $title = $_GET['title'];
        }
        
        $description = "Test";
        if(strlen($_GET['description'])){
            $description = $_GET['description'];
        }
        
        
        if(strlen($_GET['startDate']) > 0){
            $startDate = $_GET['startDate'];
        }
        else{
            $startDate = date("Y-m-d H:i:s", mktime(date("H")+1, date("i"), 0, date("m"), date("d"), date("Y")));
        }
        
        
        if($_GET['endDate'] != "0000-00-00 00:00:00"){
            $endDate = $_GET['endDate'];
            
        }
        else{
            $changeHour = substr($startDate,11,2);
            $changeMinute = substr($startDate,14,2);
            $endDate = date("Y-m-d H:i:s", mktime($changeHour+1, date("i"), 0, date("m"), date("d"), date("Y")));

        }
        echo $uID."<br>";
        echo $title."<br>";
        echo $description."<br>";
        echo $startDate."<br>";
        echo $endDate."<br>";
        // die();
        $stmt = $conn->prepare("INSERT INTO `event` (uID, title, description, startDate, endDate) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $uID, $title, $description, $startDate, $endDate);

        $stmt->execute();
    }
    else{

    }
    
    
?>