<?php
// Connecting into the database

    session_start();
    //error_reporting(0); //Haha get trolled
    $version = "0.1.5";
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "takeee";

    // Create connection
    $conn = new mysqli($servername, $username, $password,$db);

    // Check connection
    if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}
?>

