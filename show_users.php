<?php
    require_once("db.php");
    require_once("json_exempel.php");

    if(!empty($_GET["uID"])){
        errorWrite($version,"No uID given");
    }
    if(!empty($_GET["token"])){
        errorWrite($version,"No token given");
    }

    $res = checkToken($version,$uID,"111",$version,$conn);

    for($i = 3;$i>=0;--$i){
        
    }

    $stmt = $conn->prepare("SELECT * FROM `user`");
    $stmt->execute();
    $result = $stmt->get_result();

    $emparray = [];
    /*----------------------------------
        Fetch data
    ----------------------------------*/
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()){
            $emparray[] = $row;
        }
    }

    $data = ["Wiki entry"=>$emparray];
    jsonWrite($version,$data); //Output json message with data



?>