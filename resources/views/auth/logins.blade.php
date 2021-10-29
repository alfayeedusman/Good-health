@extends('layouts.app')
@section('title')
    Authentication
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
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
            <div class="panel panel-primary">
                <div class="panel-body">
			
                    <form class="form-horizontal" method="POST" action="{{ route('login.submit') }}" onsubmit="submit_btn.disabled = true; return true;" >
                        {{ csrf_field() }}
						<center><br><i id="taphand" class="far fa-hand-point-up fa-fw fa-4x hvr-pulse" onclick="playSound()"></i><br><h3>Yeheey! <br> Tap and Win</h3></center>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <div class="col-md-12">
								<p>Username</p>
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12">
								<p>Password</p>
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block" id="submit_btn" onclick="playSoundTap()">
                                    Login
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
