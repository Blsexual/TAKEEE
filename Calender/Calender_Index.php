<?php
    // require_once("../db.php");
?>

<?php
    $Login = array();
    if((isset($_GET['LoginNamn'])) && (isset($_GET['LoginPassword']))){
        array_push($Login,$_GET['LoginNamn']);
        array_push($Login,$_GET['LoginPassword']);
        echo json_encode($Login);
    }
    else{
        echo "Fuck you";
    }
    
?>