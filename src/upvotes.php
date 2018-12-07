<?php

    function insertUpvote($Story,$User){
        global $dbh;
        try {
  		    $stmt = $dbh->prepare('INSERT INTO UPVOTE(StoryID, UserID) VALUES (:StoryID, :UserID)');
  		    $stmt->bindParam(':StoryID', $Story);
            $stmt->bindParam(':UserID', $User);

            if($stmt->execute())
                return $dbh->lastInsertId();
            else
                return -1;
        }catch(PDOException $e) {
            return -1;
        }      
    }
    function deleteUpvote($story,$user){
        global $dbh;
        try {
			$stmt = $dbh->prepare('DELETE FROM UPVOTE WHERE StoryID = :StoryID AND UserID= :UserID');
            $stmt->bindParam(':StoryID', $story);
            $stmt->bindParam(':UserID', $user);
			if($stmt->execute())
				return true;
			else
				return false;
		
		} catch(PDOException $e) {
			return false;
		}
    }



    function insertDownvote($Story,$User){
        global $dbh;
        try {
  		    $stmt = $dbh->prepare('INSERT INTO DOWNVOTE(StoryID, UserID) VALUES (:StoryID, :UserID)');
  		    $stmt->bindParam(':StoryID', $Story);
            $stmt->bindParam(':UserID', $User);

            if($stmt->execute())
                return $dbh->lastInsertId();
            else
                return -1;
        }catch(PDOException $e) {
            return -1;
        }      
    }

    function deleteDownvote($story,$user){
        global $dbh;
        try {
			$stmt = $dbh->prepare('DELETE FROM DOWNVOTE WHERE StoryID = :StoryID AND UserID= :UserID');
            $stmt->bindParam(':StoryID', $story);
            $stmt->bindParam(':UserID', $user);
			if($stmt->execute())
				return true;
			else
				return false;
		
		} catch(PDOException $e) {
			return false;
		}
    }

?>