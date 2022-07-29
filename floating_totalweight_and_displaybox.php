		<div class="card sticky-top float-right sticky-top flaotordersum-hide" id="flaotordersum">
			<div class="row" style = 'width: 100%;'>
                <div style="margin-top: -30px;width: 100%; text-align: right; ">
                    <span id = 'miniwindowtogglebtn' style='display: none; cursor: pointer; border-top-left-radius: 5px; border-top-right-radius: 5px; padding-left: 10px; font-size: 10px; padding-bottom: 5px; padding-top: 5px; padding-right: 10px;background-color: rgb(40 40 40);'>
                        <span id = 'toggle-label'>Hide Mini Window</span> 
                        <i id = 'toggle-icon' class="fa fa-minus" aria-hidden="true"></i>
                    </span>
                </div>
				<div id = 'box-title' class = 'box-title-left'>
                    <span> Cumulative Order Summary</span>
                    <span id = 'hidepanel' style = 'display: none; cursor: pointer;'>
                         <span  style = 'font-size: 10px; font-weight: light;'>Show Less</span>
                         <i style = 'font-size: 10px; font-weight: light;' class="fa fa-arrow-up"></i>
                    </span>
                    <!-- <span><i class="fa fa-plus" aria-hidden="true"></i></span> -->
				</div>
                <div id = 's_window'>
                    <ul>
                        <li><span class = 's_valuecoontainer' id = 's_totaldisplayboxes' >0</span><span class = 's_label'>Number of Display Boxes:</span></li>
                        <li><span class = 's_valuecoontainer' id = 's_total10kgbox'>0</span><span class = 's_label'>Number of 10Kg FedEx Boxes:</span></li>
                        <li><span class = 's_valuecoontainer' id = 's_total25kgbox'>0</span><span class = 's_label'>Number of 25Kg FedEx Boxes:</span></li>     
                       
                        <li><span class = 's_valuecoontainer' id = 's_moreboxes'>0</span><span class = 's_label'>Displays needed to fill the current FedEx box</span></li>  
                        <li id= 'showpanel' style = ''><span style = 'margin-right: 5px;'>Show More</span><i class="fa fa-arrow-down"></i></li>  
                    </ul>
                </div>
                <div id = 'main_content' class = 'm-hide'>
                        <div class = 'box_container1'> 
                            <div class = 'input_box'> <input id = 'totalkg' type="text" readonly placeholder ='0Kg' /></div>
                            <div> <span>Order Weight:</span> </div>
                        </div>
                        <div class = 'box_container1'>
                            <div id = 'bc1'> 
                                <div class = 'input_box'> <input class = 'flash' id = 'displayboxcounter' type="text"  readonly  placeholder ='0' /></div>
                                <div> <span>Number of Display Boxes:</span> </div>
                            </div>
                            <div id = 'bc2'>
                                <div><span> Add <span id = 'moreboxes'></span> more Display boxes to fill the current FedEx box</span></div>
                            </div>
                        </div>		
                    <br>
                    <div class = 'box_container2'>
                        <div class = 'input_box'> <input id = 'total_10kgbox' type="text" readonly placeholder ='0' /></div>
                        <div> <span>Number of 10Kg FedEx Boxes:</span> </div>
                    </div> 
                    <div class = 'box_container2'>
                        <div class = 'input_box'> <input id = 'total_25kgbox' type="text" readonly placeholder ='0'  /></div>
                        <div> <span>Number of 25Kg FedEx Boxes:</span> </div>
                    </div>  
                            

                     <!--  -->
                    <div id = 'notes'>
                        <div id = 'n1'>
                            <div class="col-lg-12 col-xs-12" >
                                <span>10Kg boxes accomodates 40 Displays</span>
                            </div>	
                            <div class="col-lg-12 col-xs-12" >
                                <span>25Kg boxes accomodates 90 Displays</span>
                            </div>	     
                        </div>  
                        <div id = 'n2'>
                            <div class="col-lg-12 col-xs-12" >
                                <span>flashes Green at 40</span>
                            </div>	
                            <div class="col-lg-12 col-xs-12" >
                                <span>flashes Orange at 90</span>
                            </div>	
                            <div class="col-lg-12 col-xs-12" >
                                <span>flashes Blue at 130</span>
                            </div>	
                            <div class="col-lg-12 col-xs-12" >
                                <span>flashes Violet at 180</span>
                            </div>	                                                                                     
                        </div>       
                    </div>  
                    <!--  -->

                </div>
			</div>
		</div>


<script>

function get_items(item) {
   var arr_weight = [];
   var arr_displaybox = [];
   var total_weight = 0;
   var total_displaybox = 0;
   console.log('==================================================');
   document.querySelectorAll('input[data-type="qty_selector"]').forEach((elem) => {
        var id = elem.id;
        var qty = elem.value;
        var weight = elem.dataset.weight;
        var displaybox = elem.dataset.displaybox;
    
        if(qty > 0){
                      console.log("raw weights :"+ weight);
                     total_weight =+ weight * qty; // sum of the current item's weight
                     total_displaybox =+ displaybox * qty; // sum of the current item's display boxes
                     if(weight === '' || typeof(weight) === undefined ){
                        weight = 0;
                        arr_weight.push(weight);
                     }else {
                        arr_weight.push(total_weight);
                        arr_displaybox.push(total_displaybox); 
                     }  
                    const reducer = (accumulator, curr) => accumulator + curr; // loops over the array and calls the reducer function to store the value of array computation by the function in an accumulator
                    total_weight = arr_weight.reduce(reducer); // sum off all weight in the array
                    total_displaybox = arr_displaybox.reduce(reducer); // sum off all displayboxes in the array
        }  
   });

        // pass the total values to the element
        boxSize(total_displaybox);
        document.querySelector('#totalkg').value = total_weight.toFixed(3) + "Kg"; // toFixed() will keep the value in # decimal places
        document.querySelector('#displayboxcounter').value = total_displaybox;
        document.querySelector('#s_totaldisplayboxes').innerHTML = total_displaybox;
        displaybox_flash();
}

var two5s = 0;
var tens = 0;
var boxes = 0;
var remainigboxes = 0;

function boxSize(total_displaybox) {

    console.log("total boxes :"+ total_displaybox); 
    if(total_displaybox <= 90 && total_displaybox != 0) {
        if(total_displaybox <= 40 ) {
            moreboxes(total_displaybox, 40, 10);
            tens = 1;
        }else {
            moreboxes(total_displaybox, 0);
            tens = 0;
        }
        if(total_displaybox <= 90 && total_displaybox > 40) {
            moreboxes(total_displaybox, 90, 25);
            two5s = 1;
        }else {
            two5s = 0;
        }        
    // ==================================================
    }else if(total_displaybox >= 90 && total_displaybox <= 180) {
        console.log('reached 90')
        if(total_displaybox <= 130) {
            moreboxes(total_displaybox, 130, 10);
            tens = 1;
        }else {
            tens = 0;
        }
        if(total_displaybox <= 180 && total_displaybox > 130){
            moreboxes(total_displaybox, 180, 25);
            console.log("180!!");
            two5s = 2;
        }else if(total_displaybox <= 130){
            two5s = 1;
        }
    // ==================================================== 
    }else if(total_displaybox >= 180 && total_displaybox < 270){
        if(total_displaybox <= 220) {
            moreboxes(total_displaybox, 220, 10);
            console.log("220?");
            tens = 1;
        }else {
            tens = 0;
        }
        if(total_displaybox <= 270 && total_displaybox > 220){
            moreboxes(total_displaybox, 270, 25);
            two5s = 3
        }else if(total_displaybox <= 220){
            two5s = 2;
        }
    // ====================================================   
    }else if(total_displaybox >= 270 ){
        moreboxes(0, 0, 25);
    }else {
        moreboxes(total_displaybox, 40, 10);
        tens = 0;
    }

    console.log(tens);
    console.log(two5s);
    // Math.trunc() will only show the whole number
   
    document.querySelector('#total_25kgbox').value = Math.trunc(two5s);
    document.querySelector('#total_10kgbox').value = Math.trunc(tens);
    // document.querySelector('#total_fedexbox').value = Math.trunc(tens) + Math.trunc(two5s); 
    document.querySelector('#s_total25kgbox').innerHTML = Math.trunc(two5s);
    document.querySelector('#s_total10kgbox').innerHTML = Math.trunc(tens);         
    // document.querySelector('#s_totalfedexbox').innerHTML = Math.trunc(tens) + Math.trunc(two5s); 
         
}

function moreboxes(total_displaybox, count, boxtype) {
    boxes = count - total_displaybox;
    console.log("computation :"+ count + "-" + total_displaybox);
    console.log("remaining boxes :" + boxes );
    document.querySelector('#s_moreboxes').innerHTML = Math.trunc(boxes);
    document.querySelector('#moreboxes').innerHTML = Math.trunc(boxes);
}

//remove title highlight on mouse over
document.querySelector('#flaotordersum').onmouseover = ((elem) => {
    var summarytitle = document.querySelector('#box-title'); 
    // summarytitle.classList.remove('left-flash-green');
    // summarytitle.classList.remove('left-flash-orange');
    // summarytitle.classList.remove('left-flash-blue');
    // summarytitle.classList.remove('left-flash-violet');

    
});

document.querySelector('#flaotordersum').onmouseout = ((elem) => {
     var val = event.target.value;
     //displaybox_flash();
});

document.querySelector('#showpanel').onclick = (() => {

    var summarytitle = document.querySelector('#box-title');
    summarytitle.classList.remove('left-flash-green');
    summarytitle.classList.remove('left-flash-orange');
    summarytitle.classList.remove('left-flash-blue');
    summarytitle.classList.remove('left-flash-violet');


    document.querySelector('#flaotordersum').classList.toggle("flaotordersum-show");
    document.querySelector('#flaotordersum').classList.toggle("flaotordersum-hide");
    document.querySelector('#box-title').classList.toggle("box-title-left");
    document.querySelector('#box-title').classList.toggle("box-title-right");
    document.querySelector('#main_content').classList.toggle("m-show");
    document.querySelector('#main_content').classList.toggle("m-hide");
    document.querySelector("#s_window").style.display = 'none'; 
    document.querySelector("#hidepanel").style.display = 'inline'; 
})

document.querySelector('#hidepanel').onclick = (() => {
    document.querySelector('#flaotordersum').classList.toggle("flaotordersum-show");
    document.querySelector('#flaotordersum').classList.toggle("flaotordersum-hide");
    document.querySelector('#box-title').classList.toggle("box-title-left");
    document.querySelector('#box-title').classList.toggle("box-title-right"); 
    document.querySelector('#main_content').classList.toggle("m-show");
    document.querySelector('#main_content').classList.toggle("m-hide");     
    document.querySelector("#s_window").style.display = 'block'; 
    document.querySelector("#hidepanel").style.display = 'none'; 
     displaybox_flash();
})

document.querySelector('#miniwindowtogglebtn').onclick = (() => {

    document.querySelector('#toggle-icon').classList.toggle("fa-minus");
    document.querySelector('#toggle-icon').classList.toggle("fa-plus");
    

    if(document.querySelector('#toggle-icon').classList.contains('fa-minus')){
         document.querySelector('#box-title').style.display = 'none';
         document.querySelector('#s_window').style.display = 'none';
    }else {
         document.querySelector('#box-title').style.display = 'block';
         document.querySelector('#s_window').style.display = 'block';    
    }
})
function displaybox_flash() {
    var displaybox = document.querySelector('#displayboxcounter');
    var summarytitle = document.querySelector('#box-title');
    
    //reset flash effect for display box
    displaybox.classList.remove('flash-green');
    displaybox.classList.remove('flash-orange');
    displaybox.classList.remove('flash-blue');
    displaybox.classList.remove('flash-violet');

    // reset flash effect for title 
    summarytitle.classList.remove('left-flash-green');
    summarytitle.classList.remove('left-flash-orange');
    summarytitle.classList.remove('left-flash-blue');
    summarytitle.classList.remove('left-flash-violet'); 

    if(displaybox.value >= 40 && displaybox.value < 90) {
         displaybox.classList.add('flash-green');
         summarytitle.classList.add('left-flash-green');
    }
    if(displaybox.value >= 90 && displaybox.value < 130 ){
        displaybox.classList.add('flash-orange');
        summarytitle.classList.add('left-flash-orange');
    }
    if(displaybox.value >= 130 && displaybox.value < 180 ){
        displaybox.classList.add('flash-blue');  
        summarytitle.classList.add('left-flash-blue');
    } 
    if(displaybox.value >= 180 ){
        displaybox.classList.add('flash-violet');
        summarytitle.classList.add('left-flash-violet');
    }
}
</script>



<style>

.flash-green {
  background: green;
  color: white;
  transition: all .35s ease-in-out;
  animation-name: flash-green;
  animation-duration: 2s;
  animation-iteration-count: infinite;
}
@keyframes flash-green {
  0% {background-color: green;}
  50% {background-color: #064a00;}
  100% {background-color: green;}
}

.flash-orange {
  background: orange;
  color: white;
  transition: all .35s ease-in-out;
  animation-name: flash-orange;
  animation-duration: 2s;
  animation-iteration-count: infinite;
}
@keyframes flash-orange {
  0% {background-color: orange;}
  50% {background-color: #6e3303;}
  100% {background-color: orange;}
}

.flash-blue {
  background: blue;
  color: white;
  transition: all .35s ease-in-out;
  animation-name: flash-blue;
  animation-duration: 2s;
  animation-iteration-count: infinite;
}
@keyframes flash-blue {
  0% {background-color: #053ce3;}
  50% {background-color: #022078;}
  100% {background-color: #053ce3;}
}

.flash-violet {
  background: violet;
  color: white;
  transition: all .35s ease-in-out;
  animation-name: flash-violet;
  animation-duration: 2s;
  animation-iteration-count: infinite;
}
@keyframes flash-violet {
  0% {background-color: violet;}
  50% {background-color: #68026e;}
  100% {background-color: violet;}
}




/* *************************************************** */

.left-flash-green {
  border-left: none;
  color: white;
  transition: all .35s ease-in-out;
  animation-name: left-flash-green;
  animation-duration: 2s;
  animation-iteration-count: infinite;
}
@keyframes left-flash-green {
  0% { border-left: 6px solid green; box-shadow: -10px 0px 15px green;}
  50% { border-left: 6px solid #064a00; box-shadow: none;}
  100% { border-left: 6px solid green; box-shadow: -10px 0px 15px green;}
}

.left-flash-orange {
  border-left: none;
  color: white;
  transition: all .35s ease-in-out;
  animation-name: left-flash-orange;
  animation-duration: 2s;
  animation-iteration-count: infinite;
}
@keyframes left-flash-orange {
  0% { border-left: 6px solid orange; box-shadow: -10px 0px 15px orange;}
  50% { border-left: 6px solid #6e3303; box-shadow: none;}
  100% { border-left: 6px solid orange; box-shadow: -10px 0px 15px orange;}
}

.left-flash-blue {
  border-left: none;
  color: white;
  transition: all .35s ease-in-out;
  animation-name: left-flash-blue;
  animation-duration: 2s;
  animation-iteration-count: infinite;
}
@keyframes left-flash-blue {
  0% {border-left: 6px solid #053ce3; box-shadow: -10px 0px 15px #053ce3;}
  50% {border-left: 6px solid #022078; box-shadow: none;}
  100% {border-left: 6px solid #053ce3; box-shadow: -10px 0px 15px #053ce3;}
}

.left-flash-violet {
  border-left: none;
  color: white;
  transition: all .35s ease-in-out;
  animation-name: left-flash-violet;
  animation-duration: 2s;
  animation-iteration-count: infinite;
}
@keyframes left-flash-violet {
  0% { border-left: 6px solid violet; box-shadow: -10px 0px 15px violet;}
  50% { border-left: 6px solid #68026e; box-shadow: none;}
  100% { border-left: 6px solid violet; box-shadow: -10px 0px 15px violet;}
}

/* ================================================================== */
#showpanel {
    cursor: pointer; 
    text-align: center; 
    padding: 5px;
    border: 1px solid rgb(255 0 0);
    border-radius: 3px;
    margin-top: 10px;
    width: 95%;
    background: rgb(161 6 32);
}
#hidepanel {
    padding: 5px;
    border: 1px solid rgb(255 0 0);
    border-radius: 3px;
    background: rgb(161 6 32);
}

#showpanel:hover, #hidepanel:hover {
    background:#eb2d59;
}

#notes {
    display: flex;
    width: 100%;
    margin-top: 10px;
    margin-bottom: 10px;
}

#n1{
    width: 60%;
    justify-content: space-around;
}
#n2 {
    width: 40%;
}

/* =================================================================== */

#flaotordersum {
    z-index: 1;
    color: white;
    padding: 5px;
    padding-left: 10px;
    padding-right: 10px;
    width: 100%;
    margin-top: 33%;
    position: absolute;  
    transition: all .35s ease-in-out;
    border: none;
}
#box-title span {
    transition: all .35s ease-in-out;
    width: 100%;
    font-weight: 700;
    font-size: 14px;
}
#toggle-label {
    font-weight: 600;
    font-size: 12px;
    margin-right: 5px;
}

#box-title {
    display: block;
    background-color: rgb(40 40 40);
    border-radius: 5px;
    width: 65%;
    opacity: 1;
    transition: all .35s ease-in-out;
}
#box-title span:nth-child(1) {
    width: 90%;
}
#box-title span:nth-child(2) {
    width: 10%;
}
.box-title-right {
      margin-left: 5px;
      padding: 10px;
}
.box-title-left {
    padding: 5px;
    padding-left: 15px;
    padding-right: 20px;
    margin-left: 45%;
}

/* #flaotordersum:hover #box-title{
      margin-left: 5px;
      padding: 10px;
}

/* #flaotordersum:hover #s_window{
    display: none;
} */
/* #flaotordersum:hover #box-title > span  {
    font-size: 15px;
}  */

#s_window {
    padding-left: 20px;
    opacity: 1;
    transition: all .35s ease-in-out;
    background-color: rgb(40 40 40);
    border-radius: 5px;
    width: 55%;
    height: auto;
    margin-left: 45%;
    margin-top: 5px;
    padding: 7px;
}
#s_window ul {
    transition: all .35s ease-in-out;
    padding: 0;
    width: 100%;
    margin-bottom: 0px;
    font-size: 12px;
}
.s_valuecoontainer {
    width: 10%;
    text-align: center;
}
.s_label {
    width: 90%;
    padding-left: 5px;
}
#s_window ul li{
    width: 100%;
    transition: all .35s ease-in-out;
    list-style-type: none;
    display: inline-block;
}

#s_window ul li span{
    font-size: 13px;
    display: inline-block;
}
.flaotordersum-show {
    background-color: rgb(40 40 40);
}
.flaotordersum-hide {
    background: rgba(0, 0, 0, 0.0);
    box-shadow: -0px 0px 0px;
}


#main_content {
    font-size: 14px;
    transition: all .35s ease-in-out;
    width: 100%;
    
}
#flaotordersum:hover #main_content{
    
   
}
.m-show {
    opacity: 1;
}
.m-hide {
    opacity: .1;
}
.box_container1  {
    //border: 1px solid red;
    display: flex;
    margin-left: 20px;
    width: 100%;
    margin-bottom: 5px;
    //justify-content: space-around;
}

.box_container2{
    display: flex;
    margin-left: 20px;
    width: 100%;
    margin-bottom: 5px;
}

.box_container1 .input_box{
    width: 15%;
    margin-right: 5px;
}

.box_container2 .input_box{
    width: 10%;
    margin-right: 5px;
}

.box_container1 input, .box_container1 span, .box_container2 input, .box_container2 span{
    width: 100%;
    text-align: center;
    font-weight: 600;
}
#bc1, #bc2  {
    display: flex;
   
}

#bc1 div:nth-child(1) {
   width: 15%;
}
#bc1 div:nth-child(2) {
    width: 85%;
}
.input_box input:focus {
    outline: none;
}

.input_box input::-webkit-input-placeholder { /* Edge */
  //text-align: right;
}

.input_box input:-ms-input-placeholder { /* Internet Explorer 10-11 */
  // text-align: right;
}

.input_box input::placeholder {
 //  text-align: right;
}
</style>