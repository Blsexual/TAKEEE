<?php
    require_once("db.php");
    require_once("json_exempel.php");
    require_once("login_check.php");

    $stmt = $conn->prepare("SELECT `ID`,`name`, `email`, `admin`, `endUser`, `description`, `avatar`, `locked` FROM `user`");

    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            json_encode($row);
        }
    }
    $stmt->close();
?>