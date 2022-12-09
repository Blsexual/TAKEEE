<?php
/*-----------------------------------------------------------
        Imports
-----------------------------------------------------------*/
    require_once("../db.php");
    require_once("../json_exempel.php");
    require_once("../login_check.php");

    if(!empty($_GET)){
        if(!empty($_GET['action'])){
            $action = $_GET['action'];
            if($action == "login"){
                require_once("../login.php");
            }

            /*----------------------------------------------------------------------
                Create a user
            ----------------------------------------------------------------------*/
                if($action == "createUser"){
                    require_once("create_user.php");
                }
            #

            /*----------------------------------------------------------------------
                Delete a user
            ----------------------------------------------------------------------*/
                if($action == "deleteUser"){
                    require_once("delete_user.php");
                }
            #

            /*----------------------------------------------------------------------
                Edit a user
            ----------------------------------------------------------------------*/
            if($action == "editUser"){
                require_once("edit_user.php");
            }

            /*----------------------------------------------------------------------
                Show all users
            ----------------------------------------------------------------------*/
            if($action == "showUsers"){
                require_once("show_users.php");
            }
        #
            /*----------------------------------------------------------------------
                Show a users
            ----------------------------------------------------------------------*/
            if($action == "showUser"){
                require_once("show_user.php");
            }
        #


            errorWrite($version,"No a valid action made");
        }
        errorWrite($version,"Invalid action made");
    }
    errorWrite($version,"No action made");
?>
