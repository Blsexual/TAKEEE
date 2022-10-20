<?php
    require_once("../db.php");
    require_once("../json_exempel.php");

    $bID = 0;

    if(!empty($_GET['bID'])){
        $bID = $_GET["bID"];
    }


    /*---------------------------------------
                    Blogs
    ----------------------------------------*/

    if ($bID == 0){
        $howaboutno = "SELECT * FROM blog";
    }
    else{
        $howaboutno = "SELECT * FROM blog WHERE blog.ID = '$bID'";
    }

    $result = $conn->query($howaboutno);

    if ($result->num_rows > 0) {
        $bloggList = [];
        while($row = $result->fetch_assoc()) {  //shows all the possible blogs
            $bloggList[] = $row;
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
    
    if ($bID != 0){
        $entry = "SELECT blog_entry.title,blog_entry.contents FROM blog_entry INNER JOIN blog ON blog.ID = '$bID' AND blog_entry.bID = '$bID'";
        $result = $conn->query($entry);
        
    
        if ($result->num_rows > 0) {
            $bloggPostList = [];
            while($row = $result->fetch_assoc()) {  //shows all the entries
                $bloggPostList[] = $row;
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