<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");


    /*---------------------------------------
                Gets the data
    ----------------------------------------*/

        $suID = 0;
        $eID = 0;
        $cID = 0;
        $fID = $uID;
        

        if(!empty($_GET['eID'])){
            $eID = $_GET['eID'];
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
                $lock= $row["locked"];
            }
        } 

        $stmt = $conn->prepare("SELECT blog_entry.uID FROM blog_entry WHERE ID = ?");  //gets if the user is locked
        $stmt->bind_param("i", $eID);   
        $stmt->execute(); 
        $result = $stmt->get_result(); 

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {    
                $cID= $row["uID"];
            }
        } 
      

    #

    /*---------------------------------------
        Deleteng entries and blogs
    ----------------------------------------*/

        if ($res["userType"] == "endUser"){
            if ($lock == 0){
                if ($eID != 0){
                    if ($cID == $uID){
                        $stmt = $conn->prepare("DELETE FROM blog_entry WHERE blog_entry.ID = ? AND blog_entry.uID = ?");  // deletes entries by specific id
                        $stmt->bind_param("ii", $eID, $uID); 
                        $stmt->execute();  
                
                        $data = ["Result"=>"Entry deleted", "eID"=>$eID];
                        jsonWrite($version,$data);  
                    }    
                    else{
                        $data = ["Result"=>"You don't have permission"];
                        jsonWrite($version,$data);
                    }   
                }    
                else{
                    errorWrite($version,"Wrong inputs");
                }
            }
            else{
                $data = ["Result"=>"you are locked"];
                jsonWrite($version,$data); 
            }
        }
        else if ($res["userType"] == "admin"){
            if ($lock == 0){
                if ($euID != 0){    
                    $stmt = $conn->prepare("DELETE FROM blog WHERE blog.uID = ?"); // deletes blogs by specific id
                    $stmt->bind_param("i", $euID); 
                    $stmt->execute(); 

                    $stmt = $conn->prepare("DELETE FROM blog_entry WHERE blog_entry.uID = ?"); // deletes entries from the blog when deleted
                    $stmt->bind_param("i", $euID); 
                    $stmt->execute(); 
                    
                    $data = ["Result"=>"Blog deleted", "eID"=>$eID];
                    jsonWrite($version,$data);   
                }
                else{
                    errorWrite($version,"Wrong inputs");
                }
            if ($euID != 0){    
                $stmt = $conn->prepare("DELETE FROM blog WHERE blog.uID = ?"); // deletes blogs by specific id
                $stmt->bind_param("i", $euID); 
                $stmt->execute(); 

                $stmt = $conn->prepare("DELETE FROM blog_entry WHERE blog_entry.uID = ?"); // deletes entries from the blog when deleted
                $stmt->bind_param("i", $euID); 
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
    // ?euID=x
?>

