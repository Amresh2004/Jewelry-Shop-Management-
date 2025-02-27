<?php
session_start();
session_destroy();

// Clear cookies
setcookie('name', '', time() - 3600, "/");
setcookie('email', '', time() - 3600, "/");
setcookie('password', '', time() - 3600, "/");

// Redirect to login
header("Location: index.php");
exit();
?>
