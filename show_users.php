<?php
    require_once("db.php");
    require_once("json_exempel.php");
    require_once("login_check.php");

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
        $data = ["Result"=>"Only admins can see this information"];
        jsonWrite($version,$data);
    }

    $stmt = $conn->prepare("SELECT `ID`,`name`, `email`, `admin`, `endUser`, `description`, `avatar`, `locked` FROM `user`");
    $stmt->execute();
    $result = $stmt->get_result();

    $emparray = [];
    /*----------------------------------
        Fetch data
    ----------------------------------*/
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()){
            $emparray[] = $row;
        }
    }

    $data = ["Users"=>$emparray];
    jsonWrite($version,$data); //Output json message with data


?>