<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
?>

<?php 
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
    $sql = "SELECT * FROM user WHERE name = '$username'";
    $result = $conn->query($sql);

    $userA = [];
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if((password_verify($pass, $row['password']) && $row['endUser'][0] == "1") || (password_verify($pass, $row['password']) && $row['admin'][0] == "1")){
                $token = bin2hex(random_bytes(20));

                $date = date("Y-m-d H:i:s", mktime(date("H"), date("i")+30, 00, date("m"), date("d"), date("Y")));
                $id = $row['ID'];
                $sql = "UPDATE user SET token = '$token', validUntil = '$date'  WHERE ID = $id";

                $conn->query($sql);

                // JSON Return
                $data = ["Action"=>"Log in succsess","User"=>$row, "Token"=>$token];
                jsonWrite($version,$data);
            }
        }
    } else{ // No username match the one that has been inputed 
        // JSON Return
        errorWrite($version,"wrong username or password was given");
    }
    // JSON Return
    errorWrite($version,"wrong username or password was given");
?>
