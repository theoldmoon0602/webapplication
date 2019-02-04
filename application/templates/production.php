<?php include("header.php"); ?>

<form method="post" action="<?= $app->urlFor('create-production-post'); ?>">
  <div class="field">
    <label class="label">NAME</label>
    <div class="control">
      <input class="input" name="name" type="text" placeholder="HOGEPIYO">
    </div>
  </div>

  <div class="field">
    <label class="label">AUTHOR</label>
    <div class="control">
    <input class="input" name="author" type="text" value="<?= o($session['login']); ?>">
    </div>
  </div>

  <div class="control">
    <input type="submit" value="Register" class="button is-link" />
  </div>
</section>
<?php include("footer.php"); ?>
