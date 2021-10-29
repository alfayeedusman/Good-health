@extends('layouts.admin.app')
@section('title')
	Share Links
@endsection
@section('content')
 <div class="row">
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
	</div>
	<div class="col-md-12">
		<h3>Share Links</h3>
		<hr>
	</div>
	<div class="col-md-6">
		<form method="POST" action="{{ route('admin.post.share.links') }}" onsubmit="submit_btn.disabled = true; return true;">
			{{ csrf_field() }}

	
			<div class="form-group">
				<label for="title" class="control-label mb-1">Title</label>
				<input id="title" name="title" type="text" class="form-control" aria-required="true" aria-invalid="false"  >
			</div>
			<div class="form-group">
				<label for="description" class="control-label mb-1">Description</label>
				<input id="description" name="description" type="text" class="form-control" aria-required="true" aria-invalid="false"  >
			</div>
			<div class="form-group">
				<label for="link" class="control-label mb-1">Link</label>
				<input id="link" name="link" type="text" class="form-control" aria-required="true" aria-invalid="false"  >
			</div>
			<div class="form-group" >		
				<button type="button" class="btn btn-info btn-md" id="btn1" onclick="showSubmitBtn()">Save ?</button>
				<button type="button" class="btn btn-danger btn-md" id="btn2" style="display:none" onclick="hideSubmitBtn()">Cancel</button>
				<button type="submit" class="btn btn-info btn-md" id="submit_btn" style="display:none">Save</button>
			</div>
		</form>
	</div>

	<div class="col-md-12" >
	
	<hr>
	<h3>Share Links</h3>
	<hr>
		<div class="table-responsive">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTable-members">
					<thead>
						<tr>
							<th style="width:5%">No</th>
							<th style="width:10%">Type</th>
							<th style="width:10%">Amount</th>
							<th style="width:10%">Account Name</th>
							<th style="width:10%"></th>

						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?>
						@foreach($shareLinks as $share)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>{{$share->title}}</td>
							<td>{{$share->description}}</td>
							<td>{{$share->link}}</td>
							<td>
							<a  href="{{ route('admin.links.delete', ['id' => encryptor('encrypt', $share->id ) ]) }}" class="btn btn-danger btn-xs">delete</a>
							</td>

						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<br>

	</div>
</div>
@endsection
@section('page-script')
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

function showSubmitBtn5(){
	$('#btn15').hide();
	$('#btn25').show();
	$('#submit_btn5').show();
}
function hideSubmitBtn5(){
	$('#btn15').show();
	$('#btn25').hide();
	$('#submit_btn5').hide();
}
</script>

@endsection