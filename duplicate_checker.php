  <div class="modal fade" id="duplicate_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-bottom-dialog" role="document">
    <div class="modal-content modal-bottom-content">
      
      <div class="modal-body modal-bottom-body" align="center">
       <h5 class="modal-title" id="dup_header"></h5>
        <span class="float-right cursor" data-dismiss="modal">&times;</span>
      	<div id="search_duplicate">
         
        </div>
      </div>

      </div>
   	</div>
  </div>




  <script>
  
  document.querySelector('#chkduplicatebtn').onclick = (() => {
      //document.querySelector('#duplicate_modal').style.display = 'block';
      $("#duplicate_modal").modal("show");
      $.ajax({
					url: "controller/action.php",
					type: "POST",
					data: {action: "search_duplicate"},
					beforeSend: function(){
						$('#search_duplicate').html('Searching...');
					},
					success: function(data){
						$('#search_duplicate').html(data);
					}
			});

	
  });
  
  </script>