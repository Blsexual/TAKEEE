<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");


    /*---------------------------------------
                Gets the data
    ----------------------------------------*/

        $suID = 0;
        $eID = 0;
        $fID = $uID;

        if(!empty($_GET['eID'])){
            $eID = $_GET['eID'];
        }
        if(!empty($_GET['duID'])){
            $duID = $_GET['duID'];
            $fID = $_GET['duID'];
        }


        $stmt = $conn->prepare("SELECT locked FROM user WHERE ID = ?");  //gets if the user is locked
        $stmt->bind_param("i", $fID);   
        $stmt->execute(); 
        $result = $stmt->get_result(); 

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {    
                $lock= $row["locked"];
            }
        } 
        


    #

    /*---------------------------------------
        Deleteng entries and blogs
    ----------------------------------------*/

        if ($res["userType"] == "endUser"){
            if ($lock == 0){
                if ($eID != 0){    
                    $stmt = $conn->prepare("DELETE FROM blog_entry WHERE blog_entry.ID = ? ");  // deletes entries by specific id
                    $stmt->bind_param("i", $eID); 
                    $stmt->execute();  
                    $data = ["Action"=>"Entry deleted"];
                    jsonWrite($version,$data);
                }    
                else{
                    errorWrite($version,"Wrong inputs");
                }
            }
            else{
                $data = ["Blog"=>"you are locked"];
                jsonWrite($version,$data); 
            }
        }
        else if ($res["userType"] == "admin"){
            if ($lock == 0){
                if ($duID != 0){    
                    $stmt = $conn->prepare("DELETE FROM blog WHERE blog.uID = ?"); // deletes blogs by specific id
                    $stmt->bind_param("i", $duID); 
                    $stmt->execute(); 

                    $stmt = $conn->prepare("DELETE FROM blog_entry WHERE blog_entry.uID = ?"); // deletes entries from the blog when deleted
                    $stmt->bind_param("i", $duID); 
                    $stmt->execute(); 
                    
                    $data = ["Action"=>"Blog deleted"];
                    jsonWrite($version,$data);   
                }
                else{
                    errorWrite($version,"Wrong inputs");
                }
            }
            else{
                $data = ["Blog"=>"user is locked"];
                jsonWrite($version,$data); 
            }
            
        }
        else{
            errorWrite($version,"No user");
        }
        

    #


    // ?eID=x
    // ?duID=x
?>

