<?php
    /*----------------------------------------------------------------------
        Deletes the selected event
    ----------------------------------------------------------------------*/
        # Returns an error if no event has been selected
            if(empty($_GET['eID'])){
                errorWrite($version,"Didn't specify what event to delete");
            }
        #

        # Checks if the selected event exists in the database
            $ID = $_GET['eID'];
            $stmt = $conn->prepare("SELECT `ID` FROM `event` WHERE `ID`=? AND `uID`=?");
            $stmt->bind_param("ii", $ID,$uID);
            $stmt->execute();
            $result = $stmt->get_result();
        #
        
        # Deletes the selected event if the logged in user owns it
            if ($result->num_rows > 0) {
                $stmt->close();
                $stmt = $conn->prepare("DELETE FROM `event` WHERE `ID`=? AND `uID`=?");
                $stmt->bind_param("ii", $ID,$uID);
                $stmt->execute();
                $result = $stmt->get_result();
                # Deletes all the invites associated with the event
                    if ($result == 0) {
                        $stmt->close();
                        $stmt = $conn->prepare("DELETE FROM `event_invitation` WHERE `eID`=?");
                        $stmt->bind_param("i", $ID);
                        $stmt->execute();
                        $data = ["Result"=>"Event deleted", "eID"=>$ID];
                        jsonWrite($version,$data);  
                    } 
                    else{
                        errorWrite($version,"Selected event doesn't exist");
                    }
                #
            }
            errorWrite($version,"Selected event doesn't exist");
        #
    #
?>
