<?php
//  checkToken($token,$uID,$service,$conn)
//  If successfull return as json "UserType"="admin" or "endUser" if unsuccsessful runs errorWrite() with a error message
//  $token      | string    | ex. d801881dccef34fd79f5b5dd1d33699413d4c912
//  $uID     | int       | ex. 1
//  $service    | string    | ex. 100 = wiki, 010 = blog, 001 = calander
//  $version    | string    | ex. 0.1.0
//  $conn       | object    | ex. $conn = new mysqli($servername, $username, $password,$db)
    function checkToken($token,$uID,$service,$version,$conn){
        if(!is_numeric($uID)){ // So $uID dont make error if is string
            errorWrite($version,"Not a valid user");
        }
        if ($token == "test"){ // Temp for testing
            $sql = "SELECT * FROM user WHERE ID = $uID";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $result = $result->fetch_assoc();
                $correctUser = 0;
                $uType = "";
                for($i = 2;$i>=0;--$i){
                    if($result["endUser"][$i] == $service[$i] && $result["admin"][$i] != "0"){
                        $correctUser = 1;
                        $uType = "endUser";
                    }
                    if($result["admin"][$i] == $service[$i] && $result["admin"][$i] != "0"){
                        $correctUser = 1;
                        $uType = "admin";
                    }
                }
                if($correctUser != 1){
                    errorWrite($version,"no user found or token not valid");
                }
            }
            $conn->query($sql);
            $data = ["userType"=>"$uType"];
            return $data;
        }
        $sql = "SELECT * FROM user WHERE ID = $uID AND token = '$token'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $correctUser = 0;
            $uType = "";
            for($i = 2;$i>=0;--$i){
                if($result["endUser"][$i] == $service[$i] && $result["admin"][$i] != "0"){
                    $correctUser = 1;
                    $uType = "endUser";
                }
                if($result["admin"][$i] == $service[$i] && $result["admin"][$i] != "0"){
                    $correctUser = 1;
                    $uType = "admin";
                }
            }
            if($correctUser != 1){
                errorWrite($version,"no user found or token not valid");
            }

            #Checks if the end date is before the start date
                $date = date("Y-m-d H:i:s", mktime(date("H"), date("i"), 00, date("m"), date("d"), date("Y")));
                $pattern = ['/:/i','/-/i','/ /i']; // Removes ":","-" and " "
                $now = preg_replace($pattern, "", $date);
                $tokenEnd = preg_replace($pattern, "", $result["validUntil"]);
                
                $now = (int)$now;
                $tokenEnd = (int)$tokenEnd;

                if($now > $tokenEnd){
                    errorWrite($version,"token not valid");
                } else{
                    $ID = $result["ID"];
                    $date = date("Y-m-d H:i:s", mktime(date("H"), date("i")+30, 00, date("m"), date("d"), date("Y")));
                    $sql = "UPDATE user SET validUntil = '$date' WHERE ID = $ID";

                    $conn->query($sql);
                    $data = ["userType"=>"$uType"];
                    return $data;
                }
            #
        } else{
            errorWrite($version,"no user found or token not valid");
        }
    }
?>