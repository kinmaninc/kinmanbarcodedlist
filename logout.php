<?php 
require 'configuration.php';
unset($_SESSION['logged_id']);
unset($_SESSION['superuser']);
header("location:login.php");
exit();
?>