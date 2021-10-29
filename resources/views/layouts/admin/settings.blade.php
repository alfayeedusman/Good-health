@extends('layouts.admin.app')
@section('title')
	Accounts
@endsection
@section('content')
 <div class="row">
	<div class="col-lg-12">
		<h3>Settings</h3>
		<hr>
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
			

		<form  class="form-header" role="form" method="POST" action="{{ route('admin.settings.submit') }}" onsubmit="submit_btn.disabled = true; return true;" >
		<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
		<div class="col-md-4" >
			<div class="form-group " style="padding:0px;">
				<p>Enable / Disable Encashment
				<select  class="form-control " name="enableEncash" id="enableEncash" required>
					@if($settings->enableEncash=='false'||$settings->enableEncash==false)
					<option selected value="false">DISABLED</option>
					<option value="true">ENABLED</option>
					@else
					<option value="false">DISABLED</option>
					<option selected value="true">ENABLED</option>
					@endif
				</select>
				</p>

		</div>

		<div class="col-md-12" >
		<hr>
		</div>
		<div class="col-md-4 col-md-offset-8" >
			
			<button type="submit" class="btn btn-info btn-block btn-lg" id="submit_btn" >Save</button>		
		</div>
		</form>
		
		
		
		</div>
	</div>
</div>
@endsection
@section('page-script')
<script>
// $(document).ready(function() {   
// $('#dataTable-accounts').DataTable( {
	// dom: 'Bfrtip',
	// buttons: [
		// 'copy', 'csv', 'excel', 'pdf', 'print'
	// ]
// } );
// });

</script>
@endsection