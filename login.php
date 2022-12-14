<?php
    require_once("db.php");
    require_once("json_exempel.php");


/*-----------------------------------------------------------
        Get Input
-----------------------------------------------------------*/

    if(!empty($_GET["username"])){
        $username = $_GET["username"];
    } else{
        errorWrite($version,"No username was given");
    }
    
    if(!empty($_GET["password"])){
        $pass = $_GET["password"];
    } else{
        errorWrite($version,"No password was given");
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
                $data = ["Result"=>"Log in succsess","uID"=>$row["ID"], "Token"=>$token];
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