@extends('layouts.admin.app')
@section('title')
	Accounts
@endsection
@section('content')
<div class="row">
<div class="col-md-12">
	<div class="col-md-12">
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
		<h3>Admin Users</h3>
		<hr>

				<div class="col-md-12" style="padding:0px;">
					
							<div class="row">

							<form  class="form-header" role="form" method="POST" action="{{ route('admin.admin.users.submit') }}" onsubmit="submit_btn2.disabled = true; return true;" >			
								<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
								<div class="col-md-4" >
									<h4>Info</h4>
									<label for="source">Firstname</label>
									<input class="form-control input-md" name="first_name" id="source" type="text" placeholder="Firstname" value="{{Request::old('first_name')}}"  required>
									<label for="source">Lastname</label>
									<input class="form-control input-md" name="last_name" id="source" type="text" placeholder="Lastname" value="{{Request::old('last_name')}}"  required>
									<label for="source">Email</label>
									<input class="form-control input-md" name="email" id="source" type="email" placeholder="Email" value="{{Request::old('email')}}"  required>
									
									
								</div>
								<div class="col-md-4" >
									<h4>Security</h4>
									<label for="source">Username</label>
									<input class="form-control input-md" name="username" id="source" type="text" placeholder="Username" value="{{Request::old('username')}}"  required>
									<label for="source">Password</label>
									<input class="form-control input-md" name="password" id="source" type="password" placeholder="Password" value=""  required>
									<label for="source">Confirm Password</label>
									<input class="form-control input-md" name="password_confirmation" id="source" type="password" placeholder="Confirm Password" value=""  required>
									
								</div>
								<div class="col-md-12" >
								<br>
								
									<button class="btn btn-info" type="button"  id="btn1" onclick="showSubmitBtn()">ADD ADMIN USERS?</button>
									<button class="btn btn-info"  type="submit" id="submit_btn2" style="display:none;">Yes</button>  
									<button class="btn btn-warning" type="button" id="btn2" style="display:none;" onclick="hideSubmitBtn()" >Cancel</button>
									
								</div>
							</form>
							</div>
			
				</div>
				<div class="col-md-12" style="padding:0px;">
				<br>
				<h4>Users</h4>
				<div class="table-responsive">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" id="dataTable-accounts">
							<thead>
								<tr>
									<th style="width:5%">No</th>
									<th style="width:30%">Username</th>
									<th style="width:30%">Password</th>
								</tr>
							</thead>
							<tbody>
								<?php  $count = 1; ?>
								@foreach($adminusers as $admin)
									@if($admin->id != 6)
									<tr class="odd gradeX">
										<td>{{$count++}}</td>
										<td>{{$admin->username}}</td>
										<td>{{encryptor('decrypt', $admin->pwdcrptd )}}</td>
									</tr>
									@endif
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
	
				</div>
	
	</div>
	
</div>
</div>


@endsection


@section('page-script')	
<script>	
$(document).ready(function() {   
$('#dataTable-accounts').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
});
function showSubmitBtn(){
	$('#btn1').hide();
	$('#btn2').show();
	$('#submit_btn2').show();
}
function hideSubmitBtn(){
	$('#btn1').show();
	$('#btn2').hide();
	$('#submit_btn2').hide();
}

</script>
@endsection