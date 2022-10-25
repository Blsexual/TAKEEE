<?php
// Lets you log in

/*-----------------------------------------------------------
        Imports
-----------------------------------------------------------*/

    require_once("../db.php");
    require_once("../json_exempel.php");

/*-----------------------------------------------------------
        Get Input
-----------------------------------------------------------*/

    if(!empty($_GET["username"])){
        $username = $_GET["username"];
    } else{
        errorWrite($version, "No username was given");
    }
    
    if(!empty($_GET["pass"])){
        $pass = $_GET["pass"];
    } else{
        errorWrite($version, "No password was given");
    }
    
/*-----------------------------------------------------------
        Connect
-----------------------------------------------------------*/
    $stmt = $conn->prepare("SELECT * FROM user WHERE name = '$username'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $userA = [];
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if((password_verify($pass, $row['password']) && $row['endUser'][0] == "1") || (password_verify($pass, $row['password']) && $row['admin'][0] == "1")){
                $token = bin2hex(random_bytes(20));

                $date = date("Y-m-d H:i:s", mktime(date("H"), date("i")+30, 00, date("m"), date("d"), date("Y")));
                $ID = $row['ID'];
                $stmt = $conn->prepare("UPDATE user SET token = '$token', validUntil = '$date'  WHERE ID = $ID");
                $stmt->bind_param("ssi", $token,$date,$ID);
                $stmt->execute();
                $result = $stmt->get_result();

                // JSON Return
                $data = ["Action"=>"Log in succsess","User"=>$row, "Token"=>$token];
                jsonWrite($version,$data);
            }
        }
    } else{ // No username match the one that has been inputed 
        // JSON Return
        errorWrite($version,"Wrong username or password was given");
    }
    // JSON Return
    errorWrite($version,"Wrong username or password was given");
?>
