<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");


    /*---------------------------------------
                Gets the data
    ----------------------------------------*/

        $suID = 0;
        $eID = 0;

        if(!empty($_GET['eID'])){
            $eID = $_GET['eID'];
        }
        if(!empty($_GET['duID'])){
            $duID = $_GET['duID'];
        }
        


    #

    /*---------------------------------------
        Deleteng entries and blogs
    ----------------------------------------*/

        if ($res["userType"] == "endUser"){
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
        else if ($res["userType"] == "admin"){
            if ($duID != 0){
                $stmt = $conn->prepare("DELETE FROM blog WHERE blog.ID = ?"); // deletes blogs by specific id
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
            errorWrite($version,"No user");
        }
        

    #


    // ?eID=x
    // ?bID=x
?>

