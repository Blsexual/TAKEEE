<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
?>

<?php
    $eID = 0;
    $bID = 0;
    $title = 0;
    $content = 0;


    if(!empty($_GET['eID'])){
        $eID = $_GET['eID'];
    }
    
    if(!empty($_GET['bID'])){
        $bID = $_GET['bID'];
    }

    /*---------------------------------------
        getting the old title and content
    ----------------------------------------*/


        if($eID != 0){
            $eselect = "SELECT title,contents FROM blog_entry WHERE blog_entry.ID = '$eID'";
            $result = $conn->query($eselect);

            

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {              // gets old title and content for entety
                    $title = $row["title"];
                    $content = $row["contents"];

                }
            } 
            else {
                errorWrite($version,"No blog entrys found");
            }

            echo $title;
            echo $content;
        }

        if($bID != 0){
            $eselect = "SELECT title,description FROM blog WHERE blog.ID = '$bID'";
            $result = $conn->query($eselect);

            

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {          // gets old title and content for blog
                    $title = $row["title"];
                    $content = $row["description"];

                }
            } 
            else {
                errorWrite($version,"No blogs found");
            }

            echo $title;
            echo $content;
        }
    #

    /*---------------------------------------
        updating entries and blogs
    ----------------------------------------*/



        if(!empty($_GET['title'])){     //gets the new content and title
            $title = $_GET['title'];
        }
        
        if(!empty($_GET['content'])){
            $content = $_GET['content'];
        }



        if ($eID != 0){
            $del = "UPDATE blog_entry SET title = '$title', contents = '$content' WHERE blog_entry.ID = $eID ";  // updates entries
            $conn->query($del);
            $data = ["Action"=>"Entry Updated"];
            jsonWrite($version,$data);
        }
        else if ($bID != 0){
            $del = "UPDATE blog SET title = '$title', description = '$content' WHERE blog.ID = $bID ";   // updates blogs
            $conn->query($del);
            $data = ["Action"=>"Blog updated"];
            jsonWrite($version,$data);
        }
        else{
            errorWrite($version,"Wrong inputs");
        }
    #

?>

