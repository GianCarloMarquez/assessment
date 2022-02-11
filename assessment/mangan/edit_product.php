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

  $id = $_GET['id'];
  $sql1 = 'SELECT * FROM product WHERE product.id="' . $id . '"';
  $query1 = mysqli_query($conn, $sql1) or die('error: ' . $sql1);
  $result1 = mysqli_fetch_array($query1);
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>Edit Product</title>
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

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
          <div class="card w-100 mt-4">
            <form action="crud.php" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <h2 class="card-title mb-4 text-center">Update Product</h2>
                
                <input type="hidden" name="product_id" value="<?= $result1['id']; ?>">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="name" id="name" placeholder="Gising Gising" required value="<?= $result1['name']; ?>">
                  <label for="name">Name</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="number" class="form-control" name="stock" id="stock" placeholder="1" required value="<?= $result1['stock']; ?>">
                  <label for="stock">Stock</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="number" class="form-control" name="price" id="price" placeholder="1000" required value="<?= $result1['price']; ?>">
                  <label for="price">Price</label>
                </div>
                <div class="form-group mb-3">
                  <label for="image" class="col-form-label">Image</label>
                  <input type="file" class="form-control" name="image" id="image" placeholder="-" accept=".jpg,.jpeg,.png">
                </div>

                <div class="d-grid">
                  <button class="btn btn-lg btn-primary" type="submit" name="cmd" value="update_product">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <script src="./assets/vendor/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>