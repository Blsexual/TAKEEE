<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");


    /*---------------------------------------
                Gets the data
    ----------------------------------------*/

        $eID = 0;
        $bID = 0;
        $uID = 0;
        $token = "";

        
        if(!empty($_GET['eID'])){
            $eID = $_GET['eID'];
        }
        
        if(!empty($_GET['bID'])){
            $bID = $_GET['bID'];
        }

        if(!empty($_GET['token'])){
            $token = $_GET['token'];
        }

        if(!empty($_GET['uID'])){
            $uID = $_GET['uID'];
        }

        $res = checkToken($token,$uID,"010",$version, $conn);       // gets if you are admin or enduser
    #

    /*---------------------------------------
        Deleteng entries and blogs
    ----------------------------------------*/

        if ($res["UserType"] == "endUser"){
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
        else if ($res["UserType"] == "admin"){
            if ($bID != 0){
                $stmt = $conn->prepare("DELETE FROM blog WHERE blog.ID = ?"); // deletes blogs by specific id
                $stmt->bind_param("i", $bID); 
                $stmt->execute(); 

                $stmt = $conn->prepare("DELETE FROM blog_entry WHERE blog_entry.bID = ?"); // deletes entries from the blog when deleted
                $stmt->bind_param("i", $bID); 
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

