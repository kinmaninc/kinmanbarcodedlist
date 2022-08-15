<?php 
require 'configuration.php';
$uid = $_SESSION["logged_id"];
$dealers = mysqli_query($connection, "SELECT * FROM tbl_dealers WHERE dealer_id = '$uid'");
$dealer = mysqli_fetch_assoc($dealers);


?>
<!DOCTYPE html>
<html>
<head>
	<?php require 'meta.php'; ?>
	<title>Barcoded List</title>
	<?php require 'link.php'; ?>
	<?php require 'script.php'; ?>
	<!-- Scroll to top only -->
	<link rel="stylesheet" type="text/css" href="dist/css/scrolltotop.css">
</head>


<body>
<!-- header -->

<!-- Scroll to top only -->
<button type="button" class="btn btn-danger btn-floating btn-lg" id="btn-back-to-top" title="Back to top"><i class="fas fa-arrow-up"></i></button>


    <div id = 'pagetitle' class="pull-left">
        <h5>Ordering page for Kinman Bar Coded Products List</h5>
        
        <input type="hidden" id="user_id" value="<?php echo $_SESSION['logged_id']; ?>">
        <span><?php echo $dealer["dealer_name"]; ?> <i id="info_btn" class="fa fa-info-circle laytblu cursor" onclick="show_discount_div(1)"></i></span>
        
        <div class="discounttooltipsy">
        	<?php
        		$dealerid = $_SESSION['logged_id'];
        		$tbl_dealers = mysqli_query($connection, "SELECT * FROM tbl_dealers WHERE dealer_id='$dealerid'");
        		$tbl_dealer = mysqli_fetch_assoc($tbl_dealers);

        		$arr_discount = json_decode($tbl_dealer["dealer_vDiscount"]);
        		echo '<span class="float-right cursor" onclick="show_discount_div(0)">&times;</span>';
        		echo '<p>Dealer type: <b>'.$tbl_dealer["dealer_type"].'</b><br>';
        		if(property_exists($arr_discount, "discount")){
        			//this is static discount type
        			echo 'Discount rate: <b>'.$arr_discount->{'discount'}.'%</b>';

        		}else{
        			//this is variable discount type

        			$variable = $arr_discount->{'variant'};
        			$text = "Discount rate: <br>";
        			foreach ($variable as $props){
        				$text .= '&nbsp;&nbsp;&nbsp;us$'.$props->{'amount'}.' '.$props->{'threshold'}.'% <br>';
        			}
        			echo $text;
        		}
        		if($tbl_dealer['dealer_excludePaypalFee']==1){
              echo '<br>Including PayPal transactions fees</p>';
            }else{
        			echo '</p>';
            }

        	?>
        </div>
    </div>
    <!-- search bar -->
    <?php require 'search_panel.php'; ?>

	<div id = 'maincontentcotainer'>
		<br>
		<div style = 'display: none;' class="pull-left">
		<h1>Pickups Inventory</h1>
		<input type="hidden" value="<?php echo $_SESSION['logged_id']; ?>">
		<span><?php echo $dealer["dealer_name"]; ?></span> 
		</div>
		<!--
		<a href="logout.php" class="btn btn-danger btn-sm">Log-out</a>
        <br>
		 <div align="right">
			<a href="add.php" class="btn btn-outline-success">Add item</a>
		</div> 
		<br>
	-->
        	<?php require 'super-editor.php'; ?>
			<?php require 'product_table.php'; ?>


</body>
</html>
<!-- Modal -->





<div class="modal fade" id="viewItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ean_label_title">EAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="item_details">
        
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
 -->    </div>
  </div>
</div>

<div class="modal fade" id="addtocart_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addtocart_header"></h5>
        <button type="button" class="close" onclick="$('#Warning_modal').modal('show');">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="addtocart_details">
        
      </div>
      <div id="addtocart_results"></div>
       <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        
        <button type="button" class="btn btn-success" id="checkout_btn" disabled onclick="checkoutform();">Checkout</button>
      </div>
   	</div>
  </div>
</div>

<div id="Warning_modal" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body" style="color: white; background-color: #3C4152;">
                <h5>Warning:</h5>
                <p>Are you sure you want to close this? The added <strong>'Notes'</strong> will all be gone.</p>
                <div align="center">
                	<button type="button" class="btn btn-danger" onclick="$('#Warning_modal').modal('hide');$('#addtocart_Modal').modal('hide');">Confirm</button>
                	<button type="button" class="btn btn-outline-light" style="border: 1px solid grey; color: grey;" data-dismiss="modal">Cancel</button>
            		</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="printbarcode_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="printbarcode_header"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" align="center">
      	<div id="printbarcode_details"></div>
      	<div style="border: 1px solid black;"><svg id="printbarcode_upc"></svg></div>
        
      </div>
       <div class="modal-footer">
        
        <div class="input-group mb-3">
        	<div class="input-group-prepend">
				    <span class="input-group-text">Copies</span>
				  </div>
        	<input type="number" id="printbarcode_qty" class="form-control col-md-2" value="1" min="1">
	        	<div class="input-group-append">
		        <button type="button" class="btn btn-primary" onclick="print_barcodes();">Print</button>
		      </div>
		    </div>
	      </div>
      </div>
   	</div>
  </div>
</div>

<div class="modal fade" id="addnotes_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addnotes_header"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" align="center" id="addnotes_body">
      </div>
       <div class="modal-footer" id="addnotes_footer">
	      </div>
      </div>
   	</div>
  </div>
</div>

<div class="modal fade" id="checkoutform_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen-dialog">
    <div class="modal-content modal-fullscreen-content" style = 'height: auto;'>
<?php

$user_id = $_SESSION['logged_id'];
$dealers = mysqli_query($connection, "SELECT * FROM users WHERE id = '$user_id'");
$dealer = mysqli_fetch_assoc($dealers);


?>
      <div class="modal-body modal-fullscreen-body">
      	<div class="pull-right">
      		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
      	</div>
        <div align="center"><img src="dist/img/king-of-noiseless.jpg" style="width: 230px;"></div>
        <hr>
        <h4 align="center">Shipping Address</h4>
        <div class="row">
        	<div class="col-lg-3 col-xs-12">
        	</div>
        	<div class="col-lg-6 col-xs-12" align="center">
        		<div style="padding: 20px; border-radius: 7px; border: 1px solid black;">
        			<p class="ptoleft">Name of Recipient: <span class="stronggg" id="box_nameofrecipient"><?php echo $dealer["first_name"].' '.$dealer["last_name"]; ?></span></p>
        			<p class="ptoleft">Street 1: <span class="stronggg" id="box_street1"><?php echo $dealer["street_name"]; ?></span></p>
        			<p class="ptoleft">Street 2: <span class="stronggg" id="box_street2"><?php echo $dealer["apartment_designation"]; ?></span></p>
        			<p class="ptoleft">Street 3: <span class="stronggg" id="box_street3"><?php echo $dealer["suburb"]; ?></span></p>
        			<p class="ptoleft">City: <span class="stronggg" id="box_city"><?php echo $dealer["city"]; ?></span></p>
        			<p class="ptoleft">Region/State/Province: <span class="stronggg" id="box_regionstate"><?php echo $dealer["region_state"]; ?></span></p> 
        			<p class="ptoleft">Zip Code: <span class="stronggg" id="box_zipcode"><?php echo $dealer["zipcode"]; ?></span></p>                
        			<p class="ptoleft">Country: <span class="stronggg" id="box_country" readonly><?php echo $dealer["country"]; ?></span></p>
        			<br>
        			<p class="ptoleft">Cellphone Or Mobile: <span class="stronggg" id="box_mobileno"><?php echo $dealer["celno"]; ?></span></p>
        			<p class="ptoleft">Landline Telephone <span class="stronggg" id="box_telno"><?php echo $dealer["tel"]; ?></span></p>
        		</div>
        	</div>
        	<div class="col-lg-3 col-xs-12">
        	</div>
        </div>

        <div class="row">
        	<div class="col-lg-3 col-xs-12">
        	</div>
        	<div class="col-lg-6 col-xs-12" align="center" id="shipping_form_body">
        		<p>This is how your address prints out at this end. Please change it now to remove foreign characters - only Western characters please.</p>
        		<br>


						<input type="text" class="form-control" name="nameofrecipient" onkeyup="inputShipping(event);" value="<?php echo $dealer["first_name"].' '.$dealer["last_name"]; ?>" placeholder="Name of Recipient">
        		<br>
        		<p>Type your delivery address here. For Express Courier PO Boxes are not acceptable,
must be a Street Address.</p>
        		<input type="text" class="form-control" name="street1" onkeyup="inputShipping(event);" value="<?php echo $dealer["street_name"]; ?>" placeholder="Street 1 (required)">
        		<br>
        		<input type="text" class="form-control" name="street2" onkeyup="inputShipping(event);" value="<?php echo $dealer["apartment_designation"]; ?>" placeholder="Street 2">
        		<br>
        		<input type="text" class="form-control" name="street3" onkeyup="inputShipping(event);" value="<?php echo $dealer["suburb"]; ?>" placeholder="Street 3">
        		<br>
        		<input type="text" class="form-control" name="city" onkeyup="inputShipping(event);" value="<?php echo $dealer["city"]; ?>" placeholder="City (required)">
        		<br>
        		<input type="text" class="form-control" name="regionstate" onkeyup="inputShipping(event);" value="<?php echo $dealer["region_state"]; ?>" placeholder="Region/State/Provice (required)">
        		<br>
        		<input type="text" class="form-control" name="zipcode" onkeyup="inputShipping(event);" value="<?php echo $dealer["zipcode"]; ?>" placeholder="Zip/Post Code (required)">
        		<br>
        		<div class="form-group">
        			<label for="country" style="float: left;">Country</label>
        			<input type="text" class="form-control" readonly id="country" name="country" onkeyup="inputShipping(event);" value="<?php echo $dealer["country"]; ?>" placeholder="Country (required)">
        		</div>

        		<div class="form-group">
        			<label for="mobileno" style="float: left;">Cellphone or Mobile</label>
        			<input type="text" class="form-control" id="mobileno" name="mobileno" onkeyup="inputShipping(event);" value="<?php echo $dealer["celno"]; ?>" placeholder="Cellphone / Mobile Number (required)">
        		</div>

        		<div class="form-group">
        			<label for="telno" style="float: left;">Desk-top Telephone Number</label>
        			<input type="text" class="form-control" id="telno" name="telno" onkeyup="inputShipping(event);" value="<?php echo $dealer["tel"]; ?>" placeholder="Landline Telephone">
        		</div>

        		<div class="form-check">
						  <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="flexCheckChecked">
						  <label class="form-check-label">
						     Tick here to accept <span class="fakehref" onclick="showpurchaseterms()">Purchase and Delivery Terms & Conditions</span>  
						  </label>
						</div>
						<br>
						<p style="margin-bottom: 0px;">DO NOT CLICK submit if you were only discovering information, and avoid an unwanted order being placed, thank you.</p>
						<p id="errorMessage" style="color: red; text-align: left; display: none; font-weight: bold;"></p>
        	</div>
        	<div class="col-lg-3 col-xs-12">
        	</div>
        </div>

        <div class="row">
        	<div class="col-lg-3 col-xs-12">
        	</div>
        	<div class="col-lg-6 col-xs-12" align="center">
        		<button type="button" class="btn btn-block btn-lg btn-primary" id="submit_button" onclick="submit_order(0)"> Submit</button>
        	</div>
        	<div class="col-lg-3 col-xs-12">
        	</div>
        </div>
        
      </div>

    </div>
  </div>
</div>

<?php require 'purchase_and_terms.php'; ?>

<div class="modal fade" id="entermobile_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #FC7F22; color: black;">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" align="center">
      	<p>Please enter your Cell / Mobile phone number so we can send a Text message in the event of a failed email and we have a question for you.</p>
      </div>
       <div class="modal-footer">
        	<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#mobileno').focus();">Enter cellphone number</button>
        	<button type="button" class="btn btn-outline-light" data-dismiss="modal" id="idonthavecp_btn" onclick="submit_order(1);" style="color:black; border: 1px solid black;">I don't have a cellphone number</button>

	      </div>
      </div>
   	</div>
  </div>



<?php require 'search_modal.php'; ?>


<script type="text/javascript">

function view_item(ean){
	$('#viewItemModal').modal("show");
	$.ajax({
		url: "controller/action.php",
		type: "POST",
		beforeSend: function(){
			$('#ean_label_title').html('UPC: '+ean);
			$('#item_details').html('Loading...');
		},
		data: {action: "view_item", code: ean},
		success: function(data){
			$('#item_details').html(data);
			try{
				JsBarcode("#pic_barcode_upc", ean, {
				  format: "upc",
				  lineColor: "black",
				  width: 1.5,
				  height: 50,
				  displayValue: true
				});
			}catch(err){
				console.log("Invalid barcode.");
			  $('#pic_barcode_upc').html(`<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<g id="Group-2" transform="translate(2.000000, 2.000000)">
									<circle id="Oval-2" stroke="rgba(252, 191, 191, .5)" stroke-width="4" cx="41.5" cy="41.5" r="41.5"></circle>
									<circle  class="ui-error-circle" stroke="#F74444" stroke-width="4" cx="41.5" cy="41.5" r="41.5"></circle>
										<path class="ui-error-line1" d="M22.244224,22 L60.4279902,60.1837662" id="Line" stroke="#F74444" stroke-width="3" stroke-linecap="square"></path>
										<path class="ui-error-line2" d="M60.755776,21 L23.244224,59.8443492" id="Line" stroke="#F74444" stroke-width="3" stroke-linecap="square"></path>
								</g>
						</g>`);
			}
		}
	})
}


setTimeout(function(){
  $("#search_barcode").focus();
}, 500);

var search_option = 'upc';
document.querySelectorAll('input[name="opt_search"]').forEach((elem) => {
	elem.addEventListener("change", function(event) {
		var val = event.target.value;
		search_option = val;
	});
});


//scanner search
$("#search_barcode").keyup(function(event) {
    var sb = $('#search_barcode').val();
    if(event.keyCode === 13) {
      console.log("Entered");
      // $("#search_barcode").focus();
      // $("#search_barcode").select();
    }
    if(search_option=='upc'){
    	if(sb.length == 12){
	    	console.log("Searching code: "+sb);
	    	$("#search_barcode").focus();
	      $("#search_barcode").select();
	      
				removeHighlight();
				

				var element = document.getElementById("upc_"+sb);

		    //If it isn't "undefined" and it isn't "null", then it exists.
		    if(typeof(element) != 'undefined' && element != null){
		      $('#upc_'+sb).attr("class", "highlighted");
					document.getElementById('upc_'+sb).scrollIntoView({
					  behavior: 'smooth'
					});
		    }else{
		      alert("Barcode ["+sb+"] not found.");
		      console.log("Barcode ["+sb+"] not found.");
		    }
	    }
    }
    if(search_option=='ean'){
    	if(sb.length == 13){
	    	console.log("Searching code: "+sb);
	    	$("#search_barcode").focus();
	        $("#search_barcode").select();
	      
				removeHighlight();
				

				var element = document.getElementById("ean_"+sb);

		    //If it isn't "undefined" and it isn't "null", then it exists.
		    if(typeof(element) != 'undefined' && element != null){
		    	sb = sb.substring(1, sb.length);
		      $('#upc_'+sb).attr("class", "highlighted");
					document.getElementById('upc_'+sb).scrollIntoView({
					  behavior: 'smooth'
					});

		    }else{
		      alert("Barcode ["+sb+"] not found.");
		      console.log("Barcode ["+sb+"] not found.");
		    }
	    }
    }
    
});

//manual search
$('#search_barcode').keyup(bindDelay(function (e) {
    var sb = $('#search_barcode').val();
		if(search_option=='upc'){
	    if(!isEmpty(sb)){
	    	let h = document.querySelectorAll("[id^='upc_"+sb+"']");
				if(h.length > 0){
					removeHighlight();
					document.getElementById(h[0]['id']).scrollIntoView({
						  behavior: 'smooth'
					});
			    // $('#'+h[0]['id']).attr("class", "highlighted");

			    for (var i=0; i<h.length; i++) {
					    h[i].classList.add("highlighted");
					}
				}else{
					removeHighlight();
				}
	    }else{
					removeHighlight();
	    }
	  }
		if(search_option=='ean'){
			if(!isEmpty(sb)){
				sb = sb.substring(1, sb.length);
	    	let h = document.querySelectorAll("[id^='upc_"+sb+"']");

				if(h.length > 0){
					removeHighlight();
					document.getElementById(h[0]['id']).scrollIntoView({
						  behavior: 'smooth'
					});
			    // $('#'+h[0]['id']).attr("class", "highlighted");

			    for (var i=0; i<h.length; i++) {
					    h[i].classList.add("highlighted");
					}
				}else{
					removeHighlight();
				}
	    }else{
					removeHighlight();
	    }
		}

}, 700));



function removeHighlight() {
	let h = document.querySelectorAll('tr.highlighted');
	for (var i=0; i<h.length; i++) {
	    h[i].classList.remove("highlighted");
	}
}

function bindDelay(callback, ms) {
      var timer = 0;
      return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
          callback.apply(context, args);
        }, ms || 0);
      };
    }

function isEmpty(str) {
	if(typeof(str) != 'undefined'){
    return !str.trim().length;
	}
}



function toggle_hide_search(val){
	if(val === 1){
		document.getElementById('searchDiv').style.width = "600px";
		document.getElementById('searchDiv').style.height = "108px";
		$('#hide_search_btn').attr("onclick", "toggle_hide_search(0)");
		$('#hide_search_btn').attr("title", "Hide search box");
		$('#hide_search_btn').html('<i class="fa fa-angle-double-right sDiv_hide" aria-hidden="true"> </i>');

		$('#search_label').show();
		$('#search_barcode').show();
    $("#search_barcode").focus();
		$('#search_toggles').show();
		$('#search_item_group').show();
	}
	if(val === 0){
		document.getElementById('searchDiv').style.width = "50px";
		document.getElementById('searchDiv').style.height = "35px";
		$('#hide_search_btn').attr("onclick", "toggle_hide_search(1)");
		$('#hide_search_btn').attr("title", "Show search box");
		$('#hide_search_btn').html('<i class="fa fa-angle-double-left sDiv_hide" aria-hidden="true"> </i>');
		$('#search_label').hide();
		$('#search_barcode').hide();
		$('#search_toggles').hide();
		$('#search_item_group').hide();

	}
}

function viewpage(type){
	if(type == 'guest'){
		location.href = "index.php";
	}
	if(type == 'admin'){
		location.href = "index_maintenance.php";
	}

}


function reset(){
	$("input[data-type='qty_selector']").val(0);
	$("input[data-type='qty_selector']").css("border", "1px solid lightgray");
}


function print_barcode(upc, event, type){
var details ='';
try {
  JsBarcode("#printbarcode_upc", upc, {
		  format: "upc",
		  lineColor: "black",
		  width: 2,
		  height: 50,
		  displayValue: true
		});
}
catch(err) {
  console.log("Invalid barcode.");
  $('#printbarcode_upc').html(`<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
					<g id="Group-2" transform="translate(2.000000, 2.000000)">
						<circle id="Oval-2" stroke="rgba(252, 191, 191, .5)" stroke-width="4" cx="41.5" cy="41.5" r="41.5"></circle>
						<circle  class="ui-error-circle" stroke="#F74444" stroke-width="4" cx="41.5" cy="41.5" r="41.5"></circle>
							<path class="ui-error-line1" d="M22.244224,22 L60.4279902,60.1837662" id="Line" stroke="#F74444" stroke-width="3" stroke-linecap="square"></path>
							<path class="ui-error-line2" d="M60.755776,21 L23.244224,59.8443492" id="Line" stroke="#F74444" stroke-width="3" stroke-linecap="square"></path>
					</g>
			</g>`);
}
		
		
		details = event.target.parentElement.offsetParent.children[0].dataset;

		$('#printbarcode_header').html(details.ean);
		$('#printbarcode_details').html(`<h5>`+details.category+`</h5><p><b>`+details.item_name+`</p></b><p>`+details.description+`</p><p>`+details.cover+`</p>`+details.price+`</p>`);

		$('#printbarcode_Modal').modal("show");
}



$('#search_item').keyup(function (e) {
  // show_table_pickups(null, 'search'); //method 1 (buggy when ordering)
  if(e.keyCode == 13){
  	search_method2();
  }
});
var search_history_single = "";
var search_history_more = "";
function search_method2(mode) {
	//method 2

	if(mode == 'single'){
		let search_val = $('#search_item').val();
		if(search_history_single != search_val){
			if(!isEmpty(search_val)){
				search_history_single = search_val;
				$('#search_Modal').modal("show");
				
				$.ajax({
					url: "controller/action.php",
					type: "POST",
					data: {action: "search_item_single", search: search_val},
					beforeSend: function(){
						$('#search_results').html('Searching...');
					},
					success: function(data){
						$('#search_results').html(data);
					}
				});
			}else{
				search_history_single = "";
				$('#search_results').html("");
				removeHighlight();

			}
		}else{
			if(!isEmpty($('#search_item').val())){
				$('#search_Modal').modal("show");
			}

		}
	}
	if(mode == 'more'){
		let search_item = $('#search_item').val();
		let search_upc = $('#search_upc').val();
		let search_category = $('#search_category').val();
		let search_description = $('#search_description').val();
		let search_cover = $('#search_cover').val();
		let search_notes = $('#search_notes').val();

		var full_search = search_item + ` ` + search_upc + ` ` + search_category + ` ` + search_description + ` ` + search_cover + ` ` + search_notes;

		if(search_history_more != full_search){
			if(!isEmpty(full_search)){
				search_history_more = search_item + ` ` + search_upc + ` ` + search_category + ` ` + search_description + ` ` + search_cover + ` ` + search_notes;
				$('#search_Modal').modal("show");

				$.ajax({
					url: "controller/action.php",
					type: "POST",
					data: {action: "search_item_more", item_name: search_item, upc: search_upc, category: search_category, description: search_description, cover: search_cover, notes: search_notes},
					beforeSend: function(){
						$('#search_results').html('Searching...');
					},
					success: function(data){
						$('#search_results').html(data);
					}
				});
			}else{
				search_history_more = "";
				$('#search_results').html("");
				removeHighlight();

			}
		}else{
			$('#search_Modal').modal("show");
		}
	}
}

function scrollToRow(upc){
	$('#search_Modal').modal("hide");
	removeHighlight();
	$('#upc_'+upc).attr("class", "highlighted");
	document.getElementById('upc_'+upc).scrollIntoView({
		behavior: 'smooth'
	});
}

function showmoreopt(type){
	if(type==0){
		$('#search_more_options').show();
		$('#showmoreoptlink').attr("onclick", "showmoreopt(1);");
		$('#showmoreoptlink').html('-Less options');
		$('#littlesearchbtn').hide();
		$('#moreoptions_div').css("height", "330px");
	}else{
		$('#search_more_options').hide();
		$('#showmoreoptlink').attr("onclick", "showmoreopt(0);");
		$('#showmoreoptlink').html('+More options');
		$('#littlesearchbtn').show();
		$('#moreoptions_div').css("height", "90px");
	}
}


show_table_pickups(null, 'default');
function show_table_pickups(upc, loader){
	var search_item = $('#search_item').val();
	$.ajax({
		url: "controller/action.php",
		type: "POST",
		data: {action: "show_table_pickups_index", loader: loader, search_item: search_item},
		beforeSend: function(){
			$('#pickups_table_body').html(`<tr><td colspan="10" align="center">Loading...</td></tr>`);
		},
		success: function(data){
			$('#pickups_table_body').html(data);
			
			if(typeof(upc) != 'undefined' && upc != null){
				document.getElementById('upc_'+upc).scrollIntoView();
				document.getElementById('upc_'+upc).classList.add('blink_this');
				setTimeout(function(){
					document.getElementById('upc_'+upc).classList.remove('blink_this');
				},2500)
			}

			
			$("input[data-type='qty_selector']").bind('keyup mouseup', function (event) {
				

                get_items(event.target.id);

				
			    if(event.target.value != 0){
			    	$('#'+event.target.id).css("border", "2px solid #FF7401");
			    	
			    }else{
			    	$('#'+event.target.id).css("border", "1px solid lightgray");
			    }
			    var ctr = 0;
					let qty_selector = $("input[data-type='qty_selector']");

						for(let element of qty_selector ){ 
							
								if(element.value>0){
								ctr++;
										
								}else{
										
								}
						
						}
					if(ctr>0){
						$('#show_order_btn').attr("disabled", false);
					}else{
						$('#show_order_btn').attr("disabled", true);
					}
					
			});

		}
	})
}

function print_order(){
	let items = document.querySelectorAll("input[data-type='qty_selector']");
	let text = "";
	var total_qty = 0;
	var total_amount = 0;
	var ids = [];
	text += `<form id="form1" method="POST">`;
	text += `<input type="hidden" name="user_id" value="`+$('#user_id').val()+`">`;
	text += `<table border="1" style="width:100%;">`;
	text += `<thead>
						<tr>
							<th>#</th>
							<th>UPC</th>
							<th>Item name</th>
							<th>Cover</th>
							<th>Qty</th>
							<th>Price</th>
							<th>Amount</th>
							<th style="width: 20px;">Notes</th>
						</tr>
					</thead>`;
	text += `<tbody>`;
	var number_ctr = 1;
	for (var i=0; i<items.length; i++) {
	    if(items[i].value != 0){
			
		  	var price = items[i]['dataset']['price'];
		  	if(price == "" || typeof(price) == 'undefined' || price == null){
		  		price = 0;
		  	}
				text += `<tr>`;
		  	text += `<td>`+parseFloat(number_ctr)+`</td>`;
		  	text += `<td>`+items[i]['dataset']['upc']+`</td>`;
		  	text += `<td>`+items[i]['dataset']['category']+` - `+items[i]['dataset']['item_name']+`</td>`;
		  	text += `<td>`+items[i]['dataset']['cover']+`</td>`;
		  	text += `<td>`+items[i].value+`</td>`;
		  	text += `<td>`+price+`</td>`;
		  	text += `<td>`+parseFloat(price*items[i].value)+`</td>`;
		  	text += `<td align="center"><button type="button" class="btn btn-sm btn-secondary" id="addnotesbtn`+i+`" onclick="addnotes(`+i+`,`+parseFloat(i+1)+`)"><i class="fa fa-sticky-note" aria-hidden="true"></i></button></td>`;
		  	text += `</tr>`;

		  	text += `<tr style="display: none;"><td colspan="7">
			  				<input type="text" name="pid[`+i+`][]" value="`+items[i]['dataset']['pid']+`">

		  					<input type="text" name="product[`+i+`][]" value="`+items[i]['dataset']['category']+`">

		  					<input type="text" name="model[`+i+`][]" value="`+items[i]['dataset']['item_name']+`">

		  					<input type="text" name="upc[`+i+`][]" value="`+items[i]['dataset']['upc']+`">

		  					<input type="text" name="cover[`+i+`][]" value="`+items[i]['dataset']['cover']+`">

		  					<input type="text" name="description[`+i+`][]" value="`+items[i]['dataset']['description']+`">

		  					<input type="text" name="quantity[`+i+`]" value="`+items[i].value+`">

		  					<input type="text" name="price[`+i+`][]" value="`+price+`">

		  					<input type="text" name="subtotal[`+i+`][]" value="`+parseFloat(price*items[i].value)+`">

		  					<input type="text" id="addnotes`+i+`" name="addnotes[`+i+`][]" value="">

		  					</td></tr>`;

		  	total_qty = total_qty + parseFloat(items[i].value);
		  	total_amount = total_amount + parseFloat(price)*parseFloat(items[i].value);

			number_ctr++;
	    }
	}
	text += "</tbody></table>";
	text += '<hr>';
	text += '<p align="right" style="margin-bottom: -5px; color: #797979;">*Discount applied*</p>';
	text += '<p align="right"> Total price: <b id="print_total_amount">$'+total_amount.toFixed(2)+'</b></p>';
	text += '<input type="hidden" name="orig_total_amount" value="'+total_amount+'">';
	text += "</form>";

	//show real total amount (discount applied)
		  	$.ajax({
		  		url: "controller/action.php",
		  		type: "POST",
		  		data: {action: "show_real_total_amount", total_amount: total_amount},
		  		beforeSend: function(){
		  			$('#print_total_amount').html("Computing...");
		  			$('#checkout_btn').attr("disabled", true);
		  		},
		  		success: function(data){
		  			let results = data.split("|");
		  			$('#print_total_amount').html(results[0]);
		  			$('#print_dealer_discount').html("Discount rate: "+results[1]);
		  			$('#checkout_btn').attr("disabled", false);
		  		}
		  	})

	$('#addtocart_header').html("Print Order (Total quantity: <b>"+total_qty+"</b>)<br><i style='font-size: 15px; color: red;'>NOTE: If you close this pop-up, all the added notes will be removed.</i><br><b id='print_dealer_discount' style='font-size: 15px;font-weight:normal;'></b>");
	$('#addtocart_details').html(text);
	$('#addtocart_Modal').modal("show");
}

function addnotes(id, no){
	$('#addnotes_header').html('# '+no);

	var addnotesval = "";
	if(!isEmpty($('#addnotes'+id).val())){
		addnotesval = $('#addnotes'+id).val();
	}

	$('#addnotes_body').html(`<textarea class="form-control" rows="5" id="addnotes_textarea`+id+`">`+addnotesval+`</textarea>`);
	$('#addnotes_footer').html(`<button type="button" class="btn btn-primary" onclick="add_notes(`+id+`);">Add notes</button>`)
	$('#addnotes_modal').modal('show');
	setTimeout(function(){
		$('#addnotes_textarea'+id).focus();
	},500);

}

function add_notes(id){
	$('#addnotes'+id).val($('#addnotes_textarea'+id).val());
	// $('#addnotes_textarea'+id).val('');
	if(!isEmpty($('#addnotes'+id).val())){
		document.getElementById("addnotesbtn"+id).className = "btn btn-sm btn-success";
	}else{
		document.getElementById("addnotesbtn"+id).className = "btn btn-sm btn-secondary";
	}
	$('#addnotes_modal').modal('hide');
}

function checkoutform(){
	$('#checkoutform_modal').modal('show');
}

function showpurchaseterms(){
	$('#purchaseandterms_modal').modal('show');
}


var istheshippingformgood = false;
var isthetickboxgood = false;

function shippingformvalidationdragndrop(){

	let nameofrecipient = $('input[name="nameofrecipient"]');
	let street1 = $('input[name="street1"]');
	let city = $('input[name="city"]');
	let regionstate = $('input[name="regionstate"]');
	let zipcode = $('input[name="zipcode"]');

	if(isEmpty(nameofrecipient.val())){
		nameofrecipient.css("border", "1px solid red");
	}else{
		nameofrecipient.css("border", "1px solid lightgray");
	}

	if(isEmpty(street1.val())){
		street1.css("border", "1px solid red");
	}else{
		street1.css("border", "1px solid lightgray");
	}

	if(isEmpty(city.val())){
		city.css("border", "1px solid red");
	}else{
		city.css("border", "1px solid lightgray");
	}

	if(isEmpty(regionstate.val())){
		regionstate.css("border", "1px solid red");
	}else{
		regionstate.css("border", "1px solid lightgray");
	}

	if(isEmpty(zipcode.val())){
		zipcode.css("border", "1px solid red");
	}else{
		zipcode.css("border", "1px solid lightgray");
	}
	if(!isEmpty(nameofrecipient.val()) && !isEmpty(street1.val()) && !isEmpty(city.val()) && !isEmpty(regionstate.val()) && !isEmpty(zipcode.val())){
		istheshippingformgood = true;
	}else{
		istheshippingformgood = false;
	}
}

document.addEventListener("dragend", e => {
	shippingformvalidationdragndrop();
});
document.addEventListener("drop", e => {
	shippingformvalidationdragndrop();
});

function shippingformvalidation(){
	var nameofrecipient = $('input[name="nameofrecipient"]').val();
	var street1 = $('input[name="street1"]').val();
	var city = $('input[name="city"]').val();
	var regionstate = $('input[name="regionstate"]').val();
	var zipcode = $('input[name="zipcode"]').val();
	if(!isEmpty(nameofrecipient) && !isEmpty(street1) && !isEmpty(city) && !isEmpty(regionstate) && !isEmpty(zipcode)){
		istheshippingformgood = true;
	}else{
		istheshippingformgood = false;
	}
}


var checkbox = document.querySelector("input[name='flexCheckChecked']");
checkbox.addEventListener('change', function() {
  if (this.checked) {
    isthetickboxgood = true;
  } else {
    isthetickboxgood = false;
  }
});

function inputShipping(e){
	$('#box_'+e.target.name).text(e.target.value);
	if(e.target.name == 'nameofrecipient'){
		if(isEmpty(e.target.value)){
			$("input[name='"+e.target.name+"']").css("border", "1px solid red");
		}else{
			$("input[name='"+e.target.name+"']").css("border", "1px solid lightgray");
		}
	}

	if(e.target.name == 'street1'){
		if(isEmpty(e.target.value)){
			$("input[name='"+e.target.name+"']").css("border", "1px solid red");
		}else{
			$("input[name='"+e.target.name+"']").css("border", "1px solid lightgray");
		}
	}

	if(e.target.name == 'city'){
		if(isEmpty(e.target.value)){
			$("input[name='"+e.target.name+"']").css("border", "1px solid red");
		}else{
			$("input[name='"+e.target.name+"']").css("border", "1px solid lightgray");
		}
	}

	if(e.target.name == 'regionstate'){
		if(isEmpty(e.target.value)){
			$("input[name='"+e.target.name+"']").css("border", "1px solid red");
		}else{
			$("input[name='"+e.target.name+"']").css("border", "1px solid lightgray");
		}
	}

	if(e.target.name == 'zipcode'){
		if(isEmpty(e.target.value)){
			$("input[name='"+e.target.name+"']").css("border", "1px solid red");
		}else{
			$("input[name='"+e.target.name+"']").css("border", "1px solid lightgray");
		}
	}
}

//in submit_order function the type is default to 1
function submit_order(type = 1){
	shippingformvalidationdragndrop();
	if(istheshippingformgood == false && isthetickboxgood == false){
		$('#errorMessage').html("Please fill in the required fields and accept the Purchase and Delivery Terms & Conditions.");
		$('#errorMessage').fadeIn();
	}
	if(istheshippingformgood == true && isthetickboxgood == false){
		$('#errorMessage').html("Please accept the Purchase and Delivery Terms & Conditions.");
		$('#errorMessage').fadeIn();
	}
	if(istheshippingformgood == false && isthetickboxgood == true){
		$('#errorMessage').html("Please fill in the required fields.");
		$('#errorMessage').fadeIn();
	}

	if(istheshippingformgood == true && isthetickboxgood == true){
		$('#errorMessage').html("");
		$('#errorMessage').fadeOut("slow");
	

	$('#submit_button').attr("disabled", true);
	$('#idonthavecp_btn').attr("disabled", true);
	
	if(isEmpty($('#mobileno').val()) && type == 0){
		$('#entermobile_Modal').modal('show');
	}else{

		$('#submit_button').html("Processing...");
		if(type==0){
			console.log("Submitted order with mobile no.");
		}else{
			console.log("Submitted order without mobile no.");

		}
		var data = $("#form1").serializeArray(); 
		$.ajax({
			type: 'POST',
			async: false, 
			data: data,
			url: 'controller/submit_order.php',
			beforeSend: function(){
				$('#submit_button').html("Processing...");
				$('#submit_button').attr("disabled", true);
				$('#idonthavecp_btn').attr("disabled", true);
			},                                                            
			success: function(result){  

				// $('#addtocart_results').html(result);
				$.ajax({
					url: "controller/action.php",
					type: "POST",
					data: {action: "insert_shipping_address", 
								order_no: result, userid: $('#user_id').val(), 
								nameofrecipient: $('input[name="nameofrecipient"]').val(), 
								street1: $('input[name="street1"]').val(), 
								street2: $('input[name="street2"]').val(), 
								street3: $('input[name="street3"]').val(), 
								city: $('input[name="city"]').val(), 
								regionstate: $('input[name="regionstate"]').val(), 
								zipcode: $('input[name="zipcode"]').val(), 
								country: $('input[name="country"]').val(), 
								mobileno: $('input[name="mobileno"]').val(), 
								telno: $('input[name="telno"]').val()
					},
					success: function(data){
								setTimeout(function(){
									if(data=='good'){
											$('#submit_button').html("Submit");
											$('#submit_button').attr("disabled", false);
											$('#idonthavecp_btn').attr("disabled", false);
											location.href = 'order-summary.php?order_no='+result;
										}else{
											console.log(data);
											// alert("Error");
										}
								}, 1000);
						}
					})
				},
				error: function(xhr){
					alert("Error processing order. Please try again.");
					$('#submit_button').html("Submit");
					$('#submit_button').attr("disabled", false);
					$('#idonthavecp_btn').attr("disabled", false);
				}
			});
		}
	}
}

function show_discount_div(val){
	if(val==1){
		$('.discounttooltipsy').show();
		$('#info_btn').attr("onclick", "show_discount_div(0)");
	}else{
		$('.discounttooltipsy').hide();
		$('#info_btn').attr("onclick", "show_discount_div(1)");
	}
}
</script>
<!-- Scroll to top only -->
<script type="text/javascript" src="dist/js/scrolltotop.js"></script>

