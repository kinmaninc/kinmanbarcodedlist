<!DOCTYPE html>
<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<style>
body{
  background-color: lightgrey;
  width: 100%;
  float: left;
}
#container{
  width: 30%;
  float: left;
  margin: 100px 30%;
  padding: 100px 30px;
  text-align: center;
  float: left;
  border-radius: 4px;
  background-color: white;
}
input,button{
  margin: 10px 0;
  width: 90%;
}



</style>

<body>

  <div id="container">

    <input type="file" accept="image/*" class="fileToUpload form-control" id="imgInp"></input><br>
    <input type="text" placeholder="File name" id="filename" class="form-control"/><br>
    <img id="blah" src="dist/img/uploadimage.jpg" alt="your image" style="width: auto; max-width:400px;" /><br>
    <button class="btn btn-success" onclick="uploadfile(0)">Upload</button>
  <div id="results"></div>

  </div>

</body>
</html>


<script>

function uploadfile(act){

  var filename = $('#filename').val();                    
  var file_data = $('.fileToUpload').prop('files')[0];
  var form_data = new FormData();
  form_data.append("file",file_data);
  form_data.append("filename",filename);
  form_data.append("act",act);
  //Ajax to send file to upload
  $.ajax({
      url: "controller/upload.php",                      //Server api to receive the file
      type: "POST",
      dataType: 'script',
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,

      success:function(dat2){
        $('#results').html(dat2);
            // if(dat2==1) alert("Successful");
            // else alert("Unable to Upload");
          }
      });

}

//file previewer
var imgInp = document.getElementById('imgInp');
imgInp.onchange = evt => {
  const [file] = imgInp.files;
  if (file) {
    let blah = document.getElementById('blah');
    blah.src = URL.createObjectURL(file);
    var text = evt.target.value;
    text = text.substring(text.lastIndexOf("\\") + 1, text.length);
    $('#filename').val(text);

  }
}

</script>