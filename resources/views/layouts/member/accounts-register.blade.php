@extends('layouts.member.app')
@section('title')
	Accounts
@endsection

@section('content')

<div class="row m-t-25" >
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
	</div>
	<div class="col-lg-12" >
		<div class="row" >
						
						<div class="col-lg-4" >
							<form  class="form-header" role="form" method="POST" action="{{ route('add-register-accounts.submit') }}" onsubmit="submit_btn.disabled = true; return true;" >
							<div class="card card-stats">
								<div class="card-body ">
									<h3>For New Member </h3> <p>(leave this blank if you dont want to register new member)</p>
									<p>You must be 18 years old and above to fill up this information</p>
									<label for="code" class="control-label mb-1">Firstname</label>
									<div class="form-group col-md-12" style="padding:0px;">
										<input class="form-control input-md border-gold" name="first_name" id="code" type="first_name" placeholder="" value="{{Request::old('first_name')}}" >
									</div>
									<label for="code" class="control-label mb-1">Lastname</label>
									<div class="form-group col-md-12" style="padding:0px;">
										<input class="form-control input-md border-gold" name="last_name" id="last_name" type="text" placeholder="" value="{{Request::old('last_name')}}" >
									</div>
									<div class="form-group">
									<input style="border: 1px solid #000;" class="form-control input-lg flat" type="date" name="birthday" placeholder="Age" value="{{Request::old('birthday')}}">
								    </div>
									<label for="code" class="control-label mb-1">Username</label>
									<div class="form-group col-md-12" style="padding:0px;">
										<input class="form-control input-md border-gold" name="username" id="username" type="text" placeholder="" value="" >
									</div>
									<label for="code" class="control-label mb-1">Password</label>
									<div class="form-group col-md-12" style="padding:0px;">
										<input class="form-control input-md border-gold" name="password" id="password" type="password" placeholder="" value="" >
									</div>
									<label for="code" class="control-label mb-1">Confirm Password</label>
									<div class="form-group col-md-12" style="padding:0px;">
										<input class="form-control input-md border-gold" name="password_confirmation" id="password_confirmation" type="password" placeholder="" value="" >
									</div>	
									<br><br>
								</div>
							</div>
						</div>
						<div class="col-lg-4" >
							<div class="card card-stats">
								<div class="card-body ">
						
									
										<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
										<div class="form-group col-md-12" style="padding:0px;">

											@if(isset($_GET['upline'])&&isset($_GET['position']))
												<?php
													$upline = $_GET['upline']; 
													$position = $_GET['position']; 
												?>
											@else
												<?php
													$upline = ""; 
													$position = ""; 
												?>
											@endif

											

											<h3>Activation</h3>

											<label for="code" class="control-label mb-1">Code</label>
											<div class="form-group col-md-12" style="padding:0px;">
												<input class="form-control input-md border-gold" name="code" id="code" type="text" placeholder="" value="{{Request::old('code')}}" required>
											</div>
											<label for="sponsor" class="control-label mb-1">Sponsor</label>
											
											@if(count($accounts) > 0)	
											<div class="form-group col-md-12" style="padding:0px;">
											<select class="form-control border-gold"  name="sponsor" id="sponsor" >
												@foreach($accounts as $acc)
													<option  value="{{$acc->account_name}}" >{{$acc->account_name}} ( {{$acc->entry}} ) </option>
												@endforeach
											</select>
											</div> 
											@endif
										
											<label for="upline" class="control-label mb-1">Upline</label>
											<div class="form-group col-md-12" style="padding:0px;">
												<input class="form-control input-md border-gold" name="upline" id="upline" type="text" placeholder="" value="{{$upline}}" required readonly>
											</div>
											<label for="position" class="control-label mb-1">Position</label>
											<div class="form-group col-md-12" style="padding:0px;">
												<input class="form-control input-md border-gold" name="position" id="position" type="text" placeholder="" value="{{$position}}" required readonly>
											</div>
					
											<br>
											<div class="form-group col-md-12" style="padding:0px;">		
											  <button type="button" class="btn btn-default btn-transparent btn-lg btn-block" style="  border: 1px solid #fff;" id="btn1" onclick="showSubmitBtn()" >Activate ?</button>
											  <button type="button" class="btn btn-danger btn-transparent btn-lg btn-block" id="btn2" style="display:none;  " onclick="hideSubmitBtn()">Cancel</button>
											  <button type="submit" class="btn btn-default btn-transparent btn-lg btn-block" id="submit_btn"  style=" display:none">Activate</button>
											  <br><br>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						
						<div class="col-lg-4" >
						</div>

		</div>
	</div>
	
	
</div>

@endsection
@section('script')
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