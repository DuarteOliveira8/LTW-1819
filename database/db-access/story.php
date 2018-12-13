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
      return -1;
    }
  }

  // gets story with ID
  function getStory($idStory) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT Title, Description, StoryDate, USER.Username, USER.Avatar, UpvoteRatio, ChannelStory
                            FROM STORY, USER
                            WHERE STORY.ID = ? AND STORY.idAuthor = USER.ID
                          ');
      $stmt->execute(array($idStory));
      return $stmt->fetch();
    } catch (PDOException $e) {
      return false;
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
      $stmt = $dbh->prepare('SELECT ID, Title, Description, StoryDate FROM STORY WHERE ChannelStory = ?');
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
      $stmt = $dbh->prepare('SELECT ID, Title, Description, UpvoteRatio, StoryDate FROM STORY ORDER BY StoryDate DESC');
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
      $stmt = $dbh->prepare('SELECT ID, Title, Description, UpvoteRatio, StoryDate FROM STORY ORDER BY UpvoteRatio DESC');
      $stmt->execute();
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return null;
    }
  }

  // Checks if user has upvoted story
  function hasUpvoted($story, $user) {
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('SELECT *
                            FROM UPVOTE
                            WHERE StoryID = ? AND UserID = ?
                          ');
      $stmt->execute(array($story, $user));
      $upvote = $stmt->fetch();

      if($upvote !== false)
        return true;
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

  // User upvote
  function insertUpvote($story, $user){
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('INSERT INTO UPVOTE(StoryID, UserID) VALUES (?, ?)');

      if($stmt->execute(array($story, $user)))
        return $db->lastInsertId();
      else
        return -1;
    }catch(PDOException $e) {
      return -1;
    }
  }

  // Delete user upvote
  function deleteUpvote($story, $user){
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('DELETE
                            FROM UPVOTE
                            WHERE StoryID = ? AND UserID= ?
                          ');

    	if($stmt->execute(array($story, $user)))
    		return true;
    	else
    		return false;
    } catch(PDOException $e) {
    	return false;
    }
  }

  // Checks if user has downvoted story
  function hasDownvoted($story, $user) {
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('SELECT *
                            FROM DOWNVOTE
                            WHERE StoryID = ? AND UserID = ?
                          ');
      $stmt->execute(array($story, $user));
      $downvote = $stmt->fetch();

      if($downvote !== false)
        return true;
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

  // User downvote
  function insertDownvote($story, $user){
      $db = Database::getInstance()->getDB();

      try {
  	    $stmt = $db->prepare('INSERT INTO DOWNVOTE(StoryID, UserID) VALUES (?, ?)');

        if($stmt->execute(array($story, $user)))
          return $db->lastInsertId();
        else
          return -1;
      }catch(PDOException $e) {
        return -1;
      }
  }

  // Delete user downvote
  function deleteDownvote($story, $user){
    $db = Database::getInstance()->getDB();

    try {
    	$stmt = $db->prepare('DELETE
                            FROM DOWNVOTE
                            WHERE StoryID = ? AND UserID= ?
                          ');

    	if($stmt->execute(array($story, $user)))
    		return true;
    	else
    		return false;
    } catch(PDOException $e) {
    	return false;
    }
  }

  // Add new comment
  function createComment($description, $date, $story, $author, $comment){
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('INSERT INTO COMMENT(Description, CommentDate, idStory, idAuthor, idComment)
                            VALUES (?, ?, ?, ?, ?)
                          ');

      if($stmt->execute(array($description, $date, $story, $author, $comment)))
        return $db->lastInsertId();
      else
        return -1;
    }catch(PDOException $e) {
      return -1;
    }
  }

  // Delete comment
  function deleteComment($commentID){
    $db = Database::getInstance()->getDB();

    try {
    	$stmt = $db->prepare('DELETE
                            FROM COMMENT
                            WHERE ID = ?
                          ');

    	if($stmt->execute($commentID))
    		return true;
    	else
    		return false;
  	} catch(PDOException $e) {
  		return false;
  	}
  }

  // Get all comments of a story
  function getComments($idStory) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT *
                            FROM COMMENT
                            WHERE idStory=?
                            ORDER BY CommentDate DESC
                          ');
      $stmt->execute(array($idStory));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return null;
    }
  }

?>
