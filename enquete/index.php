
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

    if ($_POST['d'] == 3) {

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GO "D" Mars</title>
  <link rel="shortcut icon" href="d-man.png" type="image/png">
  <link rel="stylesheet" href="style.css">
<style>
body {
  background-image: url(./d-man-zoom.png);
  background-color: red;
  background-repeat: no-repeat;
}
</style>

</head>

<body>

</body>
</html>
<?php
    }
    else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GO "D" Mars</title>
  <link rel="shortcut icon" href="d-man.png" type="image/png">
  <link rel="stylesheet" href="style.css">
<style>
.d-man {
  display: block;
  position: absolute;
  top: calc(50% - 89px);
  left:calc(50% - 82px);
  text-decoration: none;
}
.d-man-leftarm {
  animation: wave 0.5s infinite;
}
.d-man-rightarm {
  transform: rotate(0.75turn);
}
@keyframes wave {
  0% {
    transform: rotate(0.1turn);
  }

  50% {
    transform: rotate(0.25turn);
  }

  100% {
    transform: rotate(0.1turn);
  }
}
</style>

</head>

<body>

  <a class="d-man" data-rot="0" href="/" >
    <img src="d-button.png" class="d-man-body" alt="">
    <img src="d-man-leftarm.png" class="d-man-leftarm" alt="" data-rot="0">
    <img src="d-man-rightarm.png" class="d-man-rightarm" alt="" data-rot="0">
    <img src="d-man-leftleg.png" class="d-man-leftleg" alt="" data-rot="0">
    <img src="d-man-rightleg.png" class="d-man-rightleg" alt="" data-rot="0">
  </div>


</body>
</html>

<?php
}
} else {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GO "D" Mars</title>
  <link rel="shortcut icon" href="d-man.png" type="image/png">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1 class="aiueo">D言語君はお好き？</h1>

  <div id="d-mans"></div>

  <div class="d-man" id="d-man-template" data-rot="0" >
    <img src="d-button.png" class="d-man-body" alt="">
    <img src="d-man-leftarm.png" class="d-man-leftarm" alt="" data-rot="0">
    <img src="d-man-rightarm.png" class="d-man-rightarm" alt="" data-rot="0">
    <img src="d-man-leftleg.png" class="d-man-leftleg" alt="" data-rot="0">
    <img src="d-man-rightleg.png" class="d-man-rightleg" alt="" data-rot="0">
  </div>


  <form action="" method="post">
    <div class="aiueo">
      <label for="d0"><input type="radio" name="d" value="0"  id="d0"/>  D言語君が好き</label>
      <label for="d1"><input type="radio" name="d" value="1"  id="d1"/>D言語君は<span class="rotsushi">&#x1f363;</span></label>
      <label for="d2"><input type="radio" name="d" value="2"  id="d2"/>D言語君は神</label>
      <label for="d3"><input type="radio" name="d" value="3" id="d3"/>D言語君なんて嫌い</label>
    </div>

      <button>
        <img src="d-button.png" class="btn btn-inactive">
        <img src="d-button-active.png" class="btn btn-active">
      </button>
  </form>

  <script>
/* from stack overflow (https://stackoverflow.com/questions/1527803/)  */
function random(min, max) {
  return Math.random() * (max - min) + min;
}
function randint(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

    document.addEventListener("DOMContentLoaded", function() {
      const template = document.querySelector("#d-man-template");
      const dmans = document.querySelector("#d-mans");

      for (let i = 0; i < 100; i++) {
        let new_dman = template.cloneNode(true);
        new_dman.removeAttribute("id");
        new_dman.style.top = randint(0, 100) + "%";
        new_dman.style.left = randint(0, 100) + "%";
        dmans.appendChild(new_dman);
      }

      let f = ()  => {
        for (let i = 0; i < dmans.children.length; i++) {
          let x =  parseFloat(dmans.children[i].style.left.replace("%", ""));
          let y =  parseFloat(dmans.children[i].style.top.replace("%", ""));
          let r =  parseFloat(dmans.children[i].dataset.rot);

          dmans.children[i].style.left = (x + random(-1, 1)) + "%";
          dmans.children[i].style.top = (y + random(-1, 1)) + "%";
          r = r + random(-0.1, 0.1);
          dmans.children[i].dataset.rot = r;
          dmans.children[i].style.transform = "rotate(" + r + "turn)";

          for (let j = 0; j < dmans.children[i].children.length; j++) {
            let r =  parseFloat(dmans.children[i].children[j].dataset.rot);
            r = r + random(-0.1, 0.1);
            dmans.children[i].children[j].dataset.rot = r;
            dmans.children[i].children[j].style.transform = "rotate(" + r + "turn)";
          }
        }
      };

      setInterval(f, 1000 / 60.0);
    });
  </script>
</body>
</html>
<?php }?>
