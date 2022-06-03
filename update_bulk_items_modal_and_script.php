<div class="modal fade" id="update_import_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Bulk Items</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Note: Do NOT upload anything here but the CSV file only you want to import. Also, check the file if there are no duplicated items to the existing database especially for the barcodes. Click <span class="fakehref" onclick="$('#import_guides_update').show();">here</span> for guides.</p>
        <form name="upload_csv" id="upload_csv" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-6 col-xs-12">
              <input type="file" class="form-control" accept=".csv" name="csv_file" id="csv_file">
            </div>
            <div class="col-lg-2 col-xs-6">
              <button type="submit" class="btn btn-outline-primary" name="upload" id="upload" value="Upload">UPLOAD</button>
            </div>
          </div>
        </form>
          <br>
          <div id="importedItemsPanel">
          </div>

          
          <div id="import_guides_update" style="display: none;">
          <hr>
          <span class="float-right cursor" onclick="$('#import_guides_update').hide();">×</span>
          <h5>Guides for updating bulk items using a CSV file</h5>
          <p>Step 1:<br>
            <span class="tabbb">Export database<br><img style="max-width:100%;" src="dist/importpics/step1.jpg"></span></p>
          <p>Step 2:<br>
            <span class="tabbb">Open the download excel file and make the changes you want. <strong>Do not edit or remove the column "ID" as it is the reference for updating the items.</strong></span></p>
          <p>Step 3:<br>
          <span class="tabbb">Now after editing the contents, you must save it as an <strong>CSV (Comma delimited) file</strong> [File>Save As] then click "Save".<br><img style="max-width:100%;" src="dist/importpics/step3.jpg"></span><br><i> &nbsp;&nbsp;Note: If there's a confirm pop-up, just click "Yes".</i></p>
          <p>Step 4:<br>
            <span class="tabbb">Go back to the page and click "Choose File" then select the saved <strong>CSV</strong> file. Lastly, click the "UPLOAD" button.<br><img style="max-width:100%;" src="dist/importpics/step4.jpg"></span></p>
          </div>

        
    </div>
      </div>
  </div>
</div>

<script type="text/javascript">

  $('#upload_csv').on('submit', function(e){
    e.preventDefault();
    $('#upload').attr('Disabled', true);
    $.ajax({
      url: "controller/update_import_items.php",
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
          $('#upload').attr('Disabled', false); 
        }
        else if(data == "Error2"){
          alert("Please select a file.");
          $('#upload').attr('Disabled', false); 
        }
        else{
          $('#importedItemsPanel').html(data);
          $('#upload').attr('Disabled', true);
          showSnackbar(`Items are updated successfully.`, `#16BF2D`);
          show_table_pickups();
         
          $('#upload').attr('Disabled', false); 
        }
      }
    });
  });

</script>