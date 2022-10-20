<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    /*----------------------------------
        Variables
    ----------------------------------*/
    $ID = $_REQUEST["ID"];
    if (empty($_GET)){
        $data = ["error"=>"No ID was given"];
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
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $emparray[] = $row;
        }
    } else{
        $data = ["error"=>"We could not find the page you are looking for"];
        $type = "error";
        $return = ["version"=>$version,"type"=>$type,"data"=>$data];
        die(json_encode($return));
    }

    $sql = "SELECT MAX(editDate) AS editDate,title,contents,date,wID,oID,uID,ID FROM wiki_entry_history where (oID) = $ID";
    $result = mysqli_query($conn, $sql);

    $test = [];
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $test[] = $row;
        }
    } else{
        $type = "ok";
        $return = ["version"=>$version,"type"=>$type,"data"=>$emparray];
        die(json_encode($return)); // Send data as json
    }
    if($test[0]["ID"] == NULL){
        $type = "ok";
        $return = ["version"=>$version,"type"=>$type,"data"=>$emparray];
        die(json_encode($return)); // Send data as json
    }
    $type = "ok";
        $return = ["version"=>$version,"type"=>$type,"data"=>$test];
        die(json_encode($return)); // Send data as json
    
    
?>
