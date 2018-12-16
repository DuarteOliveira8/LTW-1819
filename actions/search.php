<?php
    include_once('../../includes/Session.php');
    include_once('../../database/db-access/user.php');
    
    $search = htmlentities($_POST['search']);
    
    header('Location: /search.php?search='. $search);
?>