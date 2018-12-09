<?php

    function insertSubscriber($Story,$User){
        global $dbh;
        try {
  		    $stmt = $dbh->prepare('INSERT INTO SUBSCRIBER(UserID, ChannelID) VALUES (:UserID, :ChannelID)');
            $stmt->bindParam(':UserID', $User);
            $stmt->bindParam(':ChannelID', $Channel);

            if($stmt->execute())
                return $dbh->lastInsertId();
            else
                return -1;
        }catch(PDOException $e) {
            return -1;
        }      
    }

    function deleteSubscriber($user,$channel){
        global $dbh;
        try {
			$stmt = $dbh->prepare('DELETE FROM SUBSCRIBER WHERE UserID = :UserID AND ChannelID= :ChannelID');
            $stmt->bindParam(':UserID', $user);
            $stmt->bindParam(':ChannelID', $channel);
			if($stmt->execute())
				return true;
			else
				return false;
		
		} catch(PDOException $e) {
			return false;
		}
    }

?>