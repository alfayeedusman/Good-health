<div class="row">
	<div class="col-md-12">
	
			<div class="col-md-5">
				<center>
				<img src="{{ URL::asset(imagePathUser('assets/tap/'.$tapDetails[0]->id))}}" class="img-responsive"   >
				
				<hr>
				<?php
				$datenow = new DateTime(getDatetimeNow());
				$end_date = new DateTime($tapDetails[0]->end_date);
				$start_date = new DateTime($tapDetails[0]->start_date);

				?>
				@if( $end_date < $datenow )
					tap ended
					<br>
					<button onclick="viewDetails('{{encryptor('encrypt',$tapDetails[0]->id)}}')" class="btn btn-primary btn-xs" >view winners</button>											
							
				@elseif( $end_date > $datenow && $start_date < $datenow )
					tap started
					<br>
					<button onclick="viewDetails('{{encryptor('encrypt',$tapDetails[0]->id)}}')" class="btn btn-primary btn-xs" >join now</button>								
				@else
					pending
					<br>					
					<button onclick="viewDetails('{{encryptor('encrypt',$tapDetails[0]->id)}}')" class="btn btn-primary btn-xs" >join now</button>		
				@endif	
				</center>
			</div>
			<div class="col-md-7">
				<center>
				<h3> {{$tapDetails[0]->product_name}} <h3>
				<hr>
				<h5> {{$tapDetails[0]->description}} <h5>
				<hr>	
				<h5> Coins Required : {{$tapDetails[0]->minimum_coins}}  - Coins Per Tap: {{$tapDetails[0]->coins_per_tap}}<h5>		
				<hr>
				</center>			
			</div>
			<div class="col-md-12">
			<br><br><br><br><br><br>
			<button class="btn btn-danger btn-lg" data-dismiss="modal" >Close</button>
			</div>
		
	</div>					
</div>