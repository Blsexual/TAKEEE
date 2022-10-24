<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
?>

<?php
    /*----------------------------------
        Variables
    ----------------------------------*/
        $ID = $_REQUEST["ID"];
        if (empty($_GET)){
            errorWrite($version,"Wrong username or password was given");
        }
    #

    $sql = "SELECT * FROM wiki where (ID) = $ID";
    $result = mysqli_query($conn, $sql);

    $emparray = [];
    /*----------------------------------
        Fetch data
    ----------------------------------*/
    while ($row = mysqli_fetch_assoc($result)){
        $emparray[] = $row;
    }

    $sql = "SELECT * FROM wiki_entry where (wID) = $ID";
    $result = mysqli_query($conn, $sql);
    
    /*----------------------------------
        Fetch entries
    ----------------------------------*/
    $entryArray =[];
    while ($row = mysqli_fetch_assoc($result)){
        $entryArray[] = $row;
    }
    $data = ["wiki"=>$emparray, "wiki_entry"=>$entryArray];
    jsonWrite($version,$data);
?>
