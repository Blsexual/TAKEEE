<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");
?>

<?php
    if (empty($uID)){
        errorWrite($version,"No user ID was found");
    }
    if (isset($_GET['token'])){ // token
        $token = $_GET["token"];
    }
    if (empty($token)){
        errorWrite($version,"No token was found");
    }
    if (isset($_GET['wID'])){ // wiki ID
        $wID = $_GET["wID"];
    }
    if (empty($wID)){
        errorWrite($version,"No wiki ID was found");
    }

    $adminCheck = checkToken($token, $uID, "100", $version, $conn);

    if ($adminCheck["userType"] != "admin"){ // Check if admin is true for user
        errorWrite($version,"You are not allowed to create this wiki");
    }

    $stmt = $conn->prepare("SELECT ID FROM wiki WHERE ID = $wID");
    $stmt->execute();
    $resultID = $stmt->get_result();
    if ($resultID->num_rows <= 0){
        errorWrite($version,"This wiki ID doesn't exist");
    }

    /*$stmt = $conn->prepare("SELECT * FROM wiki WHERE ID = ?");
    $stmt->bind_param("i", $wID);
    $stmt->execute();
    $resultID = $stmt->get_result();

    if (empty($resultID)){
        errorWrite($version,"Found no wiki");
    }*/

    $stmt = $conn->prepare("DELETE FROM wiki WHERE ID = ?");
    $stmt->bind_param("i", $wID);
    $stmt->execute();
    $resultID = $stmt->get_result();

    $stmt = $conn->prepare("SELECT ID FROM wiki_entry WHERE wID = ?");
    $stmt->bind_param("i", $wID);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row =$result->fetch_assoc()){
            $stmt = $conn->prepare("DELETE FROM wiki_entry_history WHERE oID = ?");
            $stmt->bind_param("i", $row["ID"]);
            $stmt->execute();
            $resultID = $stmt->get_result();
        }
    }

    $stmt = $conn->prepare("DELETE FROM wiki_entry WHERE wID = ?");
    $stmt->bind_param("i", $wID);
    $stmt->execute();
    $resultID = $stmt->get_result();

    

    jsonWrite($version,"Wiki was removed");
?>