<?php #Message on error
    function errorWrite($version,$error){
        $return = ["Version"=>$version,"Type"=>"Error","Data"=>"$error"];
        die(json_encode($return));
    }
?>

<?php #How to display the data in blog
    function blogWrite($version,$blog,$blogEntry){
        $data = ["Blog"=>$blog,"Blog entry"=>$blogEntry];
        $contents = ["Version"=>$version,"Type"=>"Ok","Data"=>$data];
        die(json_encode($contents));
    }
?>

<?php
    function calendarWrite($version,$event){
        $data = ["My events"=>$event];
        $contents = ["Version"=>$version,"Type"=>"Ok","Data"=>$data];
        die(json_encode($contents));
    }
?>

<?php #How to display the data in blog
    function wikiWrite($version,$wiki, $wikiEntry){
        $data = ["Wiki"=>$wiki,"Wiki entry"=>$wikiEntry];
        $contents = ["Version"=>$version,"Type"=>"Ok","Data"=>$data];
        die(json_encode($contents));
    }

?>