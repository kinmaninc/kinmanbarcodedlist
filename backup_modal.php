<div class="modal fade" id="buckup_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style = 'height: 90%' >
    <div class="modal-content"  style ='background: none; height: 70%;'>
      <div class="modal-header" style="background-color:#343a40; color: white;">
        <h5 class="modal-title">Backup Files</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#343a40; color: white; overflow-x: auto; height:  100%;">
        <div class="row" style = 'height: 100%; width: 100%; margin: 0px;'>
            <div class = 'row' id = 'foldercontainer'>
                <div class="col-lg-3">
                    <a href="#" onclick = "openDir('sys_files')">
                        <img src="site_images/folder.png" alt="">
                        <b>System Files</b>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="#" onclick = "openDir('d_base')">
                        <img src="site_images/folder.png" alt="">
                        <b>Database</b>
                    </a>
                </div>
            </div>
            <div id ='fodlerfiles'>
                    <div id = 'sys_directory'  style ='display: none;'>
                        <div class = 'row dir_title'>
                                <span class = "col-3">System Files</span>
                        </div>
                      <?php 
                            if ($handle = opendir('Back-up/System files')) {
                                while (false !== ($entry = readdir($handle))) {
                                    if ($entry != "." && $entry != "..") {
                                        echo '<div class="col-lg-12 dir_filecontainer" style="" align="left">';
                                        $real_file_name = basename($entry);
                                        $file_name = basename($entry);
                                        $file_name = preg_replace("/\n\s+/", "\n", trim(strip_tags(htmlspecialchars_decode($file_name))));
                                                if(strlen($file_name) > 14){
                                                        $file_name = substr($file_name, 0, 14)."...";
                                                }

                                        echo '<label title="'.$real_file_name.'" style="margin-bottom: -5px;">'.$file_name.'</label> <br>';
                                        echo '</div>';
                                    }
                                }
                                closedir($handle);
                            }
                      ?>
                    </div>
                    <div id = 'db_directory' style ='display: none;'>
                        <div class = 'row dir_title'>
                                <span class = "col-3">Database</span>
                        </div>
                        <div class = 'dir_filecontainer'>
                      <?php 
                            if ($handle = opendir('Back-up/Database')) {
                                while (false !== ($entry = readdir($handle))) {
                                    if ($entry != "." && $entry != "..") {
                                        echo '<div id = "file_subcontianer" class="col-lg-12" style="" align="left">';
                                                $real_file_name = basename($entry);
                                                $file_name = basename($entry);
                                                $file_name = preg_replace("/\n\s+/", "\n", trim(strip_tags(htmlspecialchars_decode($file_name))));
                                                if(strlen($file_name) > 14){
                                                        $file_name = substr($file_name, 0, 14)."...";
                                                }

                                        echo '
                                              <div class = "file_lbl"><label title="'.$real_file_name.'" style="margin-bottom: -5px;">'.$file_name.'</label> </div>
                                              <div class = "file_dl"><a id="dl_link" href="Back-up/Database/'.$real_file_name.'" download><img src="site_images/download.png" alt=""></a></div>
                                              <div class = "file_dlt filenames" data-src="'.$real_file_name.'"  onclick = "file_del(event);"><a id="dlt_link" class ="" href="#"  ><img src="site_images/delete.png" alt=""></a></div>
                                             
                                            <br>';
                                        echo '</div>';
                                    }
                                }
                                closedir($handle);
                            }
                      ?>
                    </div>  
                    </div>                  
            </div>

        </div>
      </div>
      <div class="modal-footer" style="background-color:#343a40; color: white;">
      	<input type="hidden" id="selected_photo_txt">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="select_photo_btn" disabled onclick="confirm_selected_photo()" data-dismiss="modal">Select File</button> -->
      </div>
    </div>
  </div>
</div>

            <!-- Delete confimation window -->

    <div class="modal fade" id="delete_confirm_modal" tabindex="2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style = 'height: 90%' >
            <div class="modal-content"  style ='background: none; height: 30%; width: 50%; margin: auto;'>
            <div class="modal-header" style="background-color:#751212; color: white;">
                <img id ='warning_sign' src="site_images/warning_sign.png" alt="">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color:#751212; color: white; overflow-x: auto; height:  100%;">
                    <span><b>Are you sure you want to delete this file ? </b></span>
            </div>
            <div class="modal-footer" style="background-color:#751212; color: white;">
                <input type="hidden" id="selected_photo_txt">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="del_confirm"  onclick="del_file()" data-dismiss="modal">Yes</button>
            </div>
            </div>
        </div>
    </div>


            <!-- End of confinmation window  -->

<script>
  document.querySelector('#folderbtn').onclick = (() => {
      $("#buckup_modal").modal("show");
  });

function openDir(dir){
    document.querySelector('#sys_directory').style.display = "none";
    document.querySelector('#db_directory').style.display = "none"; 

    if(dir == "sys_files"){
        document.querySelector('#sys_directory').style.display = "block";
    }
    if(dir == "d_base"){
        document.querySelector('#db_directory').style.display = "block";
    }
}

function del_file(){
    var filename = $("#dlt_link").attr("data-file");
    console.log(filename);
    


}

function file_del(e){
    console.log(e.target.parentElement.parentElement.dataset.src);
    var ex = confirm('sample');

    if(ex){
        $.ajax({
            url: "controller/action.php",
            type: "POST",
            data: {action: "delete_bkfile"},
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
}
</script>


