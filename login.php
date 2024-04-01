<?php 
require 'configuration.php';
if($_SERVER['REQUEST_METHOD']== "POST" && isset($_POST["login_submit"])){
    $usernameko = mysqli_real_escape_string($connection, $_POST["username"]);
    $passwordko = mysqli_real_escape_string($connection, $_POST["password"]);

    $sql = "SELECT * FROM users WHERE user_email = '$usernameko' AND realpassword = '$passwordko'";
    $users = mysqli_query($connection, $sql);
    $user = mysqli_fetch_assoc($users);
    $thisid = $user["id"];
    
    $dealers = mysqli_query($connection, "SELECT * FROM tbl_dealers WHERE dealer_id = '$thisid'");
    $dealer = mysqli_fetch_assoc($dealers);
    if(!empty($dealer["id"])){
        $_SESSION['logged_id'] = $user["id"];
        if($user["id"]=='n4087' || $user["id"]=='31' || $user["id"]=='224'){
            $_SESSION['superuser'] = "admin";
        }else{
            $_SESSION['superuser'] = "guest";
        }
        login_logs($connection);
        header("location: index.php");
        exit();
    }else{
        echo '<script>alert("You are not a dealer.");</script>';
    }

    
}
?>

<!DOCTYPE html>
<html>
<head>
	<?php require 'meta.php'; ?>
	<title>Barcode Page | Kinman Pickups</title>
	<?php require 'link.php'; ?>
	<?php require 'script.php'; ?>
</head>
<body>
    <br>
    <div class="row">
        <div class="col-lg-4 col-xs-12">
        </div>
        <div class="col-lg-4 col-xs-12">
            <div style="background: black; padding: 20px; border-radius: 20px; color: white;">
            <h1 align="center" style="color: white;">Kinman Pickups <br><small>Login</small></h1>
            <br>
            <form method="POST">
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" value="<?php if(isset($_GET['username'])){ echo $_GET['username']; } ?>" id="username" name="username">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <button type="submit" name="login_submit" class="btn btn-outline-light">Login</button>
                    </div>
                </div>        
            </form>
        </div>
        </div>
        <div class="col-lg-4 col-xs-12">
        </div>
    </div>
	

</body>
</html>