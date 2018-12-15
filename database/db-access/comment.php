<?php
  // gets comment with ID
  function getComment($idComment) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT DISTINCT Description, CommentDate, USER.Username, USER.Avatar, idStory, idComment
                            FROM COMMENT, USER
                            WHERE COMMENT.ID = ? AND COMMENT.idAuthor = USER.ID
                          ');
      $stmt->execute(array($idComment));
      return $stmt->fetch();
    } catch (PDOException $e) {
      return false;
    }
  }
?>
