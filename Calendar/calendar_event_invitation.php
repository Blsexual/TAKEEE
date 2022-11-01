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
        $stmt = $conn->prepare("SELECT `ID`, `name` FROM `user` WHERE `ID`=?");
        $stmt->bind_param("i", $rID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows < 1) {           
            errorWrite($version,"Could not find recipient");
        }
    #

    /*----------------------------------------------------------------------
        Saves name of the recipent if recipentID exists
    ----------------------------------------------------------------------*/
        elseif($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $name = $row['name'];
        }
        $stmt->close();
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
    #

    /*----------------------------------------------------------------------
        Outputs json
    ----------------------------------------------------------------------*/
        $data = ["Action"=>"Invited $name to event"];
        jsonWrite($version,$data);
    #
?>
