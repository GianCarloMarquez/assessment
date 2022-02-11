<?php

session_start();
session_unset();
session_destroy();

?>
<script>
  alert('Logout went succesful.');
  location.href = 'index.php';
</script>