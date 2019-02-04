<?php include("header.php"); ?>

<h2 class="is-size-4">留年した人をえらんでね</h2>

<form method="post" action="<?= $app->urlFor('promotion-post'); ?>">
<div class="field">
  <div class="select is-multiple">
    <select multiple name="names[]">
      <?php foreach ($users as $u) { ?>
      <option value="<?= o($u['username']); ?>"><?= o($u['username']); ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="control">
    <input type="submit" value="進級" class="button is-link" />
  </div>
</div>
</form>

<?php include("footer.php"); ?>

