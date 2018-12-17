<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/search/FoundChannels.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
?>

<link rel="stylesheet" href="/css/scenes/search/searchIndex.css">


<?php
  getNavbar($user['username'], $user['avatar']);
  getFoundChannels();
?>

<script type="module" src="/js/scenes/search/search.js"></script>

<?php getFooter(); ?>
