<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");
?>

<?php
    if (isset($_REQUEST['user'])){ // user = user ID
        $user = $_REQUEST["user"];
    }
    if (empty($user)){
        errorWrite($version,"No user ID was found");
    }
    if (isset($_GET['token'])){ // token
        $token = $_GET["token"];
    }
    if (empty($token)){
        errorWrite($version,"No token was found");
    }
    if (isset($_GET['wikiID'])){ // wiki ID
        $wikiID = $_GET["wikiID"];
    }
    if (empty($wikiID)){
        errorWrite($version,"No wiki ID was found");
    }

    $adminCheck = checkToken($token, $user, "100", $version, $conn);

    if ($adminCheck["UserType"] != "admin"){ // Check if admin is true for user
        errorWrite($version,"You are not allowed to create this wiki");
    }

    /*$stmt = $conn->prepare("SELECT * FROM wiki WHERE ID = ?");
    $stmt->bind_param("i", $wikiID);
    $stmt->execute();
    $resultID = $stmt->get_result();

    if (empty($resultID)){
        errorWrite($version,"Found no wiki");
    }*/

    $stmt = $conn->prepare("DELETE FROM wiki WHERE ID = ?");
    $stmt->bind_param("i", $wikiID);
    $stmt->execute();
    $resultID = $stmt->get_result();

    $stmt = $conn->prepare("DELETE FROM wiki_entry WHERE wID = ?");
    $stmt->bind_param("i", $wikiID);
    $stmt->execute();
    $resultID = $stmt->get_result();

    $stmt = $conn->prepare("DELETE FROM wiki_entry_history WHERE oID = ?");
    $stmt->bind_param("i", $wikiID);
    $stmt->execute();
    $resultID = $stmt->get_result();

    jsonWrite($version,"Wiki was removed");
?>