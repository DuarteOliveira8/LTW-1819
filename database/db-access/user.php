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

    if (!preg_match('/[0-9a-zA-Z_-]+$/', $username)) {
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

  // Get username with id
  function getID($username) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT ID
                            FROM USER
                            WHERE Username = ?
                          ');
      $stmt->execute(array($username));
      return $stmt->fetch()['ID'];
    } catch (PDOException $e) {
      return false;
    }
  }

  // Get user id with username
  function getUsername($userID) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT Username
                            FROM USER
                            WHERE ID = ?
                          ');
      $stmt->execute(array($userID));
      return $stmt->fetch()['Username'];
    } catch (PDOException $e) {
      return false;
    }
  }

  // Get user with id
  function getUser($username) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT Username, Firstname, Lastname, Email, Bio, Avatar, BirthDate
                            FROM USER
                            WHERE Username = ?
                          ');
      $stmt->execute(array($username));
      return $stmt->fetch();
    } catch (PDOException $e) {
      return false;
    }
  }

  // Get user avatar with id
  function getUserAvatar($username) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT Avatar
                            FROM USER
                            WHERE Username = ?
                          ');
      $stmt->execute(array($username));
      return $stmt->fetch();
    } catch (PDOException $e) {
      return false;
    }
  }

  // Get all users
  function getUsers() {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT Username FROM USER');
      $stmt->execute();
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return null;
    }
  }


  // Get all stories from a user
  function getUserPosts($author) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT DISTINCT S1.Title, S1.Description, S1.StoryDate, USER.Username, USER.Avatar, S1.UpvoteRatio, S1.ChannelStory, (SELECT count(*)
                                                                                                                                                  FROM STORY S2, COMMENT
                                                                                                                                                  WHERE S2.ID = S1.ID AND S1.ID = COMMENT.idStory) AS Comments
                            FROM STORY S1, USER
                            WHERE USER.Username = ? AND S1.idAuthor = USER.ID
                            ORDER BY S1.StoryDate DESC
                          ');
      $stmt->execute(array($author));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return false;
    }
  }


  // Get all comments from a user
  function getUserComments($username) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT Description, CommentDate, idStory, idComment, USER.Username, USER.Avatar
                            FROM COMMENT, USER
                            WHERE USER.Username = ? AND USER.ID = COMMENT.idAuthor
                            ORDER BY CommentDate DESC
                          ');
      $stmt->execute(array($username));
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
  function getUserDownvotes($username) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT STORY.Title, STORY.Description, STORY.StoryDate, STORY.UpvoteRatio, STORY.ChannelStory
                            FROM STORY, DOWNVOTE, USER
                            WHERE USER.Username = ? AND DOWNVOTE.userID = USER.ID AND DOWNVOTE.StoryID = STORY.ID
                            ORDER BY STORY.StoryDate DESC
                          ');
      $stmt->execute(array($username));
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

  function isUsernameValidForUpdate($UserID, $username) {
    $db = Database::getInstance()->getDB();

    if (!preg_match('/[0-9a-zA-Z]+$/', $username)) {
      return false;
    }

    try {
      $stmt = $db->prepare('SELECT *
                            FROM USER
                            WHERE Username = ?
                          ');
      $stmt->execute(array($username));
      $user = $stmt->fetch();

      if ($user !== false && $user['ID'] !== $UserID)
        return false;
      else
        return true;
    } catch (PDOException $e) {
      return false;
    }
  }

  //Change user email
  function isEmailValidForUpdate($UserID, $Email) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT *
                            FROM USER
                            WHERE Email = ?
                          ');
      $stmt->execute(array($email));
      $user = $stmt->fetch();

      if ($user !== false && $user['ID'] !== $UserID)
        return false;
      else
        return true;
    } catch (PDOException $e) {
      return false;
    }
  }

  //Change Info
  function updateUser($UserID, $Username, $FirstName, $LastName, $Email, $Bio, $BirthDate) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('UPDATE USER
                            SET Username = ?, FirstName = ?, LastName = ?, Email = ?, Bio = ?, BirthDate = ?
                            WHERE ID = ?
                          ');
      if($stmt->execute(array($Username, $FirstName, $LastName, $Email, $Bio, $BirthDate, $UserID)))
        return true;
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

  //Change Info
  function updateUserAvatar($UserID, $Avatar) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('UPDATE USER
                            SET Avatar = ?
                            WHERE ID = ?
                          ');
      if($stmt->execute(array($Avatar, $UserID)))
        return true;
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

  //Change password
  function updateUserPassword($UserID, $Password) {
    $db = Database::getInstance()->getDB();
    $hashedPW = hash('sha256', $Password);

    try {
      $stmt = $db->prepare('UPDATE USER
                            SET Password = ?
                            WHERE ID = ?
                          ');
      if($stmt->execute(array($hashedPW, $UserID)))
        return true;
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

?>
