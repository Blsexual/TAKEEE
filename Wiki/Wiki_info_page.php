<?php
    require_once("../db.php");
    $version = "0.0.1"; 
    /*----------------------------------
        Variables
    ----------------------------------*/
    $ID = $_REQUEST["ID"];
    if (empty($_GET)){
        $data = ["error"=>"wrong username or password was given"];
        $type = "error";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    }
    $sql = "SELECT * FROM wiki_entry where (ID) = $ID";
    $result = mysqli_query($conn, $sql);

    $emparray = [];
    /*----------------------------------
        Fetch data
    ----------------------------------*/
    while ($row = mysqli_fetch_assoc($result)){
        $emparray[] = $row;
    }
    $type = "ok";
    $return = ["version"=>$version,"type"=>$type,"data"=>$emparray];
    die(json_encode($return)); // Send data as json
?>