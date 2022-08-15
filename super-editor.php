<div class="float-right" id="super_editor" style="margin-bottom: 10px; position: relative;">

	<?php if($_SESSION['superuser']=='admin'){ ?>		
		  	<form method="get" action="dist/phpspreadsheet/export_database.php" style = 'display: inline-block'>
		    	<button type="submit" class="btn btn-light btn-sm" id = 'export2ndbtn' ><i class="fa fa-file-export"></i> Export on Excel Spreadsheet</button>
        	</form>	
			<a type="button" class="btn btn-warning btn-sm" href="order_list.php"><i class="fa fa-list"></i> Order History</a>
        	<button type="button" class="btn btn-info btn-sm" onclick="viewpage('guest')"><i class="fa fa-eye"></i> Normal mode</button>
        	<button type="button" class="btn btn-light btn-sm" onclick="viewpage('admin')"><i class="fa fa-cogs"></i> Edit mode</button>
        
        	<br>
        	<br>
        	<button type="button" id="show_order_btn" class="btn btn-danger btn-sm" onclick="print_order();" disabled><i class="fa fa-shopping-cart"></i> Show Order</button>
        	<button type="button" class="btn btn-outline-primary btn-sm" onclick="show_table_pickups(null, 'default');"><i class="fa fa-retweet"></i> Clear Selections</button>
            <button id = 'hide-fw' type="button" class="btn btn-outline-secondary btn-sm"><i style="margin-right: 5px;" class="fa fa-eye-slash" aria-hidden="true"></i>Hide Floating Order Summary</button>
            <button style = 'display: none;' id = 'show-fw' type="button" class="btn btn-outline-secondary btn-sm"><i style="margin-right: 5px;" class="fa fa-eye" aria-hidden="true"></i>Show Floating Order Summary</button>
        	
    <?php }else{ //if guest mode
    			
    			if($site_setting["allow_customers_to_order"]=="yes"){
    			?>
				<form method="get" action="dist/phpspreadsheet/export_database.php" style = 'display: inline-block'>
		    	  <button type="submit" class="btn btn-light btn-sm" id = 'export2ndbtn' ><i class="fa fa-file-export"></i> Export on Excel Spreadsheet</button>
        	    </form>		
	    		<button type="button" id="show_order_btn" class="btn btn-danger btn-sm" onclick="print_order();" disabled><i class="fa fa-shopping-cart"></i> Show Order</button>
	        	<button type="button" class="btn btn-outline-primary btn-sm" onclick="show_table_pickups(null, 'default');"><i class="fa fa-retweet"></i> Clear Selections</button>
                <button id = 'hide-fw' type="button" class="btn btn-outline-secondary btn-sm"><i style="margin-right: 5px;" class="fa fa-eye-slash" aria-hidden="true"></i>Hide Floating Order Summary</button>
                <button style = 'display: none;' id = 'show-fw' type="button" class="btn btn-outline-secondary btn-sm"><i style="margin-right: 5px;" class="fa fa-eye" aria-hidden="true"></i>Show Floating Order Summary</button>	        
           
	    <?php
	     }
	  } ?>
         <?php require 'floating_totalweight_and_displaybox.php'; ?>
</div>