<?php
/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/
    $wiki = $_GET["wiki"];          // wiki = wiki ID
    $title = $_GET["title"];
    $contents = $_GET["contents"];  // html?
    $user = $_GET["uID"];
    $token = $_GET["token"];

    $date = getdate();              // get the date in a array 
    $todayDate = $date["year"]."-".$date["mon"]."-".$date["mday"];      // Creates a date variable the database can handle (yyyy-mm-dd)

/*-----------------------------------------------------------
        Connection
-----------------------------------------------------------*/
    $stmt = $conn->prepare("INSERT INTO wiki_entry (wID,uID,title,contents,date) VALUES(?,?,?,?,?)");
    $stmt->bind_param("iisss", $wiki,$date,$user,$title,$contents,$todayDate);
    $stmt->execute();
    $result = $stmt->get_result();
    
?>
