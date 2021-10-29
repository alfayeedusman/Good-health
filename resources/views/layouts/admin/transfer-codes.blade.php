@extends('layouts.admin.app')
@section('title')
	Dashboard
@endsection
@section('content')
 <div class="row">
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
	<div class="col-md-12">
		<h3>Transfer Codes</h3>
		<hr>
	</div>
	<div class="col-md-6">
		<form method="POST" action="{{ route('admin.transfer.codes.submit') }}" onsubmit="submit_btn.disabled = true; return true;">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="slot" class="control-label mb-1">Slot</label>
				<select class="form-control " name="slot" id="slot">
					<option value="SELECT">SELECT</option>
					<option value="PAID">PAID</option>	
				</select>
			</div>
			<div class="form-group">
				<label for="entry" class="control-label mb-1">Entry</label>
				<select class="form-control " name="entry" id="entry">
					<option value="SELECT">SELECT</option>
					<option value="1500">1500</option>	
				</select>
			</div>
			<div class="form-group">
				<label for="quantity" class="control-label mb-1">Quantity</label>
				<select class="form-control " name="quantity" id="quantity">
					@for($x=1;$x<1001;$x++)
						<option value="{{$x}}">{{$x}}</option>	
					@endfor
				</select>
			</div>
			<div class="form-group">
				<label for="username" class="control-label mb-1">Username</label>
				<input id="username" name="username" type="text" class="form-control" aria-required="true" aria-invalid="false"  >
			</div>
			<div class="form-group" >		
				<button type="button" class="btn btn-info btn-md" id="btn1" onclick="showSubmitBtn()">Transfer Code ?</button>
				<button type="button" class="btn btn-danger btn-md" id="btn2" style="display:none" onclick="hideSubmitBtn()">Cancel</button>
				<button type="submit" class="btn btn-info btn-md" id="submit_btn" style="display:none">Transfer Code</button>
			</div>
		</form>
	</div>
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<center>Availabe Codes</center>
			</div>
			<div class="panel-body">
				<center><h1>{{count($ePins)}}</h1></center>
			</div>
		</div>
	</div>
	<div class="col-md-12" >
	
	<hr>
	<h3>Transfer History</h3>
	<hr>
		<div class="table-responsive">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTable-members">
					<thead>
						<tr>
							<th style="width:5%">No</th>
							<th style="width:10%">Transfer by</th>
							<th style="width:10%">Transfer to</th>
							<th style="width:10%">Code</th>
							<th style="width:10%">Entry</th>
							<th style="width:5%">Points</th>
							<th style="width:5%">Slot</th>
							<th style="width:20%">Transfered date</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?>
						@foreach($transferCodes as $transfer)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>{{$transfer->transfer_byname}}</td>
							<td>{{$transfer->transfered_name}}</td>
							<td>{{$transfer->code}}</td>
							<td>{{$transfer->entry}}</td>
							<td>{{$transfer->points}}</td>
							<td>{{$transfer->slot}}</td>
							<td>{{$transfer->created_at}}</td>
							<td>
							<a  href="{{ route('admin.activation.codes', ['mid' => encryptor('encrypt', $transfer->transfer_to) ]) }}" class="btn btn-success btn-xs">view</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<br>
		<?php echo $transferCodes->appends(Input::except('page')); ?> 
	</div>
</div>
@endsection
@section('page-script')
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
</script>

@endsection