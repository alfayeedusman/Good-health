@extends('layouts.admin.app')
@section('title')
	Permission
@endsection
@section('content')
<div class="row">
<div class="col-md-12">
	<div class="col-md-12">
	
		<br><br><br><br>
		<center>
		<h3>	You dont have Permission to Access this Page! </h3>
		</center>
		<br><br><br><br>
		
		
		
		
		
		
	</div>
</div>
</div>
@endsection


@section('page-script')	
<script>	
$(document).ready(function() {   
$('#dataTable-accounts').DataTable( {
	dom: 'Bfrtip',
	buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
} );
});
</script>
@endsection