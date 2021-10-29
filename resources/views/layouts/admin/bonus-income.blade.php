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
		<h3>Bonus Income</h3>
		<hr>
	</div>
	<div class="col-md-6">
		<form method="POST" action="{{ route('admin.post.bonus.income') }}" onsubmit="submit_btn.disabled = true; return true;">
			{{ csrf_field() }}

			<h3 class="text-danger">Income Bonus Manual for single Accounts!!</h3>
			<div class="form-group">
				<label for="type" class="control-label mb-1">Income Type</label>
				<select class="form-control " name="type" id="type">
					<option value="REFERRAL">REFERRAL</option>
					<option value="BINARY">BINARY</option>	
					<option value="ACTIVATION-BONUS">ACTIVATION-BONUS</option>
					<option value="UPLINE-POOL-BONUS">UPLINE-POOL-BONUS</option>
					<option value="PRODUCT-POOL-BONUS">PRODUCT-POOL-BONUS</option>
					<option value="ROYALTY-POOL-BONUS">ROYALTY-POOL-BONUS</option>
					<option value="POSTING-ADS-BONUS">POSTING-ADS-BONUS</option>
					
				</select>
			</div>
			<div class="form-group">
				<label for="amount" class="control-label mb-1">Amount</label>
				<input id="amount" name="amount" type="number" class="form-control" aria-required="true" aria-invalid="false"  >
			</div>
			<div class="form-group">
				<label for="account_name" class="control-label mb-1">Account Name</label>
				<input id="account_name" name="account_name" type="text" class="form-control" aria-required="true" aria-invalid="false"  >
			</div>
			<div class="form-group">
				<label for="remarks" class="control-label mb-1">Remarks</label>
				<input id="remarks" name="remarks" type="text" class="form-control" aria-required="true" aria-invalid="false"  >
			</div>
			<div class="form-group" >		
				<button type="button" class="btn btn-info btn-md" id="btn1" onclick="showSubmitBtn()">Save ?</button>
				<button type="button" class="btn btn-danger btn-md" id="btn2" style="display:none" onclick="hideSubmitBtn()">Cancel</button>
				<button type="submit" class="btn btn-info btn-md" id="submit_btn" style="display:none">Save</button>
			</div>
		</form>
	</div>
	<div class="col-md-6">
		<form method="POST" action="{{ route('admin.post.bonus.income.product.pool') }}" onsubmit="submit_btn5.disabled = true; return true;">
			{{ csrf_field() }}
			<h3 class="text-danger">WARNING! For PRODUCT POOL BONUS Only.. MASS UPDATE!!</h3>
			<p>This will update or distribute PRODUCT POOL BONUSES/INCOME to all accounts..   </p>
			<div class="form-group">
				<label for="type" class="control-label mb-1">Income Type</label>
				<select class="form-control " name="type" id="type">
					<option value="PRODUCT-POOL-BONUS">PRODUCT-POOL-BONUS</option>	
				</select>
			</div>
			<div class="form-group">
				<label for="amount" class="control-label mb-1">Amount</label>
				<input id="amount" name="amount" type="number" class="form-control" aria-required="true" aria-invalid="false"  >
			</div>
			<div class="form-group" >		
				<button type="button" class="btn btn-info btn-md" id="btn15" onclick="showSubmitBtn5()">Save ?</button>
				<button type="button" class="btn btn-danger btn-md" id="btn25" style="display:none" onclick="hideSubmitBtn5()">Cancel</button>
				<button type="submit" class="btn btn-info btn-md" id="submit_btn5" style="display:none">Save</button>
			</div>
		</form>
	</div>
	<div class="col-md-12" >
	
	<hr>
	<h3>Bonus History</h3>
	<hr>
		<div class="table-responsive">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTable-members">
					<thead>
						<tr>
							<th style="width:5%">No</th>
							<th style="width:10%">Type</th>
							<th style="width:10%">Amount</th>
							<th style="width:10%">Account Name</th>
							<th style="width:20%">Remarks</th>
							<th style="width:10%">Update by</th>

						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?>
						@foreach($bonus as $bonuss)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>{{$bonuss->type}}</td>
							<td>{{$bonuss->amount}}</td>
							<td>{{$bonuss->account_name}}</td>
							<td>{{$bonuss->remarks}}</td>
							<td>{{$bonuss->updated_by_username}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<br>
		<?php echo $bonus->appends(Input::except('page')); ?> 
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

function showSubmitBtn5(){
	$('#btn15').hide();
	$('#btn25').show();
	$('#submit_btn5').show();
}
function hideSubmitBtn5(){
	$('#btn15').show();
	$('#btn25').hide();
	$('#submit_btn5').hide();
}
</script>

@endsection