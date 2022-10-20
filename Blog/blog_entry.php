
<?php
    require_once("../db.php");
    $version = "0.1.1";

    /*---------------------------------------
         creating new entries and blogs
    ----------------------------------------*/

    $title = "No Title";
    $content = "No content";  // sets base variables
    $bid = 0;
    $uid = 0;

    
    if(!empty($_GET['title'])){
        $title = $_GET['title'];
    }
    
    if(!empty($_GET['content'])){
        $content = $_GET['content'];
    }
    
    if(!empty($_GET['bid'])){
        $bid = $_GET['bid'];
    }
 
    if(!empty($_GET['uid'])){
        $uid = $_GET['uid'];
    }

    $date = date("Y/m/d");


    if ($bid != 0){
      $makeentry = "INSERT INTO blog_entry(title,contents,date,bID,uID) VALUES ('$title','$content','$date','$bid','$uid')";       //creates the new entries
      $result = $conn->query($makeentry); 
      $type = "ok";
      $dataB = array("entry created");
      $return = ["Version"=>$version,"Type"=>$type,"Blogg"=>$dataB];
      echo json_encode($return);  
    }
    else if($bid == 0){
      $makeblog = "INSERT INTO blog(title,description,date,uID) VALUES ('$title','$content','$date','$uid')";       //creates the new blogs
      $result = $conn->query($makeblog); 
      echo "test";
      $type = "ok";
      $dataB = array("Blog created");
      $return = ["Version"=>$version,"Type"=>$type,"Blogg"=>$dataB];
      echo json_encode($return);
    }
    else{
      $type = "Error";
      $dataB = array("wrong inputs");             //error output
      $return = ["Version"=>$version,"Type"=>$type,"Blogg"=>$dataB];
      die(json_encode($return));
    }
     
    //   ?title=x&content=x&uid=x

    //header("location: blog_db.php");  // go back to info site
    


?>