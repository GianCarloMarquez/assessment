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
            <a class="nav-link" href="contacts.php">Contact Us</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="about.php">Tech Stack</a>
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
          <h2 class="my-4">Technology Stack</h2>
          <table style="width:100%">
  <tr>
    <th>APPLICATION</th>
    <th>DESCRIPTION</th>

  </tr>
  <tr>
    <td>XAMPP</td>
    <td>XAMPP is a free and open-source cross-platform web server solution stack package developed by Apache Friends, consisting mainly of the Apache HTTP Server, MariaDB database, and interpreters for scripts written in the PHP and Perl programming languages.</td>
    
  </tr>
      <tr>
        <td>PHP</td>
        <td>PHP is a general-purpose scripting language geared towards web development. It was originally created by Danish-Canadian programmer Rasmus Lerdorf in 1994. The PHP reference implementation is now produced by The PHP Group.</td>
       </tr> 
       
        <tr>
        <td>CANVA</td>
        <td>Canva is a free graphic design platform that's great for making invitations, business cards, Instagram posts, and more. A drag and drop interface makes customizing thousands of templates simple and easy. Canva's wide array of features allow you to edit photos without extensive photo editing knowledge or experience.</td> 
      </tr>
      <tr>
          <td>PHOTOSHOP</td>
          <td>Photoshop is Adobe's photo editing, image creation and graphic design software. The software provides many image editing features for raster (pixel-based) images as well as vector graphics.Photoshop actions include automation features to reduce the need for repetitive tasks.</td> 
</tr>
  <tr>
        <td>CASCADING STYLE SHEETS (CSS)</td>
        <td>Cascading Style Sheets (CSS) is a style sheet language used for describing the presentation of a document written in a markup language such as HTML. CSS is a cornerstone technology of the World Wide Web, alongside HTML and JavaScript.</td> 
          </tr>

          <tr>
        <td>HTML</td>
        <td>HTML, in full hypertext markup language, a formatting system for displaying material retrieved over the Internet.HTML markup tags specify document elements such as headings, paragraphs, and tables. They mark up a document for display by a computer program known as a Web browser.</td> 
        </tr>

        <tr>
            <td>GITHUB</td>
            <td>GitHub, Inc. is a provider of Internet hosting for software development and version control using Git. It offers the distributed version control and source code management functionality of Git, plus its own features.</td> 
            </tr>
      
</table>
      </div>
    </div>

    <script src="./assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script>
      function change_product_price(element) {
        var form = element.closest('form');
        var input_price = form.querySelector('.input_price');
        var input_quantity = form.querySelector('.input_quantity');
        var label_total_price = form.querySelector('.label_total_price');

        if (input_quantity.value == '') {
          input_quantity.value = '1';
        } else if (parseFloat(element.value) > parseFloat(input_quantity.getAttribute('max'))) {
          input_quantity.value = input_quantity.getAttribute('max');
        }

        var total_price = parseFloat(input_price.value) * parseFloat(input_quantity.value);

        label_total_price.innerHTML = `Total Price: ₱ ${Intl.NumberFormat().format(total_price)}`;
      }
    </script>
  </body>
</html>