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
	</div>
	<div class="col-lg-12" >
		<div class="row" >
		
						<div class="col-lg-3" >
						<div class="card card-stats">
						<div class="card-body ">
					
									<form  class="form-header" role="form" method="POST" action="{{ route('unilevel.submit') }}" onsubmit="submit_btn.disabled = true; return true;" >
										<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
										<div class="form-group col-md-12" style="padding:0px;">

											<!--<div class="form-group col-md-12" style="padding:0px;">
											<label for="account_qty" class="control-label mb-1">number of account</label>
												<select class="form-control border-gold" name="account_qty" id="account_qty" >
														<option value="1">1</option>								
												</select>
											</div>-->


											<label for="code" class="control-label mb-1">Select Account</label>
											<div class="form-group col-md-12" style="padding:0px;">
												@if(count($accounts) > 0)
												<select class="form-control input-lg"  name="account_name" id="account_name" onchange="selectAccount(this.value)">
													@foreach($accounts as $acc)
														<option <?php if(isset($_GET['account_name'])){if($acc->account_name==$_GET['account_name']){ echo "selected";  $selectedAccount = $acc->account_name; }} ?> value="{{$acc->account_name}}" >{{$acc->account_name}}</option>
													@endforeach
												</select> 
												@else
													<select class="form-control col-md-6  input-lg" name="account_name" id="account_name">
														<option value="SELECT">NO ACCOUNT</option>
													</select> 
												@endif
											</div>
											<label for="code" class="control-label mb-1">Code</label>
											<div class="form-group col-md-12" style="padding:0px;">
												<input class="form-control input-md border-gold" name="code" id="code" type="text" placeholder="" value="{{Request::old('code')}}" required>
											</div>
											<br>
											<div class="form-group col-md-12" style="padding:0px;">		
											  <button type="button" class="btn btn-default btn-transparent btn-lg btn-block" style="  border: 1px solid #fff;" id="btn1" onclick="showSubmitBtn()" >Activate ?</button>
											  <button type="button" class="btn btn-danger btn-transparent btn-lg btn-block" id="btn2" style="display:none;  " onclick="hideSubmitBtn()">Cancel</button>
											  <button type="submit" class="btn btn-default btn-transparent btn-lg btn-block" id="submit_btn"  style=" display:none">Activate</button>
											</div>
										</div>
									</form>
						</div>
						</div>
						</div>
						<div class="col-lg-9" >
						<div class="card card-stats">
						<div class="card-body ">
							<p><strong>Accounts</strong></p>
							<div class="table-responsive m-b-30">
								<table class="table table-bordered table-striped mb-0">
									<thead >
										<tr>
											<th style="width:5%; font-size: 14px;">No</th>
											<th style="width:15%; font-size: 14px;">Name</th>
											<th style="width:10%; font-size: 14px;">Entry</th>
											<th style="width:10%; font-size: 14px;">Slot</th>
											<th style="width:15%; font-size: 14px;">Sponsor</th>
											<th style="width:10%; font-size: 14px;">Current Points</th>
											<th style="width:10%; font-size: 14px;">Current Unilevel</th>
											<th style="width:30%; font-size: 14px;" class="text-right">Updated Since</th>
										</tr>
									</thead>
									<tbody>
										<?php $x=1; ?>
										@foreach($accounts as $acc)
										<tr>
											<td style="font-size: 14px;">{{$x++}}</td>
											<td style="font-size: 14px;">{{$acc->account_name}}</td>
											<td style="font-size: 14px;">{{$acc->entry}}</td>
											<td style="font-size: 14px;">
												@if($acc->slot=='PAID')
													PD
												@else
													FR
												@endif
											</td>
											<td style="font-size: 14px;">{{$acc->account_sponsor}}</td>
											<td style="font-size: 14px;"><strong style="font-size: 20px;">{{$acc->product_points}}</strong> / 500</td>
											<td style="font-size: 14px;">{{$acc->unilevel}}</td>
											<td class="text-right" style="font-size: 14px;">
												{{$acc->product_points_date}}
											</td>
										</tr>
										@endforeach
									  
									</tbody>
								</table>
                            </div>
							<br>
						</div>
						</div>
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