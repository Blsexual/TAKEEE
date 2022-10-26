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
                require_once("wiki_login.php");
            }

            /*----------------------------------------------------------------------
                Shows all wikis
            ----------------------------------------------------------------------*/
                if($action == "showWikis"){
                    require_once("wiki_show_wikis.php");
                }
            #

            /*----------------------------------------------------------------------
                Shows all entrys on a wiki
            ----------------------------------------------------------------------*/
                if($action == "showWikiEntries"){
                    require_once("wiki_group_page.php");
                }
            #

            /*----------------------------------------------------------------------
                Shows a entry
            ----------------------------------------------------------------------*/
                if($action == "showEntry"){
                    require_once("wiki_info_page.php");
                }
            #

            /*----------------------------------------------------------------------
                Shows a entrys history
            ----------------------------------------------------------------------*/
                if($action == "showHistory"){
                    require_once("wiki_history.php");
                }
            #

            $token = $_GET['token'];
            $uID = $_GET['uID'];
            $res = checkToken($token,$uID,"100",$version,$conn);
            
            /*----------------------------------------------------------------------
                Allows the user to create a new entry
            ----------------------------------------------------------------------*/
                if($action == "createEntry"){
                    require_once("wiki_page_create.php");
                }
            #
            /*----------------------------------------------------------------------
                Allows the user to edit entry
            ----------------------------------------------------------------------*/
                if($action == "editEntry"){
                    require_once("wiki_page_edit.php");
                }
            #
            /*----------------------------------------------------------------------
                Allows the original user to delete one of their entrys
            ----------------------------------------------------------------------*/
                if($action == "deleteEntry"){
                    require_once("wiki_page_remove.php");
                }
            #


            errorWrite($version,"No a valid action made");
        }
        errorWrite($version,"Invalid action made");
    }
    errorWrite($version,"No action made");
?>
