<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");

    $res = checkToken($token,$uID,"010",$version, $conn);       // får tag om man är admin eller slutanvändare

    /*---------------------------------------
                Gets the data
    ----------------------------------------*/

        $title = "No Title";
        $content = "No content";  // sets base variables
        $bID = 0;
        $uID = 0;
        $token = "";

        if(!empty($_GET['title'])){
            $title = $_GET['title'];
        }
        
        if(!empty($_GET['content'])){
            $content = $_GET['content'];
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
        
        $date = date("Y/m/d H:i:s");

    #

    /*---------------------------------------
        creating new entries and blogs
    ----------------------------------------*/

    if ($res["UserType"] == "admin"){
        if($bID != 0){
            $stmt = $conn->prepare("SELECT `ID` FROM `Blog` WHERE `ID`=?");
            $stmt->bind_param("i", $bID);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows == 0) {           
                errorWrite($version,"Could not find Blog");
            }
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO blog_entry(title,contents,date,bID,uID) VALUES (?,?,?,?,?)");  //creates the new entries
            $stmt->bind_param("sssii", $title, $content, $date, $bID, $uID);   
            $stmt->execute();    

            $data = ["Action"=>"Entry created"];
            jsonWrite($version,$data);
        }
    }
    else if($res["UserType"] == "admin"){
        if($bID == 0){
            $stmt = $conn->prepare("INSERT INTO blog(title,description,date,uID) VALUES (?,?,?,?)"); //creates the new blogs
            $stmt->bind_param("sssi", $title, $content, $date, $uID);   
            $stmt->execute();         

            $data = ["Action"=>"Entry created"];
            jsonWrite($version,$data);
        }
        else{
            errorWrite($version,"Wrong inputs");
        }
    } 
    else{
        errorWrite($version,"no user");
    }


#
//   ?title=x&content=x&uID=x
?>