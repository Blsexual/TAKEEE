<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
?>

<?php
    /*----------------------------------
        Variables
    ----------------------------------*/
    $ID = $_REQUEST['ID'];
    if (empty($_GET)){
        errorWrite($version,"No ID was given");
    }

    $stmt = $conn->prepare("SELECT * FROM wiki_entry where (ID) = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();

    $emparray = [];
    /*----------------------------------
        Fetch data
    ----------------------------------*/
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $emparray[] = $row;
        }
    } else{
        errorWrite($version,"We could not find the page you were looking for");
    }
    
    $sql = "SELECT MAX(editDate) AS editDate,title,contents,date,wID,oID,uID,ID FROM wiki_entry_history where (oID) = $ID";
    $result = mysqli_query($conn, $sql);

    $test = [];
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $test[] = $row;
        }
    } else{
        $data = ["Wiki entry"=>$emparray];
        jsonWrite($version,$data);
    }
    $data = ["Wiki entry"=>$test];
    jsonWrite($version,$data);
    
    
?>
