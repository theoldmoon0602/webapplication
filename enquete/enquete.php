<?php
if (isset($_POST['d'])) {
  $data = [0, 0, 0, 0];
  if (file_exists("rdmd.csv")) {
    $fp = fopen("rdmd.csv", "r");
    $data = fgetcsv($fp);
    fclose($fp);
  }

  $data[$_POST['d']] += 1;

  $fp = fopen("rdmd.csv", "w");
  $data = fputcsv($fp, $data);
  fclose($fp);
}
else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GO "D" Mars</title>
  <link rel="shortcut icon" href="d-man.png" type="image/png">

  <style>
h1 { text-align: center; }
form {
  width: 200px;
  margin: 0 auto;
}
label {
  display: block;
}
button {
background: none;
border: none;
}
</style>
</head>
<body>
  <h1>D言語君はお好き？</h1>

  <form action="" method="post">
    <div>
      <label for="d0"><input type="radio" name="d" value="0"  id="d0"/>  D言語君が好き</label>
      <label for="d1"><input type="radio" name="d" value="1"  id="d1"/>D言語君は<span class="rotsushi">&#x1f363;</span></label>
      <label for="d2"><input type="radio" name="d" value="2"  id="d2"/>D言語君は神</label>
      <label for="d3"><input type="radio" name="d" value="3" id="d3"/>D言語君なんて嫌い</label>

      <button><img src="d-man.png"></button>
    </div>
  </form>
</body>
</html>
<?php } ?>
