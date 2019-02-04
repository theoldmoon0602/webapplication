<?php include("header.php"); ?>
<section class="hero">
  <div class="hero-body">
    <div class="container">
    <h1 class="title">HELLO <?= o($session['login']); ?></h1>
    </div>
  </div>
</section>

<div class="columns">
<section class="column">
<h2 class="is-size-4">Users</h2>
   <table class="table">
    <tr>
      <th>NAME</th>
      <th>GRADE</th>
      <th>COURSE</th>
    </tr>
  <?php foreach ($users as $user) { ?>
    <tr>
      <td><?= o($user['username']); ?></td>
      <td><?= o($user['grade']); ?></td>
      <td>
      <?php if ($user['course'] == 1) {  ?>
        M
      <?php } else if ($user['course'] == 2) {  ?>
        E
      <?php } else if ($user['course'] == 3) {  ?>
        S
      <?php } else if ($user['course'] == 4) {  ?>
        I
      <?php } else { ?>
        C
      <?php } ?>
      </td>
    </tr>
  <?php } ?>
  </table>
</section>

<section class="column">
<h2 class="is-size-4">Productions</h2>
   <table class="table">
    <tr>
      <th>NAME</th>
      <th>AUTHOR</th>
    </td>
  <?php foreach ($productions as $p) { ?>
    <tr>
      <td><?= o($p['name']); ?></td>
      <td><?= o($p['author']); ?></td>
    </tr>
  <?php } ?>
  </table>
</section>
</div>

<?php include("footer.php"); ?>

