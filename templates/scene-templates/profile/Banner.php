<?php function getBanner($firstName, $lastName, $avatar, $banner) { ?>
  <div class="banner-container">
    <img src="/assets/images/user-banners/<?php echo htmlentities($banner) ?>" alt="" class="background-image">

    <div class="basic-info">
      <img src="/assets/images/users/<?php echo htmlentities($avatar) ?>" alt="" class="profile-picture">

      <div class="profile-name">
        <?php echo htmlentities($firstName)." ".htmlentities($lastName) ?>
      </div>
    </div>
  </div>
<?php } ?>
