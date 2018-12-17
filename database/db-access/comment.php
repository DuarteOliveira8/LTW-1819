<?php
  include_once(__DIR__ . '/../../includes/Database.php');

  // gets comment with ID
  function getComment($idComment) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT description, upvoteRatio, commentDate, USER.username, USER.avatar
                            FROM COMMENT, USER
                            WHERE COMMENT.id = ? AND COMMENT.idAuthor = USER.id
                          ');
      $stmt->execute(array($idComment));
      return $stmt->fetch();
    } catch (PDOException $e) {
      return false;
    }
  }

  function getCommentReplies($idComment, $offset) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT COMMENT.id, description, upvoteRatio, commentDate, USER.username, USER.avatar
                            FROM COMMENT, CHAINCOMMENT, USER
                            WHERE CHAINCOMMENT.parentComment = ? AND CHAINCOMMENT.childComment = COMMENT.id AND COMMENT.idAuthor = USER.id
                            ORDER BY commentDate DESC
                            LIMIT 4 OFFSET ?
                          ');
      $stmt->execute(array($idComment, $offset));
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      return false;
    }
  }

  //Get upvote ratio from commentId
  function getUpvoteRatioComment($commentId) {
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('SELECT upvoteRatio
                            FROM COMMENT
                            WHERE id = ?
                          ');
      $stmt->execute(array($commentId));
      $comment = $stmt->fetch();

      if($comment !== false)
        return $comment['upvoteRatio'];
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

  // Checks if user has upvoted comment
  function hasUpvotedComment($comment, $user) {
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('SELECT *
                            FROM COMMENTUPVOTE
                            WHERE commentId = ? AND userId = ?
                          ');
      $stmt->execute(array($comment, $user));
      $upvote = $stmt->fetch();

      if($upvote !== false)
        return true;
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

  // User upvote comment
  function insertUpvoteComment($comment, $user){
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('INSERT INTO COMMENTUPVOTE(commentId, userId)
                            VALUES (?, ?)
                          ');

      if($stmt->execute(array($comment, $user)))
        return $db->lastInsertId();
      else
        return -1;
    }catch(PDOException $e) {
      return -1;
    }
  }

  // Delete user upvote comment
  function deleteUpvoteComment($comment, $user){
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('DELETE
                            FROM COMMENTUPVOTE
                            WHERE commentId = ? AND userId= ?
                          ');

    	if($stmt->execute(array($comment, $user)))
    		return true;
    	else
    		return false;
    } catch(PDOException $e) {
    	return false;
    }
  }

  // Checks if user has downvoted comment
  function hasDownvotedComment($comment, $user) {
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('SELECT *
                            FROM COMMENTDOWNVOTE
                            WHERE commentId = ? AND userId = ?
                          ');
      $stmt->execute(array($comment, $user));
      $downvote = $stmt->fetch();

      if($downvote !== false)
        return true;
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

  // User downvote comment
  function insertDownvoteComment($comment, $user){
      $db = Database::getInstance()->getDB();

      try {
  	    $stmt = $db->prepare('INSERT INTO COMMENTDOWNVOTE(commentId, userId)
                              VALUES (?, ?)
                            ');

        if($stmt->execute(array($comment, $user)))
          return $db->lastInsertId();
        else
          return -1;
      }catch(PDOException $e) {
        return -1;
      }
  }

  // Delete user downvote comment
  function deleteDownvoteComment($comment, $user){
    $db = Database::getInstance()->getDB();

    try {
    	$stmt = $db->prepare('DELETE
                            FROM COMMENTDOWNVOTE
                            WHERE commentId = ? AND userId= ?
                          ');

    	if($stmt->execute(array($comment, $user)))
    		return true;
    	else
    		return false;
    } catch(PDOException $e) {
    	return false;
    }
  }
?>
