<?php

session_start();
require 'connection.php';

$cmd = '';

if (isset($_POST['cmd'])) {
  $cmd = $_POST['cmd'];
}

if ($cmd == 'register') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $contact_number = $_POST['contact_number'];
  $email = $_POST['email'];

  $sql = 'INSERT INTO user(username, password, first_name, last_name, contact_number, email, role) VALUES("' . $username . '", "' . $password . '", "' . $first_name . '", "' . $last_name . '", "' . $contact_number . '", "' . $email . '", "guest")';
  $query = mysqli_query($conn, $sql) or die('error: ' . $sql);

  $_SESSION['user_id'] = mysqli_insert_id($conn);

  ?>
  <script>
    alert('User registered succesfully.');
    location.href = 'index.php';
  </script>
  <?php
} else if ($cmd == 'login') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = 'SELECT * FROM user WHERE user.email="' . $email . '" AND user.password="' . $password . '"';
  $query = mysqli_query($conn, $sql) or die('error: ' . $sql);
  $num = mysqli_num_rows($query);

  if ($num == 0) {
    ?>
    <script>
      alert('Sorry, we can\'t find your account.');
      location.href = 'login.php';
    </script>
    <?php
  } else {
    $result = mysqli_fetch_array($query);
    $_SESSION['user_id'] = $result['id'];

    $to_redirect = 'index.php';
    if ($result['role'] == 'admin') {
      $to_redirect = 'dashboard.php';
    }

    ?>
    <script>
      alert('Welcome back, <?= $result['username']; ?>!');
      location.href = '<?= $to_redirect; ?>';
    </script>
    <?php
  }
} else if ($cmd == 'update_user') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $contact_number = $_POST['contact_number'];
  $email = $_POST['email'];

  $sql = 'UPDATE user SET user.username="' . $username . '", user.password="' . $password . '", user.first_name="' . $first_name . '", user.last_name="' . $last_name . '", user.contact_number="' . $contact_number . '", user.email="' . $email . '", user.role="guest"';
  $query = mysqli_query($conn, $sql) or die('error: ' . $sql);

  $_SESSION['user_id'] = mysqli_insert_id($conn);

  ?>
  <script>
    alert('User\'s personal information updated succesfully.');
    location.href = 'personal_information.php';
  </script>
  <?php
} else if ($cmd == 'add_food_to_cart') {
  $user_id = $_POST['user_id'];
  $food_id = $_POST['food_id'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $total_price = $price * $quantity;

  $sql = 'SELECT * FROM temporary_order WHERE temporary_order.user_id="' . $user_id . '"';
  $query = mysqli_query($conn, $sql) or die('error: ' . $sql);
  $num = mysqli_num_rows($query);

  $temporary_order_id = '';
  if ($num == 0) {
    $date = date('Y-m-d');
    $sql1 = 'INSERT INTO temporary_order(user_id, date) VALUES("' . $user_id . '", "' . $date . '")';
    $query1 = mysqli_query($conn, $sql1) or die('error: ' . $sql1);
    $temporary_order_id = mysqli_insert_id($conn);
  } else {
    $result = mysqli_fetch_array($query);
    $temporary_order_id = $result['id'];
  }

  $sql2 = 'SELECT * FROM temporary_order_detail WHERE temporary_order_detail.order_id="' . $temporary_order_id . '" AND temporary_order_detail.food_id="' . $food_id . '"';
  $query2 = mysqli_query($conn, $sql2) or die('error: ' . $sql2);
  $num2 = mysqli_num_rows($query2);

  if ($num2 == 0) {
    $sql3 = 'INSERT INTO temporary_order_detail(order_id, food_id, quantity, price) VALUES("' . $temporary_order_id . '", "' . $food_id . '", "' . $quantity . '", "' . $price . '")';
    $query3 = mysqli_query($conn, $sql3) or die('error: ' . $sql3);
  } else {
    $result2 = mysqli_fetch_array($query2);

    $sql4 = 'SELECT * FROM food WHERE food.id="' . $food_id . '"';
    $query4 = mysqli_query($conn, $sql4) or die('error: ' . $sql4);
    $result4 = mysqli_fetch_array($query4);

    $quantity_new = $result2['quantity'] + $quantity;

    if ($quantity_new > $result4['stock']) {
      $quantity_new = $result4['stock'];
    }

    $sql3 = 'UPDATE temporary_order_detail SET temporary_order_detail.quantity="' . $quantity_new . '", temporary_order_detail.price="' . $price. '" WHERE temporary_order_detail.order_id="' . $temporary_order_id . '" AND temporary_order_detail.food_id="' . $food_id . '"';
    $query3 = mysqli_query($conn, $sql3) or die('error: ' . $sql3);
  }

  ?>
  <script>
    alert('Food added into cart succesfully.');
    location.href = 'index.php';
  </script>
  <?php
} else if ($cmd == 'delete_food_from_cart') {
  $user_id = $_POST['user_id'];
  $food_id = $_POST['food_id'];

  $sql = 'SELECT * FROM temporary_order WHERE temporary_order.user_id="' . $user_id . '"';
  $query = mysqli_query($conn, $sql) or die('error: ' . $sql);
  $result = mysqli_fetch_array($query);
  $temporary_order_id = $result['id'];

  $sql1 = 'DELETE FROM temporary_order_detail WHERE temporary_order_detail.order_id="' . $temporary_order_id . '" AND temporary_order_detail.food_id="' . $food_id . '"';
  $query1 = mysqli_query($conn, $sql1) or die('error: ' . $sql1);

  ?>
  <script>
    alert('Food deleted from cart succesfully.');
    location.href = 'cart.php';
  </script>
  <?php
} else if ($cmd == 'update_food_in_cart') {
  $user_id = $_POST['user_id'];
  $food_id = $_POST['food_id'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $total_price = $price * $quantity;

  $sql = 'SELECT * FROM temporary_order WHERE temporary_order.user_id="' . $user_id . '"';
  $query = mysqli_query($conn, $sql) or die('error: ' . $sql);
  $num = mysqli_num_rows($query);
  $result = mysqli_fetch_array($query);
  $temporary_order_id = $result['id'];

  $sql2 = 'SELECT * FROM temporary_order_detail WHERE temporary_order_detail.order_id="' . $temporary_order_id . '" AND temporary_order_detail.food_id="' . $food_id . '"';
  $query2 = mysqli_query($conn, $sql2) or die('error: ' . $sql2);
  $num2 = mysqli_num_rows($query2);
  $result2 = mysqli_fetch_array($query2);

  $sql4 = 'SELECT * FROM food WHERE food.id="' . $food_id . '"';
  $query4 = mysqli_query($conn, $sql4) or die('error: ' . $sql4);
  $result4 = mysqli_fetch_array($query4);

  if ($quantity > $result4['stock']) {
    $quantity = $result4['stock'];
  }

  $sql3 = 'UPDATE temporary_order_detail SET temporary_order_detail.quantity="' . $quantity . '", temporary_order_detail.price="' . $price. '" WHERE temporary_order_detail.order_id="' . $temporary_order_id . '" AND temporary_order_detail.food_id="' . $food_id . '"';
  $query3 = mysqli_query($conn, $sql3) or die('error: ' . $sql3);

  header('Location: cart.php');
} else if ($cmd == "pay_checkout") {
  $user_id = $_POST['user_id'];
  $date = $_POST['date'];
  $customer_name = $_POST['customer_name'];
  $delivery_address = $_POST['delivery_address'];

  $sql = 'SELECT * FROM temporary_order WHERE temporary_order.user_id="' . $user_id . '"';
  $query = mysqli_query($conn, $sql) or die('error: ' . $sql);
  $result = mysqli_fetch_array($query);
  $temporary_order_id = $result['id'];

  $sql1 = 'INSERT INTO orders(user_id, date, customer_name, delivery_address) VALUES("' . $user_id . '", "' . $date . '", "' . $customer_name . '", "' . $delivery_address. '")';
  $query1 = mysqli_query($conn, $sql1) or die('error: ' . $sql1); 

  $order_id = mysqli_insert_id($conn);

  $sql2 = 'DELETE FROM temporary_order WHERE temporary_order.id="' . $temporary_order_id . '"';
  $query2 = mysqli_query($conn, $sql2) or die('error: ' . $sql2);

  $sql4 = 'SELECT * FROM temporary_order_detail WHERE temporary_order_detail.order_id="' . $temporary_order_id . '"';
  $query4 = mysqli_query($conn, $sql4) or die('error: ' . $sql4);

  while ($result2 = mysqli_fetch_array($query4)) {
    $food_id = $result2['food_id'];
    $quantity = $result2['quantity'];
    $price = $result2['price'];

    $sql3 = 'INSERT INTO order_detail(order_id, food_id, quantity, price) VALUES("' . $order_id . '", "' . $food_id . '", "' . $quantity. '", "' . $price . '")';
    $query3 = mysqli_query($conn, $sql3) or die('error: ' . $sql3);
  }
  
  $sql5 = 'DELETE FROM temporary_order_detail WHERE temporary_order_detail.order_id="' . $temporary_order_id . '"';
  $query5 = mysqli_query($conn, $sql5) or die('error: ' . $sql5);

  ?>
  <script>
    alert('Checkout paid succesfully.');
    location.href = 'orders.php';
  </script>
  <?php
}