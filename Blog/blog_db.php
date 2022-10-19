
<?php

    require_once("../db.php");
    $version = "0.1.1";

    $bid = 0;

    if(!empty($_GET['bid'])){
        $bid = $_GET["bid"];
    }
   

    /*---------------------------------------
                      Blogs
    ----------------------------------------*/

    $howaboutno = "SELECT * FROM blog WHERE blog.ID = '$bid'";
    $result = $conn->query($howaboutno);
    echo "<br>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {  //shows all the possible blogs
            $dataB = array($row);
        }
    } 
    else {
        $type = "Error";
        $dataB = array("No Bloggs found");
        $return = ["Version"=>$version,"Type"=>$type,"Blogg"=>$dataB];
        die(json_encode($return));
    }
    
    /*---------------------------------------
    Blog entries
    ----------------------------------------*/
    
    
    $entry = "SELECT blog_entry.title,blog_entry.contents FROM blog_entry INNER JOIN blog ON blog.ID = '$bid' AND blog_entry.bID = '$bid'";
    $result = $conn->query($entry);
    
    echo "<br>";
    echo "<br>";
    if ($result->num_rows > 0) {
        $bloggPostList = array();
        while($row = $result->fetch_assoc()) {  //shows all the entries
            array_push($bloggPostList,$row);
        }
    } 
    else {
        $type = "Error";
        $dataBP = array("No Blogg posts found");
        $return = ["Version"=>$version,"Type"=>$type,"Blogg"=>$dataBP];
        die(json_encode($return));
    }

    $contents = array("Version"=>$version,"Type"=>"Ok","Blogg"=>$dataB,"Blogg posts"=>$bloggPostList);
    echo json_encode($contents);

?>