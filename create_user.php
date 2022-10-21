<?php
    require_once("db.php");
    require_once("../json_exempel.php");

    if(!empty($_GET["username"])){
        $username = $_GET["username"];
    } else{
        errorWrite($version,"");
    }
    if(!empty($_GET["password"])){
        $password = $_GET["password"];
    }
    if(!empty($_GET["email"])){
        $email = $_GET["email"];
    }
    if(!empty($_GET["admin"])){
        $admin = $_GET["admin"];
    }
    if(!empty($_GET["endUser"])){
        $endUser = $_GET["endUser"];
    }
?>