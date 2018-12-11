<?php
  include_once(__DIR__ . '/../../includes/Database.php');

  // Add new story
  function createStory($StoryTitle, $StoryDescription, $StoryDate, $UserID, $Channel){
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('INSERT INTO STORY(Title, Description, StoryDate, idAuthor, UpvoteRatio, ChannelStory) VALUES (?, ?, ?, ?, ?, ?)');

      if($stmt->execute(array($StoryTitle, $StoryDescription, $StoryDate, $UserID, 0, $Channel)))
        return $db->lastInsertId();
      else
        return -1;
    }catch(PDOException $e) {
      echo $e->getMessage();
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

function getMostUpvotedStories() {
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
