<?php
    require_once("../db.php");
?>

<?php
    $sql = "SELECT `uID`, `title`, `description`, `startDate`, `endDate` FROM `event`";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo json_encode($row);
      }
    } else {
      $Res = array("0 Results");
      echo json_encode($Res);
    }
?>