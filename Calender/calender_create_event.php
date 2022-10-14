<?php
    require_once("../db.php");
?>

<?php
    if(isset($_GET['uID'])){ 
        $uID = $_GET['uID'];

        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }
        else{
            $title = "My event";
        }
    
        if(isset($_GET['description'])){
            $description = $_GET['description'];
        }
        else{
            $description = NULL;
        }
    
        if(isset($_GET['startDate'])){
            $startDate = $_GET['startDate'];
        }
        else{
            $startDate = 10;
        }
    
        if(isset($_GET['endDate'])){
            $endDate = $_GET['endDate'];
        }
        else{
            $endDate = 20;
        }

        $stmt = $conn->prepare("INSERT INTO `event` (uID, title, description, startDate, endDate) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $uID, $title, $description, $startDate, $endDate);

        $stmt->execute();
    }
    else{

    }
    
    
?>