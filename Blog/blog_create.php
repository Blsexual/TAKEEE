<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");


    /*---------------------------------------
                Gets the data
    ----------------------------------------*/

        $title = "No Title";
        $content = "No content"; 
        $euID = 0;
        $fID = $uID;                  // sets base variables
        $date = date("Y/m/d H:i:s");

        if(!empty($_GET['title'])){
            $title = $_GET['title'];
        }
        elseif((empty($_GET['title'])) && ($res["userType"] == "endUser")){
            errorWrite($version,"Must set a title");
        }
        
        if(!empty($_GET['content'])){
            $content = $_GET['content'];
        }
        elseif((empty($_GET['content'])) && ($res["userType"] == "endUser")){
            errorWrite($version,"Must set a content");
        }

        if(!empty($_GET['euID'])){
            $euID = $_GET['euID'];
            $fID = $_GET['euID'];
        }


        $stmt = $conn->prepare("SELECT locked FROM user WHERE ID = ?");  //gets if the user is locked
        $stmt->bind_param("i", $fID);   
        $stmt->execute(); 
        $result = $stmt->get_result(); 

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {    
                $lock = $row["locked"];
            }
        } 

    #

    /*---------------------------------------
        creating new entries and blogs
    ----------------------------------------*/

        if($res["userType"] == "endUser"){
            if($lock == 0){
                $stmt = $conn->prepare("INSERT INTO blog_entry(title,contents,date,uID) VALUES (?,?,?,?)");  //creates the new entries
                $stmt->bind_param("sssi", $title, $content, $date, $uID);   
                $stmt->execute();    
                $last_id = $conn->insert_id;
    
                $data = ["Result"=>"Entry created", "eID"=>$last_id];
                jsonWrite($version,$data);
            }
            else{
                $data = ["Result"=>"You are locked"];
                jsonWrite($version,$data);
            }
        }
        if($res["userType"] == "admin"){                     
            if ($euID != 0){
                $stmt = $conn->prepare("SELECT uID FROM blog WHERE uID = ?"); //creates the new blogs
                $stmt->bind_param("s", $euID);
                $stmt->execute();
                $result = $stmt->get_result();  

                if ($result->num_rows > 0) {
                    errorWrite($version,"User already has a blog ");                // if user allready has a blog
                } 
                else{
                    $stmt = $conn->prepare("INSERT INTO blog(title,description,date,uID) VALUES (?,?,?,?)");
                    $stmt->bind_param("sssi", $title, $content, $date, $euID);
                    $stmt->execute();  
                    $last_id = $conn->insert_id;
                }
                
                $data = ["Result"=>"Blog created", "bID"=>$last_id];
                jsonWrite($version,$data);
            }
            else{
                errorWrite($version,"Need a user ID for the new blog");
            }
        }
        errorWrite($version,"No user");
    #
//   ?title=x&content=x&uID=x
?>