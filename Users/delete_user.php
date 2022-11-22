<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");
?>

<?php
/*---------------------------------------------------------------
        Check token and uID
---------------------------------------------------------------*/
    if(!empty($_GET['token'])){
        $token = $_GET['token'];      // Name of user
    } 
    else{
        errorWrite($version,"No token given");
    }

    if(!empty($_GET['uID'])){
        $uID = $_GET['uID'];      // Name of user
    } 
    else{
        errorWrite($version,"No uID given");
    }

    $res = checkToken($token,$uID,"111",$version,$conn);

    if($res['userType'] == "admin"){
        if(!empty($_GET['rID'])){
            $rID = $_GET['rID'];
            $stmt = $conn->prepare("SELECT `ID` FROM `user` WHERE `ID`=?");
            $stmt->bind_param("i",$rID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {   
                $stmt = $conn->prepare("DELETE FROM `blog` WHERE `blog`.`uID`=?");
                $stmt->bind_param("i",$rID);
                $stmt->execute();
                $stmt->close();
                    
                $stmt = $conn->prepare("DELETE FROM `blog_entry` WHERE `blog_entry`.`uID`=?");
                $stmt->bind_param("i",$rID);
                $stmt->execute();
                $stmt->close();

                $stmt = $conn->prepare("DELETE FROM `event` WHERE `event`.`uID`=?");
                $stmt->bind_param("i",$rID);
                $stmt->execute();
                $stmt->close();

                $stmt = $conn->prepare("DELETE FROM `event_invitation` WHERE `event_invitation`.`rID`=?");
                $stmt->bind_param("i",$rID);
                $stmt->execute();
                $stmt->close();

                $stmt = $conn->prepare("DELETE FROM `user` WHERE `user`.`ID`=?");
                $stmt->bind_param("i",$rID);
                $stmt->execute();
                $stmt->close();

                $data = ["uID"=>$rID, "Result"=>"Deleted user"];
                jsonWrite($version,$data);  
            }
            errorWrite($version,"Could not find user");
        }
        errorWrite($version,"No user selected");
    }
    errorWrite($version,"You are not allowed to do this");
    
?>