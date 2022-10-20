<?php 
    function errorWrite($version,$error){ 
        #Message on error
        $return = ["Version"=>$version,"Type"=>"Error","Data"=>"$error"];
        die(json_encode($return));
    }

    function jsonWrite($version,$data){
        #Displaying the inserted data
        $contents = ["Version"=>$version,"Type"=>"Ok","Data"=>$data];
        die(json_encode($contents));
    }
?>
