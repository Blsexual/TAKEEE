<?php
  require_once("../db.php");
  require_once("../json_exempel.php");

  /*---------------------------------------
      creating new entries and blogs
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

  if(!empty($_GET['uID'])){
    $uID = $_GET['uID'];
  }

  $date = date("Y/m/d");
//comment
  if ($bID != 0){
    $makeentry = "INSERT INTO blog_entry(title,contents,date,bID,uID) VALUES ('$title','$content','$date','$bID','$uID')";       //creates the new entries
    $result = $conn->query($makeentry); 
    $type = "ok";
    $dataB = array("entry created");
    $return = ["Version"=>$version,"Type"=>$type,"Blogg"=>$dataB];
    echo json_encode($return);  
  }
  else if($bID == 0){
    $makeblog = "INSERT INTO blog(title,description,date,uID) VALUES ('$title','$content','$date','$uID')";       //creates the new blogs
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
  
  //   ?title=x&content=x&uID=x

  //header("location: blog_db.php");  // go back to info site
  


?>