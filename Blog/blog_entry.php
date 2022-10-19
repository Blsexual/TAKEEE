
<?php
    require_once("../db.php");

    /*---------------------------------------
              creating new entries
    ----------------------------------------*/

    $title = $_GET["title"];
    $content = $_GET["content"];  // gets the varibales
    $bid = $_GET["bid"];
    $uid = $_GET["uid"];
    $date = date("Y/m/d");

    if ($bid != NULL){
      $makeblog = "INSERT INTO blog_entry(title,contents,date,bID,uID) VALUES ('$title','$content','$date','$bid','$uid')";       //creates the new entries
      $result = $conn->query($makeblog);   
    }
    else{
      $makeentry = "INSERT INTO blog(title,description,date,uID) VALUES ('$title','$content','$date','$uid')";       //creates the new entries
      $result = $conn->query($makeentry); 
    }
     
    //   ?title=x&content=x&uid=x

    //header("location: blog_db.php");  // go back to info site
    


?>