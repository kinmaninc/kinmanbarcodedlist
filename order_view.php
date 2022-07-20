<?php
require 'configuration.php';
//$_SESSION['logged_id'];
$orderid = $_GET['oid'];

$orders = mysqli_query($connection, "SELECT * FROM t_order WHERE f_order_id='$orderid'");
$order = mysqli_fetch_assoc($orders);
if($_SESSION['superuser']=="admin"){

$order_shippings = mysqli_query($connection, "SELECT * FROM t_order_shippaddress WHERE order_id = '$orderid'");
$order_shipping = mysqli_fetch_assoc($order_shippings);


?>
<!DOCTYPE html>
<html>
<head>
	<?php require 'meta.php'; ?>
	<title> <?php echo $_GET['oid']; ?></title>
	<?php require 'link.php'; ?>
	<?php require 'script.php'; ?>
</head>

<body>

<div class="container" style = 'overflow-y: auto; height: 100%;'>	
    <h4 align="center" class="title-separator">Shipping Summary</h4>
    <div class="row">
        	<div class="col-lg-3 col-xs-12">

        	</div>
        	<div class="col-lg-6 col-xs-12" align="center">
        		<div style="padding: 20px; border-radius: 7px; border: 1px solid black;">
        			<p class="ptoleft">Name of Recipient: <span class="stronggg" id="box_nameofrecipient"><?php echo $order_shipping["shipto"] ?></span></p>
        			<p class="ptoleft">Street 1: <span class="stronggg" id="box_street1"><?php echo $order_shipping["street_name"] ?></span></p>
        			<p class="ptoleft">Street 2: <span class="stronggg" id="box_street2"><?php echo $order_shipping["apartment_designation"] ?></span></p>
        			<p class="ptoleft">Street 3: <span class="stronggg" id="box_street3"><?php echo $order_shipping["suburb"] ?></span></p>
        			<p class="ptoleft">City: <span class="stronggg" id="box_city"><?php echo $order_shipping["city"] ?></span></p>
        			<p class="ptoleft">Region/State/Province: <span class="stronggg" id="box_regionstate"><?php echo $order_shipping["region_state"] ?></span></p> 
        			<p class="ptoleft">Zip Code: <span class="stronggg" id="box_zipcode"><?php echo $order_shipping["zip_postcode"] ?></span></p>                
        			<p class="ptoleft">Country: <span class="stronggg" id="box_country" readonly><?php echo $order_shipping["country"] ?></span></p>
        			<br>
        			<p class="ptoleft">Cellphone Or Mobile: <span class="stronggg" id="box_mobileno"><?php echo $order_shipping["home_tel"] ?></span></p>
        			<p class="ptoleft">Landline Telephone: <span class="stronggg" id="box_telno"><?php echo $order_shipping["delivery_tel"] ?></span></p>
        		</div>
        	</div>
        	<div class="col-lg-3 col-xs-12">
        	</div>
        </div>
        	<br>

        	<table align="center" style="padding: 10px;">
        		<tr>
        			<td class="stronggg ptoright">Name of Recipient :</td>
        			<td><?php echo $order_shipping["shipto"]; ?></td>
        		</tr>
        		<tr>
        			<td class="stronggg ptoright">Order No :</td>
        			<td><?php echo $orderid; ?></td>
        		</tr>
        		<tr>
        			<td class="stronggg ptoright">Order Date :</td>
        			<td><?php echo $order["f_order_date"]; ?></td>
        		</tr>
        	</table>

        	<br>
    	<h4 align="center" class="title-separator">Summary of the order</h4>

        <?php
        $order_details = mysqli_query($connection, "SELECT * FROM t_order_details WHERE f_order_id='$orderid'");
        while($order_detail = mysqli_fetch_assoc($order_details)){
            echo '<table class="table" style="width:90%;" align="center">
            <tr>
                <th>Quantity: '.$order_detail["f_quantity"].'</th>
                <th colspan="2" class="ptoright">Discount: '.$order_detail["f_discount"].'%</th>
            </tr>';
            $order_detail_id = $order_detail["f_order_details_id"];
            $order_lists = mysqli_query($connection, "SELECT * FROM t_order_list WHERE f_order_details_id='$order_detail_id'");
            while($order_list = mysqli_fetch_assoc($order_lists)){
                echo '<tr>
                        <td class="stronggg" style="width:25%;">'.$order_list["f_label"].'</td>
                        <td style="width:60%;">'.$order_list["f_value"].'</td>';
                        if($order_list["f_label"]=='Model'){
                            echo '<td class="ptoright" style="width:15%;">'.$order_list["f_amount"].' USD</td>';
                        }else{
                            echo '<td class="ptoright" style="width:15%;"></td>';
                        }
                    echo '</tr>';
            }
            
            if(!empty($order_detail["f_additional_note"])){
                echo '<tr>
                <td class="stronggg">Additional notes: </td>
                    <td colspan="2" style="color:red;">'.$order_detail["f_additional_note"].'</td>
                </tr>';
            }
            

        echo '</table><div align="center"><div style="width:90%; background-color: #9C3737; height:3px;"></div></div>';
        }

        ?>
        <br>
        <table class="table" style="width:100%;">
        <tr style="background: #292929; color: white;">
            <td class="stronggg ptoleft">TOTAL:</td> 
            <td class="ptoright">
                <p style="margin-bottom: -10px;"><?php echo number_format($order["f_discount_price"], 2, ".", ","); ?> USD</p>
                <p style="margin-bottom: -5px; color: #68DF63;"><?php echo '-'.number_format($order["f_discount_price"]-$order["f_total_amount"], 2, ".", ","); ?> USD </p>
                <?php echo '<span class="stronggg" style="font-size: 20px;">'.$order["f_total_amount"].' USD</span>'; ?>
            </td>
        </tr>
        </table>
        </div>
</div>
<br>
<br>
</body>
</html>

<?php }else{

echo '<h1>Access denied.</h1>';

} ?>