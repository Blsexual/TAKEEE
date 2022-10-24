<?php
    require_once("db.php");
    require_once("json_exempel.php");

    if(!empty($_GET["username"])){
        $username = $_GET["username"];
    } else{
        errorWrite($version,"No username given");
    }
    if(!empty($_GET["password"])){
        $password = password_hash($_GET["password"],PASSWORD_DEFAULT);
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
        errorWrite($version,"Admin privilliges not defined");
    }
    if(!empty($_GET["endUser"])){
        $endUser = $_GET["endUser"];
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

    $stmt = $conn->prepare("SELECT * FROM user WHERE name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        errorWrite($version,"Username already in use");
    } else{
        $stmt = $conn->prepare("INSERT INTO user (name,password,email,admin,endUser,description,avatar) values(?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssss", $username,$password,$email,$admin,$endUser,$description,$avatar);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = ["Result"=>"User was added successfully"];
        jsonWrite($version, $data);
    }

?>