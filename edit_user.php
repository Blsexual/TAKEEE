<?php
    require_once("db.php");
    require_once("json_exempel.php");
    require_once("login_check.php");

/*---------------------------------------------------------------
        Check Token
---------------------------------------------------------------*/
    if(!empty($_GET["token"])){
        $token = $_GET['token'];      // Name of user
    } 
    else{
        errorWrite($version,"No token given");
    }

    if(!empty($_GET["uID"])){
        $uID = $_GET['uID'];      // Name of user
    } 
    else{
        errorWrite($version,"No userID given");
    }
    
    $res = checkToken($token,$uID,"111",$version,$conn);

/*---------------------------------------------------------------
        Checking all variables
---------------------------------------------------------------*/

    if($res["userType"] == "admin"){
        if(!empty($_GET["rID"])){
            $rID = $_GET["rID"];
        }
        if(!empty($_GET["name"])){
            $name = $_GET["name"]; 
        } 
        else{
            errorWrite($version,"No name given");
        }
        if(!empty($_GET["password"])){
            $password = $_GET["password"];
        } 
        else{
            errorWrite($version,"No password given");
        }
        if(!empty($_GET["email"])){
            $email = $_GET["email"];
        } 
        else{
            errorWrite($version,"No email given");
        }
        if(!empty($_GET["admin"])){
            $admin = $_GET["admin"];
        } 
        else{
            errorWrite($version,"No admin given");
        }
        if(!empty($_GET["endUser"])){
            $endUser = $_GET["endUser"];
        } 
        else{
            errorWrite($version,"No endUser given");
        }
        if(!empty($_GET["description"])){
            $description = $_GET["description"];
        } 
        else{
            errorWrite($version,"No description given");
        }
        if(!empty($_GET["avatar"])){
            $avatar = $_GET["avatar"];
        } 
        else{
            errorWrite($version,"No avatar given");
        }
        if(!empty($_GET["locked"])){
            $locked = $_GET["locked"];
        } 
        else{
            $locked = 0
        }

/*------------------------------------------------------------------------
        Making sure the actions are allowed to be made
------------------------------------------------------------------------*/
        for($i=0;$i<=2;$i++){
            if($endUser[$i] == $admin[$i] && $endUser[$i] != "0" && $res["admin"][$i] != "0"){
                errorWrite($version,"A user can not be a admin and end user on the same platform");
            }
            // Checks so the user is allowed to make a endUser for something
            if($endUser[$i] == "1" && $res["admin"][$i] != "1"){
                errorWrite($version,"You are not allowed to make a user a user for a platform you are not admin on");
            }
            // Checks so the user is allowed to make a admin
            if($admin[$i] == "1" && $res["admin"][$i] != "1"){
                errorWrite($version,"You are not allowed to make a user a admin for a platform you are not admin on");
            }
        }
/*------------------------------------------------------------------------
                            Blogs lock user
------------------------------------------------------------------------*/  
  
        if($endUser[1] == "1"){    
            if ($locked != 0){
                $stmt = $conn->prepare("UPDATE user SET name = ?, password = ?, email = ?, admin = ?, endUser = ?, description = ?, avatar = ?, locked = 1 WHERE user.ID = ? "); // updates entries
                $stmt->bind_param("sssssssi", $name, $password, $email, $admin, $endUser, $description, $avatar, $rID); 
                $stmt->execute();  
                $data = ["Action"=>"User Updated"];
                jsonWrite($version,$data);
            } 
            $stmt = $conn->prepare("UPDATE user SET name = ?, password = ?, email = ?, admin = ?, endUser = ?, description = ?, avatar = ?, locked = 0 WHERE user.ID = ? "); // updates entries
            $stmt->bind_param("sssssssi", $name, $password, $email, $admin, $endUser, $description, $avatar, $rID); 
            $stmt->execute();  
            $data = ["Action"=>"User Updated"];
            jsonWrite($version,$data);
        }
#
        $stmt = $conn->prepare("UPDATE user SET name = ?, password = ?, email = ?, admin = ?, endUser = ?, description = ?, avatar = ? WHERE user.ID = ? "); // updates entries
        $stmt->bind_param("sssssssi", $name, $password, $email, $admin, $endUser, $description, $avatar, $rID); 
        $stmt->execute();  
        $data = ["Action"=>"User Updated"];
        jsonWrite($version,$data);
    } 
    else{
        errorWrite($version,"You are not allowed to do this");
    }

?>