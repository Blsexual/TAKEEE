<?php
    /*----------------------------------------------------------------------
        Shows other peoples events that the end user has agreed to see
    ----------------------------------------------------------------------*/ 
        #Gets which of the events the end user has accepted
            $stmt = $conn->prepare("SELECT event.ID AS eID, event.uID AS cID FROM `event` INNER JOIN `event_invitation` ON event_invitation.eID = event.ID AND event_invitation.accepted = 0 AND event_invitation.rID = ?");
            $stmt->bind_param("i", $uID);
            $stmt->execute();
            $result1 = $stmt->get_result();
            #Gets the name of the user who made the event
                $eventList = [];
                if($result1->num_rows > 0){
                    while($row1 = $result1->fetch_assoc()){
                        $cID = $row1['cID'];
                        $stmt->close();
                        $stmt = $conn->prepare("SELECT `ID`, `name` FROM `user` WHERE `ID`=?");
                        $stmt->bind_param("i", $cID);
                        $stmt->execute();
                        $result2 = $stmt->get_result();
                        #Shows all the data from the accepted events
                            if($result2->num_rows > 0){
                                $row2 = $result2->fetch_assoc();
                                $name = $row2['name'];
                                $stmt->close();
                                $stmt = $conn->prepare("SELECT event.ID AS eID, event.uID AS cID, event.title, event.description, event.startDate, event.endDate FROM `event` INNER JOIN `event_invitation` ON event_invitation.eID = event.ID AND event_invitation.accepted = 0 AND event_invitation.rID = ? AND event.uID = ? AND `startDate` BETWEEN '0000-00-00 00:00:00' AND ? AND `endDate` BETWEEN ? AND '9999-12-30 23:59:59' ORDER BY `startDate` asc");
                                $stmt->bind_param("iiss", $uID, $cID,$endDate,$startDate);
                                $stmt->execute();
                                $result3 = $stmt->get_result();
                                #Sorts the events to show all them based on the creator
                                    if($result3->num_rows > 0){
                                        while($row3 = $result3->fetch_assoc()){
                                            $eventList[] = $row3;
                                        }
                                        
                                    }
                                #
                            }
                        #
                    }
                }
                $data["Event invitations"] = $eventList;
            #
        #
    #
?>