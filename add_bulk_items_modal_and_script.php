<div class="modal fade" id="add_import_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Bulk Items</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Note: Do NOT upload anything here but the CSV file only you want to import. Also, check the file if there are no duplicated items to the existing database especially for the barcodes. Click <span class="fakehref" onclick="$('#import_guides_add').show();">here</span> for guides.</p>
        <form name="upload_csv_add" id="upload_csv_add" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-6 col-xs-12">
              <input type="file" class="form-control" accept=".csv" name="csv_file_add" id="csv_file_add">
            </div>
            <div class="col-lg-6 col-xs-12">
              <button type="submit" class="btn btn-outline-primary" name="upload_add" id="upload_add" value="Upload">UPLOAD</button>
              <a href="dist/add_bulk_items_format.csv" class="btn btn-outline-light lightbutton" download><i class="fa fa-download"></i> FORMAT</a>
            </div>
          </div>
        </form>
          <br>
          <div id="importedItemsPanel_add">
          </div>

          
          <div id="import_guides_add" style="display: none;">
          <hr>
          <span class="float-right cursor" onclick="$('#import_guides_add').hide();">×</span>
          <h5>Guides for adding bulk items using a CSV file</h5>
          <p>Step 1:<br>
            <span class="tabbb">Download the CSV file. This will be your <b>base format</b>.<br><img style="max-width:100%; border: 1px solid black;" src="dist/importpics/add_step1.jpg"></span></p>

          <p>Step 2:<br>
            <span class="tabbb">Open the downloaded file then add the contents.</span></p>

          <p>Step 3:<br>
            <span class="tabbb">Save the file. <br><i>Note: If there's a confirmation pop-up appears, just click "Yes"</i></span></p>
          <p>Step 4:<br>
            <span class="tabbb">Go back to the page and click "Choose file" and browse your saved file. Lastly, click the "UPLOAD" button to start the process.</span></p>
          
          </div>

        
    </div>
      </div>
  </div>
</div>

<script type="text/javascript">

  $('#upload_csv_add').on('submit', function(e){
    e.preventDefault();
    $('#upload_add').attr('Disabled', true);
    $.ajax({
      url: "controller/add_import_items.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(data){
        $('#upload').attr('Disabled', true);
        // console.log(data);
        if(data == "Error1"){
          alert("Invalid CSV file!");
          $('#upload_add').attr('Disabled', false); 
        }
        else if(data == "Error2"){
          alert("Please select a file.");
          $('#upload_add').attr('Disabled', false); 
        }
        else{
          $('#importedItemsPanel_add').html(data);
          $('#upload_add').attr('Disabled', true);
          showSnackbar(`Items are added successfully.`, `#16BF2D`);
          show_table_pickups();
         
          $('#upload_add').attr('Disabled', false); 
        }
      }
    });
  });

</script>