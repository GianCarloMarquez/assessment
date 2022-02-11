<?php
  session_start();
  require 'connection.php';

  $user_id = '';
  $username = '';
  $password = '';
  $first_name = '';
  $last_name = '';
  $contact_number = '';
  $email = '';
  $role = '';
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = 'SELECT * FROM user WHERE user.id="' . $user_id . '"';
    $query = mysqli_query($conn, $sql) or die('error: ' . $sql);
    $result = mysqli_fetch_array($query);

    $username = $result['username'];
    $password = $result['password'];
    $first_name = $result['first_name'];
    $last_name = $result['last_name'];
    $contact_number = $result['contact_number'];
    $email = $result['email'];
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

    <title>Personal Information</title>
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
              <a class="nav-link" href="cart.php">Cart</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="personal_information.php">Personal Information</a>
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

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
          <div class="card w-100 mt-4">
            <form action="crud.php" method="POST">
              <div class="card-body">
                <h2 class="card-title mb-4 text-center">Update User</h2>
                
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="username" id="username" placeholder="name@example.com" required value="<?= $username; ?>">
                  <label for="username">Username</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password" required value="<?= $password; ?>">
                  <label for="password">Password</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="first_name" id="first_name" placeholder="John" required value="<?= $first_name ;?>">
                  <label for="first_name">First Name</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Cena" required value="<?= $last_name; ?>">
                  <label for="last_name">Last Name</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="tel" class="form-control" name="contact_number" id="contact_number" placeholder="123 456 789" required value="<?= $contact_number; ?>">
                  <label for="contact_number">Contact Number</label>
                </div>
                <div class="form-floating mb-4">
                  <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required value="<?= $email; ?>">
                  <label for="email">Email Address</label>
                </div>
  
                <div class="d-grid">
                  <button class="btn btn-lg btn-primary" type="submit" name="cmd" value="update_user">Save Changes</button>
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