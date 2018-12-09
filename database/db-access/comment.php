<?php
// Add new comment

    function createComment($CommentText, $Date, $Story, $Author, $Comment){
        global $dbh;
        try {
  		    $stmt = $dbh->prepare('INSERT INTO COMMENT(Text, CommentDate, idStory, idAuthor, idComment) VALUES (:Text, :CommentDate, :idStory, :idAuthor, :idComment)');
  		    $stmt->bindParam(':Text', $CommentText);
            $stmt->bindParam(':CommentDate', $Date);
            $stmt->bindParam(':idStory', $Story);
            $stmt->bindParam(':idAuthor', $Author);
            $stmt->bindParam(':idComment', $Comment);

            if($stmt->execute())
                return $dbh->lastInsertId();
            else
                return -1;
        }catch(PDOException $e) {
            return -1;
        }
           
    }


// Delete comment

    function deleteComment($CommentID){
        global $dbh;
        try {
			$stmt = $dbh->prepare('DELETE FROM COMMENT WHERE ID = :ID');
			$stmt->bindParam(':ID', $CommentID);
			if($stmt->execute())
				return true;
			else
				return false;
		
		} catch(PDOException $e) {
			return false;
		}
    }


// Get all comments of a story

    function getComments($idStory) {        
        global $dbh;
        try {
            $stmt = $dbh->prepare('SELECT * FROM COMMENT WHERE idStory=? ORDER BY CommentDate DESC');
            $stmt->execute(array($idStory));
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            return null;
        }
    }
?>