<?php
  include_once(__DIR__ . '/../../includes/Database.php');

  // Add new channel
  function createChannel($channelName, $slogan, $idCreator){
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('INSERT INTO CHANNEL(name, slogan, idCreator)
                            VALUES (?, ?, ?)
                          ');

      if($stmt->execute(array($channelName, $slogan, $idCreator)))
        return $db->lastInsertId();
      else
        return -1;
    }catch(PDOException $e) {
        return -1;
    }
  }

  // Update channel
  function updateChannel($channelId, $channelName, $slogan){
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('UPDATE CHANNEL
                            SET name = ?, slogan = ?
                            WHERE id = ?
                          ');

      if($stmt->execute(array($channelName, $slogan, $channelId)))
        return true;
      else
        return false;
    }catch(PDOException $e) {
        return false;
    }
  }

  // Verifies if user is channel creator
  function isUserAuthor($channelName, $userId) {
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('SELECT *
                            FROM CHANNEL
                            WHERE name = ? AND idCreator = ?
                          ');
      $stmt->execute(array($channelName, $userId));
      $channel = $stmt->fetch();

      if($channel !== false)
        return true;
      else
        return false;
    }catch(PDOException $e) {
        return false;
    }
  }

  function isNameValidForUpdate($channelName) {
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('SELECT *
                            FROM CHANNEL
                            WHERE name = ?
                          ');
      $stmt->execute(array($channelName));
      $channel = $stmt->fetch();

      if($channel === false)
        return true;
      else
        return false;
    }catch(PDOException $e) {
        return false;
    }
  }

  // Get channel stories
  function getChannelPosts($offset, $channel) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT STORY.id,
                                   STORY.title,
                                   STORY.description,
                                   STORY.upvoteRatio,
                                   STORY.storyDate,
                                   USER.username,
                                   USER.avatar,
                                   (SELECT count(*)
                                    FROM STORYCOMMENT
                                    WHERE STORY.id = STORYCOMMENT.storyId) AS comments
                            FROM STORY, USER
                            WHERE STORY.channel = ? AND STORY.idAuthor = USER.id
                            ORDER BY STORY.storyDate DESC
                            LIMIT 8 OFFSET ?
                          ');
      $stmt->execute(array($channel, $offset));
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      return false;
    }
  }

  // Get channel rules
  function getChannelRules($channel) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT description
                            FROM RULE
                            WHERE RULE.idChannel = ?
                          ');
      $stmt->execute(array($channel));
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      return false;
    }
  }

  // Get channel
  function getChannel($channelName) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT id,
                                   name,
                                   slogan,
                                   banner,
                                   idCreator,
                                   (SELECT count(*)
                                    FROM SUBSCRIBER
                                    WHERE SUBSCRIBER.channelId = CHANNEL.id) AS subscriptions,
                                   (SELECT count(*)
                                    FROM STORY
                                    WHERE STORY.channel = CHANNEL.id) AS posts
                            FROM CHANNEL
                            WHERE name = ?
                          ');
      $stmt->execute(array($channelName));
      return $stmt->fetch();
    } catch (PDOException $e) {
      return false;
    }
  }

  // Get channel id
  function getChannelId($channelName) {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT id
                            FROM CHANNEL
                            WHERE name = ?
                          ');
      $stmt->execute(array($channelName));
      $channel = $stmt->fetch();

      if ($channel !== false)
        return $channel['id'];
      else
        return -1;
    } catch (PDOException $e) {
      return -1;
    }
  }

  // Delete channel
  function deleteChannel($ChannelID){
    global $dbh;
    try {
    	$stmt = $dbh->prepare('DELETE FROM CHANNEL WHERE ID = :ID');
    	$stmt->bindParam(':ID', $ChannelID);
    	if($stmt->execute())
    		return true;
    	else
    		return false;
  	} catch(PDOException $e) {
  		return false;
	  }
  }

  function getMatchNameChannel($channelName){
    $db = Database::getInstance()->getDB();
    try {
      $stmt = $db->prepare('SELECT id,
                                   name,
                                   slogan,
                                   banner,
                                   idCreator,
                                   (SELECT count(*)
                                    FROM SUBSCRIBER
                                    WHERE SUBSCRIBER.channelId = CHANNEL.id) AS subscriptions,
                                   (SELECT count(*)
                                    FROM STORY
                                    WHERE STORY.channel = CHANNEL.id) AS posts
                            FROM CHANNEL
                            WHERE name LIKE ? 
                          ');
      $stmt->execute(array($channelName));
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      return false;
    }

  }


  // Get all channels
  function getMainChannels() {
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('SELECT name,
                                   banner,
                                  (SELECT count(*)
                                   FROM SUBSCRIBER
                                   WHERE SUBSCRIBER.channelId = CHANNEL.id) AS subscriptions,
                                  (SELECT count(*)
                                   FROM STORY
                                   WHERE STORY.channel = CHANNEL.id) AS posts
                             FROM CHANNEL
                             ORDER BY subscriptions DESC
                             LIMIT 8
                           ');
      $stmt->execute();
      return $stmt->fetchAll();
    }catch(PDOException $e) {
      return null;
    }
  }

  // Subscribe to channel
  function isSubscribed($user, $channel){
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('SELECT *
                            FROM SUBSCRIBER
                            WHERE userId = ? AND channelId = ?
                          ');
      $stmt->execute(array($user, $channel));
      $subscription = $stmt->fetch();

      if($subscription !== false)
        return true;
      else
        return false;
    }catch(PDOException $e) {
      return false;
    }
  }

  // Subscribe to channel
  function insertSubscriber($user, $channel){
    $db = Database::getInstance()->getDB();

    try {
	    $stmt = $db->prepare('INSERT INTO SUBSCRIBER(userId, channelId)
                            VALUES (?, ?)
                          ');

      if($stmt->execute(array($user, $channel)))
        return $db->lastInsertId();
      else
        return -1;
    }catch(PDOException $e) {
      return -1;
    }
  }

  // Unsubscribe to channel
  function deleteSubscriber($user, $channel){
    $db = Database::getInstance()->getDB();

    try {
      $stmt = $db->prepare('DELETE
                            FROM SUBSCRIBER
                            WHERE userId = ? AND channelId = ?
                          ');

      if($stmt->execute(array($user, $channel)))
        return true;
      else
        return false;
    } catch(PDOException $e) {
      return false;
    }
  }
?>
