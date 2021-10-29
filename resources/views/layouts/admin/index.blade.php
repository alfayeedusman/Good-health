@extends('layouts.admin.app')
@section('title')
	Dashboard
@endsection
@section('content')
 <div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard</h1>
	</div>
	<?php
		$dateNow = getDatetimeNow();
		$dateToday = explode(" ",$dateNow);
	?>
	
	
	<br>
	<div class="col-lg-6">
			<table class="table">
				<?php

				?>
			  <tbody>
			    <tr>
			      <th>Total Members</th>
			      <td>{{getTotalRegisteredMembers()}}</td>
			    </tr>
			    <?php
			    $totalAccount = getTotalFreeAccounts() + getTotalPaidAccounts();
			    ?>
			    <tr>
			      <th>Total Accounts</th>
			      <td>{{$totalAccount}}</td>
			    </tr>
				<tr>
			      <th>Total Free Accounts</th>
			      <td>{{getTotalFreeAccounts()}}</td>
			    </tr>
			    <tr>
			      <th>DIAMOND</th>
			      <td>{{getTotalFreeAccountsDiamond()}}</td>
			    </tr>
			    <tr>
			      <th>GOLD</th>
			      <td>{{getTotalFreeAccountsGold()}}</td>
			    </tr>
			    <tr>
			      <th>SILVER</th>
			      <td>{{getTotalFreeAccountsSilver()}}</td>
			    </tr>
			    <tr>
			      <th>Total Paid Accounts</th>
			      <td>{{getTotalPaidAccounts()}}</td>
			    </tr>
			     <tr>
			      <th>DIAMOND</th>
			      <td>{{getTotalPaidAccountsDiamond()}}</td>
			    </tr>
			    <tr>
			      <th>GOLD</th>
			      <td>{{getTotalPaidAccountsGold()}}</td>
			    </tr>
			    <tr>
			      <th>SILVER</th>
			      <td>{{getTotalPaidAccountsSilver()}}</td>
			    </tr>
			  </tbody>
			</table>
			<br><br>
			<?php

			?>
	

			
	</div>		
	<div class="col-lg-6">
			<?php
					
			?>
			<table class="table">
			  <tbody>
			    <tr>
			      <th>TOTAL AVAILABLE ACTIVATION CODE PAID (UNUSED)</th>
			       <tr>
				      <th>DIAMOND</th>
				      <td>{{getAvailableActivationCodeDiamondPaid()}}</td>
				    </tr>
			        <tr>
				      <th>GOLD</th>
				      <td>{{getAvailableActivationCodeGoldPaid()}}</td>
				    </tr>
			        <tr>
				      <th>SILVER</th>
				      <td>{{getAvailableActivationCodeSilverPaid()}}</td>
				    </tr>
			    </tr>
			    <tr>
			      <th>TOTAL AVAILABLE ACTIVATION CODE FREE (UNUSED)</th>
			      <tr>
				      <th>DIAMOND</th>
				      <td>{{getAvailableActivationCodeDiamondFree()}}</td>
				    </tr>
			        <tr>
				      <th>GOLD</th>
				      <td>{{getAvailableActivationCodeGoldFree()}}</td>
				    </tr>
			        <tr>
				      <th>SILVER</th>
				      <td>{{getAvailableActivationCodeSilverFree()}}</td>
				    </tr>
			    </tr>
			    <tr>

			      <th><br></th>
			      <td><br></td>
			    </tr>
				
			  </tbody>
			</table>

			<table class="table">
			  <tbody>
			    <tr>
			      <th>Total Encashment</th>
			      <td></td>
			    </tr>
			    <tr>
			      <th>Pending</th>
			      <td>{{number_format(getTotalPendingEncashment(),2)}}</td>
			    </tr>
			    <tr>
			      <th>Paid</th>
			      <td>{{number_format(getTotalPaidEncashment(),2)}}</td>
			    </tr>
			    
			  </tbody>
			</table>
	</div>
	<div class="col-md-12" >	
			<div class="col-md-6" >
				<h3>Total Product Inventory ( UNUSED Unilevel Codes )</h3><br>
				<div class="table-responsive">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" id="dataTable-prodinv">
							<thead>
								<tr>
									<th style="width:5%">No</th>
									<th style="width:10%">Product</th>
									<th style="width:10%">Qty</th>
								</tr>
							</thead>
							<tbody>
								<?php  
								$count = 1;
								$prodInventory = getTotalProductInventory();
								?>
								@foreach($prodInventory as $prodInv)
								<tr>
									<td >{{$count++}}</th>
									<td >{{$prodInv->product}}</th>
									<td >{{$prodInv->total}}</th>
								</tr>
								@endforeach	
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-6" >
				<h3>Total Product Sales based in Unilevel Codes Used or Encoded by members</h3><br>
				<div class="table-responsive">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" id="dataTable-prodsales">
							<thead>
								<tr>
									<th style="width:5%">No</th>
									<th style="width:10%">Product</th>
									<th style="width:10%">Qty</th>
								</tr>
							</thead>
							<tbody>
								
								<?php  
								$count = 1;
								$prodInventoryUSED = getTotalProductInventoryUSED();
								?>
								@foreach($prodInventoryUSED as $prodInvUsed)
								<tr>
									<td >{{$count}}</th>
									<td >{{$prodInvUsed->product}}</th>
									<td >{{$prodInvUsed->total}}</th>
								</tr>
								@endforeach	
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-12" >
				<h3>Top 50 Top Earners (Based in Earnings)</h3>
				@if(isset($_GET['filter']))
					@if($_GET['filter']=="week")
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=lastweek" >Last Week</a>
					<a type="button" class="btn btn-primary btn-md " id="" href="/admin/dashboard?filter=week" >This Week</a>
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=month" >This Month</a>
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=lifetime" >Lifetime</a>
					@elseif($_GET['filter']=="lastweek")
					<a type="button" class="btn btn-primary btn-md " id="" href="/admin/dashboard?filter=lastweek" >Last Week</a>
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=week" >This Week</a>
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=month" >This Month</a>
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=lifetime" >Lifetime</a>
					@elseif($_GET['filter']=="month")
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=lastweek" >Last Week</a>
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=week" >This Week</a>
					<a type="button" class="btn btn-primary btn-md " id="" href="/admin/dashboard?filter=month" >This Month</a>
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=lifetime" >Lifetime</a>
					@elseif($_GET['filter']=="lifetime")
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=lastweek" >Last Week</a>
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=week" >This Week</a>
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=month" >This Month</a>
					<a type="button" class="btn btn-primary btn-md " id="" href="/admin/dashboard?filter=lifetime" >Lifetime</a>
					@endif
			
				@else
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=lastweek" >Last Week</a>
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=week" >This Week</a>
					<a type="button" class="btn btn-primary btn-md " id="" href="/admin/dashboard?filter=month" >This Month</a>
					<a type="button" class="btn btn-default btn-md " id="" href="/admin/dashboard?filter=lifetime" >Lifetime</a>
				@endif
				
				<br><br>OR<br><br>
				<form action="/admin/dashboard">
					<label for="date">Date From:</label>
					<input type="date" id="from" name="from">
					<label for="date">Date To:</label>
					<input type="date" id="to" name="to">
					<input type="submit">
				</form>
				<div class="table-responsive">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" id="dataTable-totalearnings2">
							<thead>
								<tr>
									<th style="width:5%">No</th>
									<th style="width:20%">Name</th>
									<th style="width:10%">Username</th>
									<th style="width:10%">Account</th>
									<th style="width:20%">Total Encashments</th>
								</tr>
							</thead>
							<tbody>
								<?php  $count = 1; ?>
							
								@foreach($topEncash as $earnings)
								<tr class="odd gradeX">
									<td>{{$count++}}</td>
									<td>{{getNameByUsername($earnings->username)}}</td>
									<td>{{$earnings->username}}</td>
									<td>{{$earnings->account_name}}</td>
									<td>{{$earnings->amount}}</td>
								</tr>
								@endforeach
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
	</div>
</div>
@endsection
@section('page-script')	
<script>
$(document).ready(function() {   
$('#dataTable-totalearnings').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
$('#dataTable-totalearnings2').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
});
$('#dataTable-prodinv').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
});
$('#dataTable-prodsales').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
});
</script>

@endsection