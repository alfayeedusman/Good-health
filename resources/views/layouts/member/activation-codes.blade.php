@extends('layouts.member.app')
@section('title')
	Activation Codes
@endsection
@section('style')

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
	</div>
	<div class="col-lg-3">
	<div class="card card-stats">
	<div class="card-body ">
			<p><strong>Available Code</strong>( {{count($ePins)}} )</p>

				<form method="POST" action="{{ route('activation-codes.submit') }}" onsubmit="submit_btn.disabled = true; return true;">
				{{ csrf_field() }}
					<div class="form-group">
						<select class="form-control border-gold" name="activation_code" id="activation_code" >
							@foreach($ePins as $ePin)
								<option value="{{$ePin->code}}">Code: {{$ePin->code}} - Entry: {{$ePin->entry}} - Point/s: {{$ePin->points}} - Slot: {{$ePin->slot}}</option>
							@endforeach

						</select>
					</div>
					<div class="form-group">
						<label for="slot" class="control-label mb-1">Slot</label>
						<select class="form-control border-gold" name="slot" id="slot"  >
							<option value="SELECT">SELECT</option>
							<option value="PAID">PAID</option>	
						</select>
					</div>
					<div class="form-group">
						<label for="entry" class="control-label mb-1">Entry</label>
						<select class="form-control border-gold" name="entry" id="entry" >
							<option value="SELECT">SELECT</option>
							<option value="1500">1500</option>	
	
						</select>
					</div>
					<div class="form-group">
						<label for="quantity" class="control-label mb-1">Quantity</label>
						<select class="form-control border-gold" name="quantity" id="quantity">
							@for($x=1;$x<51;$x++)
								<option value="{{$x}}">{{$x}}</option>	
							@endfor
						</select>
					</div>
					
					<div class="form-group">
						<label for="username" class="control-label mb-1">Transfer to (Username)</label>
						<input id="username" name="username" type="text" class="form-control border-gold" aria-required="true" aria-invalid="false"  >
					</div>
					<div class="form-group">
						<label for="pin" class="control-label mb-1">Pin</label>
						<input id="pin" name="pin" placeholder="" type="text" class="form-control border-gold" aria-required="true" aria-invalid="false"  required>
					</div>
					<div class="form-group" >		
						<button type="button"  class="btn btn-default btn-transparent btn-lg btn-block" id="btn1" onclick="showSubmitBtn()">Transfer Code ?</button>
						<button type="button"  class="btn btn-danger btn-transparent btn-lg btn-block" id="btn2" style="display:none" onclick="hideSubmitBtn()">Cancel</button>
						<button type="submit"  class="btn btn-default btn-transparent btn-lg btn-block" id="submit_btn" style="display:none; ">Transfer Code</button>
					</div>
				</form>
	</div>
	</div>	
	</div>
	<div class="col-md-9" >
	<div class="card card-stats">
	<div class="card-body ">
	<p><strong>History</strong></p>

		<div class="table-responsive">
			<div class="dataTable_wrapper">
				<table class="table table-bordered table-striped mb-0">
					<thead >
						<tr>
							<th style="width:5%;">No</th>
							<th style="width:10%;">Transfer by</th>
							<th style="width:10%;">Transfer to</th>
							<th style="width:10%;">Code</th>
							<th style="width:10%;">Entry</th>
							<th style="width:5%;">Slot</th>
							<th style="width:20%;">Transfered date</th>
						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?> 
						@foreach($transferCodes as $transfer)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>{{$transfer->transfer_byname}}</td>
							<td>{{$transfer->transfered_name}}</td>
							<td>{{$transfer->code}}</td>
							<td>{{$transfer->entry}}</td>
							<td>{{$transfer->slot}}</td>
							<td>{{$transfer->created_at}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<br>
	</div>
	</div>	
	</div>
	
</div>
<div class="row m-t-25" >
	
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