@extends('layouts.admin.app')
@section('title')
	Product Purchases
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
		<h3>Member Repeat Purchase</h3>
		<hr>
	</div>
	<div class="col-md-6">
		<form method="POST" action="{{ route('admin.purchases.submit') }}" onsubmit="submit_btn.disabled = true; return true;">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="product" class="control-label mb-1">Select Product</label>
				<select class="form-control " name="product" id="product">
					<option value="SELECT">SELECT</option>
					<option value="PURPLE CORN">PURPLE CORN</option>
					<option value="COFFEE">COFFEE</option>
					<option value="SOAP">SOAP</option>
				</select>
			</div>
			<div class="form-group">
				<label for="quantity" class="control-label mb-1">Points</label>
				<input id="quantity" name="quantity" type="number" class="form-control" aria-required="true" aria-invalid="false"  >
			</div>
			<div class="form-group">
				<label for="username" class="control-label mb-1">Member Username</label>
				<input id="username" name="username" type="text" class="form-control" aria-required="true" aria-invalid="false"  >
			</div>
			<div class="form-group" >		
				<button type="button" class="btn btn-info btn-md" id="btn1" onclick="showSubmitBtn()">Save Purchase ?</button>
				<button type="button" class="btn btn-danger btn-md" id="btn2" style="display:none" onclick="hideSubmitBtn()">Cancel</button>
				<button type="submit" class="btn btn-info btn-md" id="submit_btn" style="display:none">Save</button>
			</div>
		</form>
	</div>
	
	<div class="col-md-12" >
	
	<hr>
	<h3>Member Repeat Purchase History</h3>
	<hr>
		<div class="table-responsive">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTable-members">
					<thead>
						<tr>
							<th style="width:5%">No</th>
							<th style="width:15%">Member</th>
							<th style="width:15%">Product</th>
							<th style="width:5%">Points</th>
							<th style="width:5%">Qty</th>
							<th style="width:5%">Total Points</th>
							<th style="width:20%">Date</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?>
						@foreach($purchases as $purchase)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>{{$purchase->member_username}}</td>
							<td>{{$purchase->product}}</td>
							<td>{{$purchase->points}}</td>
							<td>{{$purchase->qty}}</td>
							<td>{{$purchase->total_points}}</td>
							<td>{{$purchase->created_at}}</td>
							<td>

							<a  href="{{ route('admin.purchases.delete', ['id' => encryptor('encrypt', $purchase->id ) ]) }}" class="btn btn-danger btn-xs">delete</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<br>
		<?php echo $purchases->appends(Input::except('page')); ?> 
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