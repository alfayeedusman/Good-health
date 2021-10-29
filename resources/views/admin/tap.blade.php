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
		<button type="button" class="btn btn-info btn-lg" data-toggle="collapse" data-target="#addtap">Show/Hide Add Tap</button>
		<br><br>
		<div id="addtap" class="collapse">
			<form enctype="multipart/form-data" class="form-header" role="form" method="POST" action="{{ route('tap.donate') }}" onsubmit="submit_btn2.disabled = true; return true;" >			
				<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
				<div class="col-md-6" style="padding:0px;">
					<div class="col-md-12" style="padding:0px;">
						<label for="title">Title</label>
						<input class="form-control input-md" name="title" id="title" type="text" placeholder="Title" value="{{Request::old('title')}}"  required>
						<br>
					</div>
					<div class="col-md-6" style="padding:0px;">
						<label for="title">Minimum Coins</label>
						<input class="form-control input-md" name="minimum_coins" id="minimum_coins" type="number" placeholder="Minimum Points" value="{{Request::old('minimum_coins')}}"  required>
						<br>
					</div>
					<div class="col-md-6" style="padding:0px;">
						<label for="title">Coins Per Tap</label>
						<input class="form-control input-md" name="coins_per_tap" id="coins_per_tap" type="number" placeholder="Points Per Tap" value="{{Request::old('coins_per_tap')}}"  required>
						<br>
					</div>								
		
					<div class="col-md-12" style="padding:0px;">
						<label for="title">Image (best: 400x400 )</label>
						<input type="file" name="image" id="image"  required>
						<br>
					</div>
					<div class="col-md-12 " style="padding:0px;">
						<button class="btn btn-info" type="button"  id="btn1" onclick="showSubmitBtn()">ADD ?</button>
						<button class="btn btn-info"  type="submit" id="submit_btn2" style="display:none;">Yes</button>  
						<button class="btn btn-warning" type="button" id="btn2" style="display:none;" onclick="hideSubmitBtn()" >Cancel</button>
					<br><br><br>
					</div>	
				</div>
				<div class="col-md-6" >
					<div class="col-md-12" style="padding:0px;">
						<label for="description">Description</label>
						<div class="input-group">
							<textarea style="height:200px;width:280px;" class="form-control" rows="3" id="description" name="description" placeholder="Description" required>{{Request::old('description')}}</textarea>
						</div>
					</div>
					<br>
					
				</div>
			</form>
			
		</div>
		
	</div>
		
	<div class="col-md-12" style="padding:0px;">
	
		<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#started">STARTED</a></li>
				<li><a data-toggle="tab" href="#ready">READY TO START</a></li>
				<li><a data-toggle="tab" href="#pending">PENDING</a></li>
				<li><a data-toggle="tab" href="#ended">TAP ENDED</a></li>
		</ul>

		<div class="tab-content">
			<div id="started" class="tab-pane fade in active">
				<div class="table-responsive">
				<table class="table" id="dataTable-started">
					<thead>
						<tr>
							<th style="width:2%">No</th>
							<th style="width:2%">ID</th>
							<th style="width:10%">Img</th>
							<th style="width:30%">Title/Desc</th>
							<th style="width:5%">Min</th>
							<th style="width:5%">Per Tap</th>
							<th style="width:10%">Current Points</th>
							<th style="width:25%">Start Date</th>
							<th style="width:25%">End Date</th>
							<th style="width:5%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?>
						@foreach($tapStarted as $taplist)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>{{$taplist->id}}</td>
							<td>
							<img src="{{ URL::asset(imagePathUser('assets/tap/'.$taplist->id))}}" class="img-responsive"   style="height:50px; width:50px;">
							</td>
							<td>Title: {{$taplist->product_name}}<br>
							Description:<br>
							{{$taplist->description}}
							</td>
							<td>{{$taplist->minimum_coins}}</td>
							<td>{{$taplist->coins_per_tap}}</td>
							<td>
							<?php
							$bidTotals = getTotalBid($taplist->id);
							$joinedcoins = 0;
							foreach($bidTotals['bidderJoined'] as $bidderJoined){
								$joinedcoins = $joinedcoins + $bidderJoined->coins;
							}
							$joinedTap = 0;
							foreach($bidTotals['bidderTotal'] as $bidderJoined){
								$joinedTap = $joinedTap + $bidderJoined->coins;
							}
							?>
							JOINED: {{$joinedcoins}}<br>
							TAPS: {{$joinedTap}}
							</td>
							<td>{{$taplist->start_date}}</td>
							<td>{{$taplist->end_date}}</td>
							<td>
							<?php
							$datenow = new DateTime(getDatetimeNow());
							$end_date = new DateTime($taplist->end_date);
							$start_date = new DateTime($taplist->start_date);

							?>
				
								<span style="color:green;">TAP STARTED</span>
								<br>
								<a href="{{route('admin.tap.history')}}?type=joined&&tapid={{$taplist->id}}" class="btn btn-primary btn-xs" >participants</a>		
								<a href="{{route('admin.tap.history')}}?type=tap&&tapid={{$taplist->id}}" class="btn btn-warning btn-xs" >tap history</a>												
							
							</td>

						</tr>
						@endforeach
					</tbody>
				</table>
				</div>
			</div>
			<div id="ready" class="tab-pane fade">
				<div class="table-responsive">
				<table class="table" id="dataTable-ready">
					<thead>
						<tr>
							<th style="width:2%">No</th>
							<th style="width:2%">ID</th>
							<th style="width:10%">Img</th>
							<th style="width:30%">Title/Desc</th>
							<th style="width:5%">Min</th>
							<th style="width:5%">Per Tap</th>
							<th style="width:10%">Current Points</th>
							<th style="width:25%">Start Date</th>
							<th style="width:25%">End Date</th>
							<th style="width:5%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?>
						@foreach($tapReady as $taplist)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>{{$taplist->id}}</td>
							<td>
							<img src="{{ URL::asset(imagePathUser('assets/tap/'.$taplist->id))}}" class="img-responsive"   style="height:50px; width:50px;">
							</td>
							<td>Title: {{$taplist->product_name}}<br>
							Description:<br>
							{{$taplist->description}}
							</td>
							<td>{{$taplist->minimum_coins}}</td>
							<td>{{$taplist->coins_per_tap}}</td>
							<td>
							<?php
							$bidTotals = getTotalBid($taplist->id);
							$joinedcoins = 0;
							foreach($bidTotals['bidderJoined'] as $bidderJoined){
								$joinedcoins = $joinedcoins + $bidderJoined->coins;
							}
							$joinedTap = 0;
							foreach($bidTotals['bidderTotal'] as $bidderJoined){
								$joinedTap = $joinedTap + $bidderJoined->coins;
							}
							?>
							JOINED: {{$joinedcoins}}<br>
							TAPS: {{$joinedTap}}
							</td>
							<td>{{$taplist->start_date}}</td>
							<td>{{$taplist->end_date}}</td>
							<td>
							<?php
							$datenow = new DateTime(getDatetimeNow());
							$end_date = new DateTime($taplist->end_date);
							$start_date = new DateTime($taplist->start_date);

							?>
						
								<span style="color:blue;">READY TO START</span>
								<a href="{{route('admin.tap.history')}}?type=joined&&tapid={{$taplist->id}}" class="btn btn-primary btn-xs" >participants</a>		
								<br>
							
							</td>

						</tr>
						@endforeach
					</tbody>
				</table>
				</div>	
			
			</div>
			<div id="pending" class="tab-pane fade">
				<div class="table-responsive">
				<table class="table" id="dataTable-pending">
					<thead>
						<tr>
							<th style="width:2%">No</th>
							<th style="width:2%">ID</th>
							<th style="width:10%">Img</th>
							<th style="width:30%">Title/Desc</th>
							<th style="width:5%">Min</th>
							<th style="width:5%">Per Tap</th>
							<th style="width:10%">Current Points</th>
							<th style="width:25%">Start Date</th>
							<th style="width:25%">End Date</th>
							<th style="width:5%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?>
						@foreach($tapUpcomming as $taplist)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>{{$taplist->id}}</td>
							<td>
							<img src="{{ URL::asset(imagePathUser('assets/tap/'.$taplist->id))}}" class="img-responsive"   style="height:50px; width:50px;">
							</td>
							<td>Title: {{$taplist->product_name}}<br>
							Description:<br>
							{{$taplist->description}}
							</td>
							<td>{{$taplist->minimum_coins}}</td>
							<td>{{$taplist->coins_per_tap}}</td>
							<td>
							<?php
							$bidTotals = getTotalBid($taplist->id);
							$joinedcoins = 0;
							foreach($bidTotals['bidderJoined'] as $bidderJoined){
								$joinedcoins = $joinedcoins + $bidderJoined->coins;
							}
							$joinedTap = 0;
							foreach($bidTotals['bidderTotal'] as $bidderJoined){
								$joinedTap = $joinedTap + $bidderJoined->coins;
							}
							?>
							JOINED: {{$joinedcoins}}<br>
							TAPS: {{$joinedTap}}
							</td>
							<td>{{$taplist->start_date}}</td>
							<td>{{$taplist->end_date}}</td>
							<td>
							<?php
							$datenow = new DateTime(getDatetimeNow());
							$end_date = new DateTime($taplist->end_date);
							$start_date = new DateTime($taplist->start_date);

							?>
										
								<button onclick="showDiv({{$taplist->id}})" id="btntap{{$taplist->id}}" class="btn btn-info btn-xs" >Start Now</button><br>							
								<div id="divtap{{$taplist->id}}" style="display:none;">
									<form  role="form" method="POST" action="{{ route('tap.donate.start') }}" >						
										<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
										<input type="hidden" name="id" value="{{$taplist->id}}"> 
										<small>Start Date</small>
										<input style="width:220px;" class="form-control input-md" id="date" type="datetime-local"  name="start_date" value=""   required/>	
										<small>End Date</small>
										<input style="width:220px;" class="form-control input-md" id="date" type="datetime-local"  name="end_date" value=""  required />	
										<button type="submit" id="btnstart{{$taplist->id}}" class="btn btn-success btn-xs" >start</button>							
										<button type="button" onclick="hideDiv({{$taplist->id}})" id="btncancel{{$taplist->id}}" class="btn btn-danger btn-xs" >cancel</button>							
									</form>
								</div>
								<hr>
								<a href="/admin/tap/delete/{{encryptor('encrypt',$taplist->id)}}" class="btn btn-danger btn-xs" >Delete</a>	
						
							</td>

						</tr>
						@endforeach
					</tbody>
				</table>
				</div>	 	
				
			</div>
			<div id="ended" class="tab-pane fade">
				<div class="table-responsive">
				<table class="table" id="dataTable-ended">
					<thead>
						<tr>
							<th style="width:2%">No</th>
							<th style="width:2%">ID</th>
							<th style="width:10%">Img</th>
							<th style="width:30%">Title/Desc</th>
							<th style="width:5%">Min</th>
							<th style="width:5%">Per Tap</th>
							<th style="width:10%">Current Points</th>
							<th style="width:25%">Start Date</th>
							<th style="width:25%">End Date</th>
							<th style="width:5%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?>
						@foreach($tapEnded as $taplist)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>{{$taplist->id}}</td>
							<td>
							<img src="{{ URL::asset(imagePathUser('assets/tap/'.$taplist->id))}}" class="img-responsive"   style="height:50px; width:50px;">
							</td>
							<td>Title: {{$taplist->product_name}}<br>
							Description:<br>
							{{$taplist->description}}
							</td>
							<td>{{$taplist->minimum_coins}}</td>
							<td>{{$taplist->coins_per_tap}}</td>
							<td>
							<?php
							$bidTotals = getTotalBid($taplist->id);
							$joinedcoins = 0;
							foreach($bidTotals['bidderJoined'] as $bidderJoined){
								$joinedcoins = $joinedcoins + $bidderJoined->coins;
							}
							$joinedTap = 0;
							foreach($bidTotals['bidderTotal'] as $bidderJoined){
								$joinedTap = $joinedTap + $bidderJoined->coins;
							}
							?>
							JOINED: {{$joinedcoins}}<br>
							TAPS: {{$joinedTap}}
							</td>
							<td>{{$taplist->start_date}}</td>
							<td>{{$taplist->end_date}}</td>
							<td>
							<?php
							$datenow = new DateTime(getDatetimeNow());
							$end_date = new DateTime($taplist->end_date);
							$start_date = new DateTime($taplist->start_date);

							?>
							
								<span style="color:red;">TAP ENDED</span>
								<br>
								<b onclick="viewWinners('{{encryptor('encrypt',$taplist->id)}}')" class="btn btn-success btn-xs" >view winners</b>
								<a href="{{route('admin.tap.history')}}?type=joined&&tapid={{$taplist->id}}" class="btn btn-primary btn-xs" >participants</a>		
								<a href="{{route('admin.tap.history')}}?type=tap&&tapid={{$taplist->id}}" class="btn btn-warning btn-xs" >tap history</a>												
										
						
							</td>

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
@section('script')
<script>
$(document).ready(function() {   
$('#dataTable-started').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
$('#dataTable-ready').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
$('#dataTable-pending').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
$('#dataTable-ended').DataTable( {
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