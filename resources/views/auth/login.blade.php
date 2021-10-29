<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
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
			    <div class="col-md-12">

				    <center>
					<br>
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
					</center>

					<br>
					<div class="panel panel-default " style="padding:40px; border: 1px solid #000; z-index: 1; position:relative;">
						<div class="panel-body " >
							<center>
							<a href="/"><img src="{{ URL::asset('assets/logo.png') }}" alt="logo images" class="img-responsive" style="height:200px;"></a>
							<h3>
								<strong>LOGIN</strong>
							</h3>
							<br>
							</center>
							<form method="POST" action="{{ route('login.submit') }}" onsubmit="submit_btn.disabled = true; return true;">
							  {{ csrf_field() }}
								<div class="form-group">
									<input style="border: 1px solid #000;" class="form-control input-lg flat" type="text" name="username" placeholder="Username">
								</div>
								<div class="form-group">
									<input style="border: 1px solid #000;"  class="form-control input-lg flat" type="password" name="password" placeholder="Password">
								</div>
	
								<button type="submit" class="btn btn-default btn-lg btn-block flat"  style="background:#208000;">Submit</button>

		
								<br><br>
								<center>
								<div class="flex-col-c p-t-50 p-b-40">
									<span class="txt1 p-b-9">
										Don’t have an account?
									</span>
									<br>
									<h3><a href="/register" class="txt3" style="color:#134d00;">
										REGISTER NOW!
									</a></h3>
								</div>
								</center>
							</form>
						</div>
					  </div>
					
		    	</div>	
			</div>
			
			<div class="col-md-3">
			</div>
			<div class="col-md-12">
	
                <br><br><br>
               
            </div>
		</div>
	</div>
	

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
	<script>

	</script>
</body>
</html>