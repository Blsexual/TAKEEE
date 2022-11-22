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
    if(empty($_GET["activet"])){
        $activet = 0;
    }
	$activet = $_GET["activet"];



    $res = checkToken($token,$uID,"111",$version,$conn);



    if($res['userType'] == "admin"){
        if($activet == 1){
            $date = date("Y-m-d H:i:s", mktime(date("H")+1, date("i"), 00, date("m"), date("d"), date("Y")));
            $stmt = $conn->prepare("UPDATE test_token SET active = 1, validUntil = ?  WHERE testID = 1");
            $stmt->bind_param("s", $date); 
            $stmt->execute();
    
            // JSON Return
            $data = ["Result"=>"token is now usable"];
            jsonWrite($version,$data);

        }   
        else{
            $stmt = "UPDATE test_token SET active = 0  WHERE testID = 1";
            $conn->query($stmt);
    
            // JSON Return
            $data = ["Result"=>"token is now disabled"];
            jsonWrite($version,$data);
        }
    }
    else{
        $data = ["Result"=>"Only admins can see this information"];
        jsonWrite($version,$data);
    }
    

?>