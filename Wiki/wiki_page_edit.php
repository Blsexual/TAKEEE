<?php
/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/
    $wiki = $_GET["wiki"];          // wiki = wiki ID
    $title = $_GET["title"];
    $contents = $_GET["contents"];  // html?
    $page = $_GET["page"];
    $token = $_GET["token"];

    $todayDate = date("Y-m-d h:i:s");
/*-----------------------------------------------------------
        Connection
-----------------------------------------------------------*/
    $stmt = $conn->prepare("SELECT * FROM wiki_entry WHERE ID = ?");
    $stmt->bind_param("i", $page);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {          // output data of each row
            $date = $row;
        }
    } else{

        // JSON Return
        errorWrite($version,"we cant find the page you are looking for");
    }

    $stmt = $conn->prepare("INSERT INTO wiki_entry_history (oID,uID,title,contents,date) VALUES(?,?,?,?,?)");
    $stmt->bind_param("iisss", $page,$uID,$title,$contents,$todayDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = ["Result"=>"Page edited successfully"];
    jsonWrite($version,$data);
    
?>