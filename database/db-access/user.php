<?php
  include_once(__DIR__ . '/../../includes/Database.php');

  // Add new User
  function createUser($username, $firstName, $lastName, $email, $password, $birthDate){
    $db = Database::getInstance()->getDB();
    $hashedPW = hash('sha256', $password);

    try {
	    $stmt = $db->prepare('INSERT INTO USER(username, firstName, lastName, email, password, birthDate) VALUES (?, ?, ?, ?, ?, ?)');

      if($stmt->execute(array($userName, $firstName, $lastName, $email, $hashedPW, $birthDate)))
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
                            WHERE username = ?
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
                            WHERE email = ?
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
                            WHERE email = ? AND password = ?
                          ');
      $stmt->execute(array($email, $hashedPW));
      $user = $stmt->fetch();

      if ($user !== false)
        return $user['id'];
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
      $stmt = $db->prepare('SELECT id
                            FROM USER
                            WHERE username = ?
                          ');
      $stmt->execute(array($username));
      return $stmt->fetch()['id'];
    } catch (PDOException $e) {
      return false;
    }
  }

  // Get user id with username
  function getUsername($userId) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT username
                            FROM USER
                            WHERE id = ?
                          ');
      $stmt->execute(array($userId));
      return $stmt->fetch()['username'];
    } catch (PDOException $e) {
      return false;
    }
  }

  // Get user with id
  function getUser($username) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT username, firstName, lastName, email, bio, avatar, birthDate
                            FROM USER
                            WHERE username = ?
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
      $stmt = $db->prepare('SELECT avatar
                            FROM USER
                            WHERE username = ?
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
      $stmt = $db->prepare('SELECT username
                            FROM USER
                          ');
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
      $stmt = $db->prepare('SELECT DISTINCT S1.title, S1.description, S1.storyDate, USER.username, USER.avatar, S1.upvoteRatio, S1.channel, (SELECT count(*)
                                                                                                                                             FROM STORYCOMMENT
                                                                                                                                             WHERE S1.id = STORYCOMMENT.storyId) AS comments
                            FROM STORY S1, USER
                            WHERE USER.username = ? AND S1.idAuthor = USER.id
                            ORDER BY S1.storyDate DESC
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
      $stmt = $db->prepare('SELECT description, commentDate, idStory, idComment, USER.username, USER.avatar
                            FROM COMMENT, USER
                            WHERE USER.username = ? AND USER.id = COMMENT.idAuthor
                            ORDER BY commentDate DESC
                          ');
      $stmt->execute(array($username));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return false;
    }
  }

  //Get all votes from a user
  function getUserVotes($userID) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT DISTINCT STORY.title, STORY.description, STORY.storyDate, STORY.upvoteRatio, STORY.channelStory
                            FROM STORY, UPVOTE, DOWNVOTE
                            WHERE ((UPVOTE.userId = ? AND UPVOTE.storyId = STORY.id)
                                  OR
                                  (DOWNVOTE.userId = ? AND DOWNVOTE.storyId = STORY.id))
                            ORDER BY STORY.StoryDate DESC
                          ');
      $stmt->execute(array($userId, $userId));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return false;
    }
  }

  // Get all upvotes from a user
  function getUserUpvotes($userId) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT STORY.title, STORY.description, STORY.storyDate, STORY.upvoteRatio, STORY.channelStory
                            FROM STORY, UPVOTE
                            WHERE (UPVOTE.userId = ? AND UPVOTE.storyId = STORY.id)
                            ORDER BY STORY.storyDate DESC
                          ');
      $stmt->execute(array($userID));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return null;
    }
  }

  // Get all upvotes from a user
  function getUserDownvotes($username) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT STORY.title, STORY.description, STORY.storyDate, STORY.upvoteRatio, STORY.channel
                            FROM STORY, STORYDOWNVOTE, USER
                            WHERE USER.username = ? AND STORYDOWNVOTE.userId = USER.id AND STORYDOWNVOTE.storyId = STORY.id
                            ORDER BY STORY.storyDate DESC
                          ');
      $stmt->execute(array($username));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return null;
    }
  }

  // Get all channels subscribed
  function getUserSubscribed($userId) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT CHANNEL.name, CHANNEL.description
                            FROM SUBSCRIBER, CHANNEL
                            WHERE (SUBSCRIBER.userId = ? AND SUBSCRIBER.channelId = CHANNEL.id)
                            ORDER BY CHANNEL.name
                          ');
      $stmt->execute(array($userId));
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return false;
    }
  }

  function isUsernameValidForUpdate($userId, $username) {
    $db = Database::getInstance()->getDB();

    if (!preg_match('/[0-9a-zA-Z]+$/', $username)) {
      return false;
    }

    try {
      $stmt = $db->prepare('SELECT *
                            FROM USER
                            WHERE username = ?
                          ');
      $stmt->execute(array($username));
      $user = $stmt->fetch();

      if ($user !== false && $user['id'] !== $userId)
        return false;
      else
        return true;
    } catch (PDOException $e) {
      return false;
    }
  }

  //Change user email
  function isEmailValidForUpdate($userId, $email) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT *
                            FROM USER
                            WHERE email = ?
                          ');
      $stmt->execute(array($email));
      $user = $stmt->fetch();

      if ($user !== false && $user['id'] !== $userId)
        return false;
      else
        return true;
    } catch (PDOException $e) {
      return false;
    }
  }

  //Change Info
  function updateUser($userId, $username, $firstName, $lastName, $email, $bio, $birthDate) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('UPDATE USER
                            SET username = ?, firstName = ?, lastName = ?, email = ?, bio = ?, birthDate = ?
                            WHERE id = ?
                          ');
      if($stmt->execute(array($username, $firstName, $lastName, $email, $bio, $birthDate, $userId)))
        return true;
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

  //Change Info
  function updateUserAvatar($userId, $avatar) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('UPDATE USER
                            SET avatar = ?
                            WHERE id = ?
                          ');
      if($stmt->execute(array($avatar, $userId)))
        return true;
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

  //Change password
  function updateUserPassword($userId, $password) {
    $db = Database::getInstance()->getDB();
    $hashedPW = hash('sha256', $password);

    try {
      $stmt = $db->prepare('UPDATE USER
                            SET password = ?
                            WHERE id = ?
                          ');
      if($stmt->execute(array($hashedPW, $userId)))
        return true;
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

?>
