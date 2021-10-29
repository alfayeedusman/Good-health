<div class="row">
	<input type="hidden" value="{{encryptor('encrypt',$tapDetails[0]->id)}}" id="tapid"/>
	<input type="hidden" value="{{getDatetimeNow()}}" id="datenow">
	<div class="col-md-12">
			<div class="col-md-2 ">
			</div>
			<div class="col-md-8 ">
				<center>
				<img src="{{ URL::asset(imagePathUser('assets/tap/'.$tapDetails[0]->id))}}" class="img-responsive"   >
				</center>
			</div>
			<div class="col-md-2 ">
			</div>
			<div class="col-md-12">
				<center>
				<br>
				<button onclick="playSoundTap()" type="button" class="btn btn-info btn-xs" data-toggle="collapse" data-target="#details">Show/Hide Details</button>
				<br><br>
				<div id="details" class="collapse in">
					<h4> {{$tapDetails[0]->product_name}} <h4>
					<hr>
					<h6> {{$tapDetails[0]->description}} <h6>
					<hr>	
					<h6> Coins Required : {{$tapDetails[0]->minimum_coins}}  - Coins Per Tap: {{$tapDetails[0]->coins_per_tap}}<h6>		
					<hr>
				</div>
				
				<?php
				$datenow = new DateTime(getDatetimeNow());
				$end_date = new DateTime($tapDetails[0]->end_date);
				$start_date = new DateTime($tapDetails[0]->start_date);
				?>

				@if( $end_date < $datenow )
					<span style="color:red;">TAP ENDED</span>
					<br><br> 
					<button onclick="viewWinners('{{encryptor('encrypt',$tapDetails[0]->id)}}')" class="btn btn-primary btn-md" ><span id="spinload"></span> VIEW WINNERS</button>																
				@elseif( $start_date < $datenow && $end_date > $datenow)
					<input type="hidden" value="{{$tapDetails[0]->end_date}}" id="tapdate">
					<span style="color:green;">TAP STARTED</span>
					<br><br>
					<p><i class="far fa-clock fa-fw"></i>Remaining time to End ( Server Time )</p>
					<h1 id="countdown"></h1>
			
					@if(checkIfJoined(Auth::user()->member->id,encryptor('encrypt',$tapDetails[0]->id))=='true')
						<h3>You Joined in this tap item.</h3>
						<button id="btntap" onclick="tap('{{encryptor('encrypt',$tapDetails[0]->id)}}')" class="btn btn-success btn-md" ><span id="spinload"></span> TAP NOW</button>		
					@else	
						<button class="btn btn-info" type="button"  id="btn1" onclick="showJoinBtn()">JOIN NOW ?</button>
						<button id="btnjoin" onclick="join('{{encryptor('encrypt',$tapDetails[0]->id)}}')" class="btn btn-primary btn-md" style="display:none;"><span id="spinload"></span>YES JOIN NOW</button>													
						<button class="btn btn-warning"  id="btncancel" style="display:none;" onclick="hideJoinBtn()" >CANCEL</button>
					@endif
				@elseif( $start_date > $datenow && $end_date > $datenow && $tapDetails[0]->start_date != "" && $tapDetails[0]->end_date != "" )
				
					<input type="hidden" value="{{$tapDetails[0]->start_date}}" id="tapdate">
					<span style="color:blue;">READY TO START</span>
					<br><br>
					<p><i class="far fa-clock fa-fw"></i>Remaining time to Start ( Server Time )</p>
					<h1 id="countdown"></h1>

					@if(checkIfJoined(Auth::user()->member->id,encryptor('encrypt',$tapDetails[0]->id))=='true')
						<h3>You Joined in this tap item.</h3>
					@else	
						<button class="btn btn-info" type="button"  id="btn1" onclick="showJoinBtn()">JOIN NOW ?</button>
						<button id="btnjoin" onclick="join('{{encryptor('encrypt',$tapDetails[0]->id)}}')" class="btn btn-primary btn-md" style="display:none;"><span id="spinload"></span>YES JOIN NOW</button>													
						<button class="btn btn-warning"  id="btncancel" style="display:none;" onclick="hideJoinBtn()" >CANCEL</button>
																			
					@endif						
				@elseif( $tapDetails[0]->start_date == "" && $tapDetails[0]->end_date == "" )
				
					<span style="color:red;">PENDING</span>
					<br><br>	
				
					@if(checkIfJoined(Auth::user()->member->id,encryptor('encrypt',$tapDetails[0]->id))=='true')
						<h3>You Joined in this tap item.</h3>
						<button  id="btntap" onclick="tap('{{encryptor('encrypt',$tapDetails[0]->id)}}')" class="btn btn-success btn-md" disabled><span id="spinload"></span> TAP NOW</button>		
					@else	
						<button class="btn btn-info" type="button"  id="btn1" onclick="showJoinBtn()">JOIN NOW ?</button>
						<button id="btnjoin" onclick="join('{{encryptor('encrypt',$tapDetails[0]->id)}}')" class="btn btn-primary btn-md" style="display:none;"><span id="spinload"></span>YES JOIN NOW</button>													
						<button class="btn btn-warning"  id="btncancel" style="display:none;" onclick="hideJoinBtn()" >CANCEL</button>
																			
					@endif						
				@endif	
				<br><br>
				<p id="msg"></p>
				</center>		
				
			</div>
			<div class="col-md-12">
			<br><br><br><br>
			<center>
			<button onclick="viewDetails('{{encryptor('encrypt',$tapDetails[0]->id)}}')" class="btn btn-warning btn-lg" data-dismiss="modal" >Refresh</button>
			<button class="btn btn-danger btn-lg" data-dismiss="modal" onclick="playSoundCancel()">Close</button>
			<center>
			</div>
		
	</div>					
</div>
<script>
function join(id){
	document.getElementById("spinload").innerHTML = '<i style=" display: none ; " class="fa fa-spinner fa-spin fa-fw" ></i>';
	document.getElementById("msg").innerHTML = '';
	var tapid = $('#tapid').val();
	document.getElementById("btnjoin").disabled = true;
	try{
		$.ajax({
			type: "POST",
			url: "{{ route('req.join') }}",
			data: {id:id},
			async: true,
			success:function(data) {
				alert(data.message)
				if(data.success=="true"){
					playSoundSuccess();
					document.getElementById("btnjoin").disabled = true;
					viewDetails(''+tapid);
				}else{
					playSoundError();
					document.getElementById("btnjoin").disabled = false;
				}
				document.getElementById("msg").innerHTML = data.message;
				document.getElementById("spinload").innerHTML = '';
			},
			error: function(data) {
				alert(JSON.stringify(data));
			}
		});
	}catch(err){

	}
}
function tap(id){
	playSoundTap();
	document.getElementById("spinload").innerHTML = '<i style=" display: none ; " class="fa fa-spinner fa-spin fa-fw" ></i>';
	document.getElementById("msg").innerHTML = '';
	var tapid = $('#tapid').val();
	document.getElementById("btntap").disabled = true;
	try{
		$.ajax({
			type: "POST",
			url: "{{ route('tap') }}",
			data: {id:id},
			async: true,
			success:function(data) {
				if(data.success=="true"){
					playSoundSuccess();
					document.getElementById("btntap").disabled = false;
				}else{
					playSoundError();
					document.getElementById("btntap").disabled = false;
				}
				document.getElementById("msg").innerHTML = data.message;
				document.getElementById("spinload").innerHTML = '';
			},
			error: function(data) {
				alert(JSON.stringify(data));
			}
		});
	}catch(err){

	}
}
function showJoinBtn(){
	playSoundTap();
	$('#btn1').hide();
	$('#btnjoin').show();
	$('#btncancel').show();
}
function hideJoinBtn(){
	playSoundCancel();
	$('#btn1').show();
	$('#btnjoin').hide();
	$('#btncancel').hide();
}


</script>


<script>
$(document).ready(function() { 
document.getElementById("msg").innerHTML = '';
clearInterval(x);
});
// Set the date we're counting down to
var tapdate = $('#tapdate').val();
var countDownDate = new Date(''+tapdate).getTime();
var count = 0;
// Update the count down every 1 second
var x = setInterval(function() {
  // Get todays date and time
  //var now = new Date().getTime();
  
  var datenow = $('#datenow').val();
  var now = new Date(""+datenow);
  now.setSeconds(now.getSeconds() + 1);
  year = "" + now.getFullYear();
  month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
  day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
  hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
  minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
  second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }
  $('#datenow').val(year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second);
  // Find the distance between now an the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
  //document.getElementById("count").innerHTML = ""+count;
  // If the count down is finished, write some text 
  if (distance < 0) {
    clearInterval(x);
	count = 0;
	var tapid = $('#tapid').val();
	viewDetails(''+tapid);
    //document.getElementById("countdown").innerHTML = "You can click now.";
  }else{
	//count = count + 1;
  }
}, 1000);



</script>