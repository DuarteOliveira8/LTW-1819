<?php
  include_once(__DIR__ . '/../../includes/Database.php');

  // Add new channel
    function createChannel($ChannelName, $ChannelDescription,$Creator){
        global $dbh;
        try {
  		    $stmt = $dbh->prepare('INSERT INTO CHANNEL(Name, Description, idCreator) VALUES (:Name, :Description, :idCreator)');
  		    $stmt->bindParam(':Name', $ChannelName);
            $stmt->bindParam(':Description', $ChannelDescription);
            $stmt->bindParam(':idCreator', $Creator);
            if($stmt->execute())
                return $dbh->lastInsertId();
            else
                return -1;
        }catch(PDOException $e) {
            return -1;
        }

    }

    // Get channel
    function getChannel($ChannelName) {
      $db = Database::getInstance()->getDB();

      try {
        $stmt = $db->prepare('SELECT *
                              FROM CHANNEL
                              WHERE Name = ?
                            ');
        $stmt->execute(array($ChannelName));
        $channel = $stmt->fetch();

        if ($channel !== false)
          return $channel['ID'];
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


  // Get all channels
  function getChannels() {
    global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT ID, Name, Description FROM CHANNEL');
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
                            WHERE UserID = ? AND ChannelID = ?
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
	    $stmt = $db->prepare('INSERT INTO SUBSCRIBER(UserID, ChannelID) VALUES (?, ?)');

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
      $stmt = $db->prepare('DELETE FROM SUBSCRIBER WHERE UserID = ? AND ChannelID = ?');

      if($stmt->execute(array($user, $channel)))
        return true;
      else
        return false;
    } catch(PDOException $e) {
      return false;
    }
  }
?>
