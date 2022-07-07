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
</head>


<body>
<!-- header -->

    <div id = 'pagetitle' class="pull-left">
        <h5>Ordering page for Kinman Bar Coded Products List</h5>
        
        <input type="hidden" value="<?php echo $_SESSION['logged_id']; ?>">
        <span><?php echo $dealer["dealer_name"]; ?></span>
    </div>
    
    
    <div class="card sticky-top searchDiv float-left" id="searchDiv">
    	<div class="row">
    		<div class="col-lg-6 col-xs-12">
		    	<div class="form-group">
		    		 <span class="float-left" title="Hide search box" onclick="toggle_hide_search(0);" id="hide_search_btn"><i class="fa fa-angle-double-right sDiv_hide" aria-hidden="true"> </i></span> &nbsp;
		    		 <label id="search_label"><strong>Search barcode here</strong></label>
		    		<input type="text" id="search_barcode" class="form-control">
		    		<div align="right" id="search_toggles">
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="opt_search" id="opt_search1" value="ean">
							  <label class="form-check-label" for="opt_search1">EAN</label>
							</div>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="opt_search" id="opt_search2" value="upc" checked>
							  <label class="form-check-label" for="opt_search2">UPC</label>
							</div>
							
						</div>
					</div>
	    	</div>
	    	<div class="col-lg-6 col-xs-12" id="search_item_group">
		    	<div class="form-group">
		    		  &nbsp;
		    		 <label id="search_label"><strong>Search item here</strong></label>
		    		<input type="text" id="search_item" class="form-control">
					</div>
	    	</div>
	    </div>
    </div>

    


	<div style="padding-left: 10px; padding-right: 10px;">
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
		<?php if($_SESSION['superuser']=='admin'){ ?>
				<div class="float-right" id="super_editor">
        	<button type="button" class="btn btn-info btn-sm" onclick="viewpage('guest')"><i class="fa fa-eye"></i> Normal mode</button>
        	<button type="button" class="btn btn-light btn-sm" onclick="viewpage('admin')"><i class="fa fa-cogs"></i> Edit mode</button>
        
        	<br>
        	<br>
        	<button type="button" class="btn btn-danger" onclick="print_order();"><i class="fa fa-print"></i> Print Order</button>
        	<button type="button" class="btn btn-outline-primary btn-sm" onclick="show_table_pickups(null, 'default');"><i class="fa fa-retweet"></i> Refresh table</button>
        	
        	</div> 
        	<br>
        	<br>
        	<br>
        	<br>
    <?php } ?>

			<table class="table">
				<thead class="thead-dark" style="position: sticky; top: 0;">
					<tr>
						<?php if($_SESSION['superuser']=='admin'){ ?>
						<th style="width: 110px;" id="print_column">Qty</th>
						<?php } ?>
						<th>UPC</th>
						<th>EAN</th>
						<th>Category</th>
						<th>Item Name</th>
						<th>Description</th>
						<th>Cover</th>
						<th>Notes</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody id="pickups_table_body">

				</tbody>
			</table>
	</div>

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

<div class="modal fade" id="addtocart_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addtocart_header"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="addtocart_details">
        
      </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <button type="button" class="btn btn-danger">Submit Order</button>
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
    return !str.trim().length;
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



function print_order(){
	let items = document.querySelectorAll("input[data-type='qty_selector']");
	let text = "";
	var total_qty = 0;
	var total_amount = 0;
	var ids = [];
	text += `<form id="form1" method="POST">`;
	for (var i=0; i<items.length; i++) {
	    if(items[i].value != 0){
	    	//items[0]['dataset']['upc']
	    	
		  	text += "<p>[#"+i+"] <strong>"+items[i].value+"</strong> ⨯ "+items[i]['dataset']['upc']+" - "+items[i]['dataset']['category']+" / "+items[i]['dataset']['item_name'];
		  	if(items[i]['dataset']['price'] != "0" && items[i]['dataset']['price'] != ""){
		  		text += " (<b>$"+items[i]['dataset']['price']+"</b>)";
		  	}

		  	total_amount = total_amount + parseFloat(items[i]['dataset']['price'])*parseFloat(items[i].value);

		  	text += "</p>";
		  	total_qty = total_qty + parseFloat(items[i].value);

	    }
		  	

	}
	text += '<hr><p align="right"> Total price: <b>$'+total_amount.toFixed(2)+'</b></p>';
	text += "</form>";

	$('#addtocart_header').html("Print Order (Total quantity: <b>"+total_qty+"</b>)");
	$('#addtocart_details').html(text);
	$('#addtocart_Modal').modal("show");
}

function entered_qty(id){
	
}

$("input[data-type='qty_selector']").bind('keyup mouseup', function (event) {
    
    if(event.target.value != 0){
    	$('#'+event.target.id).css("border", "2px solid #FF7401");
    }else{
    	$('#'+event.target.id).css("border", "1px solid lightgray");
    }
    //$("#qty_id_"+id).css("border", "1px solid red");
});

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



$('#search_item').keyup(bindDelay(function (e) {
   show_table_pickups(null, 'search');
}, 700));


show_table_pickups(null, 'default');
function show_table_pickups(upc, loader){
	var search_item = $('#search_item').val();
	$.ajax({
		url: "controller/action.php",
		type: "POST",
		data: {action: "show_table_pickups_index", loader: loader, search_item: search_item},
		beforeSend: function(){
			$('#pickups_table_body').html(`<tr><td colspan="9" align="center">Loading...</td></tr>`);
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

		}
	})
}

</script>