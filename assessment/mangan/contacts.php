<?php
  session_start();
  require 'connection.php';

  $user_id = '';
  $username = '';
  $role = '';
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = 'SELECT * FROM user WHERE user.id="' . $user_id . '"';
    $query = mysqli_query($conn, $sql) or die('error: ' . $sql);
    $result = mysqli_fetch_array($query);

    $username = $result['username'];
    $role = $result['role'];

    if ($role == 'admin') {
      ?>
      <script>
        alert('Sorry, admin doesn\'t have access for this page.');
        location.href = 'dashboard.php';
      </script>
      <?php
    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>About</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
          <img src="./assets/img/GianLogo.png" alt="" width="64" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php">Cart</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="personal_information.php">Personal Information</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="orders.php">Orders</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="contacts.php">Contact Us</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="about.php">Tech Stack</a>
            </li>
          </ul>
          <?php
            if ($username == '') {
              ?>
              <div class="d-flex">
                <a class="btn btn-primary me-2" href="login.php">Login</a>
                <a class="btn btn-primary" href="register.php">Register</a>
              </div>
              <?php
            } else {
              ?>
              <a class="btn btn-primary" href="logout.php">Logout</a>
              <?php
            }
          ?>
        </div>
      </div>
    </nav>

    <div class="container my-4">
      <div class="row">
        <div class="col-12">
          <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="./assets/img/GianBanner.png" class="d-block w-100" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <h2 class="my-4">Contact Us</h2>
          <table style="width:100%">
  
          </div>
    
    <div class="mapouter"><div class="gmap_canvas"><iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Gaisano%20mall%20of%20davao&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://fmovies-online.net">fmovies</a><br><style>.mapouter{position:relative;text-align:right;height:500px;width:600px;}</style><a href="https://www.embedgooglemap.net">google maps api html</a><style>.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}</style></div></div>
 
    &nbsp
    &nbsp
    &nbsp
    &nbsp
    &nbsp
    
      </div>
    </div>

  </body>
</html>