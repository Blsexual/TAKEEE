<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");

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
    print_r($res);
/*---------------------------------------------------------------
        Checking all variables
---------------------------------------------------------------*/
    if($res['userType'] == "endUser"){
        $stmt = $conn->prepare("SELECT `name`, `password`, `email`, `admin`, `endUser`, `description`, `avatar`, `locked` FROM `user` WHERE `ID` = ?");
        $stmt->bind_param("i", $uID);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }
        $stmt->close();

        if(!empty($_GET['name'])){
            $name = $_GET['name']; 
        } 
        else{
            $name = $user['name'];
        }

        $stmt = $conn->prepare("SELECT * FROM user WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){ 
            errorWrite($version,"Username already in use");
        }

        if(!empty($_GET['password'])){
            $password = password_hash($_GET['password'],PASSWORD_DEFAULT);
        } 
        else{
            $password = $user['password'];
        }

        if(!empty($_GET['email'])){
            $email = $_GET['email'];
        } 
        else{
            $email = $user['email'];
        }

        if(!empty($_GET['description'])){
            $description = $_GET['description'];
        } 
        else{
            $description = $user['description'];
        }

        if(!empty($_GET['avatar'])){
            $avatar = $_GET['avatar'];
        } 
        else{
            $avatar = $user['avatar'];
        }

        $admin = $user['admin'];
        $endUser = $user['endUser'];
        $locked = $user['locked'];

        $stmt = $conn->prepare("UPDATE user SET name = ?, password = ?, email = ?, admin = ?, endUser = ?, description = ?, avatar = ?, locked = 0 WHERE user.ID = ? "); // updates entries
        $stmt->bind_param("sssssssi", $name, $password, $email, $admin, $endUser, $description, $avatar, $uID); 
        $stmt->execute();  
        $stmt->close();

        $data = ["Result"=>"User Updated","uID"=>$uID];
        jsonWrite($version,$data);

    }else if($res['userType'] == "admin"){
        if(!empty($_GET['rID'])){
            $rID = $_GET['rID'];
        }
        else{
            errorWrite($version,"No rID given");
        }

        $stmt = $conn->prepare("SELECT `name`, `password`, `email`, `admin`, `endUser`, `description`, `avatar`, `locked` FROM `user` WHERE `ID` = ?");
        $stmt->bind_param("i", $rID);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }
        $stmt->close();

        if(!empty($_GET['name'])){
            $name = $_GET['name']; 
        } 
        else{
            $name = $user['name'];
        }

        $stmt = $conn->prepare("SELECT * FROM user WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){ 
            errorWrite($version,"Username already in use");
        }

        if(!empty($_GET['password'])){
            $password = password_hash($_GET['password'],PASSWORD_DEFAULT);
        } 
        else{
            $password = $user['password'];
        }

        if(!empty($_GET['email'])){
            $email = $_GET['email'];
        } 
        else{
            $email = $user['email'];
        }

        if(!empty($_GET['admin'])){
            $admin = $_GET['admin'];
        } 
        else{
            $admin = $user['admin'];
        }

        if(!empty($_GET['endUser'])){
            $endUser = $_GET['endUser'];
        } 
        else{
            $endUser = $user['endUser'];
        }

        if(!empty($_GET['description'])){
            $description = $_GET['description'];
        } 
        else{
            $description = $user['description'];
        }

        if(!empty($_GET['avatar'])){
            $avatar = $_GET['avatar'];
        } 
        else{
            $avatar = $user['avatar'];
        }

        if(!empty($_GET['locked'])){
            $locked = $_GET['locked'];
        } 
        else{
            $locked = $user['locked'];
        }
#

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
#

/*------------------------------------------------------------------------
        If user set to endUser on blog, updates user and creates blog
------------------------------------------------------------------------*/  
        if($endUser[1] == "1"){    
            $stmt = $conn->prepare("UPDATE user SET name = ?, password = ?, email = ?, admin = ?, endUser = ?, description = ?, avatar = ?, locked = ? WHERE user.ID = ? "); // updates entries
            $stmt->bind_param("ssssssssi", $name, $password, $email, $admin, $endUser, $description, $avatar, $locked, $rID); 
            $stmt->execute();
            $stmt->close();
                
            $stmt = $conn->prepare("SELECT `ID`, `uID` FROM `blog` WHERE `uID`=?");
            $stmt->bind_param("i",$rID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                $date = date("Y/m/d H:i:s");
                $title = "No Title";
                $content = "No content";  // sets variables

                $stmt = $conn->prepare("INSERT INTO blog(title,description,date,uID) VALUES (?,?,?,?)"); //creates the blog for the new user
                $stmt->bind_param("sssi", $title, $content, $date, $rID);   
                $stmt->execute();    
                $stmt->close();
            }
        }
#

/*------------------------------------------------------------------------
        If user not set to endUser on blog, updates user and deletes blog and blog entries
------------------------------------------------------------------------*/
        if($endUser[1] == "0"){  
            $stmt = $conn->prepare("UPDATE user SET name = ?, password = ?, email = ?, admin = ?, endUser = ?, description = ?, avatar = ?, locked = 0 WHERE user.ID = ? "); // updates entries
            $stmt->bind_param("sssssssi", $name, $password, $email, $admin, $endUser, $description, $avatar, $rID); 
            $stmt->execute();  
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM `blog` WHERE `blog`.`uID`=?");
            $stmt->bind_param("i",$rID);
            $stmt->execute();
            $stmt->close();
                
            $stmt = $conn->prepare("DELETE FROM `blog_entry` WHERE `blog_entry`.`uID`=?");
            $stmt->bind_param("i",$rID);
            $stmt->execute();
            $stmt->close();
        }
#

/*------------------------------------------------------------------------
        If user not set to endUser on calendar, updates user and deletes events and event invitations
------------------------------------------------------------------------*/
        if($endUser[2] == "0"){
            $stmt = $conn->prepare("DELETE FROM `event` WHERE `event`.`uID`=?");
            $stmt->bind_param("i",$uID);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM `event_invitation` WHERE `event_invitation`.`rID`=?");
            $stmt->bind_param("i",$uID);
            $stmt->execute();
            $stmt->close();
        }
#

/*----------------------------------------------------------------------
        Outputs json
----------------------------------------------------------------------*/
        $data = ["Result"=>"User Updated","uID"=>$rID];
        jsonWrite($version,$data);
#
    } 
    else{
        errorWrite($version,"You are not allowed to do this");
    }
?>