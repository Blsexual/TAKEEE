<?php
    require_once("../db.php");

    $ID = $_REQUEST["ID"];

    $sql = "SELECT wiki_entry.title, wiki_entry.contents, wiki_entry.date FROM wiki_entry where (ID) = $ID";
    $result = mysqli_query($conn, $sql);

    $emparray = [];
    while ($row = mysqli_fetch_assoc($result)){
        $emparray[] = $row;
    }

    echo json_encode($emparray);


    //$ID = $_REQUEST["ID"];

    //$stmt = "SELECT wiki_entry.title, wiki_entry.contents, wiki_entry.date FROM wiki_entry where (ID) = $ID";

    //$result = $conn->query($stmt);

    //echo $result;
    //echo json_encode($result);

?>