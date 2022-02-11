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
  } else {
    ?>
    <script>
      alert('Sorry, you have to login first.');
      location.href = 'login.php';
    </script>
    <?php
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

    <title>Cart</title>
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
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="cart.php">Cart</a>
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
        <div class="col-12">
          <h2>Cart</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Food</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $total_price = 0;

                $sql1 = 'SELECT * FROM temporary_order INNER JOIN temporary_order_detail ON temporary_order.id=temporary_order_detail.order_id INNER JOIN food ON temporary_order_detail.food_id=food.id WHERE temporary_order.user_id="' . $user_id . '"';
                $query1 = mysqli_query($conn, $sql1) or die('error: ' . $sql1);
                $index_cart = 1;
                
                while ($result1 = mysqli_fetch_array($query1)) {
                  $total_price += $result1['price'] * $result1['quantity'];

                  $food_id = $result1['food_id'];
                  $food_name = $result1['name'];
                  ?>
                  <tr>
                    <td><?= $index_cart++; ?></td>
                    <td>
                      <div class="d-flex">
                        <img src="./assets/img/<?= $food_id ?>.jpg" alt="" style="width: 8rem; height: 8rem;" class="me-4">
                        <div>
                          <form action="crud.php" method="POST">
                            <h4><?= $food_name; ?></h4>
                            <p class="mb-0">Price: ₱ <?= number_format($result1['price']); ?></p>
                            <p class="label_total_price">Total Price: ₱ <?= number_format($result1['price'] * $result1['quantity']); ?></p>
                            <input type="hidden" name="food_id" value="<?= $result1['id']; ?>">
                            <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                            <input type="hidden" class="input_price" name="price" value="<?= $result1['price']; ?>">
                            <div class="d-flex mb-2">
                              <button class="btn btn-outline-primary" type="button" onclick="change_product_price('-', this)">-</button>
                              <input type="number" class="form-control text-center input_quantity" name="quantity" placeholder="Quantity" value="<?= $result1['quantity']; ?>" min="0" max="<?= $result1['stock']; ?>" oninput="change_product_price('', this)">
                              <button class="btn btn-outline-primary" type="button" onclick="change_product_price('+', this)">+</button>
                            </div>
                            <button class="btn btn-primary text-nowrap d-none btn_add_food" type="submit" name="cmd" value="update_food_in_cart">Update Food Cart</button>
                            <form action="crud.php" method="POST">
                              <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                              <input type="hidden" name="food_id" value="<?= $result1['id']; ?>">
                              <button class="btn btn-danger btn_delete_food" type="submit" name="cmd" value="delete_food_from_cart">Delete</button>
                            </form>
                          </form>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php
                }
              ?>
              <tr>
                <td class="text-end" colspan="2">
                  <p>Total Amount: ₱ <?= number_Format($total_price); ?></p>

                  <?php
                    if ($total_price > 0) {
                      ?>
                      <a class="btn btn-primary" href="checkout.php">Checkout</a>
                      <?php
                    }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <script src="./assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script>
      function change_product_price(operator, element) {
        var form = element.closest('form');
        var input_price = form.querySelector('.input_price');
        var input_quantity = form.querySelector('.input_quantity');
        var label_total_price = form.querySelector('.label_total_price');
        var btn_add_food = form.querySelector('.btn_add_food');
        var btn_delete_food = form.querySelector('.btn_delete_food');

        if (operator == '-') {
          input_quantity.value--;
        } else if (operator == '+') {
            input_quantity.value++;
        }

        if (input_quantity.value == '0') {
          btn_delete_food.click();
          return;
        } else if (input_quantity.value == '') {
          input_quantity.value = '1';
        } else if (parseFloat(input_quantity.value) > parseFloat(input_quantity.getAttribute('max'))) {
          input_quantity.value = input_quantity.getAttribute('max');
        }

        var total_price = parseFloat(input_price.value) * parseFloat(input_quantity.value);

        label_total_price.innerHTML = `Total Price: ₱ ${Intl.NumberFormat().format(total_price)}`;
        btn_add_food.click();
      }
    </script>
  </body>
</html>