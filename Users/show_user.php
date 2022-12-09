<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");

    if(empty($_GET["uID"])){
        errorWrite($version,"No uID given");
    }
    $uID = $_GET["uID"];
    if(empty($_GET["token"])){
        errorWrite($version,"No token given");
    }
	$token = $_GET["token"];

    $res = checkToken($token,$uID,"111",$version,$conn);

    if($res['userType'] == "endUser"){
        $stmt = $conn->prepare("SELECT `ID`,`name`, `email`, `admin`, `endUser`, `description`, `avatar`, `locked` FROM `user` where user.ID = ?");
        $stmt->bind_param("i", $uID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

    
    } else{
        if(empty($_GET["rID"])){
            errorWrite($version,"No rID (recipient ID) given");
        } else {
            $rID = $_GET["rID"];
        }
        $stmt = $conn->prepare("SELECT `ID`,`name`, `email`, `admin`, `endUser`, `description`, `avatar`, `locked` FROM `user` where user.ID = ?");
        $stmt->bind_param("i", $rID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

    }
    $data = ["Users"=>$row];
    jsonWrite($version,$data); //Output json message with data
    


?>