		<div class="card sticky-top searchDiv float-left sticky-top" style = 'width: 45%;' id="searchDiv">
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
					<div class="form-group" id="moreoptions_div" style="background-color:#282828; padding-right: 10px; padding-left: 10px; height: auto; display: block;">
						&nbsp;
						<label id="search_label"><strong>Search by keywords</strong></label>
						

						<div class="input-group">
							
							<input type="text" id="search_item" class="form-control" placeholder="Item Name">
							<div class="input-group-prepend">
							<button type="button" class="btn btn-primary" id="littlesearchbtn" onclick="search_method2('single');"><i class="fa fa-search"></i></button>
							</div>
						</div>
						<!-- <input id = 'moreoptionschk' type="checkbox"> -->
						<div align="right"><span class="fakehref" id="showmoreoptlink" > +More options</span></div>
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



<script>

window.onload = (() => { 
	var url = window.location.href;
    var searchmoreopt = document.querySelector("#showmoreoptlink"); 
	var searchmorediv = document.querySelector("#moreoptions_div");
	var searchmoreinputs = document.querySelector("#search_more_options");

	// var settingsbtn = document.querySelector("#settings_btn");
	// var tooltipsydiv = document.querySelector(".tooltipsy");
	if(url.includes('index_maintenance')){
		var settingsbtn = document.querySelector("#settings_btn");
		var tooltipsydiv = document.querySelector(".tooltipsy");

		settingsbtn.onclick = ((event) => {
			if(document.querySelector('.tooltipsy').style.display == 'none') {
				show_settings(0);
			}else {
				show_settings(1);
			}
		});
	}
	document.addEventListener('click', function(event) {
		//more search option drop down
		var clickinopt = searchmoreopt.contains(event.target);
		var clickindiv = searchmorediv.contains(event.target);
		var clickininputs = searchmoreinputs.contains(event.target);

		if (!clickinopt && !clickindiv && !clickininputs) {
			showmoreopt(1);
		}
		if(url.includes('index_maintenance')){
			//settings tooltip window
			var clicinsettingsbtn = settingsbtn.contains(event.target);
			var clickinitooltipsy = tooltipsydiv.contains(event.target);
		
		// if (!clickinopt && !clickindiv && !clickininputs) {
		// 	showmoreopt(1);
		// }
			if ( !clickinitooltipsy && !clicinsettingsbtn) {
				show_settings(1);
			}
		}
	});

	searchmoreopt.onclick = ((event) => {
		if(document.querySelector('#search_more_options').style.display == 'none') {
			showmoreopt(0);
		}else {
			showmoreopt(1);
		}
	});

	// settingsbtn.onclick = ((event) => {
	// 	if(document.querySelector('.tooltipsy').style.display == 'none') {
	// 		show_settings(0);
	// 	}else {
	// 		show_settings(1);
	// 	}
	// });
});

function showmoreopt(type){
	if(type==0){
		$('#search_more_options').show();
		$('#showmoreoptlink').attr("onclick", "showmoreopt(1);");
		$('#showmoreoptlink').html('-Less options');
		$('#littlesearchbtn').hide();
		$("#moreoptions_div").css("padding-bottom", "10px");
	}else{
		$('#search_more_options').hide();
		$('#showmoreoptlink').attr("onclick", "showmoreopt(0);");
		$('#showmoreoptlink').html('+More options');
		$('#littlesearchbtn').show();
		$("#moreoptions_div").css("padding-bottom", "0px");
	}
}

function show_settings(val){
	if(val==0){
		$('.tooltipsy').show();
		//$('#settings_btn').attr("onclick", "show_settings(1)");
	}else{
		$('.tooltipsy').hide();
		//$('#settings_btn').attr("onclick", "show_settings(0)");
	}
}

</script>