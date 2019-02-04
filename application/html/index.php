<?php

require(__DIR__.'/../app.php');
require(__DIR__.'/../util.php');

$app = new App('', __DIR__ . '/../templates/');

// define routes
$app->addRouteGroup([
  ['index', 'GET', '/', function ($req) use($app) {
    $pdo = connect_db();

    $stmt = $pdo->prepare('select username, course, grade from users');
    $stmt->execute([]);
    $users = $stmt->fetchAll();

    $stmt = $pdo->prepare('select name, author from productions');
    $stmt->execute([]);
    $productions = $stmt->fetchAll();

    return $app->render($req, 'index.php', ['users' => $users, 'productions' => $productions]);
  }],
  ['create-production', 'GET', '/production', function ($req) use ($app) {
    return $app->render($req, 'production.php');
  }],
  ['create-production-post', 'POST', '/production', function ($req) use ($app) {
    $name = $req->getPost('name');
    $author = $req->getPost('author');
    if ($name && $author) {
      $pdo = connect_db();
      try {
        $stmt = $pdo->prepare('insert into productions(name, author) values (?, ?)');
        $stmt->execute([$name, $author]);
        return $app->render($req, 'production.php');
      }
      catch(PDOException $e) {}
    }
    return $app->render($req, 'production.php', ['msg' => 'Failed to register production']);
  }],
  ['promotion', 'GET', '/promotion', function ($req) use ($app) {
    $pdo = connect_db();

    $stmt = $pdo->prepare('select username, course, grade from users');
    $stmt->execute([]);
    $users = $stmt->fetchAll();

    return $app->render($req, 'promotion.php', ['users' => $users]);
  }],
  ['promotion-post', 'POST', '/promotion', function ($req) use ($app) {
    $pdo = connect_db();

    $stmt = $pdo->prepare('select username, course, grade from users');
    $stmt->execute([]);
    $users = $stmt->fetchAll();
    foreach ($users as $u) {
      if (array_search($u['username'], $req->getPost('names', [])) === FALSE) {
        $stmt = $pdo->prepare('update users set grade = ? where username = ? ');
        $stmt->execute([$u['grade'] + 1, $u['username']]);
      }
    }

    return $app->redirect('promotion', $req);
  }],
  ], [
    function($req, $next) use($app) {
      if ($req->getSession('login')) {
        return $next($req);
      }
      return $app->redirect('login', $req);
    }
]);

$app->addRoute('login', 'GET', '/login', function($req) use ($app) {
  return $app->render($req, 'login.php');
});

$app->addRoute('register', 'GET', '/register', function($req) use ($app) {
  return $app->render($req, 'register.php');
});


$app->addRoute('login-post', 'POST', '/login', function($req) use ($app) {
  $username = $req->getPost('username');
  $password = $req->getPost('password');
  if ($username && $password) {
    $pdo = connect_db();
    try {
      $stmt = $pdo->prepare('select password_hash from users where username=?');
      $stmt->execute([$username]);
      $user = $stmt->fetchAll();
      if (count($user) === 1 && password_verify($password, $user[0]['password_hash'])) {
        $req->session['login'] = $username;
        return $app->redirect('index', $req);
      }
    } catch (PDOException $e) {
    }
  }

  return $app->render($req, 'login.php', ['msg' => 'Failed to Login']);
});

$app->addRoute('register-post', 'POST', '/register', function($req) use ($app) {
  $username = $req->getPost('username');
  $password = $req->getPost('password');
  $grade = $req->getPost('grade');
  $course = $req->getPost('course');
  if ($username && $password &&  $grade && $course) {
    $pdo = connect_db();
    try {
      $stmt = $pdo->prepare('insert into users(username, password_hash, grade, course) values (?, ?, ?, ?)');
      $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), $grade, $course]);
      return $app->redirect('login', $req);
    }
    catch(PDOException $e) {
      return $app->render($req, 'register.php', ['msg' => 'Failed to Register ' . $e->getMessage()]);
    }
  }

  return $app->render($req, 'register.php', ['msg' => 'Failed to Register']);
});

$app->addRoute('logout', 'POST', '/logout', function($req) use ($app) {
  unset($req->session['login']);
  return $app->redirect('index', $req);
});

try {
  $app->write($app->run());
}
catch (NotFoundException $e) {
  $renderer = new PHPRenderer(__DIR__ . '/../templates/');
  echo $renderer->renderTemplate("404.php", ['app' => $app]);
}
catch (Exception $e) {
  $renderer = new PHPRenderer(__DIR__ . '/../templates/');
  echo $renderer->renderTemplate("500.php", ['app' => $app, 'msg' => $e->getMessage()]);
}
