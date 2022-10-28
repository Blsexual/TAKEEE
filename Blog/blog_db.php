<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    
    $uID = 0;

    if(!empty($_GET['uID'])){
        $uID = $_GET["uID"];
    }
    

    /*---------------------------------------
                    Blogs
    ----------------------------------------*/

        if ($uID == -1){
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
            errorWrite($version,"No blogs found");
        }
    #
    
    /*---------------------------------------
                blog entries
    ----------------------------------------*/

        if ($uID == -1){
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