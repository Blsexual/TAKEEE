<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
?>

<?php
    $eID = 0;
    $bID = 0;

    /*---------------------------------------
        deleteng entries and blogs
    ----------------------------------------*/

    if(!empty($_GET['eID'])){
        $eID = $_GET['eID'];
    }
    
    if(!empty($_GET['bID'])){
        $bID = $_GET['bID'];
    }


    if ($eID != 0){
        $del = "DELETE FROM blog_entry WHERE blog_entry.ID = $eID ";  // deletes entries by specific id
        $conn->query($del);
        $data = ["Result"=>"Entry deleted"];
        jsonWrite($version,$data);
    }
    else if ($bID != 0){
        $del = "DELETE FROM blog WHERE blog.ID = $bID ";   // deletes blogs by specific id
        $conn->query($del);
        $data = ["Result"=>"Blog deleted"];
        jsonWrite($version,$data);
    }
    else{
        errorWrite($version,"Wrong inputs");
    }



    // ?eID=x
    // ?bID=x
?>

