<form method='post'>
    Namn <input type='input' name='Namn' ><br>
    Efternamn <input type='input' name='Efternamn' ><br>
    E-Post <input type='email' name='E-Post' ><br>
    <input type='submit' value='Skicka'>
</form>

<?php
    print_r($_POST);
    echo "<br>";
    echo json_encode($_POST);
    echo "<br>";
    echo "<br>";
    $Data = '{"Namn":"'.$_POST['Namn'].'","Efternamn":"'.$_POST['Efternamn'].'","E-Post":"'.$_POST['E-Post'].'"}';
    echo $Data;
    echo "<br>";
    echo print_r(json_decode($Data));

    echo "<br>";
    echo "<br>";


    $DataFull = array();
    if (isset($_POST['Namn'])){
        array_push($DataFull,$_POST['Namn']);
    }
    if (isset($_POST['Efternamn'])){
        array_push($DataFull,$_POST['Efternamn']);
    }
    if (isset($_POST['E-Post'])){
        array_push($DataFull,$_POST['E-Post']);
    }
    print_r($DataFull);
    $namn = $_POST['Namn'];

    echo "<br>";
    echo "<br>";

    $families = array(
        "Griffin"=>array(
            "Peter",
            "Lois",
            "Megan"
        ),
        "Quagmire"=>array(
            "Glenn"
        ),
        "Brown"=>array(
            "Cleveland",
            "Loretta",
            "Junior"
        )
    );   
    
    print_r($families);

    echo "<br>";
    echo "<br>";

    echo json_encode($families);
