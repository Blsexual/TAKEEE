
<?php
    require_once("../db.php");

    

    if ($eid != NULL){
        $eid = $_GET ["eid"];

        $del = "DELETE FROM blog_entry WHERE blog_entry.ID = $eid ";  // deletes entries by specific id
        $conn->query($del);
    }
    else{
        $bid = $_GET ["bid"];

        $del = "DELETE FROM blog WHERE blog.ID = $bid ";   // deletes blogs by specific id
        $conn->query($del);
    }


    






    // ?eid=x
    // ?bid=x
?>

