<?php
require 'configuration.php';
require 'link.php';
require 'script.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<table id="example2" class="display">
	<thead>
		<tr>
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
</table>
<svg id="barcode"></svg>

<hr>
<svg class="barcode"
  jsbarcode-format="upc"
  jsbarcode-value="639114919665"
  jsbarcode-textmargin="0"
  jsbarcode-fontoptions="bold">
</svg>

</body>
</html>

<script type="text/javascript">
JsBarcode(".barcode").init();
JsBarcode("#barcode", "639114917715", {
  format: "upc",
  lineColor: "black",
  // flat: true,
  width: 1,
  height: 40,
  displayValue: true
});


	// refreshtable();
	function refreshtable(){


      table = $('#example2').DataTable( {
        
        dom: 'Bfrtip',
        responsive: true,
        
        buttons: [

            'copy', 'csv', 'excel', 'pdf', 'colvis',
            {
                extend: 'pageLength',
                titleAttr: 'Display how many rows in the table.'
            }
            // ,{
            //     extend: 'print',
            //     text: '<i class="fa fa-print"></i> Print',
            //     titleAttr: 'Print',
            //     customize: function ( win ) {
            //        $(win.document.body)
            //             .css( 'font-size', '12pt' );
            //         $(win.document.body).find( 'table' )
            //             .addClass( 'compact' )
            //             .css( 'font-size', 'inherit' );
            //     },
                
            //     exportOptions: {
            //         columns: ':visible'
            //     }
            // }

        ],
        //  aLengthMenu: [
        // [25, 50, 100, 200, qtq],
        // [25, 50, 100, 200, "All"]
        // ],
        colReorder: true,
        responsive: false,
        paging: false,
        ordering: true,
        info: false,

        "processing": true,
        "serverSide": true,
        "ajax":{
                    url:"controller/fetchdata.php",
                    type:"post"
                },
        "deferRender": true
    } );
      // yadcf.init(table, [{
      //             column_number: 0,
      //             filter_type: "multi_select"
      //         }]);

}


function find_max(nums) {
 let max_num = Number.NEGATIVE_INFINITY; // smaller than all other numbers
 for (let num of nums) {
if (num > max_num) {
 // (Fill in the missing line here)
  num = max_num;
}
 }
 return max_num;
 }
console.log(find_max(5));
</script>