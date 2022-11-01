<?php
    require_once("db.php");
    require_once("json_exempel.php");


/*-----------------------------------------------------------
        Get Input
-----------------------------------------------------------*/

    if(!empty($_GET["username"])){
        $username = $_GET["username"];
    } else{
        errorWrite($version,"no username was given");
    }
    
    if(!empty($_GET["pass"])){
        $pass = $_GET["pass"];
    } else{
        errorWrite($version,"no password was given");
    }
    
/*-----------------------------------------------------------
        Connect
-----------------------------------------------------------*/
    $stmt = $conn->prepare("SELECT * FROM user WHERE name = ?");
    $stmt->bind_param("s", $username); 
    $stmt->execute(); 
    $result = $stmt->get_result();

    $userA = [];
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if(password_verify($pass, $row['password'])){
                $token = bin2hex(random_bytes(20));

                $date = date("Y-m-d H:i:s", mktime(date("H"), date("i")+30, 00, date("m"), date("d"), date("Y")));
                $id = $row['ID'];
                $stmt = $conn->prepare("UPDATE user SET token = ?, validUntil = ?  WHERE ID = ?");
                $stmt->bind_param("ssi", $token, $date, $id); 
                $stmt->execute();

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