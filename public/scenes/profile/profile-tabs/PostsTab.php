<?php
include("shared-components/Post.php");

function getProfilePosts() {
  for ($i=0; $i < 8; $i++) {
    getPost();
  }
}
?>
