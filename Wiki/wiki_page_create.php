<?php
/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/
    if(!empty($_GET["wiki"])){
        $wiki = $_GET["wiki"];          // wiki = wiki ID
    }else{
        errorWrite($version,"No wiki was specified");
    }
    if(!empty($_GET["title"])){
        $title = $_GET["title"];
    }else{
        errorWrite($version,"No title was specified");
    }
    if(!empty($_GET["contents"])){
        $contents = $_GET["contents"];  // html?
    }else{
        errorWrite($version,"No contents was specified");
    }
    if(!empty($_GET["uID"])){
        $user = $_GET["uID"];
    }else{
        errorWrite($version,"No user was specified");
    }

    $date = getdate();              // get the date in a array 
    $todayDate = $date["year"]."-".$date["mon"]."-".$date["mday"];      // Creates a date variable the database can handle (yyyy-mm-dd)
/*-----------------------------------------------------------
        Connection
-----------------------------------------------------------*/
    $stmt = $conn->prepare("SELECT ID FROM wiki WHERE ID = ?");
    $stmt->bind_param("i", $wiki);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if(!$result){
        errorWrite($version,"The Wiki dont exist");
    }

    $stmt = $conn->prepare("INSERT INTO wiki_entry (wID,uID) VALUES(?,?)");
    $stmt->bind_param("ii", $wiki,$user);
    $stmt->execute();
    $result = $stmt->get_result();

    if(!$result){
        errorWrite($version,"");
    }

    $stmt = $conn->prepare("SELECT MAX(ID) FROM wiki_entry WHERE uID = ?");
    $stmt->bind_param("i", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result){
        $oID = $resultHistory->fetch_assoc();
    }

    $stmt = $conn->prepare("INSERT INTO wiki_entry_history (oID,title,contents,date) VALUES(?,?,?,?)");
    $stmt->bind_param("isss", $oID,$title,$contents,$todayDate);
    $stmt->execute();
    $result = $stmt->get_result();

    
    $data = ["Result"=>"Page created successfully"];
    jsonWrite($version,$data);
    
    //errorWrite($version,"Bad input")
    
    
?>
