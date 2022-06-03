<?php


  
    $username = mysqli_real_escape_string($connect,$_POST['username']);

    $sql="select * from users where user_name='{$username}'";
    $result_user =  $dbMaster->getRowAsAssoc($connect,$sql);
    //$user = $dbMaster->getRowAsAssoc($connect,$sql);
    /*print_r($sql);*/
    /*print_r($_POST);*/
    $today = date("Y-m-d H:i:s"); 
              
    $sql ="INSERT  INTO t_order_increment(f_date)
           VALUES('{$today}')";  
                        
    $result = $dbMaster->execute($connect,$sql);
    $orderidlast = mysqli_insert_id($connect);  


    $sql ="select * from t_countries WHERE `f_countryname` ='{$result_user['country']}'";
    $countryresult =$dbMaster->getRowAsAssoc($connect,$sql);
    

    $orderidlast =$orderidlast.$countryresult['f_iso'];
    $total = 0;
    $userid = $result_user['id'];
    $today = date("Y-m-d H:i:s");

    //$discountedprice = mysqli_real_escape_string($connect,$_POST['discountprice']);
    $discountedpricesave = mysqli_real_escape_string($connect,$_POST['discountprice1']);
    $shippingprice = mysqli_real_escape_string($connect,$_POST['shippingprice']);
    $shippingmethod = mysqli_real_escape_string($connect,$_POST['shippingmethod']);
    $currency_type = mysqli_real_escape_string($connect,$_POST['currency']);
    
              //print_r($_SESSION);
    $sql ="INSERT  INTO t_order   
                          (f_order_id,
                          f_customer_id,
                          f_order_date,           
                          f_type_currency,
                          status,
                          f_complete,
                          f_convertion,
                          f_where,
                          f_discount_price,                          
                          shipp_price,
                          shipp_method)
                          VALUES
                          ('{$orderidlast}',                     
                           '{$userid}',
                           '{$today}',
                           '{$currency_type}',
                           'Can be changed',
                           'Y',
                           '1-USD',
                           'Bulk',
                           '{$discountedpricesave}',
                           '{$shippingprice}',
                           '{$shippingmethod}')"; 
          $result = $dbMaster->execute($connect,$sql);
          $grand_total = 0;


      foreach($_POST['quantity'] as $key => $value){
            
            $quantity = $value;
            $additionalnote=$_POST['addtionalnote'][$key];

          
            if(count($_POST['warrior-label'][$key])>1){

                   $model_name = $_POST['warrior-value'][$key][0];
                   $product    = $_POST['warrior-value'][$key][1];
                   
            }else{
                  $model_name = $_POST['warrior-value'][$key][0];
                  $product    = $_POST['warrior-label'][$key][0];                  
            }

           $grand_subtotal =0;
           $sum =0;

           /////////////////////////////////////////////////////////// get the subtotal
           foreach($_POST['warrior-label'][$key] as $key2=>$value2){
               
            $discountedprice = $_POST['discount'][$key][$key2];

                  if($_POST['warrior-amount'][$key][$key2]=="" || $_POST['warrior-amount'][$key][$key2]=="0"){
                    $sum = 0.00;                     
                  }else{
                    $sum = $_POST['warrior-amount'][$key][$key2];
                  }
                  $grand_subtotal = $grand_subtotal + ($quantity * $sum);  

                  $discount_amount= $grand_subtotal * ($discountedprice / 100);

                  $grand_subtotal = $grand_subtotal - $discount_amount;
           
           ////////////////////////////////////////////////////////////

           

                        
           $sql ="INSERT INTO t_order_details ( f_product_name,
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
                              '{$quantity}',
                              '{$additionalnote}',
                              '{$discountedprice}'
                            )";
            $result = $dbMaster->execute($connect,$sql);

            $orderdetails_id = mysqli_insert_id($connect);  
               
                    if($_POST['warrior-amount'][$key][$key2]=="" || $_POST['warrior-amount'][$key][$key2]=="0"){
                      $amount = 0.00;                     
                    }else{
                      $amount = $_POST['warrior-amount'][$key][$key2];
                    } 

                    $value = $_POST['warrior-value'][$key][$key2];
                    /*$amount = mysqli_real_escape_string($connect,$_POST['warrior-amount'][$key][$key2]);  */
                    $label =$_POST['warrior-label'][$key][$key2];  

                    $sql ="INSERT into t_order_list (f_value,
                                                     f_label,
                                                     f_amount,
                                                     f_order_details_id)
                                        VALUES('{$value}',
                                               '{$label}',
                                               '{$amount}',
                                              '{$orderdetails_id}')";
                    $result = $dbMaster->execute($connect,$sql);

                    $grand_total = $grand_total + $grand_subtotal;
           } 
      }

   
    $totalamount = sprintf('%0.2f', ($shippingprice+$grand_total));

    $sql ="Update t_order
               set f_discount_percent = 'discountedprice',
               f_total_amount ='{$totalamount}'
           where f_order_id ='{$orderidlast}'";
    $updateorder  = $dbMaster->execute($connect,$sql); 

    if($updateorder){

         $date    = date("Y-m-d H:i:s"); 
         $pay_log = $date." - Add Bulk Order:{$_SESSION['warriors_user']['adminuser']}<br>";  
         $field = "payment_log = '".$pay_log."'";   
         $strsql="UPDATE t_order SET 
         $field WHERE f_order_id = '{$orderidlast}'";    
         $dbMaster->execute($connect,$strsql);     
    }

    /*[firstname] => Chris
    [lastname] => Chatsworth
  
    [street] => 144 Chery San Francisco
    [apartment] => testing only
    [suburb] => testing only
    [city] => Moorooka
    [region] => Qld
    [zip] => 4105
    [country] => Canada
    [deliveryno] => 78487584
    [cellno] => */

    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];

    $shipto = str_replace("'", '', $firstname .' '.$lastname); 

    $street  = $_POST['street'];
    $apartment  = $_POST['apartment'];
    $suburb  = $_POST['suburb'];

    $complete_address = $street." ".$apartment." ".$suburb;

    $city =$_POST['city'];
    $state = $_POST['region'];
    $zip = $_POST['zip'];

    $deliveryno = mysqli_real_escape_string($connect,$_POST['deliveryno']);
    $cellno = mysqli_real_escape_string($connect,$_POST['cellno']);
    $country = mysqli_real_escape_string($connect,$_POST['country']);
    
    /*144 Chery San Francisco testing only testing only*/

     $sql_insert_shipping = "INSERT into t_order_shippaddress(
                                          shipto,  
                                          complete_address,                                       
                                          city,
                                          region_state,
                                          order_id,
                                          country,
                                          zip_postcode,
                                          delivery_tel,
                                          home_tel  )
                                    VALUES(
                                        '{$shipto}',
                                        '{$complete_address}',                                        
                                        '{$state}',
                                        '{$city}',
                                        '{$orderidlast}',
                                        '{$country}',
                                        '{$zip}',
                                        '{$deliveryno}',
                                        '{$cellno}')";
                  
    $result_shipping_address = $dbMaster->execute($connect,$sql_insert_shipping); 

      

    $subject2 = 'Order - '.$orderidlast.'';

    $today = date("Y-m-d H:i:s"); 
    $sql_insert ="INSERT  INTO tbl_contact(fld_userids,fld_date,fld_fullname,fld_uname,fld_title,fld_status,fld_msgstatus,fld_typem,fld_typemsg,fld_ordersid)
                VALUES('{$userid}','{$today }','{$fullname}','{$username}','{$subject2}','{$orderidlast}','kinman_msg','Notification','Notification','{$orderidlast}')";
    $result = $dbMaster->execute($connect,$sql_insert); 


    $subject2 = 'Order Acknowledgment - '.$orderidlast.'';

    //$content2 = 'Order Acknowledgment .....<embed width="1000" height="500" src="../order_acknowled/acknowled_'.$value['f_order_id'].'.pdf" alt="pdf">';

    $today = date("Y-m-d H:i:s"); 
    $username =$result_user['user_name'];

    $sql_insert ="INSERT  INTO tbl_contact(fld_userids,fld_date,fld_fullname,fld_uname,fld_title,fld_status,fld_msgstatus,fld_typem,fld_typemsg,fld_ordersid)
                VALUES('{$userid}','{$today }','{$fullname}','{$username}','{$subject2}','{$orderidlast}','kinman_msg','Notification','Notification','{$orderidlast}')";
    $result = $dbMaster->execute($connect,$sql_insert); 

    echo "1";

    exit;

?>