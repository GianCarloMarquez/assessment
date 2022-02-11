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
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>Dashboard</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Mangan da Kita</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
            </li>
          </ul>
          <div class="d-flex align-items-center justify-content-center">
            <h4 class="text-white m-0 me-3"><?= $username; ?> (<?= $role; ?>)</h4>
            <a class="btn btn-primary" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </nav>

    <div class="container my-4">
      <div class="row">
        <div class="col-12">
          <h2>Orders</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Username</th>
                <th>Customer Name</th>
                <th>Delivery Address</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql1 = 'SELECT *, orders.id AS id FROM orders INNER JOIN user ON orders.user_id=user.id';
                $query1 = mysqli_query($conn, $sql1) or die('error: ' . $sql1);
                $index_cart = 1;
                
                while ($result1 = mysqli_fetch_array($query1)) {
                  ?>
                  <tr>
                    <td><?= $index_cart++; ?></td>
                    <td><?= $result1['date']; ?></td>
                    <td><?= $result1['username']; ?></td>
                    <td><?= $result1['customer_name']; ?></td>
                    <td><?= $result1['delivery_address']; ?></td>
                    <td>
                      <form action="admin_order_detail.php" method="POST">
                        <input type="hidden" name="order_id" value="<?= $result1['id']; ?>">
                        <button class="btn btn-primary" type="submit">Preview Detail</button>
                      </form>
                    </td>
                  </tr>
                  <?php
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <script src="./assets/vendor/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>