@extends('layouts.member.app')
@section('title')
	Referrals
@endsection

@section('content')
<div class="row m-t-25" >
	<div class="col-lg-12">
		<div class="card card-stats">
		<div class="card-body ">
			<p><strong>Referrals</strong></p>
				<br>
			<div class="table-responsive m-b-30">
					<table class="table table-bordered table-striped mb-0">
						<thead >
							<tr>
								<th style="width:5%; font-size: 14px;">No</th>
								<th style="width:20%; font-size: 14px;">Name</th>
								<th style="width:20%; font-size: 14px;">Username</th>
								<th style="width:10%; font-size: 14px;">Accounts</th>
								<th style="width:10%; font-size: 14px;">Paid Accounts</th>
								<th style="width:20%; font-size: 14px;" >Date Activated</th>
								<th style="width:20%; font-size: 14px;" >Reg Date</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							//$sponsorList = getSponsorsListings(Auth::user()->username); 
							$x=1;?>
							@foreach($referrals as $list)
							<tr>
								<td style="font-size: 14px;">{{$x++}}</td>
								<td style="font-size: 14px;">{{$list->first_name}} {{$list->last_name}}</td>
								<td style="font-size: 14px;">{{$list->username}}</td>
								<td style="font-size: 14px;">{{$list->accounts}}</td>
								<td style="font-size: 14px;">{{$list->paid_accounts}}</td>
								<td style="font-size: 14px;">{{$list->activated_at}}</td>
								<td style="font-size: 14px;">{{$list->created_at}}</td>
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

@endsection
@section('script')

<script>

$(document).ready(function() {   


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