<?php
    require_once("db.php");
    require_once("json_exempel.php");
    require_once("login_check.php");

    if(!empty($_GET["token"])){
        $token = $_GET['token'];      // Name of user
    } else{
        errorWrite($version,"No token given");
    }

    if(!empty($_GET["uID"])){
        $uID = $_GET['uID'];      // Name of user
    } else{
        errorWrite($version,"No userID given");
    }
    
    $res = checkToken($token,$uID,"111",$version,$conn);

    if($res["userType"] == "admin"){
        if(!empty($_GET["name"])){
            $name = $_GET["name"]; 
        } else{
            errorWrite($version,"No name given");
        }
        if(!empty($_GET["password"])){
            $password = $_GET["password"];
        } else{
            errorWrite($version,"No password given");
        }
        if(!empty($_GET["email"])){
            $email = $_GET["email"];
        } else{
            errorWrite($version,"No email given");
        }
        if(!empty($_GET["admin"])){
            $admin = $_GET["admin"];
        } else{
            errorWrite($version,"No admin given");
        }
        if(!empty($_GET["endUser"])){
            $endUser = $_GET["endUser"];
        } else{
            errorWrite($version,"No endUser given");
        }
        if(!empty($_GET["description"])){
            $description = $_GET["description"];
        } else{
            errorWrite($version,"No description given");
        }
        if(!empty($_GET["avatar"])){
            $avatar = $_GET["avatar"];
        } else{
            errorWrite($version,"No avatar given");
        }
        for($i=0;$i>=2;$i++){
            if($endUser[$i] == $admin[$i] && $endUser[$i] != "0"){
                errorWrite($version,"A user can not be a admin and end user on the same platform");
            }
        }
        // Blogs problem fuck you haha elidon och erik sug en stor ...
        if($endUser[1] == "1"){

        }

    } else{
        errorWrite($version,"You are not allowed to do this");
    }

?>