@extends('layouts.admin.app')
@section('title')
	Accounts
@endsection
@section('content')
 <div class="row">
	<div class="col-lg-12">
		<h3>Accounts</h3>
		<hr>
		
		<div class="col-md-12" >
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
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#list">Accounts List</a></li>

			</ul>

			<div class="tab-content">
				<div id="list" class="tab-pane fade in active">
					<br>
					
					<div class="col-md-4" >
						Search accounts here!
						<form  class="form-header" role="form" method="GET" action="{{ route('admin.accounts') }}" onsubmit="submit_btn.disabled = true; return true;" >			
						<div class="input-group" style="padding:0px;">
							<input type="text" class="form-control"  name="search" id="search" placeholder="Account Name" required>
							<span class="input-group-btn">Search accounts here!
							<button type="submit" class="btn btn-default" id="submit_btn" type="button">Search!</button>
							</span>
						</div>
						</form>
						<br>
					</div>

					<br>
					<div class="col-md-12" >
					<div class="table-responsive">
						<div class="dataTable_wrapper">
							<table class="table table-striped table-bordered table-hover" id="dataTable-accounts">
								<thead>
									<tr>
										<th style="width:5%">No</th>
										<th style="width:10%">Account Name</th>
										<th style="width:10%">Owner</th>
										<th style="width:10%">Placement</th>
										<th style="width:10%">Position</th>
										<th style="width:10%">Sponsor </th>
										<th style="width:10%">Entry </th>
										<th style="width:10%">Slot</th>
										<th style="width:20%">Created date</th>
										<th style="width:5%"></th>
									</tr>
								</thead>
								<tbody>
									<?php  $count = 1; ?>
									@foreach($accounts as $acc)
									<tr class="odd gradeX">
										<td>{{$count++}}</td>
										<td>{{$acc->account_name}}</td>
										<td>{{$acc->owner_username}}</td>
										<td>{{$acc->placement}}</td>
										<td>{{$acc->position}}</td>
										<td>{{$acc->account_sponsor}}</td>
										<td>{{$acc->entry}}</td>
										<td>{{$acc->slot}}</td>
										<td>{{$acc->created_at}}</td>
										<td>
										    <a  href="{{ route('admin.genealogy', ['account' => $acc->account_name ]) }}" class="btn btn-primary btn-xs">genealogy</a> 
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					</div>
					<br>
					<div class="col-md-12" >
					<?php echo $accounts->appends(Input::except('page')); ?> 
					<br><br><br>
					</div>
					
				</div>
			

			</div>

		
		</div>
</div>
@endsection
@section('page-script')
<script>
function showSubmitBtn(){
	$('#btn1').hide();
	$('#btn2').show();
	$('#submit_btns').show();
}
function hideSubmitBtn(){
	$('#btn1').show();
	$('#btn2').hide();
	$('#submit_btns').hide();
}

</script>
@endsection