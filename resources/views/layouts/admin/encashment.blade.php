@extends('layouts.admin.app')
@section('title')
	Encashment
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
	<div class="col-md-12" >
	
	<hr>
	<h3>Encashment Points Value</h3>
	<hr>
	<a  href="{{ route('admin.encashments', ['status' => 'PENDING' ]) }}" class="btn btn-primary btn-md ">PENDING</a>
	<a  href="{{ route('admin.encashments', ['status' => 'PAID' ]) }}" class="btn btn-success btn-md ">PAID</a>
	<a  href="{{ route('admin.encashments', ['status' => 'CANCELLED' ]) }}" class="btn btn-danger btn-md ">CANCELLED</a>
	<a  href="{{ route('admin.encashments', ['status' => 'ALL' ]) }}" class="btn btn-default btn-md ">ALL</a>
	<br><br>
		<div class="table-responsive">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTable-encash">
					<thead>
						<tr>
							<th style="width:5%">No</th>
							<th style="width:10%">Name</th>
							<th style="width:10%">Member</th>
							<th style="width:10%">Account</th>
							<th style="width:10%">Amount</th>
							<th style="width:10%">MOP</th>
							<th style="width:30%">Details</th>
							<th style="width:5%">Status</th>
							<th style="width:5%">Team</th>
							<th style="width:20%">Date</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?>
						@foreach($encashment as $encash)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>
							{{$encash->member->first_name}} {{$encash->member->last_name}}
							</td>
							<td>
							{{$encash->member_username}}
							</td>
							<td>
							{{$encash->account_name}}
							</td>
							<td>
							<?php
							$amount = $encash->amount;
							$less = 50;
							$total = $amount - $less;
							?>
							{{$encash->amount}} less {{$less}}(fee) = <strong style="font-size: 20px;">{{$total}}</strong>
			
							</td>
							<td>{{$encash->member->mop}}</td>
							<td><small>{{$encash->member->details}}</small></td>
							<td>{{$encash->status}}</td>
							<td>{{$encash->member->team}} </td>
							<td>{{$encash->created_at}}</td>
							<td>
							<a  href="{{ route('admin.encashments.status', ['id' => encryptor('encrypt', $encash->id ),'status' => 'PENDING' ]) }}" class="btn btn-primary btn-xs btn-block">PENDING</a>
							<a  href="{{ route('admin.encashments.status', ['id' => encryptor('encrypt', $encash->id ),'status' => 'PAID' ]) }}" class="btn btn-success btn-xs btn-block">PAID</a>
							<a  href="{{ route('admin.encashments.status', ['id' => encryptor('encrypt', $encash->id ),'status' => 'CANCELLED' ]) }}" class="btn btn-danger btn-xs btn-block">CANCELLED</a>
							
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<br>
	
	</div>
</div>
@endsection
@section('page-script')
<script>
$(document).ready(function() {   
$('#dataTable-encash').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
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
</script>

@endsection