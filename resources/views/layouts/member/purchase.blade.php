@extends('layouts.member.app')
@section('title')
	Purchases
@endsection
@section('style')

@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="overview-wrap">
			<h2 class="title-1" style="color:white;">Product Points</h2>
		</div>
	</div>
</div>	

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
	<div class="col-lg-12">
	
			<div class="row">
				<div class="col-md-6">
					
					<form method="POST" action="{{ route('purchases.submit') }}" onsubmit="submit_btn.disabled = true; return true;">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="action" class="control-label mb-1" id="action" >Select Action</label>
							<select class="form-control " name="action" id="action" style="height:35px;" onchange="showAction(this.value)" >
								<option value="TRANSFER">TRANSFER POINTS</option>	
								<option value="ACTIVATE">ACTIVATE POINTS</option>	
							</select>
						</div>
						<div class="form-group">
							<label for="points" class="control-label mb-1">Points</label>
							<input id="points" name="points" type="number" class="form-control" aria-required="true" aria-invalid="false"  >
						</div>
						<div class="form-group" id="userName">
							<label for="username" class="control-label mb-1" >Member Username</label>
							<input id="username" name="username" type="text" class="form-control" aria-required="true" aria-invalid="false"  >
						</div>
						<div class="form-group" style="display:none;" id="accName">
							<label for="account_name" class="control-label mb-1">Account Name</label>
							<input id="account_name" name="account_name" type="text" class="form-control" aria-required="true" aria-invalid="false"  >
						</div>
						<div class="form-group">
							<label for="pin" class="control-label mb-1">Pin</label>
							<input id="pin" name="pin" type="number" class="form-control" aria-required="true" aria-invalid="false"  >
						</div>
						<div class="form-group" >		
							<button type="button" class="btn btn-info btn-md" id="btn1" onclick="showSubmitBtn()">Save ?</button>
							<button type="button" class="btn btn-danger btn-md" id="btn2" style="display:none" onclick="hideSubmitBtn()">Cancel</button>
							<button type="submit" class="btn btn-info btn-md" id="submit_btn" style="display:none">Save</button>
						</div>
					</form>
				</div>
				<div class="col-md-6">
					<center>
						<h3 style="color:white;">Available Purchase Points</h3><br><br>
						<h1 style="color:white;">{{Auth::user()->member->available_prod_points}}</h1>
					</center>
				</div>
			
				<div class="col-md-12">
				<hr>
			
					<div id="purchaseDiv">
						<h3 style="color:white;">Purchase History</h3><br>
						<table class="table" id="dataTable-purchase">
							<thead>
								<tr>
									<th style="width:5%; font-size: 14px;">No</th>
									<th style="width:10%; font-size: 14px;">Username</th>
									<th style="width:20%; font-size: 14px;">Product</th>
									<th style="width:10%; font-size: 14px;">Qty</th>
									<th style="width:10%; font-size: 14px;">Total Points</th>
									<th style="width:20%; font-size: 14px;" class="text-right">Date</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								//$sponsorList = getSponsorsListings(Auth::user()->username); 
								$x=1;?>
								@foreach($purchase as $list)
								<tr>
									<td style="font-size: 14px;">{{$x++}}</td>
									<td style="font-size: 14px;">{{$list->member_username}}</td>
									<td style="font-size: 14px;">{{$list->product}}</td>
									<td style="font-size: 14px;">{{$list->qty}}</td>
									<td style="font-size: 14px;">{{$list->total_points}}</td>
									<td style="font-size: 14px;" class="text-right">{{$list->created_at}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<br><br>
						<h3 style="color:white;">Transfer/Activation History</h3><br>
						<table class="table" id="dataTable-transfer">
							<thead>
								<tr>
									<th style="width:5%; font-size: 14px;">No</th>
									<th style="width:30%; font-size: 14px;">Description</th>
									<th style="width:10%; font-size: 14px;">Action</th>
									<th style="width:10%; font-size: 14px;">Points</th>
									<th style="width:20%; font-size: 14px;" class="text-right">Date</th>
								</tr>
							</thead>
							<tbody>
							<? $x = 0; ?>
								@foreach($purchasePoints as $list)
								<tr>
									<td style="font-size: 14px;">{{$x++}}</td>
									<td style="font-size: 14px;">
									@if($list->action=="TRANSFER")
										@if($list->transfer_member_id==Auth::user()->member->id)
											You recieve {{$list->points}} purchase points from {{$list->member_username}}
										@else
											You transfer {{$list->points}} points to {{$list->transfer_member_username}}
										@endif
									@else
										@if($list->transfer_member_id==Auth::user()->member->id)
											Your account {{$list->activate_account_name}} recieve {{$list->points}} points from {{$list->member_username}}<br>
										@endif	
										@if($list->member_id==Auth::user()->member->id)
											You activate {{$list->points}} points to {{$list->activate_account_name}}
										@endif
									@endif
									</td>
									<td style="font-size: 14px;">{{$list->action}}</td>
									<td style="font-size: 14px;">{{$list->points}}</td>
									<td style="font-size: 14px;" class="text-right">{{$list->created_at}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
		
				</div>
			</div>	
	</div>
	
</div>

@endsection
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>

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
function showAction(act){
	$('#userName').hide();
	$('#accName').hide();
	if(act == 'TRANSFER'){
		$('#userName').show();
		$('#accName').hide();
	}else if(act == 'ACTIVATE'){
		$('#userName').hide();
		$('#accName').show();
	}
}

</script>

@endsection