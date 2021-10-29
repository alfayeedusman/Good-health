@extends('admin.app')

@section('content')
<div class="row bg-title">
	<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
		<h4 class="page-title">Tap</h4> </div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
			</ol>
		</div>
</div>
<div class="row">

	<div class="col-md-12" style="padding:0px;">
		<a class="btn btn-primary" href="{{route('admin.tap.history', ['type' => 'joined'])}}">Joined</a>
		<a class="btn btn-info"  href="{{route('admin.tap.history', ['type' => 'tap'])}}" >Taps</a>  
		<hr>
		<div class="table-responsive">
		<table class="table" id="dataTable-joined">
			<thead>
				<tr>
					<th style="width:2%">No</th>
					<th style="width:10%">Img</th>
					<th style="width:30%">Member</th>
					<th style="width:10%">Tap Type</th>
					<th style="width:10%">Tap ID</th>
					<th style="width:10%">Coins</th>
					<th style="width:30%">Date</th>

				</tr>
			</thead>
			<tbody>
				<?php  $count = 1; ?>
				@foreach($tap as $taplist)
				<tr class="odd gradeX">
					<td>{{$count++}}</td>
					<td>
					<img src="{{ URL::asset(imagePathUser('assets/tap/'.$taplist->tap_id))}}" class="img-responsive"   style="height:30px; width:30px;">
					</td>
					<td>{{$taplist->username}}</td>
					<td>{{$taplist->type}}</td>
					<td>{{$taplist->tap_id}}</td>
					<td>{{$taplist->coins}}</td>
					<td>{{$taplist->created_at}}</td>
					

				</tr>
				@endforeach
			</tbody>
		</table>
		
		<br>
		<?php echo $tap->appends(Input::except('page')); ?> 
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {   
$('#dataTable-joined').DataTable( {
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
function showDiv(id){
	$('#divtap'+id).show();
}
function hideDiv(id){
	$('#divtap'+id).hide();
}	
</script>

@endsection