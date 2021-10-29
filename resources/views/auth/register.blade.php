<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="_token" content="{!! csrf_token() !!}"/>
	<link rel="icon" type="image/png" href="{{ asset('assets/login/images/icons/favicon.ico') }}"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
	<link href="{{ asset('assets/ass/css/paper-dashboard.css?v=2.0.0') }}" rel="stylesheet" />
	
 	 
</head>
<style>
.flat{
	border-radius:0px;
}
</style>
	
<body >

  


	<div class="container">
	

						
		<br><br><br>
		<div class="row">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">
				
					<center>
					@if (Session::has('success-message'))
						<div class="alert alert-success">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Success!</strong><br>
								<p>{{ Session::get('success-message') }}</p>
						</div>

					@elseif (Session::has('success-message-with-account'))
						<div class="alert alert-success">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Success!</strong><br>
								<p>{{ Session::get('success-message-with-account') }}</p>
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
					
					</center> 
					
					<div class="panel panel-primary" style="padding:40px; border: 1px solid #000;">
						<div class="panel-body" >
							<center>
							<a href="/"><img src="{{ URL::asset('assets/logo.png') }}" alt="logo images" class="img-responsive" style="height:200px;"></a>
							<h3>
								<strong>Register</strong>

							</h3>
							</center>
							<form method="POST" action="{{ route('register.submit') }}" onsubmit="submit_btn.disabled = true; return true;">
							  {{ csrf_field() }}
								<div class="form-group">
								<h5>Info</h5>
								<p>You must be 18 years old and above to fill up this information</p>
									<input style="border: 1px solid #000;" class="form-control input-lg flat" type="text" name="first_name" placeholder="Firstname" value="{{Request::old('first_name')}}">
								</div>
								<div class="form-group">
									<input style="border: 1px solid #000;" class="form-control input-lg flat" type="text" name="last_name" placeholder="Lastname" value="{{Request::old('last_name')}}">
								</div>
								<div class="form-group">

									<input style="border: 1px solid #000;" class="form-control input-lg flat" type="date" name="birthday" placeholder="Birthday" value="{{Request::old('birthday')}}">
								</div>
								<!--<div class="form-group">
									<input style="border: 1px solid #000;" class="form-control input-lg flat" type="email" name="email" placeholder="Email" value="{{Request::old('email')}}">
								</div>-->

								<div class="form-group">
									<input style="border: 1px solid #000;" class="form-control input-lg flat" type="text" name="username" placeholder="Username" value="{{Request::old('username')}}">
								</div>
								<div class="form-group">
									<input style="border: 1px solid #000;" class="form-control input-lg flat"  type="password" name="password" placeholder="Password">
								</div>
								<div class="form-group">
									<input style="border: 1px solid #000;" class="form-control input-lg flat"   type="password" name="password_confirmation" placeholder="Confirm Password">
								</div>
								<?php
								$sponsorExist = false;
								$sponsor="";
								?>
								@if(isset($_GET['sponsor']))
									
									<?php
										$sponsor = $_GET['sponsor']; 
									?>
								@else
									<?php
										$sponsor = ""; 
									?>
								@endif
								<br>
								<div class="form-group">
									<h5>Activation  <small>( Leave blank if you want to activate later )</small></h5>
									<input style="border: 1px solid #000;" class="form-control input-lg flat"  type="text" name="code" placeholder="Code" value="" >
								</div>
								<div class="form-group">
									<input style="border: 1px solid #000;" class="form-control input-lg flat"  type="text" name="sponsor" placeholder="Sponsor" value="{{$sponsor}}" >
								</div>
								<div class="form-group">
									<input style="border: 1px solid #000;" class="form-control input-lg flat"  type="text" name="upline" placeholder="Upline" value="" >
								</div>
								<div class="form-group">
									<select style="border: 1px solid #000;" class="form-control input-lg" name="position" id="position">
										<option value="">Select Position</option>	
										<option value="LEFT">LEFT</option>	
										<option value="RIGHT">RIGHT</option>	
									</select>
								</div>
								
								<div >
									<span class="txt1 p-b-9">
										<br>
										<center>By clicking submit you agree to the Terms and Conditions.</center>
									</span>
								</div>
								
								<br>
									<button type="submit" class="btn btn-default btn-lg btn-block flat"  id="submit_btn" style="background:#208000;">Submit</button>

		
								<br>
								<div class="flex-col-c p-t-50 p-b-40">
									<center>
									<span class="txt1 p-b-9">
										Already have an account?
									</span>
									<br>
									<h3><a href="/login" class="txt3" style="color:#134d00;">
										LOG-IN NOW!
									</a>
									</center><h3>
								</div>
							</form>
						</div>
						
					</div>
					<br><br>	
			
			</div>
		
			<div class="col-md-12">
			    <center>
    			
                <br><br><br>
                </center>
            </div>
		</div>

	</div>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>

</body>
</html>