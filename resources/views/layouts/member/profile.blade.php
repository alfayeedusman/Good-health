@extends('layouts.member.app')
@section('title')
	Profile
@endsection
@section('content')

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
	<div class="col-lg-12" >
	<div class="row">
			<div class="col-md-4">
			<div class="card card-stats">
			<div class="card-body ">
				<p><strong>Profile Info</strong></p>
				<br>


				<form action="" method="post" novalidate="novalidate">
					<div class="form-group">
						<label for="username" class="control-label mb-1">Username</label>
						<input id="username" name="username" type="text" class="form-control border-gold" aria-required="true" aria-invalid="false" value="{{Auth::user()->username}}" readonly>
					</div>
					<div class="form-group">
						<label for="firstname" class="control-label mb-1">Firstname</label>
						<input id="firstname" name="firstname" type="text" class="form-control border-gold" aria-required="true" aria-invalid="false" value="{{Auth::user()->member->first_name}}" readonly>
					</div>
					<div class="form-group">
						<label for="lastname" class="control-label mb-1">Lastname</label>
						<input id="lastname" name="cc-payment" type="text" class="form-control border-gold" aria-required="true" aria-invalid="false" value="{{Auth::user()->member->last_name}}" readonly>
					</div>
				</form>
				<br>		
			</div>
			</div>			
			</div>
			<div class="col-md-4">
				<div class="card card-stats">
				<div class="card-body ">
				<p><strong>Encashment Details</strong></p>
				<br>
	
				<form method="POST" action="{{ route('profile.submit') }}" onsubmit="submit_btn.disabled = true; return true;">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="branch" class="control-label mb-1">Branch</label>
						<select class="form-control border-gold" name="branch" id="branch" >
							@if(Auth::user()->member->team=="MAIN")
							<option  value="SELECT">SELECT BRANCH</option>
							<option selected value="MAIN">Main Branch</option>
							@else
							<option  value="SELECT">SELECT BRANCH</option>
							<option  value="MAIN">Main Branch</option>
							@endif
							
						</select>  
					</div>
					<div>
						<button id="submit_btn" type="submit" class="btn btn-default btn-transparent btn-lg btn-block" style="color: white;">
							Update
						</button>
					</div>
				</form>
				<br>				
				</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card card-stats">
				<div class="card-body ">
				<p><strong>Security Password</strong></p>
				<br>
						<form method="POST" action="{{ route('security.submit') }}" onsubmit="submit_btn.disabled = true; return true;">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="current_password" class="control-label mb-1">Current Password</label>
								<input id="current_password" name="current_password" type="password" class="form-control border-gold" aria-required="true" aria-invalid="false"  required>
							</div>
							<div class="form-group">
								<label for="password" class="control-label mb-1">New Password</label>
								<input id="password" name="password" type="password" class="form-control border-gold" aria-required="true" aria-invalid="false" required>
							</div>
							<div class="form-group">
								<label for="password_confirmation" class="control-label mb-1">Confirm Password</label>
								<input id="password_confirmation" name="password_confirmation" type="password" class="form-control border-gold" aria-required="true" aria-invalid="false" required>
							</div>
							<div>
								<button id="submit_btn" type="submit" class="btn btn-default btn-transparent btn-lg btn-block" style="color: white;">
									Update
								</button>
							</div>
						</form>
						<br>
				</div>
				</div>
				
	
			</div>


			
</div>

	</div>

</div>
<div class="row m-t-25" >
	
</div>
@endsection
@section('script')
<script>
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#photo')
				.attr('src', e.target.result)
				.width(200)
				.height(200);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
</script>

@endsection