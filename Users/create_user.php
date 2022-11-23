<?php
// Create users

//?username=?&password=?&email=?&admin=?&endUser=?&desc=optional&avatar=optional


    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");

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

    if ($res["userType"] == "admin"){
        if(!empty($_GET["username"])){
            $username = $_GET["username"];      // Name of user
        } else{
            errorWrite($version,"No username given");
        }
        if(!empty($_GET["password"])){
            $password = password_hash($_GET["password"],PASSWORD_DEFAULT); // Password of user
        } else{
            errorWrite($version,"No password given");
        }
        if(!empty($_GET["email"])){
            $email = $_GET["email"];        // Email of user
        } else{
            errorWrite($version,"No email given");
        }
        if(!empty($_GET["admin"])){
            $admin = $_GET["admin"];        // 000 | 100 wiki | 010 blog | 001 calendar
        } else{
            errorWrite($version,"Admin privilliges not defined");
        }
        if(!empty($_GET["endUser"])){
            $endUser = $_GET["endUser"];    // 000 | 100 wiki | 010 blog | 001 calendar
        } else{
            errorWrite($version,"End user privilliges not defined");
        }
        if(!empty($_GET["description"])){
            $description = $_GET["description"];
        } else{
            $description = "Hello!";
        }
        if(!empty($_GET["avatar"])){
            $avatar = $_GET["avatar"];
        } else{
            $avatar = "unset";
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
                errorWrite($version,"You are not allowed to make a user for a platform you are not admin on");
            }
            // Checks so the user is allowed to make a admin
            if($admin[$i] == "1" && $res["admin"][$i] != "1"){
                errorWrite($version,"You are not allowed to make a admin for a platform you are not admin on");
            }
        }
        /*---------------------------------------------
                    Check If username is in use
        ---------------------------------------------*/
        $stmt = $conn->prepare("SELECT * FROM user WHERE name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){ 
            errorWrite($version,"Username already in use");
        } else{
            /*---------------------------------------------
                    If its not in use insert the user
            ---------------------------------------------*/
            $stmt = $conn->prepare("INSERT INTO user (name,password,email,admin,endUser,description,avatar) values(?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssss", $username,$password,$email,$admin,$endUser,$description,$avatar);
            $stmt->execute();

            if ($endUser[1] == "1") {       //creates blog for user if user in blog
                $date = date("Y/m/d H:i:s");
                $title = "No Title";
                $content = "No content";  // sets variables

                $stmt = $conn->prepare("SELECT ID FROM user WHERE name = ? AND password = ?");
                $stmt->bind_param("ss", $username, $password);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $res = [];
                    while($row = $result->fetch_assoc()) {          //gets which ID the new user has
                        $res[] = $row;
                    }
                } 
                else {
                    errorWrite($version,"No blogs found");
                }
                $usID = $res[0];

                $stmt = $conn->prepare("INSERT INTO blog(title,description,date,uID) VALUES (?,?,?,?)"); //creates the blog for the new user
                $stmt->bind_param("sssi", $title, $content, $date, $usID["ID"]);   
                $stmt->execute();    
            } else{
                $stmt = $conn->prepare("SELECT ID FROM user WHERE name = ? AND password = ?");
                $stmt->bind_param("ss", $username, $password);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $res = [];
                    while($row = $result->fetch_assoc()) {          //gets which ID the new user has
                        $res[] = $row;
                    }
                } 
                $usID = $res[0];
            }
            
            $data = ["Result"=>"User was added successfully","uID"=>$usID];
            jsonWrite($version, $data);
        }
    }
    else{
        errorWrite($version,"Not an Admin");
    }
?>
