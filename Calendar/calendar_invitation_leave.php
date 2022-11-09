<?php
    /*----------------------------------------------------------------------
        Checks if the invitation is set
    ----------------------------------------------------------------------*/
        if(!empty($_GET['iID'])){
            $iID = $_GET['iID'];
        }
        else{
            errorWrite($version,"Didn't specify which invitation to leave");
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
        Checks if the invitation is not accepted
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("SELECT `ID` FROM `event_invitation` WHERE `ID`=? AND `accepted`=0");
        $stmt->bind_param("i",$iID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {           
            errorWrite($version,"Has not accepted invitation");
        }
        $stmt->close();
    #

    /*----------------------------------------------------------------------
        Checks if it is the recipent leaving the invitation
    ----------------------------------------------------------------------*/
        $stmt = $conn->prepare("SELECT `rID` FROM `event_invitation` WHERE `rID`=?");
        $stmt->bind_param("i",$uID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {           
            errorWrite($version,"Only recipient can leave");
        }
        $stmt->close();
    #

    /*----------------------------------------------------------------------
        Deletes specified invitation
    ----------------------------------------------------------------------*/
    $stmt = $conn->prepare("DELETE FROM `event_invitation` WHERE `ID`=? AND `accepted`=1");
    $stmt->bind_param("i",$iID);
    $stmt->execute();
    #

    /*----------------------------------------------------------------------
        Outputs json
    ----------------------------------------------------------------------*/
        $data = ["Result"=>"Left invitation"];
        jsonWrite($version,$data);
    #
?>
