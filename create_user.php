<?php
// Create users

//?username=?&password=?&email=?&admin=?&endUser=?&desc=optional&avatar=optional


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
    
    $res = checkToken($token,$uID,"010",$version,$conn);

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
            $admin = $_GET["admin"];        // 000 | 100 wiki | 010 blog | 001 calender
        } else{
            errorWrite($version,"Admin privilliges not defined");
        }
        if(!empty($_GET["endUser"])){
            $endUser = $_GET["endUser"];    // 000 | 100 wiki | 010 blog | 001 calender
        } else{
            errorWrite($version,"End user privilliges not defined");
        }
        if(!empty($_GET["desc"])){
            $description = $_GET["desc"];
        } else{
            $description = "Hello!";
        }
        if(!empty($_GET["avatar"])){
            $avatar = $_GET["avatar"];
        } else{
            $avatar = "unset";
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

            if ($endUser == "010"||$endUser == "110"||$endUser == "011"||$endUser == "111") {       //creates blog for user if user in blog
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
                print_r($usID["ID"]);


                $stmt = $conn->prepare("INSERT INTO blog(title,description,date,uID) VALUES (?,?,?,?)"); //creates the blog for the new user
                $stmt->bind_param("sssi", $title, $content, $date, $usID["ID"]);   
                $stmt->execute();    
            }
            $data = ["Result"=>"User was added successfully"];
            jsonWrite($version, $data);
        }
    }
    else{
        errorWrite($version,"Not a Admin");
    }
?>