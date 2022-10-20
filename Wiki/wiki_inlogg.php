<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
?>

<?php 
    $data = [];
    $type = "";

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
                $_SESSION["user"] = $row["ID"];
    
                // JSON Return
                $data = ["Action"=>"Log in succsess","User"=>$row];
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
