<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- DataTables -->
<!-- <script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/vfs_fonts.js"></script>
<script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/jszip.js"></script>
<script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/buttons.print.min.js"></script>
<script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/jquery.dataTables.yadcf.js"></script>
<script type="text/javascript" src="dist/DataTables/DataTables-1.10.18/js/dataTables.fixedColumns.min.js"></script> -->

<!-- JsBarcode https://lindell.me/JsBarcode/ -->
<script src="dist/JsBarcode/JsBarcode.all.min.js"></script>


<script type="text/javascript">
function keepSessionAlive() {
  // 1200000 = 20mins
  setInterval(function() {
    $.ajax({
      url: "controller/action.php",
      type: "POST",
      data: {action: "checkSess"},
      success: function(data){
        console.log(data);
      }
    })
  }, 1200000)
}
keepSessionAlive();

function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>