<?php
  include_once(__DIR__ . '/../../includes/Database.php');

  // Add new story
  function createStory($storyTitle, $storyDescription, $storyDate, $userId, $channel){
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('INSERT INTO STORY(title, description, storyDate, idAuthor, upvoteRatio, channel)
                            VALUES (?, ?, ?, ?, ?, ?)
                          ');

      if($stmt->execute(array($storyTitle, $storyDescription, $storyDate, $userId, 0, $channel)))
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
      $stmt = $db->prepare('SELECT title, description, storyDate, USER.username, USER.avatar, upvoteRatio, channel
                            FROM STORY, USER
                            WHERE STORY.id = ? AND STORY.idAuthor = USER.id
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
                            FROM STORYUPVOTE
                            WHERE storyId = ? AND userId = ?
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
	    $stmt = $db->prepare('INSERT INTO STORYUPVOTE(storyId, userId)
                            VALUES (?, ?)
                          ');

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
                            FROM STORYUPVOTE
                            WHERE storyId = ? AND userId= ?
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
                            FROM STORYDOWNVOTE
                            WHERE storyId = ? AND userId = ?
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
  	    $stmt = $db->prepare('INSERT INTO STORYDOWNVOTE(storyId, userId)
                              VALUES (?, ?)
                            ');

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
                            FROM STORYDOWNVOTE
                            WHERE storyId = ? AND userId= ?
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
	    $stmt = $db->prepare('INSERT INTO STORYCOMMENT(description, commentDate, idStory, idAuthor, idComment)
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
  function deleteComment($commentId){
    $db = Database::getInstance()->getDB();

    try {
    	$stmt = $db->prepare('DELETE
                            FROM STORYCOMMENT
                            WHERE id = ?
                          ');

    	if($stmt->execute($commentId))
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
                            FROM STORYCOMMENT
                            WHERE idStory = ?
                            ORDER BY commentDate DESC
                          ');
      $stmt->execute(array($idStory));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return null;
    }
  }

?>
