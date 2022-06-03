<?php 
// $username = "soniminc_webuser";
// $password = "7VngX%n*UnMV";
// $database   = "soniminc_newkinman";
// $server   = "localhost";

$username = "root";
$password = "";
$database   = "pickups_inventory";
$server   = "localhost";
//hupd
$connection = mysqli_connect($server, $username, $password, $database);
if(!$connection){
		die("Connection Failed!");
}

function login_logs($connection){
  $log_id = $_SESSION['logged_id'];
  $ad_users = mysqli_query($connection, "SELECT dealer_name FROM tbl_dealers WHERE dealer_id='$log_id'");
  $ad_users_result = mysqli_fetch_assoc($ad_users);
  $dealer_name = $ad_users_result['dealer_name'];
  $datetoday = date("F d, Y h:i:s A");
  mysqli_query($connection, "INSERT INTO inv_login_logs (user_id, name, t_datetime) VALUES ('$log_id', '$dealer_name', '$datetoday')");
}

$site_settings = mysqli_query($connection, "SELECT * FROM inv_pickups_settings WHERE id=1");
$site_setting = mysqli_fetch_assoc($site_settings);


session_start();
if(basename($_SERVER['PHP_SELF']) == 'login.php' || basename($_SERVER['PHP_SELF']) == 'relog.php'){
    if(isset($_SESSION['logged_id'])){
      header("location: index.php");
      exit();
    }
}else{
    
    if(basename($_SERVER['PHP_SELF']) != 'view_newsletter.php'){
      if(!isset($_SESSION['logged_id']))
         {
           header("location:login.php");
           exit();
         }
    }
    
   
  }

?>