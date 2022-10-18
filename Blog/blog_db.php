
<?php

    require_once("../db.php");

    $bid = $_GET["bid"];


    /*---------------------------------------
                      Blogs
    ----------------------------------------*/

    $howaboutno = "SELECT * FROM blog WHERE blog.ID = '$bid'";
    $result = $conn->query($howaboutno);


    $entries = array();
    echo "<br>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {  //shows all the possible blogs
            $bloggs = array("Blogg"=>$row,"Blogg Posts"=>$entries);
        }
    } 
    else {
        $ohno = array("error=>no blog found");
        echo json_encode($ohno);
    }
    
    /*---------------------------------------
    Blog entries
    ----------------------------------------*/
    
    
    $entry = "SELECT blog_entry.title,blog_entry.contents FROM blog_entry INNER JOIN blog ON blog.ID = '$bid' AND blog_entry.bID = '$bid'";
    $result = $conn->query($entry);
    
    echo "<br>";
    echo "<br>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {  //shows all the entries
            array_push($entries,$row);
        }
    } else {
        $ohno = array("error=>no entries found");
        echo json_encode($ohno);
    }
    echo json_encode($bloggs);

?>