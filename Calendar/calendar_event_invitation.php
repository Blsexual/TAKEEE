<?php

    /*----------------------------------------------------------------------
        Checks if eventID is set
    ----------------------------------------------------------------------*/
        if(!empty($_GET['eID'])){
            $eID = $_GET['eID'];
        }
        else{
            errorWrite($version,"Didn't specify which event to invite to");
        }
    #
    
    /*----------------------------------------------------------------------
        Checks if the event exists
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("SELECT `ID` FROM `event` WHERE `ID`=? AND `uID`=?");
        $stmt->bind_param("ii", $eID,$uID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows < 1) {           
            errorWrite($version,"Could not find event");
        }
        $stmt->close();
    #

    /*----------------------------------------------------------------------
        Checks if recipentID is set
    ----------------------------------------------------------------------*/
        if(!empty($_GET['rID'])){
            $rID = $_GET['rID'];
        }
        else{
            errorWrite($version,"Didn't specify which recipient to invite");
        }
    #

    /*----------------------------------------------------------------------
        Checks if the recipentID set exists
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("SELECT `ID`, `name`, `endUser` FROM `user` WHERE `ID`=?");
        $stmt->bind_param("i", $rID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($result->num_rows < 1) {           
            errorWrite($version,"Could not find recipient");
        }
    #
    /*------------------------------------------------------------------------
        Checks if recipient is Calendar endUser
    ------------------------------------------------------------------------*/
        if($row['endUser'][2] == "0"){
            errorWrite($version,"Unable to invite recipient");
        }
    #

    /*------------------------------------------------------------------------
        Checks if recipient is self
    ------------------------------------------------------------------------*/
        if($row['ID'] == $uID){
            errorWrite($version,"Unable to invite self");
        }
    #

    /*----------------------------------------------------------------------
        Checks if the recipient is already invited
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("SELECT `ID` FROM `event_invitation` WHERE `rID`=? AND `eID`=?");
        $stmt->bind_param("ii", $rID,$eID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {           
            errorWrite($version,"Have already invited recipient");
        }
        $stmt->close();
    #

    /*----------------------------------------------------------------------
        Creates invitation
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("INSERT INTO `event_invitation` (rID, eID) VALUES (?,?)");
        $stmt->bind_param("ii", $rID, $eID);
        $stmt->execute();
        $iID = $conn->insert_id;
    #

    /*----------------------------------------------------------------------
        Outputs json
    ----------------------------------------------------------------------*/
        $data = ["Result"=>"Invited user to event", "rID"=>$rID, "iID"=>$iID];
        jsonWrite($version,$data);
    #
?>
