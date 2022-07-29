        <div id = 'prodtablecontainer'>
            <table class="table table-bordered">
				<thead class="thead-dark" style="position: sticky; top: 0;">
					<tr>
                        <?php 
                        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        if(strpos($actual_link, "index_maintenance") == false) {
                            if($_SESSION['superuser']=='admin'){ ?>
                                <th style="width: 70px;" id="print_column">Qty</th>
                            <?php 
                            }else{ 

                                    if($site_setting['allow_customers_to_order']=="yes"){
                                    ?>
                                    <th style="width: 70px;" id="print_column">Qty</th>
                            <?php 
                                    }
                            } 
                        }else {
                            echo '<th style="width: 20px;"><input type="checkbox" id="selectall_chb" onchange="selectallcheckbox();"></th>';
                        }?>
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

