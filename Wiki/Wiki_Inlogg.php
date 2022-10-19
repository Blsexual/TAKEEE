<?php 
    require_once("../db.php");
    $data = [];
    $type = "";
    $version = "0.1.0";

/*-----------------------------------------------------------
        Get Input
-----------------------------------------------------------*/

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
    
/*-----------------------------------------------------------
        Connect
-----------------------------------------------------------*/

    $sql = "SELECT * FROM user WHERE name = $username";
    $result = $conn->query($sql);

    $userA = [];
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($userA,$row);
        }
    } else{ // No username match the one that has been inputed 
        // JSON Return
        $data = ["error"=>"wrong username or password was given"];
        $type = "error";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    }

    foreach ($userA as $ua) {   // Check if the password matches
        if(password_verify($pass, $ua["password"])){
            $_SESSION["user"] = $ua["ID"];

            // JSON Return
            $data = ["login"=>1];
            $type = "ok";
            $return = ["version"=>$version,"type"=>$type,"data"=>$data];
            die(json_encode($return));  // Die because I dont want the rest to run if it has logged in
        }
    }
    // JSON Return
    $data = ["error"=>"wrong username or password was given"];
    $type = "error";
    $return = ["version"=>$version,"type"=>$type,"data"=>$data];
    die(json_encode($return));
?>