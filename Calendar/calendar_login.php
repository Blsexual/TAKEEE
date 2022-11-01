<?php 
/*-----------------------------------------------------------
        Get Input
-----------------------------------------------------------*/

    if(!empty($_GET["username"])){
        $username = $_GET["username"];
    } else{
        errorWrite($version, "No username was given");
    }
    
    if(!empty($_GET["password"])){
        $pass = $_GET["password"];
    } else{
        errorWrite($version, "No password was given");
    }
    
/*-----------------------------------------------------------
        Connect
-----------------------------------------------------------*/
    $sql = "SELECT * FROM user WHERE name = '$username'";
    $result = $conn->query($sql);

    $userA = [];
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if((password_verify($pass, $row['password']) && $row['endUser'][2] == "1") || (password_verify($pass, $row['password']) && $row['admin'][2] == "1")){
                $token = bin2hex(random_bytes(20));

                $date = date("Y-m-d H:i:s", mktime(date("H"), date("i")+30, 00, date("m"), date("d"), date("Y")));
                $uID = $row['ID'];
                $sql = "UPDATE user SET token = '$token', validUntil = '$date'  WHERE ID = $uID";

                $conn->query($sql);

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
