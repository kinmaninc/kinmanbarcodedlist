<?php 
require 'configuration.php';
$uid = $_SESSION["logged_id"];
$dealers = mysqli_query($connection, "SELECT * FROM tbl_dealers WHERE dealer_id = '$uid'");
$dealer = mysqli_fetch_assoc($dealers);

if($_SESSION['superuser']=='admin'){
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
</head>


<body>
<!-- Scroll to top only -->
<button type="button" class="btn btn-danger btn-floating btn-lg" id="btn-back-to-top" title="Back to top"><i class="fas fa-arrow-up"></i></button>

<!-- header -->
<div id="snackbar"></div>
    <div id = 'pagetitle' class="pull-left">
        <h5>Ordering page for Kinman Bar Coded Products List <small>(Edit mode)</small></h5>
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
		    	<div class="form-group" id="moreoptions_div" style="background-color:#282828; padding-right: 10px; padding-left: 10px; padding-bottom: 10px; height: 90px;">
		    		  &nbsp;
		    		 <label id="search_label"><strong>Search by keywords</strong></label>
		    		

		    		<div class="input-group">
					    
					    <input type="text" id="search_item" class="form-control" placeholder="Item Name">
					    <div class="input-group-prepend">
					      <button type="button" class="btn btn-primary" id="littlesearchbtn" onclick="search_method2('single');"><i class="fa fa-search"></i></button>
					    </div>
					  </div>
					  <div align="right"><span class="fakehref" id="showmoreoptlink" onclick="showmoreopt(0);"> +More options</span></div>
					  <div id="search_more_options" style="display: none;">
						  <input type="text" placeholder="UPC" id="search_upc" class="form-control">
						  <input type="text" placeholder="Category" id="search_category" class="form-control">
						  <input type="text" placeholder="Description" id="search_description" class="form-control">
						  <input type="text" placeholder="Cover" id="search_cover" class="form-control">
						  <input type="text" placeholder="Notes" id="search_notes" class="form-control">
						  <button type="button" class="btn btn-primary btn-block btn-sm" onclick="search_method2('more');"><i class="fa fa-search"></i> Search</button>
						</div>
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
				<div class="float-right">
        	<button type="button" class="btn btn-light btn-sm" onclick="viewpage('guest')"><i class="fa fa-eye"></i> Normal mode</button>
        	<button type="button" class="btn btn-info btn-sm" onclick="viewpage('admin')"><i class="fa fa-cogs"></i> Edit mode</button>
        	<button class="btn btn-outline-light btn-sm lightbutton" id="settings_btn" onclick="show_settings(1);"><i class="fa fa-cog"></i></button>
        	<div class="tooltipsy">
        		<span class="float-right cursor" onclick="show_settings(0)">&times;</span>
	        	<p class="stronggg">Settings</p>
	        	<label class="switch">
						  <input type="checkbox" name="allowcustomerstoorder" <?php if($site_setting["allow_customers_to_order"]=="yes"){ echo 'checked'; } ?>>
						  <span class="slider"></span>
						</label> Allow customers to order
						<br>
						<!-- <label class="switch">
						  <input type="checkbox" name="maintenancemode" disabled <?php if($site_setting["maintenance_mode"]=="yes"){ echo 'checked'; } ?>>
						  <span class="slider"></span>
						</label> <span title="Toggling this will temporarily disable customers to see all the data in this ordering page.">Maintenance mode</span> -->


						<br>
						<div class="row">
							<div class="col-lg-12 col-xs-12">
								<button class="btn btn-outline-light btn-sm btn-block lightbutton" onclick="showSnackbar(`Pending work...`,`black`);show_settings(0);">Add Bulk items (Import)</button>

							</div>
							<div class="col-lg-12 col-xs-12">
								<button class="btn btn-outline-light btn-sm btn-block lightbutton" data-toggle="modal" data-target="#update_import_modal" onclick="show_settings(0)">Update Bulk items (Import)</button>
							</div>
							<div class="col-lg-12 col-xs-12">
								<form method="get" action="dist/phpspreadsheet/export_database.php">
                  <button type="submit" class="btn btn-outline-light btn-sm btn-block lightbutton">Export database (Export)</button>
                </form>
							</div>
						</div>
	        </div>
        	<br>
        	<br>
        	<button type="button" class="btn btn-success btn-sm" onclick="show_add_modal()"><i class="fa fa-plus"></i> Add item</button>
        	<button type="button" class="btn btn-danger btn-sm" id="delete_btn" disabled onclick="delete_item()"><i class="fa fa-trash"></i> Delete item(s)</button>

        </div> 

        	

        	<br>
        	<br>
        	<br>
        	<br>
			<table class="table table-bordered">
				<thead class="thead-dark" style="position: sticky; top: 0;">
					<tr>
						<th style="width: 20px;"><input type="checkbox" id="selectall_chb" onchange="selectallcheckbox();"></th>
						<th>UPC</th>
						<th>EAN</th>
						<th>Category</th>
						<th>Item Name</th>
						<th>Description</th>
						<th>Cover</th>
						<th>Notes</th>
						<th>Weight</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody id="pickups_table_body" class="arial-10pt">
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

<div class="modal fade" id="serverphotos_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#364261; color: white;">
        <h5 class="modal-title">Server photos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#364261; color: white; overflow-x: auto; height:  60vh;">
        <div class="row">
        	<?php
        	if ($handle = opendir('site_images')) {
        		while (false !== ($entry = readdir($handle))) {
        			if ($entry != "." && $entry != "..") {
        				echo '<div class="col-lg-3" style="padding: 5px;" align="center">';
        				$real_file_name = basename($entry);
        				$file_name = basename($entry);
        				$file_name = preg_replace("/\n\s+/", "\n", trim(strip_tags(htmlspecialchars_decode($file_name))));
								if(strlen($file_name) > 14){
										$file_name = substr($file_name, 0, 14)."...";
								}

        				echo '<label title="'.$real_file_name.'" style="margin-bottom: -5px;">'.$file_name.'</label><img src="site_images/'.$entry.'" class="img_browse" title="'.$real_file_name.'" onclick="click_selected_photo(event)">';
        				echo '</div>';
        			}
        		}
        		closedir($handle);
        	}
        	?>
        </div>
      </div>
      <div class="modal-footer" style="background-color:#364261; color: white;">
      	<input type="hidden" id="selected_photo_txt">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="select_photo_btn" disabled onclick="confirm_selected_photo()" data-dismiss="modal">Select photo</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="addupdate_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addupdate_header"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

					<div class="row">
						<div class="col-lg-6 col-xs-12">
							<div class="form-group">
							    <label for="tdtxt_ean">EAN</label>
							    <input type="text" class="form-control" id="tdtxt_ean" name="tdtxt_ean" value="">
							</div>
						</div>

						<div class="col-lg-6 col-xs-12">
							<div class="form-group">
							    <label for="tdtxt_upc">UPC</label>
							    <input type="text" class="form-control" id="tdtxt_upc" name="tdtxt_upc" value="">
							</div>
						</div>

						<div class="col-lg-12 col-xs-12">
							<div class="form-group">
							    <label for="tdtxt_category">Category</label>
							    <input type="text" class="form-control" id="tdtxt_category" name="tdtxt_category" value="">
							</div>
						</div>

						<div class="col-lg-12 col-xs-12">
							<div class="form-group">
							    <label for="tdtxt_item_name">Item Name</label>
							    <input type="text" class="form-control" id="tdtxt_item_name" name="tdtxt_item_name" value="">
							</div>
						</div>

						<div class="col-lg-12 col-xs-12">
							<div class="form-group">
							    <label for="tdtxt_description">Description</label>
							
							    <textarea id="tdtxt_description" name="tdtxt_description" class="form-control" rows="5"></textarea>
							</div>
						</div>

						<div class="col-lg-6 col-xs-12">
							<div class="form-group">
							    <label for="tdtxt_cover">Cover</label>
							    <input type="text" class="form-control" id="tdtxt_cover" name="tdtxt_cover" value="">
							</div>
						</div>
						<div class="col-lg-3 col-xs-12">
							<div class="form-group">
							    <label for="tdtxt_weight">Weight (Kg)</label>
							    <input type="text" class="form-control" id="tdtxt_weight" name="tdtxt_weight" value="">
							</div>
						</div>
						<div class="col-lg-3 col-xs-12">
							<div class="form-group">
							    <label for="tdtxt_price">Price</label>
							    <input type="text" class="form-control" id="tdtxt_price" name="tdtxt_price" value="">
							</div>
						</div>
						<div class="col-lg-12 col-xs-12">
							<div class="form-group">
							    <label for="tdtxt_notes">Notes</label>
							
							    <textarea id="tdtxt_notes" name="tdtxt_notes" class="form-control" rows="5"></textarea>
							</div>
						</div>
					</div>
				
        
      </div>
			<div class="modal-footer">
        <button type="button" id="addupdate_save_btn" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
  </div>
  </div>
</div>

<?php require 'search_modal.php'; ?>

<?php require 'update_bulk_items_modal_and_script.php'; ?>

<script type="text/javascript">
show_table_pickups();
function show_table_pickups(upc){

	$.ajax({
		url: "controller/action.php",
		type: "POST",
		data: {action: "show_table_pickups"},
		beforeSend: function(){
			$('#pickups_table_body').html(`<tr><td colspan="10" align="center">Loading...</td></tr>`);
		},
		success: function(data){
			$('#pickups_table_body').html(data);
			load_checkbox();
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
var file_changed = false;
function view_item(ean, id){
	$('#viewItemModal').modal("show");
	$.ajax({
		url: "controller/action.php",
		type: "POST",
		beforeSend: function(){
			var editor_panel = `<span id="editor"> &nbsp;<button type="button" class="btn btn-warning btn-sm xbtn-sm" onclick="editing(`+ean+`);">EDIT</button><input type="hidden" id="edit_item_id" value="`+id+`"></span>`;
			var save_edit_panel = `<span id="save_edit" style="display: none;"> &nbsp;<button type="button" class="btn btn-primary btn-sm xbtn-sm" onclick="save_data('edit');">SAVE</button> <button type="button" class="btn btn-light btn-sm xbtn-sm" onclick="cancel_edit();">CANCEL</button></span><span id="updating_panel" class="xbtn-sm" style="display: none;"> &nbsp;Updating...</span><span id="updated_panel" class="xbtn-sm" style="display: none; color: #1FF846;">  &nbsp;Updated ✓</span>`;
			$('#ean_label_title').html('UPC: '+ean+editor_panel+save_edit_panel);
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
			var imgInp = document.getElementById('imgInp');
			imgInp.onchange = evt => {

				var text = evt.target.value;
				text = text.substring(text.lastIndexOf("\\") + 1, text.length);
				$('#filename').val(text);

				//check if it is existing
				if($('#filename').val() != "" || !isEmpty($('#filename').val())){
					$.ajax({
			    	url: "controller/action.php",
			    	type: "POST",
			    	data: {action: "check_existing_file", photo: $('#filename').val()},
			    	beforeSend: function(){
			    		console.log("Checking file: "+$('#filename').val());
			    	},
			    	success: function(data){
			    		console.log(data);
			    		if(data=="existing"){
			    			alert("The photo you are trying to upload is already existing in the server photos.");
			    			$('#filename').val('');
			    			file_changed = false;
			    		}else{
			    			const [file] = imgInp.files;
							  if (file) {
							    let blah = document.getElementById('blah');
							    blah.src = URL.createObjectURL(file);
			    				file_changed = true;
							  }
			    		}

			    	}
			    })
				}	
			    
			  
			}
		}
	})
}

var whereuploaded = "";
// pic uploader
function uploadfile(id, act){
	if(file_changed==true){
		var filename = $('#filename').val();                    
	  var file_data = $('.fileToUpload').prop('files')[0];
	  var form_data = new FormData();
	  form_data.append("file",file_data);
	  form_data.append("filename",filename);
	  form_data.append("act",act);
	  form_data.append("id",id);
	  //Ajax to send file to upload
	  $.ajax({
	      url: "controller/upload.php",                      //Server api to receive the file
	      type: "POST",
	      dataType: 'script',
	      cache: false,
	      contentType: false,
	      processData: false,
	      data: form_data,

	      success: function(dat2){
	      	$('#default_img').attr("src", "site_images/"+filename);
	      }
	  });
	  whereuploaded = "uploader";
	}
}

// choose file from server script
function discolorborders(){
	var imgbox=document.getElementsByClassName('img_browse');  
	for(var i=0; i<imgbox.length; i++){  
		imgbox[i].style.border = "none";
	}  
}
function click_selected_photo(e){
	discolorborders();
	var filename = e.target.title;
	// console.log(filename);
	$('#selected_photo_txt').val(filename);
	e.target.style.border= "5px solid #A555FF";
	$('#select_photo_btn').attr("disabled", false);
}

function confirm_selected_photo(){
	var filename = document.getElementById('selected_photo_txt').value;

	let blah = document.getElementById('blah');
	blah.src = "site_images/"+filename;
	whereuploaded = "server";
}

function update_img_path(id){
	var filename = document.getElementById('selected_photo_txt').value;
	$.ajax({
		url: "controller/action.php",
		type: "POST",
		data: {action: "update_img_path", id: id, filename: filename},
		success: function(data){
	    $('#default_img').attr("src", "site_images/"+filename);
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
		      alert("Barcode1 ["+sb+"] not found.");
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
		      alert("Barcode2 ["+sb+"] not found.");
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

function showSnackbar(mode, color){
	var x = document.getElementById("snackbar");
	if(mode!=""){
      $('#snackbar').html(mode);
      x.style.backgroundColor = color;
      x.className = "show";
      setTimeout(function(){
       x.className = x.className.replace("show", "");
      }, 3000);
      // $('#snackbar').delay(3000).fadeOut("slow").promise().done(function() {
      // 	$('#snackbar').removeClass('show'); 
      // });
  }
}

function show_settings(val){
	if(val==1){
		$('.tooltipsy').show();
		$('#settings_btn').attr("onclick", "show_settings(0)");
	}else{
		$('.tooltipsy').hide();
		$('#settings_btn').attr("onclick", "show_settings(1)");
	}
}

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



// start of Maintenance script

// Add function

function show_add_modal(){
	$('#addupdate_header').html('Add a new item');
	
	$('#addupdate_save_btn').html('Add');
	$('#addupdate_save_btn').attr("onclick", "save_data('add')");

	$('#addupdate_Modal').modal("show");
}

function save_data(type){
	if(type == 'add'){
		//add
		var tdtxt_ean = $('#tdtxt_ean');
		var tdtxt_upc = $('#tdtxt_upc');
		var tdtxt_category = $('#tdtxt_category');
		var tdtxt_item_name = $('#tdtxt_item_name');
		var tdtxt_description = $('#tdtxt_description');
		var tdtxt_cover = $('#tdtxt_cover');
		var tdtxt_price = $('#tdtxt_price');
		var tdtxt_notes = $('#tdtxt_notes');
		var tdtxt_weight = $('#tdtxt_weight');

		if(!isEmpty(tdtxt_ean.val().replace(/^\s+|\s+$/gm,'')) && !isEmpty(tdtxt_upc.val().replace(/^\s+|\s+$/gm,'')) && !isEmpty(tdtxt_category.val().replace(/^\s+|\s+$/gm,'')) && !isEmpty(tdtxt_item_name.val().replace(/^\s+|\s+$/gm,''))){
			tdtxt_ean.css("border", "1px solid lightgray");
			tdtxt_upc.css("border", "1px solid lightgray");
			tdtxt_category.css("border", "1px solid lightgray");
			tdtxt_item_name.css("border", "1px solid lightgray");
			
			$.ajax({
				url: "controller/action.php",
				type: "POST",
				data: {action: "add_item", ean: tdtxt_ean.val().replace(/^\s+|\s+$/gm,''), upc: tdtxt_upc.val().replace(/^\s+|\s+$/gm,''), category: tdtxt_category.val(), item_name: tdtxt_item_name.val(), description: tdtxt_description.val(), cover: tdtxt_cover.val(), price: tdtxt_price.val(), notes: tdtxt_notes.val(), weight: tdtxt_weight.val()},
				beforeSend: function(){
					$('#addupdate_save_btn').attr("disabled", true);
					$('#addupdate_save_btn').html("Adding...");
				},
				success: function(data){
					$('#addupdate_save_btn').attr("disabled", false);
					$('#addupdate_save_btn').html("Add");
					if(data=='good'){
						alert("New item added successfully.");
						tdtxt_ean.val('');
						tdtxt_upc.val('');
						tdtxt_category.val('');
						tdtxt_item_name.val('');
						tdtxt_description.val('');
						tdtxt_cover.val('');
						tdtxt_price.val('');
						tdtxt_notes.val('');
						tdtxt_weight.val('');
						show_table_pickups();
						$('#addupdate_Modal').modal("hide");


					}else if(data=='duplicate'){
						alert("This item is already existing.");
					}else{
						console.log(data);
					}
				}
			})

		}

		if(isEmpty(tdtxt_ean.val())){
			tdtxt_ean.css("border", "1px solid red");
		}else{
			tdtxt_ean.css("border", "1px solid lightgray");
		}
		if(isEmpty(tdtxt_upc.val())){
			tdtxt_upc.css("border", "1px solid red");
		}else{
			tdtxt_upc.css("border", "1px solid lightgray");
		}
		if(isEmpty(tdtxt_category.val())){
			tdtxt_category.css("border", "1px solid red");
		}else{
			tdtxt_category.css("border", "1px solid lightgray");
		}
		if(isEmpty(tdtxt_item_name.val())){
			tdtxt_item_name.css("border", "1px solid red");
		}else{
			tdtxt_item_name.css("border", "1px solid lightgray");
		}
		
	}else{
		//update
			var eii = $('#edit_item_id').val();
			var tdtxt_ean = $('#tdtxt_ean_v');
			var tdtxt_upc = $('#tdtxt_upc_v');
			var tdtxt_category = $('#tdtxt_category_v');
			var tdtxt_item_name = $('#tdtxt_item_name_v');
			var tdtxt_description = $('#tdtxt_description_v');
			var tdtxt_cover = $('#tdtxt_cover_v');
			var tdtxt_price = $('#tdtxt_price_v');
			var tdtxt_notes = $('#tdtxt_notes_v');
			var tdtxt_weight = $('#tdtxt_weight_v');

			if(!isEmpty(tdtxt_ean.val().replace(/^\s+|\s+$/gm,'')) && !isEmpty(tdtxt_upc.val().replace(/^\s+|\s+$/gm,'')) && !isEmpty(tdtxt_category.val().replace(/^\s+|\s+$/gm,'')) && !isEmpty(tdtxt_item_name.val().replace(/^\s+|\s+$/gm,''))){
				tdtxt_ean.css("border", "1px solid lightgray");
				tdtxt_upc.css("border", "1px solid lightgray");
				tdtxt_category.css("border", "1px solid lightgray");
				tdtxt_item_name.css("border", "1px solid lightgray");
				if(whereuploaded == "uploader"){
					uploadfile(eii, 0);
				}
				if(whereuploaded == "server"){
					update_img_path(eii);
				}
					$.ajax({
						url: "controller/action.php",
						type: "POST",
						data: {action: "update_item", id: eii, ean: tdtxt_ean.val().replace(/^\s+|\s+$/gm,''), upc: tdtxt_upc.val().replace(/^\s+|\s+$/gm,''), category: tdtxt_category.val(), item_name: tdtxt_item_name.val(), description: tdtxt_description.val(), cover: tdtxt_cover.val(), price: tdtxt_price.val(), notes: tdtxt_notes.val(), weight: tdtxt_weight.val()},
						beforeSend: function(){
					
							$('#save_edit').hide();
							$('#updating_panel').show();
							
						
						},
						success: function(data){

							$('#updating_panel').hide();
							$('#updated_panel').show();
							
							if(data=='good'){
								$('#fieldset_form').attr("disabled", "disabled");
								show_table_pickups(tdtxt_upc.val());
								setTimeout(function(){
									$('#updated_panel').hide();
									$('#editor').show();
								}, 2400);
								$('#default_pic_panel').show();
								$('#update_pic_panel').hide();
								discolorborders();
								$('#selected_photo_txt').val('');
								$('#select_photo_btn').attr("disabled", true);
							}
							if(data=='duplicate'){
								$('#updated_panel').hide();
								$('#save_edit').show();
								alert("This item is already existing.");
								$('#default_pic_panel').hide();
								$('#update_pic_panel').show();
							}
						}
					})
				

				

			}

			if(isEmpty(tdtxt_ean.val())){
				tdtxt_ean.css("border", "1px solid red");
			}else{
				tdtxt_ean.css("border", "1px solid lightgray");
			}
			if(isEmpty(tdtxt_upc.val())){
				tdtxt_upc.css("border", "1px solid red");
			}else{
				tdtxt_upc.css("border", "1px solid lightgray");
			}
			if(isEmpty(tdtxt_category.val())){
				tdtxt_category.css("border", "1px solid red");
			}else{
				tdtxt_category.css("border", "1px solid lightgray");
			}
			if(isEmpty(tdtxt_item_name.val())){
				tdtxt_item_name.css("border", "1px solid red");
			}else{
				tdtxt_item_name.css("border", "1px solid lightgray");
			}

		}
}


//edit script

function editing(ean){
	document.getElementById('fieldset_form').removeAttribute("disabled");
	$('#editor').hide();
	$('#save_edit').show();
	//picture panel
	$('#default_pic_panel').hide();
	$('#update_pic_panel').show();
}

function cancel_edit(){
	$('#fieldset_form').attr("disabled", "disabled");
	$('#editor').show();
	$('#save_edit').hide();
	//picture panel
	$('#default_pic_panel').show();
	$('#update_pic_panel').hide();
}


function load_checkbox(){
    var $chkboxes = $('.chkbox');
    var lastChecked = null;

    $chkboxes.click(function(e) {
        if (!lastChecked) {
            lastChecked = this;
            return;
        }

        if (e.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);

            $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);
        }

        lastChecked = this;
    });

    document.querySelectorAll('input[class="chkbox"]').forEach((elem) => {
			elem.addEventListener("change", function(event) {
				var check_id = [];
			  $('input:checkbox[name=mycheckboxes]:checked').each(function(){
			    check_id.push($(this).val());
			  });
			  if(check_id.length >= 1){
			  	$('#delete_btn').attr("disabled", false);
			  }
			  if(check_id.length == 0){
			  	$('#delete_btn').attr("disabled", true);
			  }
			});
		});
}


function selectAll(){  
                var ele=document.getElementsByClassName('chkbox');  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].type=='checkbox')  
                        ele[i].checked=true;  
                }  
            }  

function deSelectAll(){  
                var ele=document.getElementsByClassName('chkbox');  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].type=='checkbox')  
                        ele[i].checked=false;  
                      
                }  
            }     
function selectallcheckbox(){
	var checkBox = document.getElementById("selectall_chb");

	if (checkBox.checked == true){
		selectAll();
		$('#delete_btn').attr("disabled", false);
	} else {
		deSelectAll();
		$('#delete_btn').attr("disabled", true);
	}
}


function delete_item(){
	var item_id = [];
  $('input:checkbox[name=mycheckboxes]:checked').each(function(){
    item_id.push($(this).val());
  });
  var grammar = '';
  if(item_id.length > 1){
  	grammar = "these items?";
  }else{
  	grammar = "this item?";
  }
  var x = confirm("Are you sure you want to delete "+grammar);
  if(x){
  //item_id.toString()
  $.ajax({
  	url: "controller/action.php",
  	type: "POST",
  	data: {action: "delete_item", ids: item_id.toString()},
  	success: function(data){
  		if(data=='good'){
  			showSnackbar(`Item [ID: `+item_id+`] deleted successfully.`, `#FA6868`);
  			show_table_pickups();
  		}else{
  			showSnackbar(`Error.`, `#FA6868`);
  		}
  	}
  })
  	
  }
}


//search item function
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


// end of Maintenance script

function change_settings(toggle, option){

	$.ajax({
		url: "controller/action.php",
		type: "POST",
		data: {action: "slider_toggle", toggle: toggle, val: option},
		beforeSend: function(){
			if(toggle=="toggle_allowcustomerstoorder"){
				$('input[name="allowcustomerstoorder"]').attr("disabled", true);
			}
			if(toggle=="toggle_maintenancemode"){
				$('input[name="maintenancemode"]').attr("disabled", true);
			}
		},
		success: function(data){
			if(toggle=="toggle_allowcustomerstoorder"){
				$('input[name="allowcustomerstoorder"]').attr("disabled", false);
			}
			if(toggle=="toggle_maintenancemode"){
				$('input[name="maintenancemode"]').attr("disabled", false);
			}
		}
	})

}

var allowcustomerstoorder = document.querySelector("input[name='allowcustomerstoorder']");
allowcustomerstoorder.addEventListener('change', function() {
  if(this.checked){
    change_settings("toggle_allowcustomerstoorder", "yes");
  }else{
    change_settings("toggle_allowcustomerstoorder", "no");
  }
});

// var maintenancemode = document.querySelector("input[name='maintenancemode']");
// maintenancemode.addEventListener('change', function() {
//   if(this.checked){
//     change_settings("toggle_maintenancemode", "yes");
//   }else{
//     change_settings("toggle_maintenancemode", "no");
//   }
// });





</script>
<!-- Scroll to top only -->
<script type="text/javascript" src="dist/js/scrolltotop.js"></script>
<?php }else{ echo '<div align="center"><h3>Access denied!</h3></div>'; } ?>