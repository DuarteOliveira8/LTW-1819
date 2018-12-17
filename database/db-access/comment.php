<?php
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
      $stmt = $db->prepare('SELECT description, upvoteRatio, commentDate, USER.username, USER.avatar
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
?>
