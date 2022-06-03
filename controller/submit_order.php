<?php
require '../configuration.php';
// echo json_encode($_POST[""]); 
// echo json_encode($_POST['cover']); 
$dealer_id = mysqli_real_escape_string($connection, $_POST['user_id']);
$without_discount_price =  floatval($_POST['orig_total_amount']);

				//getting dealer discount
        $tbl_dealers = mysqli_query($connection, "SELECT * FROM tbl_dealers WHERE dealer_id='$dealer_id'");
        $tbl_dealer = mysqli_fetch_assoc($tbl_dealers);

        $mydiscount = 0;

        $arr_discount = json_decode($tbl_dealer["dealer_vDiscount"]);
        if(property_exists($arr_discount, "discount")){
        	//this is static discount type
        	$mydiscount = $arr_discount->{'discount'};

        }else{
        	//this is variable discount type
        	$variable = $arr_discount->{'variant'};
        	foreach ($variable as $props){
        		$amount = $props->{'amount'};
        		$threshold = $props->{'threshold'};
        		if(floatval($amount)!=0){
        			if(floatval($without_discount_price) >= floatval($amount)){
        				$mydiscount = $threshold;
        			}
        		}
        	}
        }

    $result_users = mysqli_query($connection, "SELECT * FROM users WHERE id='$dealer_id'");
    $result_user = mysqli_fetch_assoc($result_users);
    $country = $result_user["country"];
    $today = date("Y-m-d H:i:s"); 
              
    mysqli_query($connection, "INSERT INTO t_order_increment(f_date) VALUES('{$today}')");
                        
    $orderidlast = mysqli_insert_id($connection);  

    $country_results = mysqli_query($connection, "SELECT * FROM t_countries WHERE f_countryname ='$country'");
    $country_result = mysqli_fetch_assoc($country_results);


    $orderidlast =$orderidlast.$country_result['f_iso'];


    $total = 0;
    $userid = $result_user['id'];
    $today = date("Y-m-d H:i:s");

    $shippingprice = '0.00';
    $shippingmethod = 'FedEx International Express Courier';
    $currency_type = 'USD';
    
              //print_r($_SESSION);
    $sql_t_order ="INSERT INTO t_order   
                          (f_order_id,
                          f_customer_id,
                          f_order_date,           
                          f_type_currency,
                          status,
                          f_total_amount,
                          f_complete,
                          f_convertion,
                          f_where,                                                
                          shipp_price,
                          shipp_method,
                          f_orderfrom,
                          f_discount_price)
                          VALUES
                          ('$orderidlast',                     
                           '$userid',
                           '$today',
                           '$currency_type',
                           'Can be changed',
                           '0',
                           'Y',
                           '1-USD',
                           'F',
                           '$shippingprice',
                           '$shippingmethod',
                         	 'pi.kinman.com',
                         	 '$without_discount_price')"; 
    mysqli_query($connection, $sql_t_order);

$grand_total = 0;



foreach($_POST['quantity'] as $key => $value){

	$quantity = $value;
	if(count($_POST['product'][$key])>1){

		$model_name = mysqli_real_escape_string($connection, $_POST['model'][$key][0]);
		$upc = mysqli_real_escape_string($connection, $_POST['upc'][$key][0]);
		$product    = mysqli_real_escape_string($connection, $_POST['model'][$key][1]);
		$qty    = mysqli_real_escape_string($connection, $_POST['quantity'][$key]);
		$cover = mysqli_real_escape_string($connection, $_POST['cover'][$key][0]);
		$description = mysqli_real_escape_string($connection, $_POST['description'][$key][0]);
		$price = mysqli_real_escape_string($connection, $_POST['price'][$key][0]);
		$addnotes = mysqli_real_escape_string($connection, $_POST['addnotes'][$key][0]);

	}else{
		$model_name = mysqli_real_escape_string($connection, $_POST['model'][$key][0]);
		$upc    = mysqli_real_escape_string($connection, $_POST['upc'][$key][0]);          
		$product    = mysqli_real_escape_string($connection, $_POST['product'][$key][0]);          
		$qty    = mysqli_real_escape_string($connection, $_POST['quantity'][$key]);
		$cover = mysqli_real_escape_string($connection, $_POST['cover'][$key][0]);
		$description = mysqli_real_escape_string($connection, $_POST['description'][$key][0]);
		$price = mysqli_real_escape_string($connection, $_POST['price'][$key][0]);
		$addnotes = mysqli_real_escape_string($connection, $_POST['addnotes'][$key][0]);

	}

	$grand_subtotal =0;
	$sum = 0;

    /////////////////////////////////////////////////////////// get the subtotal
	foreach($_POST['product'][$key] as $key2=>$value2){

            // $discountedprice = $_POST['discount'][$key][$key2];

		if($_POST['price'][$key][$key2]=="" || $_POST['price'][$key][$key2]=="0"){
			$sum = 0.00;                     
		}else{
			$sum = $_POST['price'][$key][$key2];
		}

				$grand_subtotal = $grand_subtotal + ($qty * $sum);  

        $discount_amount= $grand_subtotal * ($mydiscount / 100); 

        $grand_subtotal = $grand_subtotal - $discount_amount;

		//echo 'UPC: '.$upc.', Product: '.$product.', Model: '.$model_name.', cover: '.$cover.', description: '.$description.', Qty: '.$qty.', Price: '.$price.', Subtotal: '.$grand_subtotal.', Notes: '.$addnotes.' <br>';



		 $sql_t_order_details ="INSERT INTO t_order_details ( f_product_name,
                               f_order_id,
                               f_product_model_name,
                               f_sub_total,
                               f_quantity,
                               f_additional_note,
                               f_discount)
                      VALUES(
                              '{$product}',
                              '{$orderidlast}',
                              '{$model_name}',
                              '{$grand_subtotal}',
                              '{$qty}',
                              '{$addnotes}',
                              '{$mydiscount}'
                            )";
            mysqli_query($connection, $sql_t_order_details);

            $orderdetails_id = mysqli_insert_id($connection);  
               
                    if($_POST['price'][$key][$key2]=="" || $_POST['price'][$key][$key2]=="0"){
                      $price = 0.00;                     
                    }else{
                      $price = $_POST['price'][$key][$key2];
                    } 

				$value = $product;
				$label = 'Product';  

				mysqli_query($connection, "INSERT INTO t_order_list (f_value,
				                                                     f_label,
				                                                     f_amount,
				                                                     f_order_details_id)
				                                             VALUES ('{$value}',
				                                                     '{$label}',
				                                                     '0',
				                                                     '{$orderdetails_id}')");

				$value = $model_name;
				$label = 'Model';  

				mysqli_query($connection, "INSERT INTO t_order_list (f_value,
				                                                     f_label,
				                                                     f_amount,
				                                                     f_order_details_id)
				                                             VALUES ('{$value}',
				                                                     '{$label}',
				                                                     '{$price}',
				                                                     '{$orderdetails_id}')");
				                    
				$value = $upc;
				$label = 'UPC';  

				mysqli_query($connection, "INSERT INTO t_order_list (f_value,
				                                                     f_label,
				                                                     f_amount,
				                                                     f_order_details_id)
				                                             VALUES ('{$value}',
				                                                     '{$label}',
				                                                     '0',
				                                                     '{$orderdetails_id}')");

				$value = $cover;
				$label = 'Cover';  
				if(!empty($cover)){
					mysqli_query($connection, "INSERT INTO t_order_list (f_value,
				                                                     f_label,
				                                                     f_amount,
				                                                     f_order_details_id)
				                                             VALUES ('{$value}',
				                                                     '{$label}',
				                                                     '0',
				                                                     '{$orderdetails_id}')");
				}
				

				$value = $description;
				$label = 'Description';  
				if(!empty($description)){
				mysqli_query($connection, "INSERT INTO t_order_list (f_value,
				                                                     f_label,
				                                                     f_amount,
				                                                     f_order_details_id)
				                                             VALUES ('{$value}',
				                                                     '{$label}',
				                                                     '0',
				                                                     '{$orderdetails_id}')");
				}

				$grand_total = $grand_total + $grand_subtotal;

	}
}


$totalamount = sprintf('%0.2f', ($shippingprice+$grand_total));

mysqli_query($connection, "UPDATE t_order SET f_discount_percent='$mydiscount', f_total_amount ='$totalamount' WHERE f_order_id ='$orderidlast'");
    
echo $orderidlast;

//for insertion of shipping address, it is located on action.php (insert_shipping_address)
?>