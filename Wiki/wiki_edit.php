<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");

    /*-----------------------------------------------------------
            Variabels
    -----------------------------------------------------------*/
    
    if (isset($_GET['wID'])){ // ID
        $ID = $_GET["wID"];
    }
    if (empty($wID)){
        errorWrite($version,"No wID was found");
    }
    if (isset($_GET['title'])){ // title
        $title = $_GET["title"];
    }
    if (empty($title)){
        errorWrite($version,"No title was found");
    }
    if (isset($_GET['wikiIndex'])){ // wiki Index
        $wikiIndex = $_GET["wikiIndex"];
    }
    if (empty($wikiIndex)){
        errorWrite($version,"No wiki index was found");
    }
    
    $adminCheck = checkToken($token, $uID, "100", $version, $conn);

    $stmt = $conn->prepare("SELECT ID FROM wiki WHERE ID = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $resultID = $stmt->get_result();
    if ($resultID->num_rows <= 0){
        errorWrite($version,"This wiki ID doesn't exist");
    }

    if ($adminCheck["userType"] != "admin"){ // Check if admin is true for user
        errorWrite($version,"You are not allowed to create this wiki");
    }

    $stmt = $conn->prepare("UPDATE wiki SET title = ?, wikiIndex = ? WHERE ID = ?");
    $stmt->bind_param("sii", $title, $wikiIndex, $ID);
    $stmt->execute();
    $resultID = $stmt->get_result(); 
    $data = ["Result"=>"Wiki was edited"];

    $stmt = $conn->prepare("SELECT `title`, `description`, `startDate`, `endDate` FROM `event` WHERE ID = ?"); // gets new title and content for entry
    $stmt->bind_param("i", $eID); 
    $stmt->execute();  
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {              // gets old title and content for entry
            $data = ["Result"=>"Wiki was updated", "Title"=>$row['title'], "Description"=>$row['description'], "StartDate"=>$row['startDate'], "EndDate"=>$row['endDate']];
        }
    } 
    jsonWrite($version,$data);
?>