<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    
    /*---------------------------------------
                Gets the data
    ----------------------------------------*/

        if(empty($_GET["uID"])){
            $uID = 0;
        }
        else{
            if(!is_numeric($_GET["uID"])){
                errorWrite($version,"Not a valid uID");
            }
            $uID = $_GET['uID'];
        }

        if ($uID == 0){
            $selectBlog = "SELECT * FROM blog";
            $result = $conn->query($selectBlog);
            if ($result->num_rows > 0) {
                $bloggList = [];
                while($row = $result->fetch_assoc()) {  //shows all the possible blogs
                    $bloggList[] = $row;
                }
            } 
            $data = ["Blog"=>$bloggList];
            jsonWrite($version,$data); 
        }

        $stmt = $conn->prepare("SELECT locked FROM user WHERE ID = ?");  //gets if the user is locked
        $stmt->bind_param("i", $uID);   
        $stmt->execute(); 
        $result = $stmt->get_result(); 

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {    
                $lock= $row["locked"];
            }
            if ($lock !=0){
                $data = ["Blog"=>"User is locked"];
                jsonWrite($version,$data); 
            }
        } 
        else{
            $data = ["Blog"=>"User does not exist"];
            jsonWrite($version,$data);
        }

    #

    /*---------------------------------------
                    Blogs
    ----------------------------------------*/

        if ($uID == 0){
            $selectBlog = "SELECT * FROM blog";
            $result = $conn->query($selectBlog);
        }
        else{
            $stmt = $conn->prepare("SELECT * FROM blog WHERE blog.uID = ?");
            $stmt->bind_param("i", $uID); 
            $stmt->execute();  
            $result = $stmt->get_result();  
        }

        

        if ($result->num_rows > 0) {
            $bloggList = [];
            while($row = $result->fetch_assoc()) {  //shows all the possible blogs
                $bloggList[] = $row;
            }
        } 
        else {
            $data = ["Blog"=>"No blogs found"];
            jsonWrite($version,$data);
        }
    #
    
    /*---------------------------------------
                blog entries
    ----------------------------------------*/

        if ($uID == 0){
            $data = ["Blog"=>$bloggList];
            jsonWrite($version,$data); 
        }
        else{
            $stmt = $conn->prepare("SELECT blog_entry.title,blog_entry.contents FROM blog_entry INNER JOIN blog ON blog.uID = ? AND blog_entry.uID = ?");
            $stmt->bind_param("ii", $uID, $uID); 
            $stmt->execute();  
            $result = $stmt->get_result();
            
        
            if ($result->num_rows > 0) {
                $bloggPostList = [];
                while($row = $result->fetch_assoc()) {  //shows all the entries
                    $bloggPostList[] = $row;
                }
            } 
            else {
                errorWrite($version,"No blog posts found");
            }

            $data = ["Blog"=>$bloggList,"Blog entry"=>$bloggPostList];
            jsonWrite($version,$data);
        }
    #
?>