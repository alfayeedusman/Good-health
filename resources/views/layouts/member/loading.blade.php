@extends('layouts.member.app')
@section('title')
	Loading
@endsection
@section('style')
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12">
		
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<h3>
					@foreach ($errors->all() as $error)
						{{ $error }} <br>
					@endforeach
				</h3>
			</div>
		@endif
		@if (Session::has('message'))
			<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<br>
				<h4>{{ Session::get('message') }}</h4>
				<br>
			</div>
		@endif
	
		</div>
		<div class="col-md-12">
		<form  class="form-header" role="form" method="POST" action="{{ route('loading.submit') }}" onsubmit="btn2.disabled = true; return true;" >
		<input type="hidden" name="_token" value="{{ csrf_token() }}">						
		<div class="col-md-6">
			<h2>Top up mobile phone in seconds!</h2>
			<hr>
			<h3>My Load Wallet : <strong class="text-primary">&#8369; {{number_format(getTotalLoadWallet(Auth::user()->member->username),2)}}</strong></h3>	
			<hr>
			<br>
			<div class="form-group" style="padding:0px;">
				<p>Prepaid Phone Number ( 11 digit number , starts with zero(0) )</p>
				<input class="form-control input-lg" name="mobile" id="mobile" type="text" placeholder="Ex: 09991234567" required>
			</div>
			<div class="form-group">
				<p>Network</p>
				<select class="form-control input-lg" id="network" name="network" onchange="showProducts(this.value)" style="height:40px;" required>
		
					<option value="1">SMARTBUDDY | TNT | SMARTBRO</option>
					<option value="2">SUN</option>
				</select>
			</div>
			<div class="form-group">
			<p>Product</p>
				<select class="form-control input-lg" id="productSmart" name="product_code_smart" required onchange="getProductDesc(1)" style="height:40px;">
				
					@foreach( $smartProductCodes as  $codes)
						<?php
						$buddy = $codes['buddy'];
						$tnt = $codes['tnt'];
						$bro = $codes['bro'];
						if($buddy=="Y"){
							$buddy = "SMARTBUDDY ,";
						}else{  $buddy = "";  }
						if($tnt=="Y"){
							$tnt = "TNT ,";
						}else{  $tnt = "";  }
						if($bro=="Y"){
							$bro = "SMARTBRO ,";
						}else{  $bro = "";  }
						?>
						
						<option value="{{$codes['keyword']}}">{{'Amount: '.$codes['amount'].' = '.$codes['product_type'].' | '.$codes['keyword'].' | Available Network: '. $buddy.' '.$tnt.' '.$bro.' ( '.$codes['package_offer'].' )'}}</option>
					@endforeach
				</select>
				
				<select class="form-control input-lg" id="productSun" name="product_code_sun" style="display:none;height:40px;" onchange="getProductDesc(2)"  required>
	
					@foreach( $sunProductCodes as  $suncodes)
						<option value="{{$suncodes['keyword']}}">{{'Amount: '.$suncodes['amount'].' = '.$suncodes['product_type'].' | '.$suncodes['keyword'].' ( '.$suncodes['package_offer'].' )'}}</option>
					@endforeach
				</select>
			
				<br>
				
				
			</div>
		<?php
		
		?>
		</div>
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">Top Up Review</div>
				<div class="panel-body">
				<center>
					<h2 id="mobiletxt" >Mobile #</h2>
					<h4 id="networktxt">Network</h4>
					<img id="imgsmart" src="{{ URL::asset('assets/smart.jpg') }}" class="img-responsive img-circle" style="height:100px; display:none;" >
					<img id="imgsun" src="{{ URL::asset('assets/sun.png') }}" class="img-responsive img-circle" style="height:100px; display:none;" >
					<img id="imgglobe" src="{{ URL::asset('assets/globe.png') }}" class="img-responsive img-circle" style="height:100px; display:none;" >
					
					<h3 id="productcode">Product</h3>
					<h4 id="productdesc">Description</h4>
					<br>
					<br>
					<button type="button" class="btn btn-info" type="button"  id="btn1" onclick="submitLoad()">Top Up?</button>
					<button type="submit" id="btn2"  class="btn btn-success btn-md" style="display:none;">YES</button>													
					<button type="button" class="btn btn-warning"  id="btn3" style="display:none;" onclick="cancelsubmitLoad()" >CANCEL</button>
				</center>
				</div>
			</div>

		</div>
		</form>
		</div>
		
		<div class="col-md-12">
			<hr>
			<h3>Top up history</h3>
			<div class="table-responsive m-b-30">	
				<table class="table" id="dataTable-topup">
					<thead>
						<tr>
							<th style="width:2%">No</th>
							<th style="width:5%">Mobile</th>
							<th style="width:15%">Network</th>
							<th style="width:5%">Product Code</th>
							<th style="width:5%">Amount</th>
							<th style="width:30%">Result</th>
							<th style="width:5%">Deduction Wallet</th>
							<th style="width:5%">Remaining Wallet</th>
							<th style="width:5%">RefNo</th>
							<th style="width:30%">Date</th>
						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?>
						@foreach($loadTopUp as $loadtopup)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>{{$loadtopup->mobile}}</td>
							<td>
							@if($loadtopup->network==1)
							SMARTBUDDY | TNT | SMARTBRO
							@elseif($loadtopup->network==2)
							SUN
							@elseif($loadtopup->network==3)
							GLOBE | TM | CHERRY | ABS ( REGULAR LOAD )
							@elseif($loadtopup->network==4)
							GLOBE | TM | CHERRY | ABS ( SPECIAL LOAD )
							@endif
							</td>
							<td>{{$loadtopup->product_code}}</td>
							<td>{{$loadtopup->amount}}</td>
							<td>
							@if($loadtopup->network==1)
							<?php
							$res = postMyEloadPlusQuery($loadtopup->session_id);
							?>
							{{$res['ResultCodeDesc']}}
							@elseif($loadtopup->network==2)
							<?php
							$res = postLoadToGOQuery($loadtopup->session_id);
							?>
							{{$res['ResultCodeDesc']}}
							
							@elseif($loadtopup->network==3)
							<?php
							$res = postAirtimeLoadQuery($loadtopup->airtimetransaction_num);
							?>
							{{$res['ResultDescription']}}
							
							@elseif($loadtopup->network==4)
							<?php
							$res = postAirtimeLoadQuery($loadtopup->airtimetransaction_num);
							?>
							{{$res['ResultDescription']}}
							@endif
							
						
						
							</td>
							<td>{{$loadtopup->deduct_wallet}}</td>
							<td>{{$loadtopup->remaining_wallet}}</td>
							<td>{{$loadtopup->refNo}}</td>
							<td>{{$loadtopup->created_at}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>	
		
						
				

		</div>
	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		<br>
			
		
		<br><br>
		</div>
		
	</div>
</div>

@endsection
@section('script')	
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.colVis.min.js"></script>
<script>	
function showProducts(num){
	
	$('#productSmart').hide();
	$('#productSun').hide();
	$('#amount').hide();
	$('#lbl').hide();
	$('#imgsmart').hide();
	$('#imgsun').hide();
	var network =  $("#network option:selected").text();
	document.getElementById('networktxt').innerHTML = ''+network;
	if(num == 1){
		$('#productSmart').show();
		$('#imgsmart').show();
	}else if(num == 2){
		$('#productSun').show();
		$('#imgsun').show();
	}
	getProductDesc(num);
	
}
function submitLoad(){
	
	$('#btn1').hide();
	$('#btn2').show();
	$('#btn3').show();
}
function cancelsubmitLoad(){

	$('#btn1').show();
	$('#btn2').hide();
	$('#btn3').hide();
}
function getMobile(num){
	$('#mobile').val(num);
}
$("#mobile").on('change keydown paste input', function(){
	  var num = $('#mobile').val();
	  if(num==""){
		document.getElementById('mobiletxt').innerHTML = 'Mobile #';
	  }else{
		document.getElementById('mobiletxt').innerHTML = ''+num;
	  }
});
$(document).ready(function() { 
	$('#dataTable-topup, #dataTable-wallet').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	} );
	$('#imgsmart').show();
	var network =  $("#network option:selected").text();
	
	var productSun =  $("#productSun option:selected").text();
	var productSmart =  $("#productSmart option:selected").text();
	
	var codeSun = $("#productSun option:selected").val();
	var codeSmart = $("#productSmart option:selected").val();
	
	document.getElementById('networktxt').innerHTML = ''+network;
	document.getElementById('productcode').innerHTML = ''+codeSmart;
	document.getElementById('productdesc').innerHTML = ''+productSmart;
});
function getProductDesc(num){
	var desc = "";
	var code = "";
	if(num==1){
		desc =  $("#productSmart option:selected").text();
		code =  $("#productSmart option:selected").val();
	}else if(num==2){
		desc =  $("#productSun option:selected").text();
		code =  $("#productSun option:selected").val();
	}
	document.getElementById('productdesc').innerHTML = ''+desc;
	document.getElementById('productcode').innerHTML = ''+code;
}

</script>
@endsection
