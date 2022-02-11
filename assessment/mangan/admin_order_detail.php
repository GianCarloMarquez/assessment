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
    $first_name = $result['first_name'];
    $last_name = $result['last_name'];
    $role = $result['role'];
    $full_name = $first_name . ' ' . $last_name;

    if ($role == 'guest') {
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

  $order_id = $_POST['order_id'];

  $sql2 = 'SELECT * FROM orders INNER JOIN user ON orders.user_id=user.id WHERE orders.id="' . $order_id . '"';
  $query2 = mysqli_query($conn, $sql2) or die('error: ' . $sql2);

  $result2 = mysqli_fetch_array($query2);
  $date = $result2['date'];
  $customer_name = $result2['customer_name'];
  $delivery_address = $result2['delivery_address'];
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>Order Detail</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
          <img src="./assets/img/GianLogo.png" alt="" width="64" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="products.php">Products</a>
            </li>
          </ul>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </nav>

    <div class="container my-4">
      <div class="row justify-content-center">
        <div class="col-4">
          <form action="crud.php" method="POST">
            <a class="btn btn-outline-primary" href="dashboard.php">Back To Dashboard</a>
            <h4 class="text-center my-4">Order Form</h4>

            <div class="row g-3 align-items-center mb-2">
              <div class="col-auto">
                <label for="date" class="col-form-label">Date</label>
              </div>
              <div class="col-auto">
                <input type="date" id="date" name="date" class="form-control-plaintext" readonly value="<?= $date; ?>">
              </div>
            </div>
            <div class="row g-3 align-items-center mb-2">
              <div class="col-auto">
                <label for="username" class="col-form-label">Username</label>
              </div>
              <div class="col-auto">
                <input type="text" id="username" name="username" class="form-control-plaintext" readonly value="<?= $result2['username']; ?>">
              </div>
            </div>
            <div class="row g-3 align-items-center mb-2">
              <div class="col-auto">
                <label for="customer_name" class="col-form-label">Customer Name</label>
              </div>
              <div class="col-auto">
                <input type="text" id="customer_name" name="customer_name" class="form-control-plaintext" readonly value="<?= $customer_name; ?>">
              </div>
            </div>
            <div class="row g-3 align-items-center">
              <div class="col-auto">
                <label for="delivery_address" class="col-form-label">Delivery Address</label>
              </div>
              <div class="col-auto">
                <input type="text" id="delivery_address" name="delivery_address" class="form-control-plaintext" readonly value="<?= $delivery_address; ?>">
              </div>
            </div>

            <p class="text-center fst-italic mt-4">Order Details</p>
            <table class="table">
              <thead class="table-dark">
                <tr>
                  <th>Product Item</th>
                  <th>Quantity</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $total_price = 0;

                  $sql1 = 'SELECT * FROM orders INNER JOIN order_detail ON orders.id=order_detail.order_id INNER JOIN product ON order_detail.product_id=product.id WHERE orders.id="' . $order_id . '"';
                  $query1 = mysqli_query($conn, $sql1) or die('error: ' . $sql1);
                  $index_cart = 1;
                  
                  while ($result1 = mysqli_fetch_array($query1)) {
                    $total_price += $result1['price'] * $result1['quantity'];

                    $product_id = $result1['product_id'];
                    $product_name = $result1['name'];
                    ?>
                    <tr>
                      <td class="text-nowrap">
                        <p><?= $product_name; ?></p>
                      </td>
                      <td class="text-nowrap"><?= $result1['quantity']; ?></td>
                      <td class="text-nowrap">
                        <p class="mb-0">Price: ₱ <?= number_format($result1['price']); ?></p>
                        <p>Total Price: ₱ <?= number_format($result1['price'] * $result1['quantity']); ?></p>
                      </td>
                    </tr>
                    <?php
                  }
                ?>
                <tr>
                  <td class="text-nowrap" colspan="3">
                    <p>Total Amount: ₱ <?= number_Format($total_price); ?></p>
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>

    <script src="./assets/vendor/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>