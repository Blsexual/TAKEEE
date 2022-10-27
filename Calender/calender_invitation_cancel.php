<?php
    /*----------------------------------------------------------------------
        Checks if the invitation is set
    ----------------------------------------------------------------------*/
        if(!empty($_GET['iID'])){
            $iID = $_GET['iID'];
        }
        else{
            errorWrite($version,"Didn't specify which invitation to cancel");
        }
    #

    /*----------------------------------------------------------------------
        Checks if the invitation exists
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("SELECT `ID` FROM `event_invitation` WHERE `ID`=?");
        $stmt->bind_param("i",$iID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {           
            errorWrite($version,"Could not find invitation");
        }
        $stmt->close();
    #

    /*----------------------------------------------------------------------
        Checks if the invitation is already accepted
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("SELECT `ID` FROM `event_invitation` WHERE `ID`=? AND `accepted`=1");
        $stmt->bind_param("i",$iID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {           
            errorWrite($version,"Invitation is already accepted");
        }
        $stmt->close();
    #

    /*----------------------------------------------------------------------
        Checks if it is the creator cancelling the invitation
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("SELECT `event_invitation`.`eID`, `event`.`uID` AS cID FROM `event` INNER JOIN `event_invitation` ON `event`.`ID`=`event_invitation`.`eID` AND `event`.`uID`=?");
        $stmt->bind_param("i",$uID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            errorWrite($version,"Only creator can cancel");
        }
        $stmt->close();
    #

    /*----------------------------------------------------------------------
        Deletes specified invitation
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("DELETE FROM `event_invitation` WHERE `ID`=? AND `accepted`=0");
        $stmt->bind_param("i",$iID);
        $stmt->execute();
    #

    /*----------------------------------------------------------------------
        Outputs json
    ----------------------------------------------------------------------*/
        $data = ["Action"=>"Cancelled invitation"];
        jsonWrite($version,$data);
    #
?>