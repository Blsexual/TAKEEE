<?php 
    require_once("../db.php");
    $data = [];
    $type = "";
    $version = "0.1.0";


    if(!empty($_GET["username"])){
        $username = $_GET["username"];
    } else{
        $data = ["error"=>"no username was given"];
        $type = "error";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    }
    
    if(!empty($_GET["pass"])){
        $pass = $_GET["pass"];
    } else{
        $data = ["error"=>"no password was given"];
        $type = "error";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    }
    

    $sql = "SELECT * FROM user WHERE name = $username";
    $result = $conn->query($sql);

    $userA = [];
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($userA,$row);
        }
    } else{
        $data = ["error"=>"wrong username or password was given"];
        $type = "error";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    }

    foreach ($userA as $ua) {
        if(password_verify($pass, $ua["password"])){
            $_SESSION["user"] = $ua["ID"];
            $data = ["login"=>1];
            $type = "ok";
            $return = ["version"=>$version,"type"=>$type,"data"=>$data];
            die(json_encode($return));
        }
    }
    $data = ["error"=>"wrong username or password was given"];
    $type = "error";
    $return = ["version"=>$version,"type"=>$type,"data"=>$data];
    die(json_encode($return));
?>