/* from stack overflow (https://stackoverflow.com/questions/1527803/)  */
function random(min, max) {
  return Math.random() * (max - min) + min;
}
function randint(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

document.addEventListener("DOMContentLoaded", function() {
  let c = document.querySelector("#container");
  let btn = document.querySelector("#newball");
  let btn2 = document.querySelector("#newballs");

  const addBall = () => {
    let ball = document.createElement("div");
    ball.classList.add("ball");
    ball.style.top=5 + "%";
    ball.style.left=5 + "%";
    ball.style.background='rgb('+randint(0, 255) + ","+ randint(0, 255) + "," + randint(0, 255)+")";
    ball.dataset.dx=random(-2.0, 2.0);
    ball.dataset.dy=random(-2.0, 2.0);
    c.appendChild(ball);

    btn.innerText = document.querySelectorAll(".ball").length + " " + "balls";
  };

  btn.addEventListener("click", addBall);
  btn2.addEventListener("click", () => { for(let i=0; i < 100; i++){ addBall(); }});

  setInterval(function() {
    let balls = document.querySelectorAll(".ball");
    for (let ball of balls) {
      let dx = parseFloat(ball.dataset.dx);
      let dy = parseFloat(ball.dataset.dy);
      let x =  parseFloat(ball.style.left.replace("%", ""));
      let y =  parseFloat(ball.style.top.replace("%", ""));
      if (dx + x < 0 || dx + x > 100) {
        dx = -dx;
        ball.dataset.dx = dx;
      }
      if (dy + y < 0 || dy + y > 100) {
        dy = -dy;
        ball.dataset.dy = dy;
      }
      ball.style.left = Math.min(x + dx, 100) + "%";
      ball.style.top = Math.min(y + dy, 100) + "%";
    }
  }, 1000.0/60.0);
});

