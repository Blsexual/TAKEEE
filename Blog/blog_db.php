
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

    if ($bid == 0){
        $howaboutno = "SELECT * FROM blog";
    }
    else{
        $howaboutno = "SELECT * FROM blog WHERE blog.ID = '$bid'";
    }

    $result = $conn->query($howaboutno);

    if ($result->num_rows > 0) {
        $bloggList = array();
        while($row = $result->fetch_assoc()) {  //shows all the possible blogs
            array_push($bloggList,$row);
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
    
    if ($bid != 0){
        $entry = "SELECT blog_entry.title,blog_entry.contents FROM blog_entry INNER JOIN blog ON blog.ID = '$bid' AND blog_entry.bID = '$bid'";
        $result = $conn->query($entry);
        
    
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

        $contents = array("Version"=>$version,"Type"=>"Ok","Blogg"=>$bloggList,"Blogg posts"=>$bloggPostList);
    }
    else{
        $contents = array("Version"=>$version,"Type"=>"Ok","Blogg"=>$bloggList);
    }


    
    echo json_encode($contents);

?>