<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<!-- https://fontawesome.com/v4/icons/ -->



<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="dist/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="dist/DataTables/DataTables-1.10.18/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="dist/DataTables/DataTables-1.10.18/css/colReorder.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="dist/DataTables/DataTables-1.10.18/css/responsive.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="dist/DataTables/DataTables-1.10.18/css/jquery.dataTables.yadcf.css">
<link rel="stylesheet" type="text/css" href="dist/DataTables/DataTables-1.10.18/css/fixedColumns.bootstrap.min.css">



<style type="text/css">
.va_ta{
 vertical-align: middle;
 text-align: center;
}

.img_browse{
  height: 150px; 
  width: 150px; 
  object-fit: cover; 
  border-radius: 5px; 
  cursor: pointer;
}

.laytblu{
  color: #3EADE1;
}

.cursor{
  cursor: pointer;
}

.fakehref {
  color: #03B4F6; 
  cursor: pointer; 
  text-decoration: underline;
}

.title-separator{
  background-color: #632B23;
  color: white;
  padding: 7px;
}

tr td{
  padding: 5px !important; 
}

.stronggg{
  font-weight: bold;
}

.ptoleft{
  text-align: left;
}
.ptoright{
  text-align: right;
}

.modal-fullscreen-dialog{
  width: 100%;
  max-width: none;
  height: 100%;
  margin: 0;
}
.modal-fullscreen-content{
  height: 100%;
  border: 0;
  border-radius: 0;
}
.modal-fullscreen-body{
  overflow-y: auto;
}

.modal-bottom-dialog{
  width: 100%;
  max-width: none;
  /*height: 60vh;*/
  margin: 0;
  top: 55vh;
}
.modal-bottom-content{
  border: 0;
  border-radius: 0;
}
.modal-bottom-body{
  overflow-y: auto;
}

.arial-10pt{
  font-family: Arial, Helvetica, sans-serif; font-size: 13.3px;
}

#pagetitle {
    color: white;
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 15px;
    padding-right: 15px;
    background:rgb(99 43 35);
    width: 100%;
}
#searchmaincontainer{
    margin-top: 10px;
    width: 100%;
    display: inline-block;
}


#search_more_options > input {
  /* margin-bottom: 5px; */
}

.searchDiv {
  z-index: 2;
  float: left;
  left: 20px;
  right: 20px; 
  width: 600px; 
  height: 108px; 
  padding: 10px;
  padding-bottom: 0px;
  background-color: #282828;
  color: white;
  margin-top: 10px;
  margin-bottom: 10px;
}

.sDiv_hide{
  cursor: pointer;
  color: #FF9B00;
}
.highlighted {
  background-color: yellow;
}

.xbtn-sm {
  font-size: 10px; 
  font-weight: bolder;
}

.blink_this {
  background: yellow;
  animation: blinker 1.5s linear infinite;
}
@keyframes blinker {
  50% {
    opacity: 0;
  }
}

.zindexinput{
  z-index: -2;
}

/* The snackbar - position it at the bottom and in the middle of the screen */
#snackbar {
  visibility: hidden; /* Hidden by default. Visible on click */
  min-width: 200px; /* Set a default minimum width */
  margin-left: -125px; /* Divide value of min-width by 2 */
  background-color: #F7AF59; /* Black background color */
  color: #fff; /* White text color */
  text-align: center; /* Centered text */
  border-radius: 5px; /* Rounded borders */
  padding: 16px; /* Padding */
  position: fixed; /* Sit on top of the screen */
  z-index: 5; /* Add a z-index if needed */
  right: 1%; /* Center the snackbar */
  top: 30px; /* 30px from the bottom */
  height: 50px;
  
}
.btn-white {
  margin: 1px;
}

/* Show the snackbar when clicking on a button (class added with JavaScript) */
#snackbar.show {
  visibility: visible; /* Show the snackbar */
          /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
          However, delay the fade out process for 2.5 seconds */
          -webkit-animation: fadein 0.5s;
          animation: fadein 0.5s;
        }

        /* Animations to fade the snackbar in and out */
        @-webkit-keyframes fadein {
          from {bottom: 0; opacity: 0;}
          to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadein {
          from {bottom: 0; opacity: 0;}
          to {bottom: 30px; opacity: 1;}
        }

        @-webkit-keyframes fadeout {
          from {bottom: 30px; opacity: 1;}
          to {bottom: 0; opacity: 0;}
        }

        @keyframes fadeout {
          from {bottom: 30px; opacity: 1;}
          to {bottom: 0; opacity: 0;}
        }


/* Slider button */
.switch {
  position: relative;
  display: inline-block;
  width: 30px;
  height: 17px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 5px;
  left: 0;
  right: 0;
  bottom: -5px;
  border-radius: 17px;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 13px;
  width: 13px;
  left: 2px;
  bottom: 2px;
  border-radius: 50%;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:disabled{
  background-color: lightgrey;

}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13px);
  -ms-transform: translateX(13px);
  transform: translateX(13px);
}

/* end of sliders button */

.tooltipsy{
  margin: 5px;
  z-index: 2;
  position: absolute;
  border: solid 1px;
  background-color: white;
  padding: 10px;
  right: 5px;
  display: none;
  width: 300px;
}

.discounttooltipsy{
  color: black;
  margin: 5px;
  z-index: 3;
  position: absolute;
  background-color: white;
  padding: 10px;
  /*right: 5px;*/
  display: none;
  width: 300px;
  border: 1px solid #3EADE1;
  border-radius: 5px;
}

.lightbutton{
  color: #7C7C7C; 
  border: 1px solid #7C7C7C;
}

.tabbb{
  margin-left: 10px;
}

/* picture panel style */
.pic_updater_div {
  position: relative;
  
}

.myimage {
  /*display: block;
  width: 100%;
  height: auto;*/

  width: auto; 
  max-width: 80%; 
  max-height: 30vh;
  border: 1px dotted lightgray; 
  border-radius: 10px;
}

.overlaytext {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
  transition: .5s ease;
  background-color: white;
}

.pic_updater_div:hover .overlaytext {
  opacity: .8;
}

.optionstext {
  color: black;
  font-size: 13px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  text-align: center;

}


</style>