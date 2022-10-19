
<?php
    require_once("../db.php");

    $eid = $_GET ["eid"];
    $bid = $_GET ["bid"];

    if (!empty($eid)){
        $del = "DELETE FROM blog_entry WHERE blog_entry.ID = $eid ";  // deletes entries by specific id
        $conn->query($del);
    }
    else{
        

        $del = "DELETE FROM blog WHERE blog.ID = $bid ";   // deletes blogs by specific id
        $conn->query($del);
    }


    






    // ?eid=x
    // ?bid=x
?>

