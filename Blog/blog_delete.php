
<?php
    require_once("../db.php");
    $version = "0.1.1";

    $eid = 0;
    $bid = 0;

    if(!empty($_GET['eid'])){
        $eid = $_GET['eid'];
    }
    
    if(!empty($_GET['bid'])){
        $bid = $_GET['bid'];
    }


    if ($eid != 0){
        $del = "DELETE FROM blog_entry WHERE blog_entry.ID = $eid ";  // deletes entries by specific id
        $conn->query($del);
    }
    else if ($bid != 0){
        $del = "DELETE FROM blog WHERE blog.ID = $bid ";   // deletes blogs by specific id
        $conn->query($del);
    }
    else{
        $type = "Error";
        $dataB = array("wrong inputs");
        $return = ["Version"=>$version,"Type"=>$type,"Blogg"=>$dataB];
        die(json_encode($return));
    }



    // ?eid=x
    // ?bid=x
?>

