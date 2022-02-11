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

    <title>Products</title>
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
              <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="products.php">Products</a>
            </li>
          </ul>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </nav>

    <div class="container my-4">
      <div class="row">
        <h2>Product List</h2>

        <div>
          <a class="btn btn-primary my-4" href="create_product.php">Create Product</a>
        </div>

        <table class="table">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Product</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = 'SELECT * FROM product';
            $query = mysqli_query($conn, $sql) or die('error: ' . $sql);
            $index_product = 1;

            while ($result = mysqli_fetch_array($query)) {
              ?>
              <tr>
                <td><?= $index_product++; ?></td>
                <td>
                  <div class="d-flex">
                    <img src="<?= $result['image']; ?>" alt="" style="width: 12rem; height: 12rem;">
                    <div class="ms-4">
                      <h5><?= $result['name']; ?></h5>
                      <p class="mb-0">Stock: <?= $result['stock']; ?></p>
                      <p class="">Price: ₱ <?= number_format($result['price']); ?></p>
                      <input type="hidden" name="product_id" value="<?= $result['id']; ?>">
                      <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                      <input type="hidden" class="input_price" name="price" value="<?= $result['price']; ?>">
                    </div>
                  </div>
                </td>
                <td>
                  <form action="crud.php" method="POST" class="d-flex">
                    <input type="hidden" name="product_id" value="<?= $result['id']; ?>">
                    <a class="btn btn-info me-2" href="edit_product.php?id=<?= $result['id']; ?>">Edit</a>
                    <button class="btn btn-danger" type="submit" name="cmd" value="delete_product">Delete</button>
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

    <script src="./assets/vendor/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>