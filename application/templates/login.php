<?php include("header.php"); ?>

<form method="post" action="<?= $app->urlFor('login-post'); ?>">
  <div class="field">
    <label class="label">NAME</label>
    <div class="control">
      <input class="input" name="username" type="text" placeholder="MADARAME">
    </div>
  </div>

  <div class="field">
    <label class="label">PASSWORD</label>
    <div class="control">
      <input class="input" name="password" type="password" placeholder="ILOVEMIKU">
    </div>
  </div>

  <div class="control">
    <input type="submit" value="Login" class="button is-link" />
  </div>
</section>
<?php include("footer.php"); ?>
