<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>Login</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">MANGAN DA KITA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
          <div class="card w-100" style="margin-top: 8rem;">
            <form action="crud.php?cmd=login" method="POST">
              <div class="card-body">
                <h2 class="card-title mb-4 text-center">Login</h2>
                
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                  <label for="email">Email Address</label>
                </div>
                <div class="form-floating mb-1">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                  <label for="password">Password</label>
                </div>
                <a class="text-end d-block mb-4 text-decoration-none" href="register.php">Don't have an account? Register.</a>
  
                <div class="d-grid">
                  <button class="btn btn-lg btn-primary" type="submit" name="cmd" value="login">Login</button>
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