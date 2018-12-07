<?php
// Add new story

    function createStory($StoryTitle, $StoryText, $Date, $userID, $Channel){
        global $dbh;
        try {
  		    $stmt = $dbh->prepare('INSERT INTO STORY(Title, Text, StoryDate, idAuthor, UpvoteRatio, ChannelStory) VALUES (:Title, :Text, :StoryDate, :idAuthor, :UpvoteRatio, :ChannelStory)');
  		    $stmt->bindParam(':Title', $StoryTitle);
            $stmt->bindParam(':Text', $StoryText);
            $stmt->bindParam(':StoryDate', $Date);
            $stmt->bindValue(':UpvoteRatio', null, PDO::PARAM_NULL);
            $stmt->bindParam(':ChannelStory', $Channel);
            $stmt->bindParam(':idAuthor', $userID);
            if($stmt->execute())
                return $dbh->lastInsertId();
            else
                return -1;
        }catch(PDOException $e) {
            return -1;
        }
           
    }


// Delete story

    function deleteStory($StoryID){
        global $dbh;
        try {
			$stmt = $dbh->prepare('DELETE FROM STORY WHERE ID = :ID');
			$stmt->bindParam(':ID', $StoryID);
			if($stmt->execute())
				return true;
			else
				return false;
		
		} catch(PDOException $e) {
			return false;
		}
    }


//Get all stories from a channel

function getChannelStories($ChannelStory) {        
        global $dbh;
        try {
            $stmt = $dbh->prepare('SELECT ID, Title, Text, StoryDate FROM STORY WHERE ChannelStory = ?');
            $stmt->execute(array($ChannelStory));
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            return null;
        }
    }


//Most Recent Stories

function getRecentStories() {        
        global $dbh;
        try {
            $stmt = $dbh->prepare('SELECT ID, Title, Text, UpvoteRatio, StoryDate FROM STORY ORDER BY StoryDate DESC');
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            return null;
        }
    }


//Most Upvoted Stories

function getRecentStories() {        
        global $dbh;
        try {
            $stmt = $dbh->prepare('SELECT ID, Title, Text, UpvoteRatio, StoryDate FROM STORY ORDER BY UpvoteRatio DESC');
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            return null;
        }
    }

?>