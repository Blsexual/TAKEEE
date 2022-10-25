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

        if ($bID == -1){
            $selectBlog = "SELECT * FROM blog";
            $result = $conn->query($selectBlog);
        }
        else{
            $stmt = $conn->prepare("SELECT * FROM blog WHERE blog.ID = ?");
            $stmt->bind_param("i", $bID); 
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

        if ($bID == -1){
            $data = ["Blog"=>$bloggList];
            jsonWrite($version,$data); 
        }
        else{
            $stmt = $conn->prepare("SELECT blog_entry.title,blog_entry.contents FROM blog_entry INNER JOIN blog ON blog.ID = ? AND blog_entry.bID = ?");
            $stmt->bind_param("ii", $bID, $bID); 
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