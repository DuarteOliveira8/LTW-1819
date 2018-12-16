<?php function getBanner($firstName, $lastName, $avatar, $banner) { ?>
  <div class="banner-container">
    <img src="/assets/images/user-banners/<?php echo strip_tags($banner) ?>" alt="" class="background-image">

    <div class="basic-info">
      <img src="/assets/images/users/<?php echo strip_tags($avatar) ?>" alt="" class="profile-picture">

      <div class="profile-name">
        <?php echo strip_tags($firstName)." ".strip_tags($lastName) ?>
      </div>
    </div>
  </div>
<?php } ?>
