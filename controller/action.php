<?php
require '../configuration.php';

if(isset($_POST["action"])){

	if($_POST["action"]=="checkSess"){
		echo '~u make the flowers bloom';
	}
	if($_POST["action"]=="show_table_pickups"){
		$pickups = mysqli_query($connection, "SELECT * FROM inv_pickups");
		while($pickup = mysqli_fetch_assoc($pickups)){

			$short_text_description = preg_replace( "/\n\s+/", "\n", trim(strip_tags(htmlspecialchars_decode($pickup["description"]))));
			if(strlen($short_text_description) > 50){
					$short_text_description = substr($short_text_description, 0, 50)."...";
			}

			$short_text_notes = preg_replace( "/\n\s+/", "\n", trim(strip_tags(htmlspecialchars_decode($pickup["notes"]))));
			if(strlen($short_text_notes) > 50){
					$short_text_notes = substr($short_text_notes, 0, 50)."...";
			}

			echo '<tr id="upc_'.$pickup["upc"].'" style="scroll-margin: 170px;">';
			echo '<td class="va_ta"><input type="checkbox" class="chkbox" name="mycheckboxes" id="cbox_'.$pickup["id"].'" value="'.$pickup["id"].'"></td>';
			echo '<td><a href="javascript:void(0)" onclick="view_item('.$pickup["upc"].', '.$pickup["id"].')" >'.$pickup["upc"].'</td>';
			echo '<td id="ean_'.$pickup["ean"].'" style="scroll-margin: 170px;">'.$pickup["ean"].'</td>';
			echo '<td>'.$pickup["category"].'</td>';
			echo '<td>'.$pickup["item_name"].'</td>';
			echo '<td>'.$short_text_description.'</td>';
			echo '<td>'.$pickup["cover"].'</td>';
			echo '<td>'.$short_text_notes.'</td>';
			if(!empty($pickup["weight"])){
				echo '<td>'.$pickup["weight"].' Kg</td>';
			}else{
			    echo '<td></td>';
			}
			if(!empty($pickup["price"])){
				 echo '<td>$'.number_format($pickup["price"], 2, ".", "").'</td>';
			}else{
				echo '<td></td>';
			}
			echo '</tr>';
		}
	}


	if($_POST["action"]=="view_item"){
		$code = $_POST['code'];
		$pickups = mysqli_query($connection, "SELECT * FROM inv_pickups WHERE upc = '$code'");
		$pickup = mysqli_fetch_assoc($pickups);
		?>
		<fieldset id="fieldset_form" disabled="disabled">
		<div class="row">
			<div class="col-lg-4 col-xs-12">
				<div class="form-group">
				    <label for="tdtxt_ean_v">EAN</label>
				    <input type="text" class="form-control" id="tdtxt_ean_v" name="tdtxt_ean_v" value="<?php echo $pickup['ean']; ?>">
				</div>
			</div>
			<div class="col-lg-4 col-xs-12">
				<div class="form-group">
				    <label for="tdtxt_upc_v">UPC</label>
				    <input type="text" class="form-control" id="tdtxt_upc_v" name="tdtxt_upc_v" value="<?php echo $pickup['upc']; ?>">
				</div>
			</div>
			<div class="col-lg-4 col-xs-12" align="center">
				<svg id="pic_barcode_upc"></svg>
			</div>

			<div class="col-lg-12 col-xs-12" align="center" id="default_pic_panel">
				<img src="<?php 
				if(!empty($pickup['img_path'])){
					echo 'site_images/'.$pickup['img_path'];
				}else{
					echo 'dist/img/uploadimagehere.jpg';
				} ?>" class="myimage" id="default_img">
			</div>

			
			<div class="col-lg-12 col-xs-12" align="center" id="update_pic_panel" style="display: none;">
					<div class="pic_updater_div">
					<input type="file" accept="image/*" class="fileToUpload form-control" id="imgInp" hidden>
	    			<input type="text" placeholder="File name" id="filename" class="form-control" hidden>
					<img src="<?php 
					if(!empty($pickup['img_path'])){
						echo 'site_images/'.$pickup['img_path'];
					}else{
						echo 'dist/img/uploadimagehere.jpg';
					} ?>" class="myimage" id="blah">
					<div class="overlaytext">
					    <div class="optionstext">
					    	<button onclick="$('#imgInp').click();">Click here to upload</button><br>- or -<br><button type="button" data-toggle="modal" data-target="#serverphotos_modal">Choose photos from server</button>
					    </div>
					</div>
				</div>
			</div>

			<div class="col-lg-12 col-xs-12">
				<div class="form-group">
				    <label for="tdtxt_category_v">Category</label>
				    <input type="text" class="form-control" id="tdtxt_category_v" name="tdtxt_category_v" value="<?php echo $pickup['category']; ?>">
				</div>
			</div>

			<div class="col-lg-12 col-xs-12">
				<div class="form-group">
				    <label for="tdtxt_item_name_v">Item Name</label>
				    <input type="text" class="form-control" id="tdtxt_item_name_v" name="tdtxt_item_name_v" value="<?php echo $pickup['item_name']; ?>">
				</div>
			</div>

			<div class="col-lg-12 col-xs-12">
				<div class="form-group">
				    <label for="tdtxt_description_v">Description</label>
				
				    <textarea id="tdtxt_description_v" name="tdtxt_description_v" class="form-control" rows="5"><?php echo $pickup['description']; ?></textarea>
				</div>
			</div>

			<div class="col-lg-6 col-xs-12">
				<div class="form-group">
				    <label for="tdtxt_cover_v">Cover</label>
				    <input type="text" class="form-control" id="tdtxt_cover_v" name="tdtxt_cover_v" value="<?php echo $pickup['cover']; ?>">
				</div>
			</div>
			<div class="col-lg-3 col-xs-12">
				<div class="form-group">
				    <label for="tdtxt_weight_v">Weight (Kg)</label>
				    <input type="text" class="form-control" id="tdtxt_weight_v" name="tdtxt_weight_v" value="<?php echo $pickup['weight']; ?>">
				</div>
			</div>
			<div class="col-lg-3 col-xs-12">
				<div class="form-group">
				    <label for="tdtxt_price_v">Price</label>
				    <input type="text" class="form-control" id="tdtxt_price_v" name="tdtxt_price_v" value="<?php echo $pickup['price']; ?>">
				</div>
			</div>
			<div class="col-lg-12 col-xs-12">
				<div class="form-group">
				    <label for="tdtxt_notes_v">Notes</label>
				
				    <textarea id="tdtxt_notes_v" name="tdtxt_notes_v" class="form-control" rows="5"><?php echo $pickup['notes']; ?></textarea>
				</div>
			</div>
		</div>
	</fieldset>
		<?php
	}


	if($_POST["action"]=="add_item"){
		$ean = mysqli_real_escape_string($connection, $_POST["ean"]);
		$upc = mysqli_real_escape_string($connection, $_POST["upc"]);
		$category = mysqli_real_escape_string($connection, $_POST["category"]);
		$item_name = mysqli_real_escape_string($connection, $_POST["item_name"]);
		$description = mysqli_real_escape_string($connection, $_POST["description"]);
		$cover = mysqli_real_escape_string($connection, $_POST["cover"]);
		$price = mysqli_real_escape_string($connection, $_POST["price"]);
		$notes = mysqli_real_escape_string($connection, $_POST["notes"]);
		$weight = mysqli_real_escape_string($connection, $_POST["weight"]);

		$barcodes = mysqli_query($connection, "SELECT ean, upc FROM inv_pickups WHERE (ean = '$ean' OR upc = '$upc')");
		$barcode = mysqli_fetch_assoc($barcodes);

		$row_results=mysqli_num_rows($barcodes);
		
		if($row_results<=0){
			mysqli_query($connection, "INSERT INTO inv_pickups (ean, upc, category, item_name, description, cover, price, notes, weight) VALUES ('$ean', '$upc', '$category', '$item_name', '$description', '$cover', '$price', '$notes', '$weight')");
			echo 'good';
		}else{
			echo "duplicate";
		}
	}

	if($_POST["action"]=="update_item"){
		
		$id = mysqli_real_escape_string($connection, $_POST["id"]);

		$ean = mysqli_real_escape_string($connection, $_POST["ean"]);
		$upc = mysqli_real_escape_string($connection, $_POST["upc"]);
		$category = mysqli_real_escape_string($connection, $_POST["category"]);
		$item_name = mysqli_real_escape_string($connection, $_POST["item_name"]);
		$description = mysqli_real_escape_string($connection, $_POST["description"]);
		$cover = mysqli_real_escape_string($connection, $_POST["cover"]);
		$price = mysqli_real_escape_string($connection, $_POST["price"]);
		$notes = mysqli_real_escape_string($connection, $_POST["notes"]);
		$weight = mysqli_real_escape_string($connection, $_POST["weight"]);

		$barcodes = mysqli_query($connection, "SELECT ean, upc FROM inv_pickups WHERE (ean = '$ean' OR upc = '$upc') AND id<>'$id'");
		$barcode = mysqli_fetch_assoc($barcodes);
		if(empty($barcode["ean"])){
			mysqli_query($connection, "UPDATE inv_pickups SET ean ='$ean', upc ='$upc', category ='$category', item_name ='$item_name', description ='$description', cover ='$cover', price ='$price', notes ='$notes', weight ='$weight' WHERE id='$id'");
			echo 'good';
		}else{
			echo "duplicate";
		}
	}
	if($_POST["action"]=="delete_item"){
		$ids = mysqli_real_escape_string($connection, $_POST["ids"]);
		$f_ids = explode(",",$ids);

		if(count($f_ids) > 1){
			foreach($f_ids as $id){
				mysqli_query($connection, "DELETE FROM inv_pickups WHERE id='$id'");
			}
			echo 'good';
		}else{
			$id = $f_ids[0];
			$results = mysqli_query($connection, "DELETE FROM inv_pickups WHERE id='$id'");
			if($results){
				echo 'good';
			}
		}
		
	}

	// if($_POST["action"]=="search_item"){
	// 	$search_value = mysqli_real_escape_string($connection, $_POST["value"]);
	// 	$sql ="SELECT * FROM inv_pickups ";
	// 		if(!empty($search_value)){
	// 		    $sql.=" WHERE (category LIKE '%".$search_value."%' ";
	// 		    $sql.=" OR item_name LIKE '%".$search_value."%' ";
	// 		    $sql.=" OR description LIKE '%".$search_value."%' ";
	// 		    $sql.=" OR cover LIKE '%".$search_value."%' ";
	// 		    $sql.=" OR notes LIKE '%".$search_value."%' ";
	// 		    $sql.=" OR weight LIKE '%".$search_value."%' ";
	// 		    $sql.=" OR price LIKE '%".$search_value."%' )";
	// 		}
	// 	$pickups = mysqli_query($connection, $sql);
	// 	$row_results=mysqli_num_rows($pickups);
		
	// 	if($row_results>0){
	// 		while($pickup = mysqli_fetch_assoc($pickups)){

	// 			$short_text_description = preg_replace( "/\n\s+/", "\n", trim(strip_tags(htmlspecialchars_decode($pickup["description"]))));
	// 			if(strlen($short_text_description) > 50){
	// 					$short_text_description = substr($short_text_description, 0, 50)."...";
	// 			}

	// 			$short_text_notes = preg_replace( "/\n\s+/", "\n", trim(strip_tags(htmlspecialchars_decode($pickup["notes"]))));
	// 			if(strlen($short_text_notes) > 50){
	// 					$short_text_notes = substr($short_text_notes, 0, 50)."...";
	// 			}

	// 			echo '<tr id="upc_'.$pickup["upc"].'" style="scroll-margin: 170px;">';
	// 			echo '<td><input type="checkbox" class="chkbox" name="mycheckboxes" id="cbox_'.$pickup["id"].'" value="'.$pickup["id"].'"></td>';
	// 			echo '<td><a href="javascript:void(0)" onclick="view_item('.$pickup["upc"].', '.$pickup["id"].')" >'.$pickup["upc"].'</td>';
	// 			echo '<td id="ean_'.$pickup["ean"].'" style="scroll-margin: 170px;">'.$pickup["ean"].'</td>';
	// 			echo '<td>'.$pickup["category"].'</td>';
	// 			echo '<td>'.$pickup["item_name"].'</td>';
	// 			echo '<td>'.$short_text_description.'</td>';
	// 			echo '<td>'.$pickup["cover"].'</td>';
	// 			echo '<td>'.$short_text_notes.'</td>';
	// 			if(!empty($pickup["weight"])){
	// 			    echo '<td>'.$pickup["weight"].' Kg</td>';
	// 			}else{
	// 			    echo '<td></td>';
	// 			}
	// 			echo '<td>'.$pickup["price"].'</td>';
	// 			echo '</tr>';
	// 		}
	// 	}
	// }

	if($_POST["action"]=="search_item_single"){
		//method 2
		$search_value = mysqli_real_escape_string($connection, $_POST["search"]);
		$sql ="SELECT * FROM inv_pickups ";
			if(!empty($search_value)){
			    // $sql.=" WHERE CONCAT_WS(ean, upc, category, item_name, description, cover, notes, price, weight) LIKE '%$search_value%' ";
			    $sql.=" WHERE (category LIKE '%".$search_value."%' ";
			    $sql.=" OR item_name LIKE '%".$search_value."%' ";
			    $sql.=" OR description LIKE '%".$search_value."%' ";
			    $sql.=" OR cover LIKE '%".$search_value."%' ";
			    $sql.=" OR notes LIKE '%".$search_value."%' ";
			    $sql.=" OR weight LIKE '%".$search_value."%' ";
			    $sql.=" OR price LIKE '%".$search_value."%' )";
			}
		$pickups = mysqli_query($connection, $sql);
		$row_results=mysqli_num_rows($pickups);
		
		if($row_results>0){
			echo '<h5>Search Results:</h5>
				<div style="overflow-y: scroll; max-height: 90%;">
			         <table class="table table-bordered">
			           <thead>
			             <th>UPC</th>
			             <th>Category</th>
			             <th>Item name</th>
			             <th>Cover</th>
			             <th>Price</th>
			           </thead>
			           <tbody>';
			while($pickup = mysqli_fetch_assoc($pickups)){
				$short_text_item_name = preg_replace( "/\n\s+/", "\n", trim(strip_tags(htmlspecialchars_decode($pickup["item_name"]))));
				if(strlen($short_text_item_name) > 35){
						$short_text_item_name = substr($short_text_item_name, 0, 35)."...";
				}

				echo '<tr>';

				echo '<td><span class="fakehref" onclick="scrollToRow('.$pickup["upc"].')">'.$pickup["upc"].'</span></td>';
				echo '<td>'.$pickup["category"].'</td>';
				echo '<td title="'.$pickup["item_name"].'">'.$short_text_item_name.'</td>';
				echo '<td>'.$pickup["cover"].'</td>';
				echo '<td>$'.$pickup["price"].'</td>';


				echo '</tr>';
			}

			echo '</tbody>
			    </table> </div> ';
		}else{
			echo '<h4 align="center">No results found.</h4>';
		}
	}
	if($_POST["action"]=="search_item_more"){
		//method 2

		$item_name = mysqli_real_escape_string($connection, $_POST["item_name"]);
		$upc = mysqli_real_escape_string($connection, $_POST["upc"]);
		$category = mysqli_real_escape_string($connection, $_POST["category"]);
		$description = mysqli_real_escape_string($connection, $_POST["description"]);
		$cover = mysqli_real_escape_string($connection, $_POST["cover"]);
		$notes = mysqli_real_escape_string($connection, $_POST["notes"]);

		$sql ="SELECT * FROM inv_pickups WHERE ";
			
				if(!empty($item_name)){
			    	$sql.=" item_name LIKE '%".$item_name."%' AND";
				}

				if(!empty($upc)){
			    	$sql.=" upc LIKE '%".$upc."%' AND";
				}

				if(!empty($category)){
				    $sql.=" category LIKE '%".$category."%' AND";
				}

				if(!empty($description)){
				    $sql.=" description LIKE '%".$description."%' AND";
				}

				if(!empty($cover)){
				    $sql.=" cover LIKE '%".$cover."%' AND";
				}
				if(!empty($notes)){
				    $sql.=" notes LIKE '%".$notes."%' ";
				}
				$sql = rtrim($sql, "AND");
			
		$pickups = mysqli_query($connection, $sql);
		$row_results=mysqli_num_rows($pickups);
		
		if($row_results>0){
			echo '<h5>Search Results:</h5>
			<div style="overflow-y: scroll; max-height: 90%;">
			         <table class="table table-bordered">
			           <thead id = "thead">
			             <th>UPC</th>
			             <th>Category</th>
			             <th>Item name</th>
			             <th>Cover</th>
			             <th>Price</th>
			           </thead>
			           <tbody>
					   
';
			while($pickup = mysqli_fetch_assoc($pickups)){
				$short_text_item_name = preg_replace( "/\n\s+/", "\n", trim(strip_tags(htmlspecialchars_decode($pickup["item_name"]))));
				if(strlen($short_text_item_name) > 25){
						$short_text_item_name = substr($short_text_item_name, 0, 25)."...";
				}

				echo '<tr>';

				echo '<td><span class="fakehref" onclick="scrollToRow('.$pickup["upc"].')">'.$pickup["upc"].'</span></td>';
				echo '<td>'.$pickup["category"].'</td>';
				echo '<td title="'.$pickup["item_name"].'">'.$short_text_item_name.'</td>';
				echo '<td>'.$pickup["cover"].'</td>';
				echo '<td>$'.$pickup["price"].'</td>';


				echo '</tr>';
			}

			echo '</tbody>
			    </table> 
				</div>';
		}else{
			echo '<h4 align="center">No results found.</h4>';
		}
	}

	if($_POST["action"]=="show_table_pickups_index"){
		if($_POST["loader"]=='default'){
			$pickups = mysqli_query($connection, "SELECT * FROM inv_pickups ORDER BY id ASC");
		// $pickups = mysqli_query($connection, "SELECT * FROM inv_pickups WHERE id IN ('205','206','207')");

		}
		if($_POST["loader"]=='search'){
			$search_item = mysqli_real_escape_string($connection, $_POST["search_item"]);
			$sql ="SELECT * FROM inv_pickups ";
			if(!empty($search_item)){
			    $sql.=" WHERE (category LIKE '%".$search_item."%' ";
			    $sql.=" OR item_name LIKE '%".$search_item."%' ";
			    $sql.=" OR description LIKE '%".$search_item."%' ";
			    $sql.=" OR cover LIKE '%".$search_item."%' ";
			    $sql.=" OR notes LIKE '%".$search_item."%' ";
			    $sql.=" OR weight LIKE '%".$search_item."%' ";
			    $sql.=" OR price LIKE '%".$search_item."%' )";
			}
			$pickups = mysqli_query($connection, $sql);
		}
			while($pickup = mysqli_fetch_assoc($pickups)){

				$short_text_description = preg_replace( "/\n\s+/", "\n", trim(strip_tags(htmlspecialchars_decode($pickup["description"]))));
				if(strlen($short_text_description) > 50){
					$short_text_description = substr($short_text_description, 0, 50)."...";
				}

				$short_text_notes = preg_replace( "/\n\s+/", "\n", trim(strip_tags(htmlspecialchars_decode($pickup["description"]))));
				if(strlen($short_text_notes) > 50){
					$short_text_notes = substr($short_text_notes, 0, 50)."...";
				}

				echo '<tr id="upc_'.$pickup["upc"].'" style="scroll-margin: 170px;">';
				if($_SESSION['superuser']=='admin'){ 
					echo '<td class="print_column_td">
							
								<input type="number" 
								class="form-control zindexinput" 
								id="qty_id_'.$pickup["id"].'"
								title="qty_id_'.$pickup["id"].'"
								min="0" value="0" min="0"
								data-type="qty_selector" 
								data-pid="'.$pickup["id"].'" 
								data-upc="'.$pickup["upc"].'" 
								data-ean="'.$pickup["ean"].'" 
								data-category="'.mysqli_real_escape_string($connection, $pickup["category"]).'" 
								data-item_name="'.mysqli_real_escape_string($connection, $pickup["item_name"]).'" 
								data-description="'.mysqli_real_escape_string($connection, $pickup["description"]).'" 
								data-cover="'.mysqli_real_escape_string($connection, $pickup["cover"]).'" 
								data-price="'.$pickup["price"].'">
								
							
						</td>';
				}else{
					if($site_setting["allow_customers_to_order"]=="yes"){
						echo '<td class="print_column_td">
					
								<input type="number" 
								class="form-control zindexinput" 
								id="qty_id_'.$pickup["id"].'"
								title="qty_id_'.$pickup["id"].'"
								min="0" value="0" min="0"
								data-type="qty_selector" 
								data-pid="'.$pickup["id"].'" 
								data-upc="'.$pickup["upc"].'" 
								data-ean="'.$pickup["ean"].'" 
								data-category="'.mysqli_real_escape_string($connection, $pickup["category"]).'" 
								data-item_name="'.mysqli_real_escape_string($connection, $pickup["item_name"]).'" 
								data-description="'.mysqli_real_escape_string($connection, $pickup["description"]).'" 
								data-cover="'.mysqli_real_escape_string($connection, $pickup["cover"]).'" 
								data-price="'.$pickup["price"].'">
	
						</td>';
					}
				}



				echo '<td><a href="javascript:void(0)" onclick="view_item('.$pickup["upc"].')" >'.$pickup["upc"].'</td>';
				echo '<td id="ean_'.$pickup["ean"].'" style="scroll-margin: 170px;">'.$pickup["ean"].'</td>';
				echo '<td>'.$pickup["category"].'</td>';
				echo '<td>'.$pickup["item_name"].'</td>';
				echo '<td>'.$short_text_description.'</td>';
				echo '<td>'.$pickup["cover"].'</td>';
				echo '<td>'.$short_text_notes.'</td>';
				if(!empty($pickup["weight"])){
				    echo '<td>'.$pickup["weight"].' Kg</td>';
				}else{
				    echo '<td></td>';
				}
				if(!empty($pickup["price"])){
				    echo '<td>$'.number_format($pickup["price"], 2, ".", "").'</td>';
				}else{
				    echo '<td></td>';
				}

				echo '</tr>';
			}	

	}


	if($_POST["action"]=="insert_shipping_address"){

		$orderid = $_POST["order_no"];
		$userid = $_POST["userid"];

		$nameofrecipient = mysqli_real_escape_string($connection, $_POST['nameofrecipient']);
		$street1 = mysqli_real_escape_string($connection, $_POST['street1']);
		$street2 = mysqli_real_escape_string($connection, $_POST['street2']);
		$street3 = mysqli_real_escape_string($connection, $_POST['street3']);
		$city = mysqli_real_escape_string($connection, $_POST['city']);
		$regionstate = mysqli_real_escape_string($connection, $_POST['regionstate']);
		$zipcode = mysqli_real_escape_string($connection, $_POST['zipcode']);
		$country = mysqli_real_escape_string($connection, $_POST['country']);
		$mobileno = mysqli_real_escape_string($connection, $_POST['mobileno']);
		$telno = mysqli_real_escape_string($connection, $_POST['telno']);

		$complete_address = $street1.' '.$street2.' '.$street3;
		$sql_insert_shipping = "INSERT INTO t_order_shippaddress(
                                          shipto,  
                                          street_name,  
                                          apartment_designation,  
                                          suburb,  
                                          complete_address,                                       
                                          city,
                                          region_state,
                                          order_id,
                                          country,
                                          zip_postcode,
                                          delivery_tel,
                                          home_tel  )
                                    VALUES(
                                        '{$nameofrecipient}',
                                        '{$street1}',
                                        '{$street2}',
                                        '{$street3}',
                                        '{$complete_address}',                                        
                                        '{$regionstate}',
                                        '{$city}',
                                        '{$orderid}',
                                        '{$country}',
                                        '{$zipcode}',
                                        '{$telno}',
                                        '{$mobileno}')";

       	mysqli_query($connection, $sql_insert_shipping);

       	//insertion of messages order ack.


       	$users = mysqli_query($connection, "SELECT * FROM users WHERE id='$userid'");
       	$user = mysqli_fetch_assoc($users);
       	$fullname = $user["first_name"].' '.$user["last_name"];
       	$username = $user["user_name"];

       	$subject = 'Order - '.$orderid;
       	$today = date("Y-m-d H:i:s"); 
    	$sql_insert_order_m ="INSERT INTO tbl_contact
									    	(fld_userids, 
									    	fld_date, 
									    	fld_fullname, 
									    	fld_uname, 
									    	fld_title, 
									    	fld_status, 
									    	fld_msgstatus, 
									    	fld_typem, 
									    	fld_typemsg, 
									    	fld_ordersid)
									        VALUES
									        ('$userid', 
									        '$today', 
									        '$fullname', 
									        '$username', 
									        '$subject', 
									        '$orderid', 
									        'kinman_msg', 
									        'Notification', 
									        'Notification', 
									        '$orderid')";
        mysqli_query($connection, $sql_insert_order_m);

    	$subject2 = 'Order Acknowledgment - '.$orderid;
    	$sql_insert_order_ack ="INSERT INTO tbl_contact 
									    	(fld_userids, 
									    	fld_date, 
									    	fld_fullname, 
									    	fld_uname, 
									    	fld_title, 
									    	fld_status, 
									    	fld_msgstatus, 
									    	fld_typem, 
									    	fld_typemsg, 
									    	fld_ordersid)
									        VALUES 
									        ('$userid', 
									        '$today', 
									        '$fullname', 
									        '$username', 
									        '$subject2', 
									        '$orderid', 
									        'kinman_msg', 
									        'Notification', 
									        'Notification', 
									        '$orderid')";
        mysqli_query($connection, $sql_insert_order_ack);

        echo "good";

	}

	if($_POST["action"]=="slider_toggle"){
		$toggle = $_POST["toggle"];
		$value = $_POST["val"];
		if($toggle == "toggle_allowcustomerstoorder"){
			mysqli_query($connection, "UPDATE inv_pickups_settings SET allow_customers_to_order='$value' WHERE id = 1");
		}
		if($toggle == "toggle_maintenancemode"){
			mysqli_query($connection, "UPDATE inv_pickups_settings SET maintenance_mode='$value' WHERE id = 1");
		}
	}

	if($_POST["action"]=="show_real_total_amount"){
		$totalamount = $_POST["total_amount"];
		$dealerid = $_SESSION['logged_id'];
        $tbl_dealers = mysqli_query($connection, "SELECT * FROM tbl_dealers WHERE dealer_id='$dealerid'");
        $tbl_dealer = mysqli_fetch_assoc($tbl_dealers);

        $mydiscount = 0;
        $real_amount = 0;
        //formula to get discount in decimal = percent/100
        $arr_discount = json_decode($tbl_dealer["dealer_vDiscount"]);
        if(property_exists($arr_discount, "discount")){
        	//this is static discount type
        	$mydiscount = floatval($arr_discount->{'discount'});
        	$real_amount = $totalamount*($mydiscount/100);
        	$real_amount = floatval($totalamount-$real_amount);
        }else{
        	//this is variable discount type
        	$variable = $arr_discount->{'variant'};
        	foreach ($variable as $props){
        		$amount = $props->{'amount'};
        		$threshold = $props->{'threshold'};
        		if(floatval($amount)!=0){
        			if(floatval($totalamount) >= floatval($amount)){
        				$mydiscount = $threshold;
        			}
        		}
        	}
        	$real_amount = $totalamount*($mydiscount/100);
        	$real_amount = floatval($totalamount-$real_amount);
        }

        echo '$'.number_format($real_amount, 2, ".", ",").'|'.$mydiscount.'%';

	}

	if($_POST["action"]=="check_existing_file"){
		$photo = $_POST["photo"];
		if(file_exists("../site_images/".$photo)){
			echo 'existing';
		}
	}

	if($_POST["action"]=="update_img_path"){
		$id = $_POST["id"];
		$filename = mysqli_real_escape_string($connection, $_POST["filename"]);
		mysqli_query($connection, "UPDATE inv_pickups SET img_path = '$filename' WHERE id = '$id'");
	}

	if($_POST["action"]=="backup_files"){
	    $today = date("Y-m-d");
	    $time = time();
	    //!!!!!!!!---------------------------------\                        
	    //!!!!!!!!----------------------------------\              BBBBBB     BB    BB    BB   BBBBB
	    //!!!!!!!!-----------------------------------\             BB   BB   BBBB   BBB   BB  BB   BB
	    //!!!!!!!!------------------------------------\            BB   BB  BB  BB  BBBB  BB  BB
	    //!!!!!!!!-------------------------------------\           BBBBBB   BBBBBB  BB BB BB  BB  BBB
	    //change path if this is not running on localhost          BB   BB  BB  BB  BB  BBBB  BB   BB
	    //!!!!!!!!--------------------------------------/          BB   BB  BB  BB  BB    BB  BB   BB
	    //!!!!!!!!-------------------------------------/           BBBBBB   BB  BB  BB    BB   BBBBB
	    //!!!!!!!!------------------------------------/
	    //!!!!!!!!-----------------------------------/
	    //!!!!!!!!----------------------------------/
	    new GoodZipArchive('../../barcodedlist', '../Back-up/System files/Barcoded list System Back-up ['.$today.'] - '.$time.'.zip');
	    $backupzip = 'Barcoded list System Back-up ['.$today.'] - '.$time.'.zip';
	    echo $backupzip;
	}


	if($_POST["action"]=="backup_db"){
	    $connection->set_charset("utf8");

	    // Get All Table Names From the Database
	    $tables = array();
	    $sql = "SHOW TABLES WHERE Tables_in_".$database." IN ('inv_pickups', 'inv_login_logs', 'inv_pickups_settings')";
	    $result = mysqli_query($connection, $sql);

	    while ($row = mysqli_fetch_row($result)) {
	        $tables[] = $row[0];
	    }

	    $sqlScript = "";
	    foreach ($tables as $table) {
	        
	        // Prepare SQLscript for creating table structure
	        $query = "SHOW CREATE TABLE $table";
	        $result = mysqli_query($connection, $query);
	        $row = mysqli_fetch_row($result);
	        
	        $sqlScript .= "\n\n" . $row[1] . ";\n\n";
	        
	        
	        $query = "SELECT * FROM $table";
	        $result = mysqli_query($connection, $query);
	        
	        $columnCount = mysqli_num_fields($result);
	        
	        // Prepare SQLscript for dumping data for each table
	        for ($i = 0; $i < $columnCount; $i ++) {
	            while ($row = mysqli_fetch_row($result)) {
	                $sqlScript .= "INSERT INTO $table VALUES(";
	                for ($j = 0; $j < $columnCount; $j ++) {
	                    $row[$j] = $row[$j];
	                    
	                    if (isset($row[$j])) {
	                        $sqlScript .= '"' . $row[$j] . '"';
	                    } else {
	                        $sqlScript .= '""';
	                    }
	                    if ($j < ($columnCount - 1)) {
	                        $sqlScript .= ',';
	                    }
	                }
	                $sqlScript .= ");\n";
	            }
	        }
	        
	        $sqlScript .= "\n"; 
	    }

	    if(!empty($sqlScript)){
	        // Save the SQL script to a backup file
	        $backup_file_name = '../Back-up/Database/'.$database.'_backup_'.strtoupper(date("FdY")).'_'.time().'.sql';
	        $fileHandler = fopen($backup_file_name, 'w+');
	        $number_of_lines = fwrite($fileHandler, $sqlScript);
	        fclose($fileHandler); 

	    }
	    echo basename($backup_file_name);
	}

}


?>