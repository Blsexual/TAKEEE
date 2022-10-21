<?php
//  checkToken($token,$userID,$service,$conn)
//  Returns $data which is a json object with the type "ok" if the user is found and the token is valid or "error" if the user was not found or the token was not valid and a error message
//  $token      | string    | ex. d801881dccef34fd79f5b5dd1d33699413d4c912
//  $userID     | int       | ex. 1
//  $service    | string    | ex. 100 = wiki, 010 = blog, 001 = calander
//  $version    | string    | ex. 0.1.0
//  $conn       | object    | ex. $conn = new mysqli($servername, $username, $password,$db)
    function checkToken($token,$userID,$service,$version,$conn){
        $sql = "SELECT * FROM user WHERE ID = $userID AND token = $token";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();

            #Checks if the end date is before the start date
            $date = date("Y-m-d H:i:s", mktime(date("H"), date("i"), 00, date("m"), date("d"), date("Y")));
            $pattern = ['/:/i','/-/i','/ /i']; //kommentera skiten!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
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
            }
            #
        } else{
            errorWrite($version,"no user found");
        }


    }
?>