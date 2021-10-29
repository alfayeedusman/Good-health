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
									<th style="width:15%">Action</th>
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
									<td>
									<div id="div1{{$taplist->id}}">
									<button id="btnsetremove{{$taplist->id}}" class="btn btn-danger btn-xs" onclick="removeWinner({{$taplist->id}})" ><span id="spinloadremove{{$taplist->id}}"></span>Remove Winner</button>
									</div>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@else
				<center>
					<h2>No winner yet. You can manually add winners </h2>
					<h2>Or </h2>
					<h2>Generate Random Winners </h2>
					<br>
					<p>Select Number of Winners</p>
					<div class="col-md-4 col-md-offset-4 "> 
					<select class="form-control" id="num">
					 @for ($i = 1; $i < 101; $i++)
						<option value="{{ $i }}">{{ $i }}</option>
					@endfor
					</select>
					<br>
					<button id="btngenerate" class="btn btn-success btn-lg" onclick="generaterandom('{{encryptor('encrypt',$taplistid)}}')" ><span id="spinloadgenerate"></span>Generate Random Winners</button>
						
					</div>
					
								
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
								<th style="width:15%">Action</th>
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
								<td>
								<div id="div2{{$taplist->id}}">
								@if(checkIfWinner($taplist->id)=='true')
								<h5>Winner</h5>
								@else
								<button id="btnset{{$taplist->id}}" class="btn btn-danger btn-xs" onclick="setWinner({{$taplist->id}})" ><span id="spinload{{$taplist->id}}"></span>Set As Winner</button>
								@endif
								</div>
								</td>
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
		<button class="btn btn-danger btn-lg" data-dismiss="modal" >Close</button>
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
function setWinner(id){
	document.getElementById("spinload"+id).innerHTML = '<i style=" display: none ; " class="fa fa-spinner fa-spin fa-fw" ></i>';
	document.getElementById("msg").innerHTML = '';
	document.getElementById("btnset"+id).disabled = true;
	try{
		$.ajax({
			type: "POST",
			url: "{{ route('set.winner') }}",
			data: {id:id},
			async: true,
			success:function(data) {
				if(data.success=="true"){
					document.getElementById("btnset"+id).disabled = true;
					document.getElementById("div2"+id).innerHTML = '<h5>Winner</h5>';
					

				}else{
					document.getElementById("btnset"+id).disabled = false;
				}
				document.getElementById("msg").innerHTML = data.message;
				document.getElementById("spinload"+id).innerHTML = '';
			},
			error: function(data) {
				alert(JSON.stringify(data));
			}
		});
	}catch(err){

	}
}
function removeWinner(id){
	document.getElementById("spinloadremove"+id).innerHTML = '<i style=" display: none ; " class="fa fa-spinner fa-spin fa-fw" ></i>';
	document.getElementById("msg").innerHTML = '';
	document.getElementById("btnsetremove"+id).disabled = true;
	var tapid = $('#tapid').val();
	try{
		$.ajax({
			type: "POST",
			url: "{{ route('remove.winner') }}",
			data: {id:id},
			async: true,
			success:function(data) {
				if(data.success=="true"){
					document.getElementById("btnsetremove"+id).disabled = true;
					document.getElementById("div1"+id).innerHTML = '<h5>Removed. Please Refresh</h5>';
					//viewWinners(''+tapid);

				}else{
					document.getElementById("btnsetremove"+id).disabled = false;
				}
				document.getElementById("msg").innerHTML = data.message;
				document.getElementById("spinloadremove"+id).innerHTML = '';
			},
			error: function(data) {
				alert(JSON.stringify(data));
			}
		});
	}catch(err){

	}
}
function generaterandom(id){

	document.getElementById("spinloadgenerate").innerHTML = '<i style=" display: none ; " class="fa fa-spinner fa-spin fa-fw" ></i>';
	document.getElementById("msg").innerHTML = '';
	document.getElementById("btngenerate").disabled = true;
	var tapid = $('#tapid').val();
	var num = $('#num').val();

	try{
		$.ajax({
			type: "POST",
			url: "{{ route('generate.winner') }}",
			data: {id:id,num:num},
			async: true,
			success:function(data) {
				if(data.success=="true"){
					document.getElementById("btngenerate").disabled = true;
					viewWinners(''+tapid);

				}else{
					document.getElementById("btngenerate").disabled = false;
				}
				document.getElementById("msg").innerHTML = data.message;
				document.getElementById("spinloadgenerate").innerHTML = '';
			},
			error: function(data) {
				alert(JSON.stringify(data));
			}
		});
	}catch(err){

	}
}
</script>