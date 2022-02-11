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

    <title>Home</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Mangan da Kita</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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
              <div class="d-flex align-items-center justify-content-center">
                <h4 class="text-white m-0 me-3"><?= $username; ?> (<?= $role; ?>)</h4>
                <a class="btn btn-primary" href="logout.php">Logout</a>
              </div>
              <?php
            }
          ?>
        </div>
      </div>
    </nav>

    <div class="container my-4">
      <div class="row">
        <div class="col-12 mb-4">
          <h2>Food List</h2>
        </div>
      </div>
      <div class="row">
        <?php
          $sql = 'SELECT * FROM food';
          $query = mysqli_query($conn, $sql) or die('error: ' . $sql);
          
          while ($result = mysqli_fetch_array($query)) {
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card w-100">
                <form action="crud.php" method="POST">
                  <img src="./assets/img/<?= $result['id']; ?>.jpg" class="card-img-top" alt="">
                  <div class="card-body">
                    <h5 class="card-title"><?= $result['name']; ?></h5>
                    <p class="card-text mb-0">Price: ₱ <?= number_format($result['price']); ?></p>
                    <p class="card-text label_total_price">Total Price: ₱ <?= number_format($result['price']); ?></p>
                    <input type="hidden" name="food_id" value="<?= $result['id']; ?>">
                    <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                    <input type="hidden" class="input_price" name="price" value="<?= $result['price']; ?>">
                    <div class="d-flex">
                      <input type="number" class="form-control me-4 input_quantity" name="quantity" placeholder="Quantity" value="1" min="1" max="<?= $result['stock']; ?>" oninput="change_product_price(this)">
                      <?php
                        if ($username == '') {
                          ?>
                          <a class="btn btn-primary text-nowrap" href="login.php">Add To Cart</a>
                          <?php
                        } else {
                          ?>
                          <button class="btn btn-primary text-nowrap" type="submit" name="cmd" value="add_food_to_cart">Add To Cart</button>
                          <?php
                        }
                      ?>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <?php
          }
        ?>
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