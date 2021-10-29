@extends('layouts.admin.app')

@section('title')
	Activation Codes
@endsection
@section('content')

<div class="row">
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
		<h3>Activation Codes</h3>
		<hr>

		
		<div class="col-md-6" >
			<form  class="form-header" role="form" method="GET" action="{{ route('admin.activation.codes') }}" onsubmit="submit_btn2.disabled = true; return true;" >
			<div class="col-md-2" style="padding:0px;">	
			<p>entry</p>
			<select class="form-control " name="entry" id="entry">
				@if(isset($_GET['entry']))
					@if($_GET['entry']=='DIAMOND')
						<option selected value="DIAMOND">DIAMOND</option>	
						<option value="GOLD">GOLD</option>	
						<option value="SILVER">SILVER</option>
					@elseif($_GET['entry']=='GOLD')
						<option value="DIAMOND">DIAMOND</option>	
						<option selected value="GOLD">GOLD</option>	
						<option value="SILVER">SILVER</option>
					@else
						<option value="DIAMOND">DIAMOND</option>	
						<option value="GOLD">GOLD</option>	
						<option selected value="SILVER">SILVER</option>
					@endif
				@else
					<option selected value="DIAMOND">DIAMOND</option>	
					<option value="GOLD">GOLD</option>	
					<option value="SILVER">SILVER</option>	
				@endif
			</select><br>
			</div>
			<div class="col-md-2" >	
			<p>slot</p>
			<select class="form-control " name="slot" id="slot">
				@if(isset($_GET['slot']))
					@if($_GET['slot']=='PAID')
					<option value="FREE">FREE</option>	
					<option selected value="PAID">PAID</option>
					@else
					<option selected value="FREE">FREE</option>	
					<option value="PAID">PAID</option>
					@endif
				@else
					<option selected value="FREE">FREE</option>	
					<option value="PAID">PAID</option>
				@endif
						
			</select><br>	
			</div>
			<div class="col-md-2" >	
			<p>status</p>
			<select class="form-control " name="status" id="status">
				@if(isset($_GET['status']))
					@if($_GET['status']=='USED')
					<option selected value="USED">USED</option>	
					<option value="UNUSED">UNUSED</option>	
					@else
					<option value="USED">USED</option>	
					<option selected value="UNUSED">UNUSED</option>	
					@endif
				@else
					<option selected value="USED">USED</option>	
					<option value="UNUSED">UNUSED</option>	
				@endif
					
			</select><br>	
			</div>
			<div class="col-md-2" >	
			<p>filter</p>
			<button type="submit" class="btn btn-warning" id="submit_btn2" type="button">filter</button>
			<br><br>
			</div>	
			</form>

		<br>
		</div>
		<div class="col-md-6" >
	
			<br>
				<div class="row" >
					<form  class="form-header" role="form" method="POST" action="{{ route('admin.activation.codes.submit') }}" onsubmit="submit_btn2.disabled = true; return true;" >	 {{ csrf_field() }}
						<div class="col-md-2" >		
						<p>1st code</p>	
						<input type="text" class="form-control"  name="code" id="code" placeholder="" required><br>
						</div>
						<div class="col-md-2" >	
						<p>qty</p>
						<input type="text" class="form-control"  name="qty" id="qty" placeholder=""  required><br>
						</div>
						<div class="col-md-2" >	
						<p>entry</p>
						<select class="form-control " name="entry" id="quantity">
								<option value="DIAMOND">DIAMOND</option>	
								<option value="GOLD">GOLD</option>	
								<option value="SILVER">SILVER</option>	
						</select><br>
						</div>
						<div class="col-md-2" >	
						<p>slot</p>
						<select class="form-control " name="slot" id="slot">
								<option value="FREE">FREE</option>	
								<option value="PAID">PAID</option>	
						</select><br>	
						</div>

						<div class="col-md-2" >	
						<p>generate</p>
						<button type="submit" class="btn btn-danger" id="submit_btn2" type="button">Generate</button>
						</div>
					</form>
					<br><br>
				</div>
		
			<br>
		
		</div>
		<div class="col-md-12" >
				<div class="table-responsive">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" id="dataTable-codes">
							<thead>
								<tr>
									<th style="width:5%">No</th>
									<th style="width:10%">Code</th>
									<th style="width:10%">Entry</th>
									<th style="width:5%">Slot</th>
									<th style="width:10%">Status</th>
									<th style="width:10%">Used by</th>
									<th style="width:10%">Used date</th>
									
									
								</tr>
							</thead>
							<tbody>
								<?php  $count = 1; ?>
								@foreach($ePins as $epin)
								<tr class="odd gradeX">
									<td>{{$count++}}</td>
									<td>{{$epin->code}}</td>
									<td>{{$epin->entry}}</td>
									<td>{{$epin->slot}}</td>
									<td>{{$epin->status}}</td>
									<td>{{$epin->used_by_username}}</td>
									<td>{{$epin->used_at}}</td>
									

								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				@if(count($ePins)>0)
				<?php echo $ePins->appends(Input::except('page')); ?> 
				<p>
				Showing {{($ePins->currentpage()-1)*$ePins->perpage()+1}} to
					@if(($ePins->currentpage()*$ePins->perpage())<$ePins->total())
						{{$ePins->currentpage()*$ePins->perpage()}}
					@else
						{{$ePins->total()}}
					@endif
				of  {{$ePins->total()}} items
				</p>
				@endif
		</div>	

</div>
</div>
@endsection


@section('page-script')	
<script>	
$(document).ready(function() {   
$('#dataTable-codes').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
});

function showSubmitBtn(id){ 
	$('#btn1'+id).hide();
	$('#btn2'+id).show();
	$('#submit_btn'+id).show();
}
function hideSubmitBtn(id){
	$('#btn1'+id).show();
	$('#btn2'+id).hide();
	$('#submit_btn'+id).hide();
}	
function showSubmitBtns(id){ 

	$('#btn1s'+id).hide();
	$('#btn2s'+id).show();
	$('#submit_btns'+id).show();
}
function hideSubmitBtns(id){
	$('#btn1s'+id).show();
	$('#btn2s'+id).hide();
	$('#submit_btns'+id).hide();
}
</script>
@endsection