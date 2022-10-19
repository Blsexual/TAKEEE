<?php
require_once("../db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method = "get" action = "blog_db.php">
    <input type="text" id="Bsearch" name="blogSearch" autocomplete="off" placeholder="Search"/><br>
    <input type="submit" value="Search"/>
    </form>

    
</body>
</html>