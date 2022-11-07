<?php
/*-----------------------------------------------------------
        Variabels
-----------------------------------------------------------*/
    if(!empty($_GET["wID"])){
        $wiki = $_GET["wID"];          // wiki = wiki ID
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

    $todayDate = date("Y-m-d h:i:s");

/*-----------------------------------------------------------
        Connection
-----------------------------------------------------------*/
    $stmt = $conn->prepare("SELECT ID FROM wiki WHERE ID = ?");
    $stmt->bind_param("i", $wiki);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $result = $result->fetch_assoc();

    if(!$result){
        errorWrite($version,"The Wiki dont exist");
    }

    $stmt = $conn->prepare("INSERT INTO wiki_entry (wID,uID) VALUES(?,?)");
    $stmt->bind_param("ii", $wiki,$user);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt = $conn->prepare("SELECT MAX(ID) AS ID FROM wiki_entry WHERE uID = ?");
    $stmt->bind_param("i", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();

    $stmt = $conn->prepare("INSERT INTO wiki_entry_history (oID,uID,title,contents,date) VALUES(?,?,?,?,?)");
    $stmt->bind_param("iisss", $result["ID"],$uID,$title,$contents,$todayDate);
    $stmt->execute();
    $data = ["Result"=>"Page created successfully"];
    jsonWrite($version,$data);

    
?>
