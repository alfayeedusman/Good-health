<div class="row">
	<input type="hidden" value="{{encryptor('encrypt',$taplistid)}}" id="tapid"/>
	<div class="col-md-12">
		
		<center><h2>{{$taptitle}}</h2><hr><h4 id="msg" class="text-danger"></h4><br></center>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#winners">WINNERS</a></li>
			<li><a data-toggle="tab" href="#valid">INCLUDED/VALID TAPS</a></li>
		</ul>

		<div class="tab-content">
			<div id="winners" class="tab-pane fade in active">
				<center><h2 class="text-success">List of Winners <br> <small>( from 1st prize to last prize order )</small></h2><br></center>
				@if(count($tapWinner)>0)
					<div class="table-responsive">
						<table class="table" id="dataTable-winner">
							<thead>
								<tr>
									<th style="width:2%">No</th>
									<th style="width:10%">BID ID</th>
									<th style="width:10%">Tap ID</th>
									<th style="width:15%">Username</th>
								</tr>
							</thead>
							<tbody>
								<?php  $count = 1; ?>
								@foreach($tapWinner as $taplist)
								<tr class="odd gradeX">
									<td>{{$count++}}</td>
									<td>{{$taplist->bid_id}}</td>
									<td>{{$taplist->tap_id}}</td>
									<td>{{$taplist->username}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@else
				<center>
					<h2>No winner yet. </h2>			
				</center>
				@endif
				
			</div>
			<div id="valid" class="tab-pane fade in ">
				<center><h2 class="text-success">List of Valid Taps <br> <small>( from last tap to 1st tap order )</small></h2><br></center>
				<div class="table-responsive">
					<table class="table" id="dataTable-included">
						<thead>
							<tr>
								<th style="width:2%">No</th>
								<th style="width:10%">BID ID</th>
								<th style="width:10%">Tap ID</th>
								<th style="width:15%">Username</th>
								<th style="width:15%">Tap Coins</th>
								<th style="width:15%">Tap Date</th>
							</tr>
						</thead>
						<tbody>
							<?php  $count = 1; ?>
							@foreach($bid as $taplist)
							<tr class="odd gradeX">
								<td>{{$count++}}</td>
								<td>{{$taplist->id}}</td>
								<td>{{$taplist->tap_id}}</td>
								<td>{{$taplist->username}}</td>
								<td>{{$taplist->coins}}</td>
								<td>{{$taplist->created_at}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			
			</div>
		</div>
	
			
		
	</div>		
	<div class="col-md-12">
		<br><br><br><br><br><br>
		<button class="btn btn-danger btn-lg" data-dismiss="modal" onclick="playSoundCancel()">Close</button>
		<button class="btn btn-warning btn-lg" onclick="viewWinners('{{encryptor('encrypt',$taplistid)}}')"  >Refresh</button>
	</div>	
</div>
<script>
$(document).ready(function() {   
$('#dataTable-included').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
$('#dataTable-winner').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
});
</script>