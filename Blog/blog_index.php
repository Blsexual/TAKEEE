<?php
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");

    if(!empty($_GET)){
        if(!empty($_GET['action'])){
            $action = $_GET['action'];

            /*----------------------------------------------------------------------
                Shows all blogs and whats in a blog
            ----------------------------------------------------------------------*/
                if($action == "showBlog"){
                    require_once("blog_db.php");
                }
            #

            $token = $_GET['token'];
            $uID = $_GET['uID'];
            $res = checkToken($token,$uID,"010",$version,$conn);
            
            
            /*----------------------------------------------------------------------
                Allows the user to create a new blog or entety
            ----------------------------------------------------------------------*/
                if($action == "create"){
                    require_once("blog_create.php");
                }
            #
            /*----------------------------------------------------------------------
                Allows the user to delete a blog or entety
            ----------------------------------------------------------------------*/
                if($action == "delete"){
                    require_once("blog_delete.php");
                }
            #
            /*----------------------------------------------------------------------
                Shows all events on the timeline
            ----------------------------------------------------------------------*/
                if($action == "edit"){
                    require_once("blog_edit.php");
                }
            #
            
            errorWrite($version,"Not a valid action made");
        }
        errorWrite($version,"Invalid action made");
    }
    errorWrite($version,"No action made");
?>