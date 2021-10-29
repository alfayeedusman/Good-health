@extends('layouts.member.app')
@section('title')
	Genealogy
@endsection
@section('style')	
<?php
$genealogyLevel = 3;
$genealogyWidth = 1300;
?>
<style>
	

#wrapper {
    overflow-x:scroll;
    overflow-y:hidden; 
}

#mainContainer{
width: {{$genealogyWidth}}px ;
height: 760px;
}
.container{
	
    text-align:center;
    margin:10px .5%;
    padding:10px .5%;

    float:left;
  
    
}
.member{
	font-size:10px;
    position:relative;
	padding-top:20px;
	padding-bottom:20px;
    z-index:   1;
    cursor:default;
    border-bottom:solid 1px green;
}
.member:after{
    display:block;
    position:absolute;
    left:50%;
    width:1px; 
    height:20px;
    background:#000;
    content:" ";
    bottom:100%;
}
.member:hover{
 z-index:   2;
}
.member .metaInfo{
    display:none;
    border:solid 1px #000;
    background:#fff;
    position:absolute;
    bottom:100%;
    left:50%;
    padding:5px;
	margin-bottom:-100px;
	margin-left:30px;
    width:150px;
}
.member:hover .metaInfo{
    display:block;   
}
.member .metaInfo img{
  width:50px;
  height:50px; 
  display:inline-block; 
  padding:5px;
  margin-right:5px;
    vertical-align:top;
  border:solid 1px #aaa;
}

#well1 {
    height: 15%; /*fall back for IE8, Safari 5.1, Opera Mini and pre-4.4 Android browsers*/
    height: calc(15% - 20px);
    overflow: hidden; /*better to decide how you want to handle this than to let the browser decide*/
}
#well2 {
    height: 85%;
    margin-bottom: 0;
    overflow: auto;
}
.list-group{
	font-size:8px;
	
    height: 500px;
    margin-bottom: 10px;
    overflow:scroll;
    -webkit-overflow-scrolling: touch;
	font-size:10px;
}

</style>
@endsection



@section('content')	



<?php

// $arrayLeftForPairing = array();
// $arrayRightForPairing = array();

$parent_account_name = $account['account_name'];
if(isset($_GET['account'])){
	if($_GET['account']!=''){
		$parent_account_name = $_GET['account'];
	}
}

unset($GLOBALS["arrayLeftForPairing2"]);
unset($GLOBALS["arrayRightForPairing2"]);
unset($GLOBALS["arrayLeftForPairingPAID"]);
unset($GLOBALS["arrayRightForPairingPAID"]);

$GLOBALS["arrayLeftForPairing2"] = array();
$GLOBALS["arrayRightForPairing2"] = array();
$GLOBALS["arrayLeftForPairingPAID"] = array();
$GLOBALS["arrayRightForPairingPAID"] = array();


 $accountN2 = App\Account::where('account_name',$parent_account_name)->get();
 
// display
unset($GLOBALS["arrayLeftForPairing"]);
unset($GLOBALS["arrayRightForPairing"]);
$GLOBALS["arrayLeftForPairing"] = array();
$GLOBALS["arrayRightForPairing"] = array();
$countLevel = 1;
$levelLimit = $genealogyLevel + 1;
$accountN = App\Account::where('account_name',$parent_account_name)->get();


$parentBinary = getAccountDownline( $parent_account_name , $countLevel  );

foreach($parentBinary as $parent){
	if($parent->position=="LEFT"){
		getAccountDownlineLeft($parent->account_name, $countLevel, $levelLimit);// get all left downlines
	}else{
		getAccountDownlineRight($parent->account_name, $countLevel , $levelLimit);// get all right downlines
	}
}
$mergeLeftRightArray = array_merge($GLOBALS["arrayLeftForPairing"],$GLOBALS["arrayRightForPairing"]);
$arrayParent = array();
$account_name8 = preg_replace('/[^A-Za-z0-9\-]/', '', $accountN[0]->account_name); //preg_replace('/\s/', '', $acc->account_name);
$account_name8 = strtolower($account_name8);
$arrayParent['id'] = $accountN[0]->id;
$arrayParent['level'] = 0;
$arrayParent['account_name'] = $account_name8;
$arrayParent['realaccount_name'] = $accountN[0]->account_name;
$arrayParent['activation_code'] = $accountN[0]->activation_code;
$arrayParent['placement'] = null;
$arrayParent['placement_member_id'] = $accountN[0]->placement_member_id;
$arrayParent['position'] = $accountN[0]->position;
$arrayParent['created_at'] = $accountN[0]->created_at;
$arrayParent['slot'] = $accountN[0]->slot;
$arrayParent['entry'] = $accountN[0]->entry;
$arrayParent['points'] = $accountN[0]->points;
$arrayParent['purchase_points'] = $accountN[0]->purchase_points;
$arrayParent['total_points'] = $accountN[0]->purchase_points + $accountN[0]->points;
$arrayParent['owner_member_id'] = $accountN[0]->owner_member_id;
$arrayParent['remaining_left'] = $accountN[0]->remaining_left;
$arrayParent['remaining_right'] = $accountN[0]->remaining_right;
array_push( $mergeLeftRightArray , $arrayParent);




// foreach($mergeLeftRightArray as $key => $val){
// 	if ($val['level'] === 0) {
// 		  $accs =  App\Account::where('placement', '=', $val['account_name'])->where('position', '=', 'LEFT')->get();
// 		  $accs2 =  App\Account::where('placement', '=', $val['account_name'])->where('placement', '=', 'RIGHT')->get();
// 	      echo $accs;
// 	}
// }






usort($GLOBALS["arrayLeftForPairing"], 'sortByPosition');
usort($GLOBALS["arrayRightForPairing"], 'sortByPosition');
usort($mergeLeftRightArray, 'sortByPosition');









function addLeftExtra($username, $countLevel){
	$leftArray = array();
	$leftArray['id'] = 0;
	$leftArray['level'] = $countLevel;
	$leftArray['account_name'] = 0;
	$leftArray['realaccount_name'] = 0;
	$leftArray['activation_code'] = 0;
	$leftArray['placement'] = strtolower($username);
	$leftArray['placement_member_id'] = 0;
	$leftArray['position'] = "LEFT";
	$leftArray['created_at'] = 0;
	$leftArray['slot'] = 0;
	$leftArray['entry'] = 0;
	$leftArray['points'] = 0;
	$leftArray['purchase_points'] = 0;
	$leftArray['total_points'] = 0;
	$leftArray['owner_member_id'] = 0;
	$leftArray['remaining_left'] = 0;
	$leftArray['remaining_right'] = 0;
	array_push( $GLOBALS["arrayLeftForPairing"] , $leftArray);

}
function addRightExtra($username, $countLevel){
		$rightArray = array();
		$rightArray['id'] = 0;
		$rightArray['level'] = $countLevel;
		$rightArray['account_name'] = 0;
		$rightArray['realaccount_name'] = 0;
		$rightArray['activation_code'] = 0;
		$rightArray['placement'] = strtolower($username);
		$rightArray['placement_member_id'] = 0;
		$rightArray['position'] = "RIGHT";
		$rightArray['created_at'] = 0;
		$rightArray['slot'] = 0;
		$rightArray['entry'] = 0;
		$rightArray['points'] = 0;
		$rightArray['purchase_points'] = 0;
		$rightArray['owner_member_id'] = 0;
		$rightArray['total_points'] = 0;
		$rightArray['remaining_left'] = 0;
		$rightArray['remaining_right'] = 0;
		array_push( $GLOBALS["arrayRightForPairing"], $rightArray);
}


function getAccountDownline($username, $countLevel){

	$level = 1;
	$account =  App\Account::where('placement', '=', $username)->get();
	if(count($account)==0){
		addLeftExtra($username, $countLevel);
		addRightExtra($username, $countLevel);
	}else{

		if(count($account)==1){
	
				foreach($account as $acc){
					$account_name7 = preg_replace('/[^A-Za-z0-9\-]/', '', $acc->account_name); //preg_replace('/\s/', '', $acc->account_name);
					$account_name7 = strtolower($account_name7);
					$account_name7Place =  preg_replace('/[^A-Za-z0-9\-]/', '', $acc->placement);
					$account_name7Place = strtolower($account_name7Place);
					if($acc->position=='LEFT'){
						addRightExtra($username, $countLevel);
						$leftArray = array();
						$leftArray['id'] = $acc->id;
						$leftArray['level'] = $countLevel;
						$leftArray['account_name'] = $account_name7;
						$leftArray['realaccount_name'] = $acc->account_name;
						$leftArray['activation_code'] = $acc->activation_code;
						$leftArray['placement'] = $account_name7Place;
						$leftArray['placement_member_id'] = $acc->placement_member_id;
						$leftArray['position'] = $acc->position;
						$leftArray['created_at'] = $acc->created_at;
						$leftArray['slot'] = $acc->slot;
						$leftArray['entry'] = $acc->entry;
						$leftArray['points'] = $acc->points;
						$leftArray['purchase_points'] = $acc->purchase_points;
						$leftArray['total_points'] = $acc->purchase_points + $acc->points;
						$leftArray['owner_member_id'] = $acc->owner_member_id;
						$leftArray['remaining_left'] = $acc->remaining_left;
						$leftArray['remaining_right'] = $acc->remaining_right;
						array_push( $GLOBALS["arrayLeftForPairing"] , $leftArray);
					}else{
						addLeftExtra($username, $countLevel);
						$rightArray = array();
						$rightArray['id'] = $acc->id;
						$rightArray['level'] = $countLevel;
						$rightArray['account_name'] = $account_name7;
						$rightArray['realaccount_name'] = $acc->account_name;
						$rightArray['activation_code'] = $acc->activation_code;
						$rightArray['placement'] = $account_name7Place;
						$rightArray['placement_member_id'] = $acc->placement_member_id;
						$rightArray['position'] = $acc->position;
						$rightArray['created_at'] = $acc->created_at;	
						$rightArray['slot'] = $acc->slot;
						$rightArray['entry'] = $acc->entry;
						$rightArray['points'] = $acc->points;
						$rightArray['purchase_points'] = $acc->purchase_points;
						$rightArray['owner_member_id'] = $acc->owner_member_id;
						$rightArray['total_points'] = $acc->purchase_points + $acc->points;
						$rightArray['remaining_left'] = $acc->remaining_left;
						$rightArray['remaining_right'] = $acc->remaining_right;
						array_push( $GLOBALS["arrayRightForPairing"], $rightArray);
					}
				}
		

		}else{

			foreach($account as $acc){
					$account_name7 = preg_replace('/[^A-Za-z0-9\-]/', '', $acc->account_name); //preg_replace('/\s/', '', $acc->account_name);
					$account_name7 = strtolower($account_name7);
					$account_name7Place =  preg_replace('/[^A-Za-z0-9\-]/', '', $acc->placement);
					$account_name7Place = strtolower($account_name7Place);
					if($acc->position=="LEFT"){
						$leftArray = array();
						$leftArray['id'] = $acc->id;
						$leftArray['level'] = $countLevel;
						$leftArray['account_name'] = $account_name7;
						$leftArray['realaccount_name'] = $acc->account_name;
						$leftArray['activation_code'] = $acc->activation_code;
						$leftArray['placement'] = $account_name7Place;
						$leftArray['placement_member_id'] = $acc->placement_member_id;
						$leftArray['position'] = $acc->position;
						$leftArray['created_at'] = $acc->created_at;
						$leftArray['slot'] = $acc->slot;
						$leftArray['entry'] = $acc->entry;
						$leftArray['points'] = $acc->points;
						$leftArray['purchase_points'] = $acc->purchase_points;
						$leftArray['total_points'] = $acc->purchase_points + $acc->points;
						$leftArray['owner_member_id'] = $acc->owner_member_id;
						$leftArray['remaining_left'] = $acc->remaining_left;
						$leftArray['remaining_right'] = $acc->remaining_right;
						array_push( $GLOBALS["arrayLeftForPairing"] , $leftArray);
					}else{
						$rightArray = array();
						$rightArray['id'] = $acc->id;
						$rightArray['level'] = $countLevel;
						$rightArray['account_name'] = $account_name7;
						$rightArray['realaccount_name'] = $acc->account_name;
						$rightArray['activation_code'] = $acc->activation_code;
						$rightArray['placement'] = $account_name7Place;
						$rightArray['placement_member_id'] = $acc->placement_member_id;
						$rightArray['position'] = $acc->position;
						$rightArray['created_at'] = $acc->created_at;	
						$rightArray['slot'] = $acc->slot;
						$rightArray['entry'] = $acc->entry;
						$rightArray['points'] = $acc->points;
						$rightArray['purchase_points'] = $acc->purchase_points;
						$rightArray['owner_member_id'] = $acc->owner_member_id;
						$rightArray['total_points'] = $acc->purchase_points + $acc->points;
						$rightArray['remaining_left'] = $acc->remaining_left;
						$rightArray['remaining_right'] = $acc->remaining_right;
						array_push( $GLOBALS["arrayRightForPairing"], $rightArray);
					}
			}

		}


	}
	
	return $account;
}

function getAccountDownlineLeft($username, $countLevel , $levelLimit){
	$account =  App\Account::where('placement', '=', $username)->get();
	$countLevel++;
	if(count($account)==0){
		addLeftExtra($username, $countLevel);
		addRightExtra($username, $countLevel);
	}else{
		if(count($account)==1){
			foreach($account as $acc){
				$account_name5 = preg_replace('/[^A-Za-z0-9\-]/', '', $acc->account_name); //preg_replace('/\s/', '', $acc->account_name);
				$account_name5 = strtolower($account_name5);
				$account_name5Place = preg_replace('/[^A-Za-z0-9\-]/', '', $acc->placement); 
				$account_name5Place = strtolower($account_name5Place);
				if($acc->position=='LEFT'){	
					if($countLevel<$levelLimit){
						addRightExtra($username, $countLevel);
						$leftArray = array();
						$leftArray['id'] = $acc->id;
						$leftArray['level'] = $countLevel;
						$leftArray['account_name'] = $account_name5;
						$leftArray['realaccount_name'] = $acc->account_name;
						$leftArray['activation_code'] = $acc->activation_code;
						$leftArray['placement'] = $account_name5Place;
						$leftArray['placement_member_id'] = $acc->placement_member_id;
						$leftArray['position'] = $acc->position;
						$leftArray['created_at'] = $acc->created_at;
						$leftArray['slot'] = $acc->slot;
						$leftArray['entry'] = $acc->entry;
						$leftArray['points'] = $acc->points;
						$leftArray['purchase_points'] = $acc->purchase_points;
						$leftArray['total_points'] = $acc->purchase_points + $acc->points;
						$leftArray['owner_member_id'] = $acc->owner_member_id;
						$leftArray['remaining_right'] = $acc->remaining_right;
						$leftArray['remaining_left'] = $acc->remaining_left;
						array_push( $GLOBALS["arrayLeftForPairing"], $leftArray);
						getAccountDownlineLeft($acc->account_name, $countLevel, $levelLimit);
					}
				}else{
					if($countLevel<$levelLimit){
						addLeftExtra($username, $countLevel);
						$leftArray = array();
						$leftArray['id'] = $acc->id;
						$leftArray['level'] = $countLevel;
						$leftArray['account_name'] = $account_name5;
						$leftArray['realaccount_name'] = $acc->account_name;
						$leftArray['activation_code'] = $acc->activation_code;
						$leftArray['placement'] = $account_name5Place;
						$leftArray['placement_member_id'] = $acc->placement_member_id;
						$leftArray['position'] = $acc->position;
						$leftArray['created_at'] = $acc->created_at;
						$leftArray['slot'] = $acc->slot;
						$leftArray['entry'] = $acc->entry;
						$leftArray['points'] = $acc->points;
						$leftArray['purchase_points'] = $acc->purchase_points;
						$leftArray['total_points'] = $acc->purchase_points + $acc->points;
						$leftArray['owner_member_id'] = $acc->owner_member_id;
						$leftArray['remaining_right'] = $acc->remaining_right;
						$leftArray['remaining_left'] = $acc->remaining_left;
						array_push( $GLOBALS["arrayLeftForPairing"], $leftArray);
						getAccountDownlineLeft($acc->account_name, $countLevel, $levelLimit);
					}

				}
			}

		}else{
			foreach($account as $acc){
			$account_name5 = preg_replace('/[^A-Za-z0-9\-]/', '', $acc->account_name); //preg_replace('/\s/', '', $acc->account_name);
			$account_name5 = strtolower($account_name5);
			$account_name5Place = preg_replace('/[^A-Za-z0-9\-]/', '', $acc->placement); 
			$account_name5Place = strtolower($account_name5Place);
				if($countLevel<$levelLimit){
					$leftArray = array();
					$leftArray['id'] = $acc->id;
					$leftArray['level'] = $countLevel;
					$leftArray['account_name'] = $account_name5;
					$leftArray['realaccount_name'] = $acc->account_name;
					$leftArray['activation_code'] = $acc->activation_code;
					$leftArray['placement'] = $account_name5Place;
					$leftArray['placement_member_id'] = $acc->placement_member_id;
					$leftArray['position'] = $acc->position;
					$leftArray['created_at'] = $acc->created_at;
					$leftArray['slot'] = $acc->slot;
					$leftArray['entry'] = $acc->entry;
					$leftArray['points'] = $acc->points;
					$leftArray['purchase_points'] = $acc->purchase_points;
					$leftArray['total_points'] = $acc->purchase_points + $acc->points;
					$leftArray['owner_member_id'] = $acc->owner_member_id;
					$leftArray['remaining_left'] = $acc->remaining_left;
					$leftArray['remaining_right'] = $acc->remaining_right;
					array_push( $GLOBALS["arrayLeftForPairing"], $leftArray);
					getAccountDownlineLeft($acc->account_name, $countLevel, $levelLimit);
				}
			}

		}



	}





			
}
function getAccountDownlineRight($username, $countLevel , $levelLimit){
	$account =  App\Account::where('placement', '=', $username)->get();
	$countLevel++;
	if(count($account)==0){
		addLeftExtra($username, $countLevel);
		addRightExtra($username, $countLevel);
	}else{
		if(count($account)==1){
			foreach($account as $acc){
				$account_name6 =  preg_replace('/[^A-Za-z0-9\-]/', '', $acc->account_name); //preg_replace('/\s/', '', $acc->account_name);
				$account_name6 = strtolower($account_name6);
				$account_name6Place =  preg_replace('/[^A-Za-z0-9\-]/', '', $acc->placement);
				$account_name6Place = strtolower($account_name6Place);
				if($acc->position=='LEFT'){	
					if($countLevel<$levelLimit){
						addRightExtra($username, $countLevel);
						$rightArray = array();
						$rightArray['id'] = $acc->id;
						$rightArray['level'] = $countLevel;
						$rightArray['account_name'] = $account_name6;
						$rightArray['realaccount_name'] = $acc->account_name;
						$rightArray['activation_code'] = $acc->activation_code;
						$rightArray['placement'] = $account_name6Place;
						$rightArray['placement_member_id'] = $acc->placement_member_id;
						$rightArray['position'] = $acc->position;
						$rightArray['created_at'] = $acc->created_at;
						$rightArray['slot'] = $acc->slot;
						$rightArray['entry'] = $acc->entry;
						$rightArray['points'] = $acc->points;
						$rightArray['purchase_points'] = $acc->purchase_points;
						$rightArray['total_points'] = $acc->purchase_points + $acc->points;
						$rightArray['owner_member_id'] = $acc->owner_member_id;
						$rightArray['remaining_left'] = $acc->remaining_left;
						$rightArray['remaining_right'] = $acc->remaining_right;
						array_push( $GLOBALS["arrayRightForPairing"], $rightArray);
						getAccountDownlineRight($acc->account_name, $countLevel, $levelLimit);
					}
				}else{

					if($countLevel<$levelLimit){
						addLeftExtra($username, $countLevel);
						$rightArray = array();
						$rightArray['id'] = $acc->id;
						$rightArray['level'] = $countLevel;
						$rightArray['account_name'] = $account_name6;
						$rightArray['realaccount_name'] = $acc->account_name;
						$rightArray['activation_code'] = $acc->activation_code;
						$rightArray['placement'] = $account_name6Place;
						$rightArray['placement_member_id'] = $acc->placement_member_id;
						$rightArray['position'] = $acc->position;
						$rightArray['created_at'] = $acc->created_at;
						$rightArray['slot'] = $acc->slot;
						$rightArray['entry'] = $acc->entry;
						$rightArray['points'] = $acc->points;
						$rightArray['purchase_points'] = $acc->purchase_points;
						$rightArray['total_points'] = $acc->purchase_points + $acc->points;
						$rightArray['owner_member_id'] = $acc->owner_member_id;
						$rightArray['remaining_left'] = $acc->remaining_left;
						$rightArray['remaining_right'] = $acc->remaining_right;
						array_push( $GLOBALS["arrayRightForPairing"], $rightArray);
						getAccountDownlineRight($acc->account_name, $countLevel, $levelLimit);
					}
				}
			}

		}else{
			foreach($account as $acc){
			$account_name6 =  preg_replace('/[^A-Za-z0-9\-]/', '', $acc->account_name); //preg_replace('/\s/', '', $acc->account_name);
			$account_name6 = strtolower($account_name6);
			$account_name6Place =  preg_replace('/[^A-Za-z0-9\-]/', '', $acc->placement);
			$account_name6Place = strtolower($account_name6Place);
				if($countLevel<$levelLimit){
					$rightArray = array();
					$rightArray['id'] = $acc->id;
					$rightArray['level'] = $countLevel;
					$rightArray['account_name'] = $account_name6;
					$rightArray['realaccount_name'] = $acc->account_name;
					$rightArray['activation_code'] = $acc->activation_code;
					$rightArray['placement'] = $account_name6Place;
					$rightArray['placement_member_id'] = $acc->placement_member_id;
					$rightArray['position'] = $acc->position;
					$rightArray['created_at'] = $acc->created_at;
					$rightArray['slot'] = $acc->slot;
					$rightArray['entry'] = $acc->entry;
					$rightArray['points'] = $acc->points;
					$rightArray['purchase_points'] = $acc->purchase_points;
					$rightArray['total_points'] = $acc->purchase_points + $acc->points;
					$rightArray['owner_member_id'] = $acc->owner_member_id;
					$rightArray['remaining_left'] = $acc->remaining_left;
					$rightArray['remaining_right'] = $acc->remaining_right;
					array_push( $GLOBALS["arrayRightForPairing"], $rightArray);
					getAccountDownlineRight($acc->account_name, $countLevel, $levelLimit);
				}
			}

		}


	}


	
}

//method of sorting by level
function sortByPosition($a, $b){
	$a = $a['position'];
	$b = $b['position'];
	if ($a == $b){
		return 0;
	}
	return ($a < $b) ? -1 : 1;
}
// function sortByLevel($a, $b){
	// $a = $a['level'];
	// $b = $b['level'];
	// if ($a == $b){
		// return 0;
	// }
	// return ($a < $b) ? -1 : 1;
// }

?>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div class="row">
	<div class="col-md-12" style="padding:0px;">
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
		@if (Session::has('success-message'))
			<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Success!</strong><br>
					<p>{{ Session::get('success-message') }}</p>
			</div>

		@elseif (Session::has('success-message-with-account'))
			<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Success!</strong><br>
					<p>{{ Session::get('success-message-with-account') }}</p>
			</div>	
			

		@elseif (Session::has('error-message'))
			<div class="alert alert-danger">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Something went wrong!</strong><br>
					<p>{{ Session::get('error-message') }}</p>
			</div>
		@endif
		</div>
		<div class="col-md-12">
			
			<center>
			<h3 > Genealogy </h3>
		
			</center>
			<br><br>
			<div id="wrapper" style="border: 2px solid green; padding:5px; ">
				<center>
			<br>
				<div id="mainContainer" class="clearfix" >
				
				</div>
			<br><br><br>
		</center>
			</div>
			<br><br>
			<textarea rows="2" cols="50" id="merge-array" style="display: none;" >
			<?php echo json_encode($mergeLeftRightArray).''; ?>
			</textarea>
			
		</div>
	</div>
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
	<div class="col-md-12" >
	<div class="row">
		<div class="col-md-12" >
		<center>
			<h3 >Downlines</h3>
			<br>
			<form method="GET" action="/genealogy">
				  <label for="from">From:</label>
				  <input type="date" id="from" name="from">
				  <label for="to">To:</label>
				  <input type="date" id="to" name="to">
				  <input type="submit" value="search">
			</form>
			<br>
			<a href="/genealogy" class="btn btn-primary">reset</a>
			<br>
		</center>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6" style="padding:0px;">
			<?php
				$accountNameLeft = App\Account::where('placement',$parent_account_name)->where('position','LEFT')->get();
			?>	
			
			
			@if(count($accountNameLeft)>0)
				<?php
					
					if(isset($_GET['from'])&&isset($_GET['to'])){
						$from = $_GET['from']; $to = $_GET['to']; 
						$downlinesLeft = getDownlineFromTo($accountNameLeft[0]->account_name,$from,$to);
					}else{
						$downlinesLeft = getDownline($accountNameLeft[0]->account_name);
					}
					$c = 1;
					$waitingLeft = $accountN2[0]->remaining_left;
				?>	
				<center>
				<h4>LEFT - Total Accounts = {{count($downlinesLeft)}}</h4>
				<h5>Waiting : {{$waitingLeft}} </h5>
				<br>
				</center>
				<ul class="list-group" style="border: 2px solid green;">
					<div class="table-wrapper-scroll-y my-custom-scrollbar">
					
						  <table class="table table-bordered table-striped mb-0" id="tbl1">
							<thead>
							  <tr>
								<th scope="col" ></th>
								<th scope="col" >Date</th>
								<th scope="col" ><center>Account Name</center></th>
								<th scope="col" ><center>Sponsor</center></th>
								<th scope="col" ><center>Upline</center></th>
								<th scope="col" ><center>Package</center></th>
								<th scope="col" ><center>Slot</center></th>
								<th scope="col" ><center>Position</center></th>
							  </tr>
							</thead>
							<tbody>
							@if(count($downlinesLeft)>0)
								@foreach($downlinesLeft as $left)
								  <tr>
								  	<td > {{$c++}}</td>
									<td > {{$left->created_at}}</td>
									<td > {{$left->account_name}} <br> {{$left->member->first_name}} {{$left->member->last_name}}</td>
									<td > {{$left->account_sponsor}}<br> {{$left->memberSponsor->first_name}} {{$left->memberSponsor->last_name}}</td>
									<td > {{$left->placement}}<br> {{$left->memberUpline->first_name}} {{$left->memberUpline->last_name}}</td>
									<td > <center>{{$left->entry}}</center> </td>
									<td >
										@if($left->slot=='PAID')
											PD
										@else
											FR
										@endif
									</td>
									<td > <center>{{$left->position}}</center> </td>
								  </tr>
								@endforeach
							@endif
							</tbody>
						  </table>
							
						</div>
						<br>
				</ul>
			@else
				<center>
				<h4>LEFT - 0</h4>
				<br>
				</center>	
			@endif
			<br><br>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6" style="padding:0px;">
			<?php

			$accountNameRight = App\Account::with('member')->where('placement',$parent_account_name)->where('position','RIGHT')->get();
			
			?>	
			
			
			@if(count($accountNameRight)>0)
				<?php
					if(isset($_GET['from'])&&isset($_GET['to'])){
						$from = $_GET['from']; $to = $_GET['to']; 
						$downlinesRight = getDownlineFromTo($accountNameRight[0]->account_name,$from,$to);
					}else{
						$downlinesRight = getDownline($accountNameRight[0]->account_name);
					}
					$c2 = 1;
					$waitingRight = $accountN2[0]->remaining_right;
				?>	
				<center>

				<h4>RIGHT - Total Accounts : {{count($downlinesRight)}} </h4>
				<h5>Waiting : {{$waitingRight}} </h5>
				<br>

				</center>
				<ul class="list-group" style="border: 2px solid green; ">
			
				
		
						<div class="table-wrapper-scroll-y my-custom-scrollbar">
					
						  <table class="table table-bordered table-striped mb-0" id="tbl2">
							<thead>
							  <tr>
								<th scope="col" ></th>
								<th scope="col" >Date</th>
								<th scope="col" ><center>Account Name</center></th>
								<th scope="col" ><center>Sponsor</center></th>
								<th scope="col" ><center>Upline</center></th>
								<th scope="col" ><center>Package</center></th>
								<th scope="col" ><center>Slot</center></th>
								<th scope="col" ><center>Position</center></th>
							  </tr>
							</thead>
							<tbody>
							@if(count($downlinesRight)>0)
								@foreach($downlinesRight as $right)
								  <tr>
								  	<td > {{$c2++}}</td>
									<td > {{$right->created_at}}</td>
									<td > {{$right->account_name}} <br> {{$right->member->first_name}} {{$right->member->last_name}}</td>
									<td > {{$right->account_sponsor}}<br> {{$right->memberSponsor->first_name}} {{$right->memberSponsor->last_name}}</td>
									<td > {{$right->placement}}<br> {{$right->memberUpline->first_name}} {{$right->memberUpline->last_name}}</td>
									<td > <center>{{$right->entry}}</center> </td>
									<td >
										@if($right->slot=='PAID')
											PD
										@else
											FR
										@endif
									</td>
									<td > <center>{{$right->position}}</center> </td>
								  </tr>
								@endforeach
							@endif
							</tbody>
						  </table>
							
						</div>
						<br>
				
		
			
				</ul>	
			@else
				<center>
				<h4 >RIGHT - 0</h4>
				<br>
				</center>
			@endif
			
			<br><br>
		</div>
	</div>
	</div>
</div>

@endsection



@section('script')	
<script>	
function a(id){

	alert(id);
}
function openCity(cityName) {
    var i;
    var x = document.getElementsByClassName("city");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    document.getElementById(cityName).style.display = "block";  
}	
var data = $("#merge-array").val();
var members = JSON.parse(data);
//alert(JSON.stringify(members));
var testImgSrc = "http://0.gravatar.com/avatar/06005cd2700c136d09e71838645d36ff?s=69&d=wavatar";
(function heya( parentId ){
    for(var i = 0; i < members.length; i++){
        var member = members[i];
		var memberParentID = member.placement+"";

        if(memberParentID === parentId+""){ 
			//alert(memberParentID+' '+parentId);
			//var path = checkImageFile(member.owned_by);
			var color = '#ffffff';
			if(member.entry=='DIAMOND'){
				var color = '#ffffff';
				//var color = 'green';
			}else if(member.entry=='GOLD'){
				var color = '#d4af37';
				//var color = 'green';
			}else{
				var color = '#aaa9ad';
				//var color = 'green';
			}
			if(member.slot==='0'||member.slot===0){ 
				var info = "<a  href='/accounts-register?upline="+parentId+"&&position="+member.position+"'>"+"<center><i class='fa fa-user-plus fa-3x' style='color:green;'></i></center> </a><br> <p style='font-size:12px;'>  ADD </p></p><br>  <br> <br>  ";


			}else{
				var slot='';
				if(member.slot==='PAID'){
					slot='PD';
				}else{
					slot='FR';
				}
				var info = "<a href='?account="+member.realaccount_name+"'>"+"<center><i class='fa fa-user-circle-o fa-3x' style='color:green;'></i></center></a><br> <p style='font-size:12px;'>"+ member.position +"  <br> "+ member.realaccount_name +"<br>"+" ("+slot+") <br> <strong>"+member.entry+"</strong>  <br> <strong> L="+member.remaining_left+" - R="+member.remaining_right+"  <br> <br> </p> </div></div>";
			}
			

            var parent = parentId ? $("#containerFor" + parentId) : $("#mainContainer"),
                account_name = member.account_name,
				//alert(memberId);
                    metaInfo = member.realaccount_name+ " <br> ( level " + member.level + ") <br> "+ member.slot +" <br> "+ member.entry +" <br> "+ member.activation_code +"";
            parent.append("<div class='container' id='containerFor" + account_name + "'><div class='member' style='padding:0px;'>" + info);
            heya(account_name);
        } 
    }
 }( null ));

var pretty = function(){
    var self = $(this),
        children = self.children(".container"),
        width = (100/children.length) - 2;
    children
        .css("width", width + "%")
        .each(pretty);
};
$("#mainContainer").each(pretty);


$(function(){
    $("#tbl1").each(function(elem,index){
      var arr = $.makeArray($("tr",this).detach());
      arr.reverse();
        $(this).append(arr);
    });
    $("#tbl2").each(function(elem,index){
      var arr = $.makeArray($("tr",this).detach());
      arr.reverse();
        $(this).append(arr);
    });
});
</script>
@endsection
