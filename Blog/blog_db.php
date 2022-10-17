
<?php

    require_once("../db.php");

    if(isset($_GET)){
        $_SESSION['blogSearch'] = $_GET['blogSearch'];
    }

    $blogname = $_SESSION['blogSearch'];
    echo "<br>";
    $howaboutno = "SELECT * FROM blog WHERE title = '$blogname'";
    $result = $conn->query($howaboutno);


    echo "<br>";
    $bloggs = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($bloggs,$row);
        }
        echo json_encode($bloggs);
      } else {
        echo "0 results";
      }


    $entry = "SELECT * FROM blog_entry";
    $result = $conn->query($entry);


    echo "<br>";
    echo "<br>";
    echo "<br>";
    $entries = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
        array_push($entries,$row);
        }
        echo json_encode($entries);
    } else {
        echo "0 results";
    }

?>