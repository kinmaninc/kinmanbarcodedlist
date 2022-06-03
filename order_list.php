<?php 
require 'configuration.php';
if($_SESSION["superuser"]=="admin"){
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php require 'meta.php'; ?>
	<title>ORDER HISTORY</title>
	<?php require 'link.php'; ?>
	<?php require 'script.php'; ?>
</head>
<body>
<h1 align="center" class="title-separator">ORDER HISTORY PAGE <small>Orders from Bar Coded Products only</small></h1>
<a href="index.php" class="float-left" style="padding-left:10px;"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Go back to ordering page</a>

<div class="container">
	<br>
	<br>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Order ID</th>
				<th>Order Date</th>
				<th>Name</th>
				<th>Qty Ordered</th>
				<th>Order Amount</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php

			$orders = mysqli_query($connection, "SELECT * FROM t_order WHERE f_orderfrom='pi.kinman.com' ORDER BY f_ctr_id DESC");
			while($order = mysqli_fetch_assoc($orders)){
				$orderid = $order["f_order_id"];
			$user_id = $order['f_customer_id'];
				$users = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
				$user = mysqli_fetch_assoc($users);

				$order_details = mysqli_query($connection, "SELECT SUM(f_quantity) FROM t_order_details WHERE f_order_id='$orderid'");
				$order_detail = mysqli_fetch_assoc($order_details);

				echo '<tr>';
				echo '<td><a href="order_view.php?oid='.$order["f_order_id"].'" target="_blank">'.$order["f_order_id"].'</span></td>';
				echo '<td>'.date("F d, Y h:i:s A", strtotime($order["f_order_date"])).'</td>';
				echo '<td>'.$user["first_name"].' '.$user["last_name"].'</td>';
				echo '<td>'.$order_detail["SUM(f_quantity)"].'</td>';
				echo '<td>'.$order["f_total_amount"].' USD</td>';
				echo '<td>'.$order["status"].'</td>';
			}

			?>
		</tbody>
	</table>
</div>
</body>
</html>

<div class="modal fade" id="vieworder_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #FF8133; color: black;">
        <h5 class="modal-title" id="vieworder_header">Loading...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" align="center" id="vieworder_body">
      	Loading...
      </div>
       <div class="modal-footer">
        	<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
	      </div>
      </div>
   	</div>
  </div>
<?php 
}else{
	echo '<h1>Access denied.</h1>';
}
?>
