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
                $del = "DELETE FROM blog_entry WHERE blog_entry.ID = $eID ";  // deletes entries by specific id
                $conn->query($del);
                $data = ["Action"=>"Entry deleted"];
                jsonWrite($version,$data);
            }
            else{
                errorWrite($version,"Wrong inputs");
            }
        }
        else if ($res["UserType"] == "admin"){
            if ($bID != 0){
                $del = "DELETE FROM blog WHERE blog.ID = $bID ";   // deletes blogs by specific id
                $conn->query($del);
                $del = "DELETE FROM blog_entry WHERE blog_entry.ID = $bID ";   // Fix this
                $conn->query($del);
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

