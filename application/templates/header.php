<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gensiken</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  </head>
  <body>
  <section class="section">
    <div class="container">
      <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
          <a class="navbar-item is-size-3" href="<?= $app->urlFor('index') ?>">Gensiken</a>

          <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
          <div class="navbar-start">
          <a class="navbar-item" href="<?= $app->urlFor('create-production'); ?>">Create Production</a>
            <a class="navbar-item" href="<?= $app->urlFor('promotion'); ?>">Promotion</a>
          </div>

          <?php if(isset($session['login'])) { ?>
          <div class="navbar-end">
            <a class="navbar-item" href="<?= $app->urlFor('logout'); ?>" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Logout</a>
            <form method="post" action="<?= $app->urlFor('logout'); ?>" style="display: none;" id="logoutForm">
            </form>
          </div>
          <?php } else { ?>
          <div class="navbar-end">
            <a class="navbar-item" href="<?= $app->urlFor('register') ?>">Register</a>
            <a class="navbar-item" href="<?= $app->urlFor('login') ?>">Login</a>
          </div>
          <?php } ?>
        </div>
      </nav>

    <?php if (isset($msg)) { ?>
    <div class="notification is-danger"><?= o($msg); ?></div>
    <?php } ?>
