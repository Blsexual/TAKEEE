<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");


    /*---------------------------------------
                Gets the data
    ----------------------------------------*/

        $title = "No Title";
        $content = "No content"; 
        $duID = 0;                  // sets base variables
        

        if(!empty($_GET['title'])){
            $title = $_GET['title'];
        }
        
        if(!empty($_GET['content'])){
            $content = $_GET['content'];
        }

        if(!empty($_GET['duID'])){
            $duID = $_GET['duID'];
        }


        $date = date("Y/m/d H:i:s");


        $stmt = $conn->prepare("SELECT locked FROM user uID = ?");  //creates the new entries
        $stmt->bind_param("i", $uID);   
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        print_r($result)
    #

    /*---------------------------------------
        creating new entries and blogs
    ----------------------------------------*/

        if ($res["userType"] == "endUser"){
            $stmt = $conn->prepare("INSERT INTO blog_entry(title,contents,date,uID) VALUES (?,?,?,?)");  //creates the new entries
            $stmt->bind_param("sssi", $title, $content, $date, $uID);   
            $stmt->execute();    

            $data = ["Action"=>"Entry created"];
            jsonWrite($version,$data);
        }
        if($res["userType"] == "admin"){
            if ($duID != 0){
                $stmt = $conn->prepare("SELECT uID FROM blog WHERE uID = ?"); //creates the new blogs
                $stmt->bind_param("s", $duID);
                $stmt->execute();
                $result = $stmt->get_result();  

                if ($result->num_rows > 0) {
                    errorWrite($version,"user already has a blog ");
                } 

                else{
                    $stmt = $conn->prepare("INSERT INTO blog(title,description,date,uID) VALUES (?,?,?,?)"); //creates the new blogs
                    $stmt->bind_param("sssi", $title, $content, $date, $duID);
                    $stmt->execute();  
                }
                
                $data = ["Action"=>"Blog created"];
                jsonWrite($version,$data);
            }
            else{
                errorWrite($version,"need a user ID for the new blog");
            }
            
        }


        errorWrite($version,"no user");
    


    #
//   ?title=x&content=x&uID=x
?>