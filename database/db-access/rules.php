<?php
// Add new rule to a channel

    function createRule($RuleTitle, $RuleDescription,$Channel){
        global $dbh;
        try {
  		    $stmt = $dbh->prepare('INSERT INTO RULES(Title, Description, ChannelStory) VALUES (:Title, :Description, :ChannelStory)');
  		    $stmt->bindParam(':Title', $RuleTitle);
            $stmt->bindParam(':Description', $RuleDescription);
            $stmt->bindParam(':ChannelStory', $Channel);
            if($stmt->execute())
                return $dbh->lastInsertId();
            else
                return -1;
        }catch(PDOException $e) {
            return -1;
        }
           
    }


// Delete rule of a channel

    function deleteRule($RuleID){
        global $dbh;
        try {
			$stmt = $dbh->prepare('DELETE FROM RULES WHERE ID = :ID');
			$stmt->bindParam(':ID', $RuleID);
			if($stmt->execute())
				return true;
			else
				return false;
		
		} catch(PDOException $e) {
			return false;
		}
    }

// Get all Rules for a Channel

    function getRulesChannel($idChannel) {        
        global $dbh;
        try {
            $stmt = $dbh->prepare('SELECT ID, Title, Description FROM RULES WHERE idChannel = ?');
            $stmt->execute(array($idChannel));
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            return null;
        }
    }
?>