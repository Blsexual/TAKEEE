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
                    require_once("blog_show.php");
                }
                else if($action != "create" && $action != "delete" && $action != "edit"){
                    errorWrite($version,"Not a valid action made");
                }
            #

            if(!empty($_GET["token"])){
                $token = $_GET['token'];
            } else{
                errorWrite($version,"No token was given");
            }
            
            if(!empty($_GET["uID"])){
                $uID = $_GET['uID'];
            } else{
                errorWrite($version,"No uID was given");
            }

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
                    if ($res["userType"] == "endUser"){
                        require_once("blog_edit.php");
                    }
                    else{
                        errorWrite($version,"Not a valid user");
                    }
                }
            #
            
            errorWrite($version,"Not a valid action made");
        }
        errorWrite($version,"Invalid action made");
    }
    errorWrite($version,"No action made");
?>