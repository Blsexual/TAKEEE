<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");

    /*-----------------------------------------------------------
            Variabels
    -----------------------------------------------------------*/
    if (isset($_GET['uID'])){ // user id
        $uID = $_GET["uID"];
    }
    if (empty($uID)){
        errorWrite($version,"No content was found");
    }
	if (isset($_GET['contents'])){ // contents
        $contents = $_GET["contents"];
    }
    if (empty($contents)){
        errorWrite($version,"No content was found");
    }
    if (isset($_GET['title'])){ // title
        $title = $_GET["title"];
    }
    if (empty($title)){
        errorWrite($version,"No title was found");
    }
    $private = 0;
	if (!empty($_GET['private'])){
        $private = $_GET["private"]; // 0 = public 1 = private
    }

	
    $adminCheck = checkToken($token, $uID, "100", $version, $conn);

    if ($adminCheck["userType"] != "admin"){ // Check if admin is true for user
        errorWrite($version,"You are not allowed to create this wiki");
    }

    $date = getdate();              // get the date in a array 
    $todayDate = $date["year"]."-".$date["mon"]."-".$date["mday"]." ".$date['hours'].":".$date['minutes'].":".$date['seconds'];      // Creates a date variable the database can handle (yyyy-mm-dd)

    $int = $uID;
    $stmt = $conn->prepare("INSERT INTO wiki (uID,title,wikiIndex,private) VALUES(?,?,?,?)");
    $stmt->bind_param("isii", $uID, $title, $int, $private);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT ID FROM wiki");
    $stmt->execute();
    $resultID = $stmt->get_result();

    $wikiID = 0;
    if ($resultID->num_rows > 0) {
        while ($row = $resultID->fetch_assoc()){
            if ((int)$row['ID'] > (int)$wikiID){
                (int)$wikiID = (int)$row['ID'];
            }
        }
    }

    $stmt = $conn->prepare("INSERT INTO wiki_entry (wID,uID) VALUES (?,?)");
    $stmt->bind_param("ii", $wikiID, $uID);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT ID FROM wiki_entry");
    $stmt->execute();
    $resultID = $stmt->get_result();

    $oID = 0;
    if ($resultID->num_rows > 0) {
        while ($row = $resultID->fetch_assoc()){
            if ((int)$row['ID'] > (int)$oID){
                (int)$oID = (int)$row['ID'];
            }
        }
    }

    $stmt = $conn->prepare("INSERT INTO wiki_entry_history (oID,uID,title,contents,date) VALUES(?,?,?,?,?)");
    $stmt->bind_param("iisss", $oID, $uID, $title, $contents, $todayDate);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT ID FROM wiki_entry_history");
    $stmt->execute();
    $resultID = $stmt->get_result();

    $wikiIndex = 0;
    if ($resultID->num_rows > 0) {
        while ($row = $resultID->fetch_assoc()){
            if ((int)$row['ID'] > (int)$wikiIndex){
                (int)$wikiIndex = (int)$row['ID'];
            }
        }
    }

    $stmt = $conn->prepare("UPDATE wiki set wikiIndex = $wikiIndex where ID = $wikiID");
    $stmt->execute();
    $resultHistory = $stmt->get_result();
    /*-----------------------------------------------------------
        Connection
    -----------------------------------------------------------*/

    $data = ["Result"=>"Wiki was created"];
    jsonWrite($version,$data);
?>