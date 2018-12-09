<?php

// Add new User

    function createUser($username, $firstname, $lastname, $email, $password, $birthdate){
      global $dbh;
      try {
		    $stmt = $dbh->prepare('INSERT INTO USER(Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES (:Username, :FirstName, :LastName, :Email, :Password, :Bio, :Avatar, :BirthDate)');
		    $stmt->bindParam(':Username', $username);
        $stmt->bindParam(':FirstName', $firstname);
        $stmt->bindParam(':LastName', $lastname);
        $stmt->bindParam(':Email', $email);
        $stmt->bindParam(':Password', $password);
        $stmt->bindParam(':BirthDate', $birthdate);

        if($stmt->execute())
          return $dbh->lastInsertId();
        else
          return -1;
      }catch(PDOException $e) {
          return -1;
      }
    }


// Delete user

    function deleteUser($UserID){
        global $dbh;
        try {
			$stmt = $dbh->prepare('DELETE FROM USER WHERE ID = :ID');
			$stmt->bindParam(':ID', $UserID);
			if($stmt->execute())
				return true;
			else
				return false;

		} catch(PDOException $e) {
			return false;
		}
    }

//Get id with username
    function getID($username) {
        global $dbh;
        try {
          $stmt = $dbh->prepare('SELECT ID FROM USER WHERE Username = ?');
          $stmt->execute(array($username));
          return $stmt->fetch();
        }catch(PDOException $e) {
          return -1;
        }
      }

// Get all users

    function getUsers() {
        global $dbh;
        try {
            $stmt = $dbh->prepare('SELECT Username FROM USER');
            $stmt->execute(array($idChannel));
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            return null;
        }
    }


// Get all stories from a user

    function getUserStories($idAuthor) {
        global $dbh;
        try {
            $stmt = $dbh->prepare('SELECT ID, Title, Text FROM STORY WHERE idAuthor = ?');
            $stmt->execute(array($idAuthor));
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            return null;
        }
    }


// Get all comments from a user

    function getUserComments($idAuthor) {
        global $dbh;
        try {
            $stmt = $dbh->prepare('SELECT ID, Text FROM COMMENT WHERE idAuthor = ?');
            $stmt->execute(array($idAuthor));
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            return null;
        }
    }

// Get all upvotes from a user

    function getUserUpvotes($UserID) {
        global $dbh;
        try {
            $stmt = $dbh->prepare('SELECT STORY.ID, STORY.TITLE, STORY.Text FROM UPVOTE,STORY WHERE (UserID = ? AND STORY.ID = UPVOTE.StoryID AND UserID=UPVOTE.UserID)');
            $stmt->execute(array($UserID));
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            return null;
        }
    }


// Get all channels subscribed

    function getUserSubscribe($UserID) {
        global $dbh;
        try {
            $stmt = $dbh->prepare('SELECT CHANNEL.ID, CHANNEL.Name FROM SUBSCRIBER, CHANNEL WHERE (UserID = ? AND STORY.ID = UPVOTE.StoryID AND UserID=UPVOTE.UserID)');
            $stmt->execute(array($UserID));
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            return null;
        }
    }

//Change user email

    function changeEmail($ID,$Email) {
        global $dbh;
        try {
            $stmt = $dbh->prepare('UPDATE USER SET Email = ? WHERE ID = ?');
            if($stmt->execute(array($ID, $Email)))
                return true;
            else
                return false;
        }catch(PDOException $e) {
            return null;
        }
    }

//Change password

    function changePassword($ID,$Password) {
        global $dbh;
        try {
            $stmt = $dbh->prepare('UPDATE USER SET Password = ? WHERE ID = ?');
            if($stmt->execute(array($ID, $Password)))
                return true;
            else
                return false;
        }catch(PDOException $e) {
            return null;
        }
    }

//Change Info

    function changeInfo($ID,$FirstName,$LastName,$Bio,$Avatar,$BirthDate) {
        global $dbh;
        try {
            $stmt = $dbh->prepare('UPDATE USER SET FirstName = ?, LastName = ?, Bio = ?, Avatar = ?, BirthDate = ? WHERE ID = ?');
            if($stmt->execute(array($ID,$FirstName,$LastName,$Bio,$Avatar,$BirthDate)))
                return true;
            else
                return false;
        }catch(PDOException $e) {
            return null;
        }
    }

?>
