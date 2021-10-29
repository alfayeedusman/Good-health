@extends('layouts.admin.app')
@section('title')
	Genealogy
@endsection
@section('head')	
<?php
$genealogyLevel = 5;
$genealogyWidth = 4000;
?>
<style>
	

#wrapper {
    overflow-x:scroll;
    overflow-y:hidden; 
}

#mainContainer{
width: {{$genealogyWidth}}px;
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
    border-bottom:solid 1px #000;
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
	font-size:9px;
    height: 900px;
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
$arrayParent['isgraduate'] = $accountN[0]->isgraduate;

array_push( $mergeLeftRightArray , $arrayParent);
usort($GLOBALS["arrayLeftForPairing"], 'sortByPosition');
usort($GLOBALS["arrayRightForPairing"], 'sortByPosition');
usort($mergeLeftRightArray, 'sortByPosition');
function getAccountDownline($username, $countLevel){

	$level = 1;
	$account =  App\Account::where('placement', '=', $username)->get();
	
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
			$leftArray['isgraduate'] = $acc->isgraduate;
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
			$rightArray['total_points'] = $acc->purchase_points + $acc->points;
			$rightArray['owner_member_id'] = $acc->owner_member_id;
			$rightArray['isgraduate'] = $acc->isgraduate;
			array_push( $GLOBALS["arrayRightForPairing"], $rightArray);
		}
	}
	return $account;
}

function getAccountDownlineLeft($username, $countLevel , $levelLimit){
	$account =  App\Account::where('placement', '=', $username)->get();
	$countLevel++;
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
			$leftArray['isgraduate'] = $acc->isgraduate;
			array_push( $GLOBALS["arrayLeftForPairing"], $leftArray);
			getAccountDownlineLeft($acc->account_name, $countLevel, $levelLimit);
		}
	}		
}
function getAccountDownlineRight($username, $countLevel , $levelLimit){
	$account =  App\Account::where('placement', '=', $username)->get();
	$countLevel++;
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
			$rightArray['isgraduate'] = $acc->isgraduate;
			array_push( $GLOBALS["arrayRightForPairing"], $rightArray);
			getAccountDownlineRight($acc->account_name, $countLevel, $levelLimit);
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
<div class="row">
	<div class="col-md-12" style="padding:0px;">
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
			<center><h3> Genealogy </h3>
			<form action="/admin/genealogy" method="GET" >
				search account name
				<br>
			  <input type="text" name="account" >
			  <br><br>
			  <input type="submit" value="Submit">
			</form> 
			<br>
			</center>
			<div id="wrapper" style="border: 2px solid #0099ff; padding:5px;">
				<br>
				<div id="mainContainer" class="clearfix">
				
				</div>
				<br><br><br>
			</div>
		
			<textarea style="display:none;" rows="4" cols="50" id="merge-array" >
			<?php echo json_encode($mergeLeftRightArray).''; ?>
			</textarea>
			
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12" >
				<center>
					<h3>Downlines</h3>
					<br>
				</center>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6" style="padding:0px;">
					<center>
					<h4>LEFT</h4>
					<br>
					</center>
					<?php
						$accountNameLeft = App\Account::select('account_name')->where('placement',$parent_account_name)->where('position','LEFT')->get();
					?>	
					@if(count($accountNameLeft)>0)
						<?php
							$downlinesLeft = getDownline($accountNameLeft[0]->account_name);
						?>	
						<ul class="list-group" style="border: 2px solid #0099ff;">
						@foreach($downlinesLeft as $left)
						<li class="list-group-item"><strong><a href="?account={{$left->account_name}}" > {{$left->account_name}} - ({{$left->slot}})</a></strong>
						</li>
						@endforeach
						</ul>			
					@endif
					<br><br>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6" style="padding:0px;">
					<center>
					<h4>RIGHT</h4>
					<br>
					</center>
					<?php
					$accountNameRight = App\Account::select('account_name')->where('placement',$parent_account_name)->where('position','RIGHT')->get();
					?>	
					@if(count($accountNameRight)>0)
						<?php
							$downlinesRight = getDownline($accountNameRight[0]->account_name);
						?>	
						<ul class="list-group" style="border: 2px solid #0099ff; ">
						@foreach($downlinesRight as $right)
						<li class="list-group-item"><strong><a href="?account={{$right->account_name}}" > {{$right->account_name}} - ({{$right->slot}}) </a></strong>
						</li>
						@endforeach
						</ul>			
					@endif
					
					<br><br>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection



@section('page-script')	
<script>	

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
		var isgraduate = member.isgraduate+"";
		var color = "blue";
		if(isgraduate==='TRUE'){
			color = "red";
		}
        if(memberParentID === parentId+""){ 
			//alert(memberParentID+' '+parentId);
			//var path = checkImageFile(member.owned_by);
            var parent = parentId ? $("#containerFor" + parentId) : $("#mainContainer"),
                account_name = member.account_name,
				//alert(memberId);
                    metaInfo = member.realaccount_name+ " <br> ( level " + member.level + ") <br> "+ member.slot +" <br> "+ member.entry +" <br> "+ member.activation_code +"";
            parent.append("<div class='container' id='containerFor" + account_name + "'><div class='member' style='padding:0px;'><a href='?account="+member.realaccount_name+"'>"+
			"<center><i class='fas fa-user-circle fa-3x' style='color:"+color+";'></i></center>"
			+"</a> <p style='font-size:12px;'>"+ member.position +"  <br> "+ member.realaccount_name +"<br>"+" ("+member.slot+")   <br>  <br> <br>  </div></div>");
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


</script>
@endsection