<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Page Not Found</title>
  <link rel="shortcut icon" href="https://img.icons8.com/material-sharp/24/000000/nothing-found.png">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/src/css/page-not-found.css')}}">
</head>
<body>
  <div id="container">
    <div class="content">
      <h2>404</h2>  
      <h4>Maaf, Halaman tidak ditemukan !</h4>
    </div>
  </div>
  <script>
    var container = document.getElementById('container');
    window.onmousemove = function(e){
      var x = - e.clientX / 5,
          y = - e.clientY / 5;
      container.style.backgroundPositionX = x + 'px';
      container.style.backgroundPositionY = y + 'px';
    };
  </script>
</body>
</html>