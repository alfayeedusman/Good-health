@extends('layouts.admin.app')
@section('title')
	Members
@endsection
@section('content')
 <div class="row">
	<div class="col-lg-12">
		<h3>Members</h3>
		<hr>
		<div class="col-md-4" >
			Search member here!
			<form  class="form-header" role="form" method="GET" action="{{ route('admin.members') }}" onsubmit="submit_btn.disabled = true; return true;" >			
			<div class="input-group" style="padding:0px;">
				<input type="text" class="form-control"  name="search" id="search" placeholder="Search Name, username" required>
				<span class="input-group-btn">Search member here!
				<button type="submit" class="btn btn-default" id="submit_btn" type="button">Search!</button>
				</span>
			</div>
			</form>
			<br>
		</div>
		<div class="col-md-12" >
		<div class="table-responsive">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTable-members">
					<thead>
						<tr>
							<th style="width:5%">No</th>
							<th style="width:10%">Name</th>
							<th style="width:10%">Username</th>
							<th style="width:10%">Accounts</th>
							<th style="width:10%">Sponsor</th>
							<th style="width:20%">Created date</th>
							<th style="width:20%">Activated date</th>
							<th style="width:20%"></th>
						</tr>
					</thead>
					<tbody>
						<?php  $count = 1; ?>
						@foreach($members as $mem)
						<tr class="odd gradeX">
							<td>{{$count++}}</td>
							<td>{{$mem->first_name}} {{$mem->last_name}}</td>
							<td>{{$mem->username}}</td>
							<td>{{$mem->accounts}}</td>
							<td>{{$mem->sponsor}}</td>
							<td>{{$mem->created_at}}</td>
							<td>{{$mem->activated_at}}</td>
		
							<td>
							<?php
								$id = encryptor('encrypt', $mem->id );
							?>
							<a  href="{{ route('admin.members.info', ['id' => $id ]) }}" class="btn btn-primary btn-xs">info</a>
							<a  href="{{ route('admin.accounts', ['mid' => $id ]) }}" class="btn btn-warning btn-xs">accounts</a>
							
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		</div>
		<br>
		<div class="col-md-12" >
		<?php echo $members->appends(Input::except('page')); ?> 
		<br><br><br>
		</div>
	</div>
</div>
@endsection
@section('page-script')
<script>
// $(document).ready(function() {   
// $('#dataTable-members').DataTable( {
	// dom: 'Bfrtip',
	// buttons: [
		// 'copy', 'csv', 'excel', 'pdf', 'print'
	// ]
// } );
// });
function getMemberInfo(id){
	window.open('/admin/members/'+id,'name','height=500,width=500');

}

</script>
@endsection