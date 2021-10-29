@extends('layouts.member.app')
@section('title')
	Account Income
@endsection
@section('content')
<input type="hidden" value="{{$account[0]->account_name}}" id="acct">
<div class="row">
	<div class="col-md-8">
		<div class="overview-wrap">
			<h2 class="title-1">Account Income<br><br></h2>
		</div>
	</div>
	<div class="col-md-4">
		<div class="overview-item overview-item--c4">
			<div class="overview__inner">
				<div class="overview-box clearfix">
					<div class="icon">
						<h1 style="color:white;">&#8369;</h1>
					</div>
					<div class="text">
						<?php
							$wallet = getTotalWallet(Auth::user()->username);
						?>
						<h3 style="color:white;">{{number_format($wallet,2)}}</h3>
						<span>Wallet</span>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<div class="row m-t-25" >

	<div class="col-sm-6 col-md-3 ">
	
	</div>
	<div class="col-sm-6 col-md-6 ">
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
			<br>
		@endif
		@if (Session::has('message'))
			<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Success!</strong><br>
					<p>{{ Session::get('message') }}</p>
			</div>
			<br>
		@endif
		
		<center><h1>{{$account[0]->account_name}}</h1></center>
		<br>
		<div class="overview-item overview-item--c1">
			<div class="overview__inner">
				<center>
				<span style="color:white;">Income</span>
				<h1 style="color:white;"><span id="income">{{number_format(0,2)}}</span></h1><br>
				<span style="color:white;">Points</span>
				<h4 style="color:white;">LEFT: <span id="left">0</span> - RIGHT: <span id="right">0</span></h4><br>
				</center>
			</div> 
		</div>
		
		<form  class="form-header" role="form" method="POST" action="{{ route('accounts.move.to.wallet.submit', ['id' => $account[0]->account_name ]) }}" onsubmit="submit_btn.disabled = true; return true;" >
			<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
			<input type="hidden" name="account_name" value="{{$account[0]->account_name}}"> 
			<div class="form-group col-md-12" style="padding:0px;">
				<input id="pin" name="pin" type="number" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter your 4 digit PIN" >
				<p  class="text-danger"><small>Minimum move to wallet amount is 100.</small></p>			 						
				<div class="form-group col-md-12" style="padding:0px;">		
				  <button type="button" class="btn btn-info btn-md btn-block" id="btn1" onclick="showSubmitBtn()">Move To Wallet? ?</button>
				  <button type="button" class="btn btn-danger btn-md btn-block" id="btn2" style="display:none" onclick="hideSubmitBtn()">Cancel</button>
				  <button type="submit" class="btn btn-info btn-md btn-block" id="submit_btn" style="display:none">Move</button>
				</div>
			</div>
		</form>
		
	</div>
	
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
	var acct = $('#acct').val();
	getAccountIncome(acct);
});
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

function getAccountIncome(acct){
	document.getElementById("income").innerHTML = '<i class="fa fa-spinner fa-spin  fa-fw"></i> loading...';
	document.getElementById("left").innerHTML = '<i class="fa fa-spinner fa-spin  fa-fw"></i> loading...';
	document.getElementById("right").innerHTML = '<i class="fa fa-spinner fa-spin  fa-fw"></i> loading...';
	try{
		$.ajax({
			type: "GET",
			url: "/acc/inc",
			data: {acct:acct},
			async: true,
			success:function(data) {
				document.getElementById("income").innerHTML =  ''+data.income;
				document.getElementById("left").innerHTML =  ''+data.left;
				document.getElementById("right").innerHTML =  ''+data.right;
			},
			error: function(data) {
				alert(data.statusText);
			}
		});
	}catch(err){
		alert(err.message);
	}
}	

</script>

@endsection