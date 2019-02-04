<?php include("header.php"); ?>

<form method="post" action="<?= $app->urlFor('register-post'); ?>">
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

  <div class="field">
    <label class="label">GRADE</label>
    <div class="control">
      <input class="input" name="grade" type="number" placeholder="1">
    </div>
  </div>

  <div class="field">
  <div class="select">
    <select name="course">
      <option value="1">M</option>
      <option value="2">E</option>
      <option value="3">S</option>
      <option value="4">I</option>
      <option value="5">C</option>
    </select>
  </div>
</div>

  <div class="control">
    <input type="submit" value="Register" class="button is-link" />
  </div>
</section>
<?php include("footer.php"); ?>
