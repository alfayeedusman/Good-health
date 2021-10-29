@extends('layouts.admin.app')
@section('title')
	Member Info
@endsection
@section('content')

  <div class="row">
	<div class="col-lg-12">
	@if (Session::has('success-message'))
		<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong><br>
				<p>{{ Session::get('success-message') }}</p>
		</div>
	@elseif (Session::has('error-message'))
		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Something went wrong!</strong><br>
				<p>{{ Session::get('error-message') }}</p>
		</div>
	@endif
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
	</div>
    <div class="col-lg-4">
		<h3>Info</h3>
		<form action="" method="post" novalidate="novalidate">
			<div class="form-group">
				<label for="username" class="control-label mb-1">Username</label>
				<input id="username" name="username" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$member[0]->username}}" readonly>
			</div>
			<div class="form-group">
				<label for="firstname" class="control-label mb-1">Firstname</label>
				<input id="firstname" name="firstname" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$member[0]->first_name}}" readonly>
			</div>
			<div class="form-group">
				<label for="lastname" class="control-label mb-1">Lastname</label>
				<input id="lastname" name="cc-payment" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$member[0]->last_name}}" readonly>
			</div>
			<div class="form-group">
				<label for="email" class="control-label mb-1">Email</label>
				<input id="email" name="email" type="email" class="form-control" aria-required="true" aria-invalid="false" value="{{$member[0]->email}}" readonly>
			</div>
		</form>
		<form method="POST" action="{{ route('admin.profile.submit', ['id' => encryptor('encrypt', $member[0]->id ) ]) }}" onsubmit="submit_btn.disabled = true; return true;">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="mobile" class="control-label mb-1">Mobile</label>
				<input id="mobile" name="mobile" type="number" class="form-control" aria-required="true" aria-invalid="false" value="{{$member[0]->mobile}}" required>
			</div>
			<div class="form-group">
				<label for="address" class="control-label mb-1">Address</label>
				<textarea name="address" id="address" rows="6"  class="form-control" required>{{$member[0]->address}}</textarea>
			</div>
			<div>
				<button id="submit_btn" type="submit" class="btn btn-lg btn-info btn-block">
					Password Update
				</button>
			</div>
		</form>
	</div>
	<div class="col-lg-4">
		<h3>Security</h3>
		<form method="POST" action="{{ route('admin.security.submit', ['id' => encryptor('encrypt', $member[0]->user_id ) ]) }}" onsubmit="submit_btn1.disabled = true; return true;">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="password" class="control-label mb-1">New Password</label>
				<input id="password" name="password" type="password" class="form-control" aria-required="true" aria-invalid="false" required>
			</div>
			<div class="form-group">
				<label for="password_confirmation" class="control-label mb-1">Confirm Password</label>
				<input id="password_confirmation" name="password_confirmation" type="password" class="form-control" aria-required="true" aria-invalid="false" required>
			</div>
			<div>
				<button id="submit_btn1" type="submit" class="btn btn-lg btn-info btn-block">
					Pin Update
				</button>
			</div>
		</form>
		<hr>
		<form method="POST" action="{{ route('admin.security-pin.submit', ['id' => encryptor('encrypt', $member[0]->user_id ) ]) }}" onsubmit="submit_btn2.disabled = true; return true;">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="new_pin" class="control-label mb-1">New Pin</label>
				<input id="new_pin" name="new_pin" type="password" class="form-control" aria-required="true" aria-invalid="false" required>
			</div>
			<div class="form-group">
				<label for="confirm_pin" class="control-label mb-1">Confirm Pin</label>
				<input id="confirm_pin" name="confirm_pin" type="password" class="form-control" aria-required="true" aria-invalid="false" required>
			</div>
			<div>
				<button id="submit_btn2" type="submit" class="btn btn-lg btn-info btn-block">
					Update
				</button>
			</div>
		</form>
	</div>
	<div class="col-lg-4">
		<h3>Login Status</h3>
		<form method="POST" action="{{ route('admin.profile-status.submit', ['id' => encryptor('encrypt', $member[0]->user_id ) ]) }}" onsubmit="submit_btn3.disabled = true; return true;">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="login_status" class="control-label mb-1">Login Status</label>
				<select class="form-control " name="login_status" id="login_status" >
					@if($member[0]->user->login_status=="ACTIVE")
						<option selected value="ACTIVE">ACTIVE</option>
						<option value="INACTIVE">INACTIVE</option>		
						<option value="BANNED">BANNED</option>
						<option value="DEACTIVATED">DEACTIVATED</option>	
					@elseif($member[0]->user->login_status=="INACTIVE")
						<option value="ACTIVE">ACTIVE</option>
						<option selected value="INACTIVE">INACTIVE</option>		
						<option value="BANNED">BANNED</option>
						<option value="DEACTIVATED">DEACTIVATED</option>
					@elseif($member[0]->user->login_status=="BANNED")
						<option value="ACTIVE">ACTIVE</option>
						<option value="INACTIVE">INACTIVE</option>		
						<option selected value="BANNED">BANNED</option>
						<option value="DEACTIVATED">DEACTIVATED</option>
					@elseif($member[0]->user->login_status=="DEACTIVATED")
						<option value="ACTIVE">ACTIVE</option>
						<option value="INACTIVE">INACTIVE</option>		
						<option value="BANNED">BANNED</option>
						<option selected value="DEACTIVATED">DEACTIVATED</option>
					@endif
					
											
				</select>
			</div>
			<div class="form-group">
				<label for="remarks" class="control-label mb-1">Remarks</label>
				<textarea name="remarks" id="remarks" rows="6"  class="form-control" required>{{$member[0]->user->login_remarks}}</textarea>
			</div>
			<div>
				<button id="submit_btn3" type="submit" class="btn btn-lg btn-info btn-block">
					Log Status Update
				</button>
			</div>
		</form>
		
	</div>
  </div>
@endsection
@section('script')
<script>

</script>

@endsection
