<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");

    

    /*---------------------------------------
                gets the data
    ----------------------------------------*/

        $title = "No Title";
        $content = "No content";  // sets base variables
        $bID = 0;
        $uID = 0;

        if(!empty($_GET['title'])){
            $title = $_GET['title'];
        }
        
        if(!empty($_GET['content'])){
            $content = $_GET['content'];
        }
        
        if(!empty($_GET['bID'])){
            $bID = $_GET['bID'];
        }

        $token = $_GET['token'];
        $uID = $_GET['uID'];
        

        $date = date("Y/m/d H:i:s");

        checkToken($token,$uID,"010",$version, $conn);
    #

    /*---------------------------------------
        creating new entries and blogs
    ----------------------------------------*/

        if ($bID != 0){
            $makeentry = "INSERT INTO blog_entry(title,contents,date,bID,uID) VALUES ('$title','$content','$date','$bID','$uID')";       //creates the new entries
            $result = $conn->query($makeentry); 
            $data = ["Action"=>"Entry created"];
            jsonWrite($version,$data);
        }
        else if($bID == 0){
            $makeblog = "INSERT INTO blog(title,description,date,uID) VALUES ('$title','$content','$date','$uID')";       //creates the new blogs
            $result = $conn->query($makeblog); 
            $data = ["Action"=>"Blog created"];
            jsonWrite($version,$data);
        }
        else{
            errorWrite($version,"Wrong inputs");
        }
    #
    //   ?title=x&content=x&uID=x
?>