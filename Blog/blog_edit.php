<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");


    /*---------------------------------------
                Gets the data
    ----------------------------------------*/

        $eID = 0;
        $title = 0;
        $content = 0;


        if(!empty($_GET['eID'])){
            $eID = $_GET['eID'];
        }
        

        $stmt = $conn->prepare("SELECT locked FROM user WHERE ID = ?");  //gets if the user is locked
        $stmt->bind_param("i", $uID);   
        $stmt->execute(); 
        $result = $stmt->get_result(); 

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {    
                $lock= $row["locked"];
            }
        } 
    #

    /*---------------------------------------
        getting the old title and content
    ----------------------------------------*/


        if($eID != 0){
            
            $stmt = $conn->prepare("SELECT title,contents FROM blog_entry WHERE blog_entry.ID = ?");
            $stmt->bind_param("i", $eID); 
            $stmt->execute();  
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {              // gets old title and content for entry
                    $title = $row["title"];
                    $content = $row["contents"];
                }
            } 
            else {
                errorWrite($version,"No blog entrys found");
            }

        }

        if($eID == 0){
            $stmt = $conn->prepare("SELECT title,description FROM blog WHERE blog.uID = ?");
            $stmt->bind_param("i", $uID); 
            $stmt->execute();  
            $result = $stmt->get_result();

            

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {          // gets old title and content for blog
                    $title = $row["title"];
                    $content = $row["description"];

                }
            } 
            else {
                errorWrite($version,"No blogs found");
            }

        }
    #

    /*---------------------------------------
        updating entries and blogs
    ----------------------------------------*/



        if(!empty($_GET['title'])){     //gets the new content and title
            $title = $_GET['title'];
        }
        
        if(!empty($_GET['content'])){
            $content = $_GET['content'];
        }


        if ($lock == 0){
            if ($eID != 0){
                $stmt = $conn->prepare("UPDATE blog_entry SET title = ?, contents = ? WHERE blog_entry.ID = ? "); // updates entries
                $stmt->bind_param("ssi", $title, $content, $eID); 
                $stmt->execute();  
                $data = ["Result"=>"Entry Updated"];
                
                $stmt = $conn->prepare("SELECT `title`,`contents` FROM blog_entry WHERE blog_entry.ID = ? "); // gets new title and content for entry
                $stmt->bind_param("i", $eID); 
                $stmt->execute();  
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {              // gets old title and content for entry
                        $data = ["Result"=>"Blog updated", "Title"=>$row['title'], "Content"=>$row['contents']];
                    }
                } 
                jsonWrite($version,$data);
            }
            else if ($eID == 0){
                $stmt = $conn->prepare("UPDATE blog SET title = ?, description = ? WHERE blog.uID = ? "); // updates blogs
                $stmt->bind_param("ssi", $title, $content, $uID); 
                $stmt->execute(); 
                $data = ["Result"=>"Blog updated"];

                $stmt = $conn->prepare("SELECT `title`,`description` FROM blog WHERE blog.uID = ? "); // gets new title and content for blog
                $stmt->bind_param("i", $uID); 
                $stmt->execute();  
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {              // gets old title and content for entry
                        $data = ["Result"=>"Blog updated", "Title"=>$row['title'], "Description"=>$row['description']];
                    }
                }
                jsonWrite($version,$data);
            }
            else{
                errorWrite($version,"Wrong inputs");
            }
        }
        else{
            $data = ["Result"=>"User is locked"];
            jsonWrite($version,$data); 
        }
        

        
       
    #

?>

