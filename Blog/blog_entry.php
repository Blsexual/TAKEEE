
<?php
    require_once("../db.php");



    $title = $_GET["title"];
    $content = $_GET["content"];
    $date = date("y/m/d");

    $howaboutno = "INSERT INTO blog_entry(title,contents,date) VALUES ('$title','$content','$date')";
    $result = $conn->query($howaboutno);



    
    header("location: blog_db.php");
    


?>