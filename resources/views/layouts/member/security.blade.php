@extends('layouts.member.app')
@section('title')
	Security
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="overview-wrap">
			<h3 style="color: white;">Security Password</h3>
		</div>
	</div>
</div>	
<div class="row m-t-25" >
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

				<form method="POST" action="{{ route('security.submit') }}" onsubmit="submit_btn.disabled = true; return true;">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="current_password" class="control-label mb-1">Current Password</label>
						<input id="current_password" name="current_password" type="password" class="form-control" aria-required="true" aria-invalid="false"  required>
					</div>
					<div class="form-group">
						<label for="password" class="control-label mb-1">New Password</label>
						<input id="password" name="password" type="password" class="form-control" aria-required="true" aria-invalid="false" required>
					</div>
					<div class="form-group">
						<label for="password_confirmation" class="control-label mb-1">Confirm Password</label>
						<input id="password_confirmation" name="password_confirmation" type="password" class="form-control" aria-required="true" aria-invalid="false" required>
					</div>
					<div>
						<button id="submit_btn" type="submit" class="btn btn-default btn-transparent btn-lg btn-block" style="color: white; background:#b38f00;">
							Update
						</button>
					</div>
				</form>
		
	</div>
	<div class="col-md-12">
		<br>
		<h3 style="color:white;">Security Pin</h3>
		<br>
	</div>
	<div class="col-lg-4">

				<form method="POST" action="{{ route('security-pin.submit') }}" onsubmit="submit_btn2.disabled = true; return true;">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="current_pin" class="control-label mb-1">Current Pin</label>
						<input id="current_pin" name="current_pin" placeholder="'default pin is 1234'" type="password" class="form-control" aria-required="true" aria-invalid="false"  required>
					</div>
					<div class="form-group">
						<label for="new_pin" class="control-label mb-1">New Pin</label>
						<input id="new_pin" name="new_pin" type="password" class="form-control" aria-required="true" aria-invalid="false" required>
					</div>
					<div class="form-group">
						<label for="confirm_pin" class="control-label mb-1">Confirm Pin</label>
						<input id="confirm_pin" name="confirm_pin" type="password" class="form-control" aria-required="true" aria-invalid="false" required>
					</div>
					<div>
						<button id="submit_btn2" type="submit" class="btn btn-default btn-transparent btn-lg btn-block" style="color: white; background:#b38f00;">
							Update
						</button>
					</div>
				</form>

	</div>
</div>
<div class="row m-t-25" >
	
</div>
@endsection
@section('script')
<script>

</script>

@endsection