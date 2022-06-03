<?php 
require 'configuration.php';

$user_id = mysqli_real_escape_string($connection, $_GET["uid"]);
$dealers = mysqli_query($connection, "SELECT * FROM tbl_dealers WHERE dealer_id = '$user_id'");
$dealer = mysqli_fetch_assoc($dealers);
    if(!empty($dealer["id"])){
        $_SESSION['logged_id'] = $dealer["dealer_id"];
        if($dealer["dealer_id"]=='n4087' || $dealer["dealer_id"]=='31'){
            $_SESSION['superuser'] = "admin";
        }else{
            $_SESSION['superuser'] = "guest";
        }
        header("location: index.php");
        exit();
    }else{
        echo '<script>alert("Access denied.");</script>';
    }
 
?>