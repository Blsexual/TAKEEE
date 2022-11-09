<?php
    /*----------------------------------------------------------------------
        Checks if the invitation is set
    ----------------------------------------------------------------------*/
        if(!empty($_GET['iID'])){
            $iID = $_GET['iID'];
        }
        else{
            errorWrite($version,"Didn't specify which invitation to accept");
        }
    #

    /*----------------------------------------------------------------------
        Checks if the invitation exists
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("SELECT `ID`, `eID`, `rID` FROM `event_invitation` WHERE `ID`=?");
        $stmt->bind_param("i",$iID);
        $stmt->execute();
        $result = $stmt->get_result();

        $invitation = $result->fetch_assoc();

        if ($result->num_rows < 1) {           
            errorWrite($version,"Could not find invitation");
        }
        $stmt->close();
    #

    /*----------------------------------------------------------------------
        Checks if it is the recipent accepting the invitation
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("SELECT `rID` FROM `event_invitation` WHERE `rID`=?");
        $stmt->bind_param("i",$uID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {           
            errorWrite($version,"Only recipient can accept");
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
        Updates specified invitation's accepted to 1
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("UPDATE `event_invitation` SET `accepted`=1 WHERE `ID`=?");
        $stmt->bind_param("i",$iID);
        $stmt->execute();
    #

    /*----------------------------------------------------------------------
        Outputs json
    ----------------------------------------------------------------------*/
        $data = ["Result"=>"Invitation accepted", "iID"=>$iID, "rID"=>$invitation['rID'], "eID"=>$invitation['eID']];
        jsonWrite($version,$data);
    #
?>
