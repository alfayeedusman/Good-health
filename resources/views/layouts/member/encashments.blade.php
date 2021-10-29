 @extends('layouts.member.app')
@section('title')
	Encashments
@endsection

@section('content')

<div class="row m-t-25" >
	<div class="col-lg-12">
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Something went wrong!</strong><br>
			<p>
				@foreach ($errors->all() as $error)
					{{ $error }} <br>
				@endforeach
			</p>
		</div>
	@endif
	@if (Session::has('message'))
		<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong><br>
				<p>{{ Session::get('message') }}</p>
		</div>
	@endif
	</div>
	<?php

	$selectedAccount = "";
	if(count($accounts)>0){
		$selectedAccount = $accounts[0]->account_name;
		$accountCount = 0;
	}
	?>	
	<div class="col-md-4">

	<form  class="form-header" role="form" method="POST" action="{{ route('encashments.submit') }}" onsubmit="submit_btn3.disabled = true; return true;" >
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
									
		
		<div class="form-group col-md-12" style="padding:0px;">
			<label for="account_name" class="control-label mb-1">Account</label>
			<div class="form-group ">
				@if(count($accounts) > 0)
				<select class="form-control col-md-6 input-lg"  name="account_name" id="account_name" onchange="selectAccount(this.value)">
					@foreach($accounts as $acc)
						<option <?php if(isset($_GET['account_name'])){if($acc->account_name==$_GET['account_name']){ echo "selected";  $selectedAccount = $acc->account_name; }} ?> value="{{$acc->account_name}}" >{{$acc->account_name}}</option>
					@endforeach
				</select> 
				@else
					<select class="form-control col-md-6  input-lg" name="account_name" id="account_name">
						<option value="SELECT">NO ACCOUNT</option>
					</select> 
				@endif
			</div>
			
			<div class="form-group col-md-12" style="padding:0px;">		
			  <button type="button" class="btn btn-info btn-md" id="btn13" onclick="showSubmitBtn3()" style="color: white; background:#b38f00;">Send Request ?</button>
			  <button type="button" class="btn btn-danger btn-md" id="btn23" style="display:none" onclick="hideSubmitBtn3()">Cancel</button>
			  <button type="submit" class="btn btn-info btn-md" id="submit_btn3" style="display:none; color: white; background:#b38f00;">Send</button>
			</div>
		</div>
	</form>
	</div>
	<div class="col-md-4">
	</div>
	<div class="col-md-4">
		<br>
		<p>Minimum Encashment is 500</p>
		<div class="panel panel-default card" style="padding:20px">
			<center>
		  <div class="panel-heading"><h5>Wallet</h5></div>
		  <div class="panel-body">
		  	<h2><strong>&#8369; {{number_format(getTotalWallet(Auth::user()->username,$selectedAccount),2)}}</strong></h2>
		  </div>
		</center>
		</div>
										
		
	</div>
	<div class="col-lg-12">
		<div class="card card-stats">
		<div class="card-body ">
						
						<div class="tab-pane fade show " id="nav-list" role="tabpanel" aria-labelledby="nav-list">
	
							<div class="row">
								
								<div class="col-md-12">

									
								
										<div class="table-responsive m-b-30">
												<table class="table table-bordered table-striped mb-0">
													<thead>
														<tr>
															<th style="width:5%; font-size: 14px;">No</th>
															<th style="width:15%; font-size: 14px;">Account</th>
															<th style="width:25%; font-size: 14px;">Amount</th>
															<th style="width:20%; font-size: 14px;">Status</th>
															<th style="width:20%; font-size: 14px;" >Request Date</th>
														</tr>
													</thead>
													<tbody>
														<?php $x=1; ?>
														@foreach($encashment as $encash)
														<tr>
															<td style="font-size: 14px;">{{$x++}}</td>
															<td style="font-size: 14px;">{{$encash->account_name}}</td>
															<td style="font-size: 14px;">
															    <?php
																$amount = $encash->amount;
																$less = 50;
																$total = $amount - $less;
																?>
																 &#8369;{{$encash->amount}} less {{$less}}(Encashment Fee) = <strong style="font-size: 20px;"> &#8369;{{$total}}</strong>
															</td>
															<td style="font-size: 14px;">{{$encash->status}}</td>
															<td style="font-size: 14px;">{{$encash->created_at}}</td>
														</tr>
														@endforeach
													  
													</tbody>
												</table>
										</div>
								
								</div>
							</div>
							
			
						</div>

				<br>
		</div>
		</div>
	</div>
	
</div>

@endsection
@section('script')
<script>
function showSubmitBtn(){
	$('#btn1').hide();
	$('#btn2').show();
	$('#submit_btn').show();
}
function hideSubmitBtn(){
	$('#btn1').show();
	$('#btn2').hide();
	$('#submit_btn').hide();
}
function showSubmitBtn2(){
	$('#btn12').hide();
	$('#btn22').show();
	$('#submit_btn2').show();
}
function hideSubmitBtn2(){
	$('#btn12').show();
	$('#btn22').hide();
	$('#submit_btn2').hide();
}
function showSubmitBtn3(){
	$('#btn13').hide();
	$('#btn23').show();
	$('#submit_btn3').show();
}
function hideSubmitBtn3(){
	$('#btn13').show();
	$('#btn23').hide();
	$('#submit_btn3').hide();
}
function showSubmitBtn4(){
	$('#btn14').hide();
	$('#btn24').show();
	$('#submit_btn4').show();
}
function hideSubmitBtn4(){
	$('#btn14').show();
	$('#btn24').hide();
	$('#submit_btn4').hide();
}
function selectAccount(account_name){
	window.location = '?account_name='+account_name;
}
</script>

@endsection