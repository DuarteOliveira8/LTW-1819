<?php
  include_once('includes/Session.php');
  include_once('database/db-access/story.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/post/Post.php');
  include_once('templates/scene-templates/post/Comments.php');
  include_once('templates/shared-components/Footer.php');

  if (($post = getStory($matches['id'])) === false) {
    die(header('Location: /404'));
  }

  getHeader();
  getNavbar($user['username'], $user['avatar']);
?>

<link rel="stylesheet" href="/css/scenes/post/PostIndex.css">

<div class="container">
  <?php
    getPost($post['title'], $post['description'], $post['storyDate'], $post['username'], $post['avatar'], $post['upvoteRatio'], $post['comments']);
    getPostComments();
  ?>
</div>

<script type="text/javascript">
  let user = "<?php echo $user['username'] ?>";
  let csrf = "<?php echo $user['csrf'] ?>";
</script>
<script type="module" src="/js/scenes/post/Post.js"></script>

<?php getFooter(); ?>
