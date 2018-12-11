<?php
  include_once(__DIR__ . '/../../includes/Database.php');

  // Add new User
  function createUser($username, $firstname, $lastname, $email, $password, $birthdate){
    $db = Database::getInstance()->getDB();
    $hashedPW = hash('sha256', $password);

    try {
	    $stmt = $db->prepare('INSERT INTO USER(Username, FirstName, LastName, Email, Password, BirthDate) VALUES (?, ?, ?, ?, ?, ?)');

      if($stmt->execute(array($username, $firstname, $lastname, $email, $hashedPW, $birthdate)))
        return $db->lastInsertId();
      else
        return -1;
    }catch(PDOException $e) {
      return -1;
    }
  }

  function isUsernameValid($username) {
    $db = Database::getInstance()->getDB();

    if (!preg_match('/[0-9a-zA-Z]+$/', $username)) {
      echo "hello";
      return false;
    }

    try {
      $stmt = $db->prepare('SELECT *
                            FROM USER
                            WHERE Username = ?
                          ');
      $stmt->execute(array($username));
      $user = $stmt->fetch();

      if ($user !== false)
        return false;
      else
        return true;
    } catch (PDOException $e) {
      return false;
    }
  }

  function isEmailValid($email) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT *
                            FROM USER
                            WHERE Email = ?
                          ');
      $stmt->execute(array($email));
      $user = $stmt->fetch();

      if ($user !== false)
        return false;
      else
        return true;
    } catch (PDOException $e) {
      return false;
    }
  }

  // Validate User
  function authenticateUser($email, $password) {
    $db = Database::getInstance()->getDB();
    $hashedPW = hash('sha256', $password);

    try {
      $stmt = $db->prepare('SELECT *
                            FROM USER
                            WHERE Email = ? AND Password = ?
                          ');
      $stmt->execute(array($email, $hashedPW));
      $user = $stmt->fetch();

      if ($user !== false)
        return $user['ID'];
      else
        return -1;
    } catch (PDOException $e) {
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

  // Get user with id
  function getUser($userID) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT Username, Firstname, Lastname, Email, Bio, Avatar, BirthDate
                            FROM USER
                            WHERE Id = ?
                          ');
      $stmt->execute(array($userID));
      return $stmt->fetch();
    } catch (PDOException $e) {
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
  function getUserPosts($idAuthor) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT Title, Description, StoryDate, UpvoteRatio, ChannelStory
                            FROM STORY
                            WHERE idAuthor = ?
                            ORDER BY StoryDate DESC
                          ');
      $stmt->execute(array($idAuthor));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return false;
    }
  }


  // Get all comments from a user
  function getUserComments($idAuthor) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT Description, CommentDate, idStory, idComment
                            FROM COMMENT
                            WHERE idAuthor = ?
                            ORDER BY CommentDate DESC
                          ');
      $stmt->execute(array($idAuthor));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return false;
    }
  }

  //Get all votes from a user
  function getUserVotes($UserID) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT DISTINCT STORY.Title, STORY.Description, STORY.StoryDate, STORY.UpvoteRatio, STORY.ChannelStory
                            FROM STORY, UPVOTE, DOWNVOTE
                            WHERE ((UPVOTE.userID = ? AND UPVOTE.StoryID = STORY.ID)
                                  OR
                                  (DOWNVOTE.userID = ? AND DOWNVOTE.StoryID = STORY.ID))
                            ORDER BY STORY.StoryDate DESC
                          ');
      $stmt->execute(array($UserID, $UserID));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return false;
    }
  }

  // Get all upvotes from a user
  function getUserUpvotes($UserID) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT STORY.Title, STORY.Description, STORY.StoryDate, STORY.UpvoteRatio, STORY.ChannelStory
                            FROM STORY, UPVOTE
                            WHERE (UPVOTE.userID = ? AND UPVOTE.StoryID = STORY.ID)
                            ORDER BY STORY.StoryDate DESC
                          ');
      $stmt->execute(array($UserID));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return null;
    }
  }

  // Get all upvotes from a user
  function getUserDownvotes($UserID) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT STORY.Title, STORY.Description, STORY.StoryDate, STORY.UpvoteRatio, STORY.ChannelStory
                            FROM STORY, DOWNVOTE
                            WHERE (DOWNVOTE.userID = ? AND DOWNVOTE.StoryID = STORY.ID)
                            ORDER BY STORY.StoryDate DESC
                          ');
      $stmt->execute(array($UserID));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return null;
    }
  }

  // Get all channels subscribed
  function getUserSubscribed($UserID) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT CHANNEL.Name, CHANNEL.Description
                            FROM SUBSCRIBER, CHANNEL
                            WHERE (SUBSCRIBER.UserID = ? AND SUBSCRIBER.ChannelID = CHANNEL.ID)
                            ORDER BY CHANNEL.Name
                          ');
      $stmt->execute(array($UserID));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return false;
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
