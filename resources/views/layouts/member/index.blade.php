@extends('layouts.member.app')
@section('title')
	Dashboard
@endsection
@section('content')
<style>
.order-card {
    color: #fff;
}

.bg-c-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}

.bg-c-green {
    background: #208000; color:white;
}

.bg-c-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}

.bg-c-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}


.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.card .card-block {
    padding: 25px;
}

.order-card i {
    font-size: 26px;
}

.f-left {
    float: left;
}

.f-right {
    float: right;
}
</style>
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
	<?php
		$dateNow = getDatetimeNow();
		$dateToday = explode(" ",$dateNow);
		$dateYearMonthDay = explode("-",$dateToday[0]);

		$selectedAccount = "NO ACCOUNT";
		$selectedAccountID = "";
		$accountCount = 0;
		$accountPos = 0;

		$unilevel = 0;
		$product_points = 0;
		if(count($accounts) > 0){
			$selectedAccount = $accounts[0]->account_name;
			$selectedAccountID = $accounts[0]->id;
			$unilevel = $accounts[0]->unilevel;
			$product_points = $accounts[0]->product_points;
		}

	 	//$tree = App\Referral::orderBy('lvl','asc')->descendantsOf(183);
	 ?>


	
</div>		


<div class="row">
	
	<div class="col-md-12 ">
		<div class="row">
			<div class="col-12"><br><br>
			<center><h3>Welcome <strong style="color:#208000;">{{Auth::user()->username}} </strong>!!</h3></center>	
			</div>
			<div class="col-12 col-sm-12 col-md-4 col-lg-4">
			
			<h4>Account Dashboard</h4>	

			@if(count($accounts) > 0)	
			<br>
			<h5>Select Account</h5>	
			<select class="form-control border-gold"  onchange="selectAccount(this.value)">
				@foreach($accounts as $acc)
					<?php $accountCount++; ?>
					<option <?php if(isset($_GET['account_name'])){if($acc->account_name==$_GET['account_name']){ echo "selected";  $selectedAccount = $acc->account_name; $accountPos = $accountCount;  $unilevel = $acc->unilevel; $product_points = $acc->product_points; }} ?> value="{{$acc->account_name}}" >{{$acc->account_name}} ( {{$acc->entry}} ) </option>
				@endforeach
			</select> 
			@else
				<select class="form-control border-gold" >
					<option value="SELECT">NO ACCOUNT</option>
				</select> 
			@endif
			<input type="hidden" value="{{$selectedAccount}}" readonly></input>
			<br>
			</div>

			<div class="col-12 col-sm-12 col-md-4 col-lg-4">
				<br><br><br><br>
				<div class="card card-stats bg-c-green ">
				 <div class="card-header" style="border-bottom:2px solid black;"><h5><strong>Rank</strong> </h5></div>
				  <div class="card-body ">
						<center>
						<h5><strong>{{getTotalEncashmentOverAllRank(Auth::user()->username)}}</strong></h5>
						</center>
				  </div>
				</div>
			</div>	
			<div class="col-12 col-sm-12 col-md-4 col-lg-4">
			<h4>Referral Link</h4>	
				<div class="card card-stats">
					<div class="card-body ">
					<center>
					<h5>
					@if(count($accounts) > 0)	
					Link: <a style="color:#cca300;" href="https://<?php echo($_SERVER['HTTP_HOST']); ?>/register?sponsor={{Auth::user()->username}}">https://<?php echo($_SERVER['HTTP_HOST']); ?>/register?sponsor={{$selectedAccount}}</a>
					@else
						No Account
					@endif
					</h5>
					<center>
					</div>
				</div>
			</div>
			
			<div class="col-6 col-sm-6 col-md-4 col-lg-4">
				<div class="card card-stats bg-c-green ">
				 <div class="card-header" style="border-bottom:2px solid black;"><h5><strong>Sales Match Bonus</strong> </h5></div>
				  <div class="card-body ">
						<center>
						<h5><strong>&#8369; {{number_format(getTotalSalesMatchNotEncash(Auth::user()->username,$selectedAccount),2)}}</strong></h5>
						</center>
				  </div>
				</div>
			</div>
			<div class="col-6 col-sm-6 col-md-4 col-lg-4">
				<div class="card card-stats bg-c-green ">
				 <div class="card-header" style="border-bottom:2px solid black;"><h5><strong>Direct Referral Bonus</strong> </h5></div>
				  <div class="card-body ">
						<center>
						<h5><strong>&#8369; {{number_format(getTotalReferralIncomeNotEncash(Auth::user()->username,$selectedAccount),2)}}</strong></h5>
						</center>
				  </div>
				</div>
			</div>
			<div class="col-6 col-sm-6 col-md-4 col-lg-4">
				<div class="card card-stats bg-c-green ">
				 <div class="card-header" style="border-bottom:2px solid black;"><h5><strong>Direct Referral Bonus (GC)</strong> </h5></div>
				  <div class="card-body ">
						<center>
						<h5><strong>&#8369; {{number_format(getTotalReferralIncomeGC(Auth::user()->username,$selectedAccount),2)}}</strong></h5>
						</center>
						
				  </div>
				</div>
			</div>
			<div class="col-6 col-sm-6 col-md-4 col-lg-4">
				<div class="card card-stats bg-c-green ">
				 <div class="card-header" style="border-bottom:2px solid black;"><h5><strong>Indirect Referral Bonus</strong> </h5></div>
				  <div class="card-body ">
						<center>
						<h5><strong>&#8369; {{number_format(getTotalIndirectIncomeNotEncash(Auth::user()->username,$selectedAccount),2)}}</strong></h5>
						</center>
				  </div>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-4 col-lg-4">
				<div class="card card-stats bg-c-green ">
				 <div class="card-header" style="border-bottom:2px solid black;"><h5><strong>Unilevel Bonus</strong> </h5></div>
				  <div class="card-body ">
					<center>	
						<h5><strong>Current Unilevel: &#8369; {{number_format($unilevel,2)}}</strong></h5>
						<p>Monthly Maintenance: {{number_format($product_points,2)}} / {{number_format(500,2)}} POINTS</p>
						<a href="/unilevel-claim?account={{$selectedAccount}}" class="btn btn-primary btn-sm">move to wallet</a>
					</center>
						
				  </div>
				</div>
			</div>
			
			<div class="col-6 col-sm-6 col-md-4 col-lg-4">
				<div class="card card-stats bg-c-green ">
				 <div class="card-header" style="border-bottom:2px solid black;"><h5><strong>Leadership Bonus</strong> </h5></div>
				  <div class="card-body ">
						<center>
						<h5><strong>&#8369; {{number_format(getTotalLeadershipNotEncash(Auth::user()->username,$selectedAccount),2)}}</strong></h5>
						</center>
				  </div>
				</div>
			</div>
			<div class="col-6 col-sm-6 col-md-4 col-lg-4">
				<div class="card card-stats bg-c-green ">
				 <div class="card-header" style="border-bottom:2px solid black;"><h5><strong>5TH Cycle GC</strong> </h5></div>
				  <div class="card-body ">
						<center>
						<h5><strong>&#8369; {{number_format(getTotalAvailableGC(Auth::user()->username,$selectedAccount),2)}}</strong></h5>
						<a href="/encashments/gc" class="btn btn-primary btn-sm">withdraw</a>
						</center>
				  </div>
				</div>
			</div>
			<div class="col-6 col-sm-6 col-md-4 col-lg-4">
				<div class="card card-stats bg-c-green ">
				 <div class="card-header" style="border-bottom:2px solid black;"><h5><strong>Wallet</strong> </h5></div>
				  <div class="card-body ">
						<center>
						<h5><strong>&#8369; {{number_format(getTotalWallet(Auth::user()->username,$selectedAccount),2)}}</strong></h5>
						</center>
				  </div>
				</div>
			</div>
			<div class="col-6 col-sm-6 col-md-4 col-lg-4">
				<div class="card card-stats bg-c-green ">
				 <div class="card-header" style="border-bottom:2px solid black;"><h5><strong>Total Encashments</strong> </h5></div>
				  <div class="card-body ">
						<center>
						<h5><strong>&#8369; {{number_format(getTotalEncashment(Auth::user()->username,$selectedAccount),2)}}</strong></h5>
						</center>
				  </div>
				</div>
			</div>
			
			
			
				
		</div>
	</div>
	<div class="col-md-12">
		<style>
			.my-custom-scrollbar {
			position: relative;
			height: 500px;
			overflow: auto;
			}
			.table-wrapper-scroll-y {
			display: block;
			}
		</style>
		<?php

		$history = getIncomeHistory(Auth::user()->username,$selectedAccount);
		?>	
		<h4>Income History</h4>
		<div class="card card-stats">
			<div class="card-body ">
				<div class="table-wrapper-scroll-y my-custom-scrollbar">
			
				  <table class="table table-bordered table-striped mb-0">
					<thead>
					  <tr>
						
						<th scope="col" >Description</th>
						<th scope="col" ><center>Amount</center></th>
						<th scope="col" ><center>Date</center></th>
					  </tr>
					</thead>
					<tbody>
					@if(count($history)>0)
						@foreach($history as $his)
						  <tr>
							
							<td > {{$his->remarks}}</td>
							<td > <center>{{$his->amount}}</center> </td>
							<td > <center>{{$his->created_at}}</center> </td>
						  </tr>
						@endforeach
					@endif
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
function selectAccount(account_name){
	window.location = '?account_name='+account_name;
}

function showSubmitBtn3(){
	$('#btn13').hide();
	$('#btn23').show();
	$('#submit_btn3').show();
}
function hideSubmitBtn3(){
	$('#btn13').show();
	$('#btn23').hide();
	$('#submit_btn3').hide();
}
</script>

@endsection