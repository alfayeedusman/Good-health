<?php
// My common functions
ini_set('max_execution_time', '0');
function encodeUrlRoute($string)
{
    return str_replace(' ','-',$string);
}
function decodeUrlRoute($string)
{
    return str_replace('-',' ',$string);
}
function decodeUrlRoute2($string)
{
    return str_replace('+',' ',$string);
}
function generateTrackingNumber(){
	$track = time().mt_rand(100000, 999999);
	return $track;
}
function generateActivationNumber(){
	$activationNumber = time().mt_rand(1000, 9999);
	return $activationNumber;
}
function generateRandomNumber(){
	$activationNumber = mt_rand(1000, 9999);
	return $activationNumber;
}
function generateMemberCode(){
	$key = true;
	$memberCode = "";
    while($key){
        // Do stuff
        $memberCode = mt_rand(10000000, 99999999);
		$member = DB::table('member_tbl')->where('member_code','=',$memberCode)->get();
		if (count($member)>0) {
			$key = true;
		}else{
			$key = false;
		}
    }
	
	return $memberCode;
}
function generateEpins() {
	$code = substr(md5(uniqid(mt_rand(), true)) , 0, 12);
	$code = strToUpper($code);
	for($x = 0; $x < 1000; $x++){
		$epins = App\Epins::where('code', '=' ,$code)->get();
		if(count($epins)==0){
			$epinssave = new App\Epins;
			$epinssave->code = $code;
			$epinssave->save();
			$code = substr(md5(uniqid(mt_rand(), true)) , 0, 12);
			$code = strToUpper($code);
		}
	}
	echo " success ";

}

function generateEpins2($codes,$slot,$points,$entry,$qty) {
	$code = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
	$code = strToUpper($codes).strToUpper($code);
	for($x = 0; $x < $qty; $x++){
		$epins = App\Epins::where('code', '=' ,$code)->get();
		if(count($epins)==0){
			$epinssave = new App\Epins;
			$epinssave->code = $code;
			$epinssave->slot = $slot;
			$epinssave->points = $points;
			$epinssave->entry = $entry;
			$epinssave->save();
			$code = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
			$code = strToUpper($codes).strToUpper($code);
		}
	}
	echo " success ";

}
function generateProductEpins($codes,$product,$points,$qty,$unilevel) {
	$code = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
	$code = strToUpper($codes).strToUpper($code);
	for($x = 0; $x < $qty; $x++){
		$epins = App\ProductEpins::where('code', '=' ,$code)->get();
		if(count($epins)==0){
			$epinssave = new App\ProductEpins;
			$epinssave->code = $code;
			$epinssave->product = $product;
			$epinssave->points = $points;
			$epinssave->unilevel = $unilevel;
			$epinssave->save();
			$code = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
			$code = strToUpper($codes).strToUpper($code);
		}
	}

}
function checkloginAuthentication(){
	$role = "";
	if (Auth::check()){
		$role = Auth::user()->role;
		return $role;
	}else{
		return $role;
	}
}
function isPermitted(){
	$bool = false;
	if (Auth::check()){
		$role = Auth::user()->role;
		$id = Auth::user()->id;
		if($role=="ADMIN"){
			if($id==1){
				$bool = true;
			}else{
				$bool = false;
			}
		}
	}else{
		$bool = false;
	}
	return $bool;
}	
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function encryptor($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'homemall';
    $secret_iv = 'anone12345';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
function getDatetimeNow() {
	date_default_timezone_set('Asia/Manila');
	$datetime = date("Y-m-d H:i:s");
	//adding date
	// $datetime = strtotime('2016-01-04 03:31:52 + 1 hour');
	// $datetime= date('Y-m-d H:i:s', $datetime);
	return $datetime;
}
function getExpirationDatetime() {
	date_default_timezone_set('Asia/Manila');
	$datetime = date("Y-m-d H:i:s");
	//adding date
	$datetime = strtotime($datetime.' + 30 day');
	$datetime= date('Y-m-d H:i:s', $datetime);
	return $datetime;
}
function imagePathUser($path)
{
    if(file_exists($path.'.png')){
		return $path.'.png';
	}
	else if(file_exists($path.'.gif'))
	{
		return $path.'.gif';
	}
	else if(file_exists($path.'.jpg'))
	{
		return $path.'.jpg';
	}	
	else{
		return 'assets/member/default-user.png';
	}
}
function imagePath($path)
{
    if(file_exists($path.'.png')){
		return $path.'.png';
	}
	else if(file_exists($path.'.gif'))
	{
		return $path.'.gif';
	}
	else if(file_exists($path.'.jpg'))
	{
		return $path.'.jpg';
	}	
	else{
		return $path.'.jpg';
	}
}
function imagePathUserByAccountID($id)
{

    if(file_exists($path.'.png')){
		return $path.'.png';
	}
	else if(file_exists($path.'.gif'))
	{
		return $path.'.gif';
	}
	else if(file_exists($path.'.jpg'))
	{
		return $path.'.jpg';
	}	
	else{
		return 'assets/avatar.jpg';
	}
}
function getAuthenticatedUser(){
	$user = Auth::user()->with('member')->get();
	return $user;
}
function checkIfActiveUser($name){
	$user = App\User::select('status')->where('name','=',$name)->get();
	if(count($user)>0){
		if($user[0]->status=='ACTIVE'){
			return array(
				'success'=>'true',
				'msg'=>'Active',
			);
		}else{
			return array(
				'success'=>'false',
				'msg'=>'Not Active',
			);
		}
	}else{
		return array(
			'success'=>'false',
			'msg'=>'Not Exist',
		);
	}
}



// function getSponsorsListings($username){
	// unset($GLOBALS["arrayforreferrals"]);
	// $GLOBALS["arrayforreferrals"] = array();
	// return getSponsorList($username,1);
// }
// function getSponsorList($username,$lvl){
	// $sponsors =  App\Member::select('id','username','sponsor','member_status','activated_at','created_at','accounts')->where('sponsor', '=', $username)->get();
	// if(count($sponsors)>0){
		// foreach($sponsors as $sponsorsList){
			// $listarray = array();
			// $listarray['id'] = $sponsorsList->id;
			// $listarray['username'] = $sponsorsList->username;
			// $listarray['member_status'] = $sponsorsList->member_status;
			// $listarray['activated_at'] = $sponsorsList->activated_at;
			// $listarray['created_at'] = $sponsorsList->created_at;
			// $listarray['accounts'] = $sponsorsList->accounts;
			// $listarray['level'] = $lvl;
			// array_push( $GLOBALS["arrayforreferrals"], $listarray);
			// $leveling = $lvl+1;
			// getSponsorList($sponsorsList->username,$leveling);
		// }
	// }
	// usort($GLOBALS["arrayforreferrals"], 'sortByLevel');
	// return $GLOBALS["arrayforreferrals"];
// }
function getDownline($parent){

		$acc = App\Account::where('account_name',$parent)->get();
		$tree = App\Account::with('member')->with('memberSponsor')->with('memberUpline')->descendantsAndSelf($acc[0]->id);	
		return $tree;
}
function getDownlineFromTo($parent,$from,$to){

		$acc = App\Account::where('account_name',$parent)->get();
		$tree = App\Account::with('member')->with('memberSponsor')->with('memberUpline')->whereBetween('_date', [$from, $to])->descendantsAndSelf($acc[0]->id);	
		return $tree;
}
function getDownlines($parent){

		$acc = App\Account::where('account_name',$parent)->get();
		$tree = App\Account::with('member')->with('memberSponsor')->with('memberUpline')->descendantsAndSelf($acc[0]->id);	
		return $tree;
}
function getDownlineFromTos($parent,$from,$to){

		$acc = App\Account::where('account_name',$parent)->get();
		$tree = App\Account::with('member')->with('memberSponsor')->with('memberUpline')->whereBetween('_date', [$from, $to])->descendantsAndSelf($acc[0]->id);	
		return $tree;
}
function sortByLevel($a, $b){
	$a = $a['level'];
	$b = $b['level'];
	if ($a == $b){
		return 0;
	}
	return ($a < $b) ? -1 : 1;
}
function date_sort($a, $b) {
    return strtotime($a) - strtotime($b);
}




function isFirstTimeEncashment($username,$account_name){
	$bool = 'true';
	$encashment = App\Encashment::where('member_username','=',$username)->where('account_name','=',$account_name)->where('status','=','PAID')->get();
	if(count($encashment)>0){
		$bool = 'false';
	}
	return $bool;
}






// function getTotalAccountMoveToWallet($account_name){
	// $totalMoveToWallet = 0;
	// $moveToWallet = App\MoveToWallet::where('account_name','=',$account_name)->get();
	// foreach($moveToWallet as $move){
		// $totalMoveToWallet = $totalMoveToWallet +  $move->amount;
	// }
	// return $totalMoveToWallet;
// }
// function getTotalMoveToWallet($username){
	// $totalMoveToWallet = 0;
	// $moveToWallet = App\MoveToWallet::where('member_username','=',$username)->get();
	// foreach($moveToWallet as $move){
		// $totalMoveToWallet = $totalMoveToWallet +  $move->amount;
	// }
	// return $totalMoveToWallet;
// }
function getSettings(){
	$settings =  App\Settings::where('id', '=', '1')->get();
	$set = $settings[0]->settings;
	$setarry =  json_decode($set);
	return $setarry;
}

////////////// dashboard admin
function getTotalRegisteredMembers(){
	$members = App\Member::select('id')->count();
	return $members;
}
function getTotalActiveMembers(){
	$members = App\Member::select('id')->where('member_status','=','ACTIVE')->count();
	return $members;
}
function getTotalPaidAccounts(){
	$acc = App\Account::select('id')->where('slot','=','PAID')->count();
	return $acc;
}
function getTotalFreeAccounts(){
	$acc = App\Account::select('id')->where('slot','=','FREE')->count();
	return $acc;
}
function getTotalAvailableCodes(){
	$epins = App\Epins::select('id')->where('status','=','UNUSED')->count();
	return $epins ;
}

function getTotalPaidEncashment(){
	$encashment = App\Encashment::select('amount')->where('status','=','PAID')->sum('amount');
	return $encashment;
}
function getTotalPendingEncashment(){
	$encashment = App\Encashment::select('amount')->where('status','=','PENDING')->sum('amount');
	return $encashment;
}

function getTotalPaidEncashmentGC(){
	$encashment = App\Encashment::select('amount')->where('status','=','PAID')->sum('amount');
	return $encashment;
}
function getTotalPendingEncashmentGC(){
	$encashment = App\Encashment::select('amount')->where('status','=','PENDING')->sum('amount');
	return $encashment;
}


function getTotalPaidAccountsDiamond(){
	$acc = App\Account::select('id')->where('slot','=','PAID')->where('entry','=','DIAMOND')->count();
	return $acc;
}
function getTotalPaidAccountsGold(){
	$acc = App\Account::select('id')->where('slot','=','PAID')->where('entry','=','GOLD')->count();
	return $acc;
}
function getTotalPaidAccountsSilver(){
	$acc = App\Account::select('id')->where('slot','=','PAID')->where('entry','=','SILVER')->count();
	return $acc;
}

function getTotalFreeAccountsDiamond(){
	$acc = App\Account::select('id')->where('slot','=','FREE')->where('entry','=','DIAMOND')->count();
	return $acc;
}
function getTotalFreeAccountsGold(){
	$acc = App\Account::select('id')->where('slot','=','FREE')->where('entry','=','GOLD')->count();
	return $acc;
}
function getTotalFreeAccountsSilver(){
	$acc = App\Account::select('id')->where('slot','=','FREE')->where('entry','=','SILVER')->count();
	return $acc;
}



function getAvailableActivationCodeDiamondFree(){
	$pins = App\Epins::select('entry','slot','status')->where('status','=','UNUSED')->where('slot','=','FREE')->where('entry','=','DIAMOND')->count();
	return $pins;
}
function getAvailableActivationCodeGoldFree(){
	$pins = App\Epins::select('entry','slot','status')->where('status','=','UNUSED')->where('slot','=','FREE')->where('entry','=','GOLD')->count();
	return $pins;
}
function getAvailableActivationCodeSilverFree(){
	$pins = App\Epins::select('entry','slot','status')->where('status','=','UNUSED')->where('slot','=','FREE')->where('entry','=','SILVER')->count();
	return $pins;
}


function getAvailableActivationCodeDiamondPaid(){
	$pins = App\Epins::select('entry','slot','status')->where('status','=','UNUSED')->where('slot','=','PAID')->where('entry','=','DIAMOND')->count();
	return $pins;
}
function getAvailableActivationCodeGoldPaid(){
	$pins = App\Epins::select('entry','slot','status')->where('status','=','UNUSED')->where('slot','=','PAID')->where('entry','=','GOLD')->count();
	return $pins;
}
function getAvailableActivationCodeSilverPaid(){
	$pins = App\Epins::select('entry','slot','status')->where('status','=','UNUSED')->where('slot','=','PAID')->where('entry','=','SILVER')->count();
	return $pins;
}


function getTotalProductInventory(){
	$prodEpins = App\ProductEpins::where('status','=','UNUSED')
    ->groupBy('product')
    ->get(array(DB::raw('COUNT(id) as total'),'product'));
    return $prodEpins;
}

function getTotalProductInventoryUSED(){
	$prodEpins = App\ProductEpins::where('status','=','USED')
    ->groupBy('product')
    ->get(array(DB::raw('COUNT(id) as total'),'product'));
    return $prodEpins;
}






function getTotalPool(){
	$poolCount1 = App\Account::select('pool_bonus','entry')->where('pool_bonus','>=','4500')->where('entry','=','1500')->count();
	$poolCount2 = App\Account::select('pool_bonus','entry')->where('pool_bonus','>=','1500')->where('entry','=','750')->count();
	
	$pool1 = $poolCount1 * 4500;
	$pool2 = $poolCount2 * 1500;
	$pool3 = App\Account::select('pool_bonus','entry')->where('pool_bonus','<','4500')->where('entry','=','1500')->sum('pool_bonus');
	$pool4 = App\Account::select('pool_bonus','entry')->where('pool_bonus','<','1500')->where('entry','=','750')->sum('pool_bonus');
	
	$totalPool = $pool1 + $pool2 + $pool3 + $pool4;
	return $totalPool;
}
function getTotalGiftCheques(){
	$cheque = App\BonusIncome::select('amount','type')->where('TYPE', '=', 'PAIRINGGC')->sum('amount');	
	return $cheque;
}

function getTotalIncome(){
	$income = App\BonusIncome::select('amount','type')->sum('amount');
	return $income;
}

function getTotalGiftChequesByDate($date){
	$cheque = App\BonusIncome::select('amount','type','created_at')->where('created_at','like',$date.'%')->where('TYPE', '=', 'PAIRINGGC')->sum('amount');
			
	return $cheque;
}
function getTotalIncomeByDate($date){
	$cheque = App\BonusIncome::select('amount','type','created_at')->where('created_at','like',$date.'%')->sum('amount');
			
	return $cheque;
}
function getTotalPaidAccountsByDate($date){
	$acc = App\Account::select('id','created_at')->where('slot','=','PAID')->where('created_at','like',$date.'%')->count();
	return $acc;
}
function getTotalFreeAccountsByDate($date){
	$acc = App\Account::select('id','created_at')->where('slot','=','FREE')->where('created_at','like',$date.'%')->count();
	return $acc;
}
function getTotalRegisteredMembersByDate($date){
	$members = App\Member::select('id','created_at')->where('created_at','like',$date.'%')->count();
	return $members;
}







function getAccounts($username){
	$account = App\Account::where('owner_username','=',$username)->get();
	return $account;
}
function ifphotogreetingsexist( $path )
{
    if(file_exists($path)){
		return 'true';
	}else{
		return 'false';
	}
}
function getUserIdbyUsername($username){
	$user = App\User::where('username','=',$username)->get();
	if(count($user)>0){
		return $user[0]->id;
	}else{
		return '0';
	}
}
function getUserGreetingsbyUsername($username){
	$member = App\Member::where('username','=',$username)->get();
	if(count($member)>0){
		return $member[0]->greetings;
	}else{
		return '';
	}
}
function generateAcountName($username){
	$x=1;
	$accName = $username.'-'.$x;
		while(App\Account::where('account_name','=',$accName)->exists()){
			$x++;
			$accName = $username.'-'.$x;
		}
	return $accName;	
}








///// new codes
function addIncome($username,$member_id,$type,$amount,$actual_amount,$remarks,$account_name,$account_id,$updated_by_username,$updated_by_id){

	$bonus = new App\BonusIncome;
	$bonus->username = $username;
	$bonus->member_id = $member_id;
	$bonus->type = $type; 
	$bonus->amount = $amount;
	$bonus->actual_amount = $actual_amount;
	$bonus->remarks = $remarks;
	$bonus->account_name = $account_name;
	$bonus->account_id = $account_id;
	$bonus->inwallet = 'true';
	$bonus->updated_by_username = $updated_by_username;
	$bonus->updated_by_id = $updated_by_id;
	$bonus->save();
}


function getIncomeHistory($username,$account_name){
	$bonusIncomeHistory = App\BonusIncome::select('username','account_name','created_at','remarks','amount')->where('username',$username)->where('account_name',$account_name)->orderBy('created_at','desc')->get();
	return $bonusIncomeHistory;
}



function getTotalReferralIncome($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','DIRECT')->sum('amount');
	return $achiever;
}
function getTotalReferralIncomeGC($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','DIRECTGC')->sum('amount');
	return $achiever;
}
function getTotalIndirectIncome($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','INDIRECT')->sum('amount');
	return $achiever;
}
function getTotalCycleGC($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','CYCLEGC')->sum('amount');
	return $achiever;
}
function getTotalSalesMatch($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','SALESMATCH')->sum('amount');
	return $achiever;
}
function getTotalUnilevel($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','UNILEVEL')->sum('amount');
	return $achiever;
}
function getTotalLeadership($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','LEADERSHIP')->sum('amount');
	return $achiever;
}
function getTotalEncashment($username,$account_name){
	$encashment = App\Encashment::where('member_username','=',$username)->where('account_name',$account_name)->where('status','!=','CANCELLED')->sum('amount');
	return $encashment;
}
function getTotalDirect($username,$account_name){
	$direct = App\Account::where('account_sponsor','=',$account_name)->where('slot','=','PAID')->count();
	return $direct;
}

function getTotalInDirect($username,$account_name){
	$total = 0;
	$direct = App\Account::where('account_sponsor','=',$account_name)->where('slot','=','PAID')->get();
	foreach($direct  as $directAcc){
		$indirect = App\Account::where('account_sponsor','=',$directAcc->account_name)->where('slot','=','PAID')->count();
		$total = $total + $indirect;
	}
	return $total;
}


function getTotalEncashmentOverAllRank($username){
	$encashment = App\Encashment::where('member_username','=',$username)->where('status','!=','CANCELLED')->sum('amount');
	$rank = "DISTRIBUTOR";
	if($rank<=15000){
		$rank = "DISTRIBUTOR";
	}elseif($encashment>=15001||$encashment<=25000){
		$rank = "RISING STAR";
	}elseif($encashment>=25001||$encashment<=50000){
		$rank = "EAGLES CLUB";
	}elseif($encashment>=50001||$encashment<=100000){
		$rank = "ELITE CLUB";
	}elseif($encashment>=100001||$encashment<=250000){
		$rank = "SAPPHIRE EXECUTIVE";
	}elseif($encashment>=250001||$encashment<=500000){
		$rank = "RUBY EXECUTIVE";
	}elseif($encashment>=500001||$encashment<=750000){
		$rank = "EMERALD EXECUTIVE";
	}elseif($encashment>=750001||$encashment<=1000000){
		$rank = "DIAMOND EXECUTIVE";
	}elseif($encashment>1000001){
		$rank = "MILLIONARES CIRCLE";
	}
	return $rank;
}





function insertIncome($account_name){
	
	$acc = App\Account::where('account_name',$account_name)->get();
	$uplines = App\Account::select('account_name','id','last_pair','added_pair','last_pair_date','owner_member_id','owner_username','entry','slot','account_sponsor','position','placement','remaining_left','remaining_right','counter_pairs','total_pair_amount')->whereAncestorOf($acc[0]->id)->reversed()->get();
	$dateNow = getDatetimeNow();
	$dateToday = explode(" ",$dateNow);
	
	
	$count = 0;
	foreach($uplines as $upline){

			
			$entry = $upline->entry;

			$counter_pairs = $upline->counter_pairs;
			$total_pair_amount = $upline->total_pair_amount;
			$flushleft = $upline->flushout_left;
			$flushright = $upline->flushout_right;

			$limitPerday = 0;
			$silver = 250;
			$gold = 500;
			$diamond = 1000;
			if($entry=='DIAMOND'){
		
				$perPairInfinite = 1800;
				$perpairmultiplier = 9;

				$firstlvl = 10000;
				$perPair = 1000;
				$silverPair = 250;
				$goldPair = 500;
				$diamondPair = 1000;
			}elseif($entry=='GOLD'){

				$perPair = 500;
				$perPairInfinite = 900;
				$perpairmultiplier = 9;

				$firstlvl = 5000;
				$perPair = 500;
				$silver = 250;
				$gold = 500;
				$diamond = 500;
			}else{
				
				$perPairInfinite = 450;
				$perpairmultiplier = 5;

				$firstlvl = 2500;
				$perPair = 250;
				$silver = 250;
				$gold = 250;
				$diamond = 250;
			}

			$acc1 = App\Account::where('placement',$upline->account_name)->where('position','LEFT')->get();
			$acc2 = App\Account::where('placement',$upline->account_name)->where('position','RIGHT')->get();
			
		
			$treeLeftCount = 0 - $flushleft;;
			$treeLeftTotalPointsConsumed = 0;
			if(count($acc1)>0){
				$treeLeft = App\Account::select('_date','points','slot','entry')->where('slot','PAID')->descendantsAndSelf($acc1[0]->id);
				$treeLeftCount = count($treeLeft);
			}
		
			$treeRightCount = 0 - $flushright;
			$treeRightTotalPointsConsumed = 0;
			if(count($acc2)>0){
				$treeRight = App\Account::select('_date','points','slot','entry')->where('slot','PAID')->descendantsAndSelf($acc2[0]->id);		
				$treeRightCount = count($treeRight);			
			}
	
			
			
			$leftAmount = 0;
			if($treeLeftCount>0){
				foreach ($treeLeft as  $left) {
					$leftEntry = $left->entry;

					if($leftEntry=='DIAMOND'){
						$ppair = $diamond;
					}elseif($leftEntry=='GOLD'){
						$ppair = $gold;
					}else{
						$ppair = $silver;
					}

					if($leftAmount<=$firstlvl){
						$lm = $leftAmount + $ppair;
						if($lm>=$firstlvl){
							$out = $lm - $firstlvl;
							$in = $ppair - $out;

							$computed = ( $out * 2 ) * .10;
							$out = ( $out * 2 ) - $computed;
							$leftAmount = $leftAmount + $in + $out;
						}else{
							$leftAmount = $leftAmount + $ppair;
						}
						
					}elseif($leftAmount>$firstlvl){
						$comp = ($ppair*2) * .10;
						$comp = ($ppair*2) - $comp;
						$leftAmount = $leftAmount + $comp;
					}

				}
			}

			$rightAmount = 0;
			if($treeRightCount>0){
				foreach ($treeRight as  $right) {
					$rightEntry = $right->entry;
					if($rightEntry=='DIAMOND'){
						$ppair2 = $diamond;
					}elseif($rightEntry=='GOLD'){
						$ppair2 = $gold;
					}else{
						$ppair2 = $silver;
					}

					if($rightAmount<=$firstlvl){
						$rm = $rightAmount + $ppair2;
						if($rm>=$firstlvl){
							$out = $rm - $firstlvl;
							$in = $ppair2 - $out;

							$computed = ( $out * 2 ) * .10;
							$out = ( $out * 2 ) - $computed;
							$rightAmount = $rightAmount  + $in + $out;
						}else{
							$rightAmount = $rightAmount + $ppair2;
						}
						
					}elseif($rightAmount>$firstlvl){
						$comp = ($ppair2*2) * .10;
						$comp = ($ppair2*2) - $comp;
						$rightAmount = $rightAmount + $comp;
					}

				}
			}

			$count_pairs = 0;
			$remaining_left = 0;
			$remaining_right = 0;
			$leftAmount = $leftAmount - $total_pair_amount;
			$rightAmount = $rightAmount - $total_pair_amount;

			$newPairAmount = 0;
			if($leftAmount>=$rightAmount){
				$newPairAmount = $rightAmount;
				$remaining_left = $leftAmount - $rightAmount;
			}else{
				$newPairAmount = $leftAmount;
				$remaining_right = $rightAmount - $leftAmount;
			}
			if($newPairAmount>0){
				$count_pairs = $counter_pairs + 1;
			}
			$total_pair_amount = $total_pair_amount + $newPairAmount;

			$countGc = countCycleGC($upline->owner_username,$upline->account_name);
			$gc = $perPair;
			$limitPerday = $perPair * $perpairmultiplier;
			if($countGc==1){
				$gc = $perPair;
				//$perPair = $perPair * 2;
				//$perPair = $perPair - ($perPair * .10);
				$limitPerday = $perPair + ($perPairInfinite * $perpairmultiplier );
				
			}elseif($countGc>=2){
				$gc = $perPairInfinite;
				//$perPair = $perPair * 2;
				//$perPair = $perPair - ($perPair * .10);
				$limitPerday = $perPairInfinite * $perpairmultiplier;
				
			}
			$multiple = 5;
			$nextcountGc = $countGc + 1;
			$limitToGc = $perPair * $multiple;
			$limitToGc = $limitToGc *  $nextcountGc;
			$firstlimitToGc = $limitToGc - $gc;

			$sumtotal = sumPairingTodayTotal($upline->account_name);
			$sumtotal = $sumtotal + $newPairAmount;
			if($sumtotal>$limitPerday){

				$flushout = $sumtotal - $limitPerday;
				$in = $newPairAmount - $flushout;
				
				if($in>0){
					$total_pair_amount = $total_pair_amount + $in;
				}

				$accounts = App\Account::find( $upline->id );
				$accounts->flushout_right = $flushout;
				$accounts->flushout_left = $flushout;
				$accounts->touch();
				$accounts->save();

			}


				$less = 0;
					if($total_pair_amount > $firstlimitToGc ){


						$less = $total_pair_amount - $firstlimitToGc;
						$remainingToPair = 0;
						if($less>=$gc){
							
							$newIncomePairAmount = $total_pair_amount - $limitToGc;
							// if($countGc>1){
							// 	$newIncomePairAmountless = ($newIncomePairAmount * 2) * .10;
							// 	$newIncomePairAmount = $newIncomePairAmount - $newIncomePairAmountless;
							// }
							

							addIncome($upline->owner_username,$upline->owner_member_id, "CYCLEGC" , $gc , $gc, 'EARNED 5th CYCLE MATCH BONUS' ,$upline->account_name,$upline->id,Auth::user()->username,Auth::user()->member->id);

								if($newIncomePairAmount>0){
									if($entry=='DIAMOND'){
										if($newIncomePairAmount>1800){
											$newIncomePairAmount=1800;
										}
									}elseif($entry=='GOLD'){
										if($newIncomePairAmount>900){
											$newIncomePairAmount=900;
										}
									}else{
										if($newIncomePairAmount>450){
											$newIncomePairAmount=450;
										}
									}
									$pairIncome = $newIncomePairAmount - ( $newIncomePairAmount * .10 );
									
									addIncome($upline->owner_username,$upline->owner_member_id, "SALESMATCH" ,$pairIncome , $newIncomePairAmount, 'EARNED SALES MATCH BONUS' ,$upline->account_name,$upline->id,Auth::user()->username,Auth::user()->member->id);
									
									//add leadership bonus 3%
									$actualLeadershipBonus = $pairIncome * .03;
									$leadershipBonusLessTax = $actualLeadershipBonus * .10;
									$leadershipBonus = $actualLeadershipBonus - $leadershipBonusLessTax;
									$accSponsor = App\Account::where('account_name',$upline->account_sponsor)->get();
									if(count($accSponsor)>0){
										if($accSponsor[0]->entry=='DIAMOND'){
										addIncome($accSponsor[0]->owner_username,$accSponsor[0]->owner_member_id,'LEADERSHIP',$leadershipBonus , $actualLeadershipBonus,'EARNED LEADERSHIP BONUS',$accSponsor[0]->account_name,$accSponsor[0]->id,Auth::user()->username,Auth::user()->member->id);
										}
									}	
								}
								$accounts = App\Account::find( $upline->id );
								$accounts->counter_pairs = $count_pairs;
								$accounts->remaining_left = $remaining_left;
								$accounts->remaining_right = $remaining_right;
								$accounts->total_pair_amount = $total_pair_amount;
								$accounts->touch();
								$accounts->save();


							

							}else{

								$newIncomePairAmount = $newPairAmount - $less;
								if($newIncomePairAmount>0){
									if($entry=='DIAMOND'){
										if($newIncomePairAmount>1800){
											$newIncomePairAmount=1800;
										}
									}elseif($entry=='GOLD'){
										if($newIncomePairAmount>900){
											$newIncomePairAmount=900;
										}
									}else{
										if($newIncomePairAmount>450){
											$newIncomePairAmount=450;
										}
									}
									$pairIncome = $newIncomePairAmount - ( $newIncomePairAmount * .10 );

									addIncome($upline->owner_username,$upline->owner_member_id, "SALESMATCH" ,$pairIncome , $newIncomePairAmount, 'EARNED SALES MATCH BONUS' ,$upline->account_name,$upline->id,Auth::user()->username,Auth::user()->member->id);
									
									//add leadership bonus 3%
									$actualLeadershipBonus = $pairIncome * .03;
									$leadershipBonusLessTax = $actualLeadershipBonus * .10;
									$leadershipBonus = $actualLeadershipBonus - $leadershipBonusLessTax;
									$accSponsor = App\Account::where('account_name',$upline->account_sponsor)->get();
									if(count($accSponsor)>0){
										if($accSponsor[0]->entry=='DIAMOND'){
										addIncome($accSponsor[0]->owner_username,$accSponsor[0]->owner_member_id,'LEADERSHIP',$leadershipBonus , $actualLeadershipBonus,'EARNED LEADERSHIP BONUS',$accSponsor[0]->account_name,$accSponsor[0]->id,Auth::user()->username,Auth::user()->member->id);
										}
									}	
								}

								$accounts = App\Account::find( $upline->id );
								$accounts->counter_pairs = $count_pairs;
								$accounts->remaining_left = $remaining_left;
								$accounts->remaining_right = $remaining_right;
								$accounts->total_pair_amount = $total_pair_amount;
								$accounts->touch();
								$accounts->save();

							}
						

					}else{

						$newIncomePairAmount = $newPairAmount;
						$accounts = App\Account::find( $upline->id );
						$accounts->counter_pairs = $count_pairs;
						$accounts->remaining_left = $remaining_left;
						$accounts->remaining_right = $remaining_right;
						$accounts->total_pair_amount = $total_pair_amount;
						$accounts->touch();
						$accounts->save();

						if($newIncomePairAmount>0){
								$pairIncome = $newIncomePairAmount - ( $newIncomePairAmount * .10 );
								addIncome($upline->owner_username,$upline->owner_member_id, "SALESMATCH" ,$pairIncome , $newIncomePairAmount, 'EARNED SALES MATCH BONUS' ,$upline->account_name,$upline->id,Auth::user()->username,Auth::user()->member->id);
								
								//add leadership bonus 3%
								$actualLeadershipBonus = $pairIncome * .03;
								$leadershipBonusLessTax = $actualLeadershipBonus * .10;
								$leadershipBonus = $actualLeadershipBonus - $leadershipBonusLessTax;
								$accSponsor = App\Account::where('account_name',$upline->account_sponsor)->get();
								if(count($accSponsor)>0){
									if($accSponsor[0]->entry=='DIAMOND'){
									addIncome($accSponsor[0]->owner_username,$accSponsor[0]->owner_member_id,'LEADERSHIP',$leadershipBonus , $actualLeadershipBonus,'EARNED LEADERSHIP BONUS',$accSponsor[0]->account_name,$accSponsor[0]->id,Auth::user()->username,Auth::user()->member->id);
									}
								
								}
								
								
						}

					}



			


			














	}
	
}




function countCycleGC($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','CYCLEGC')->get();
	return count($achiever);
}
function sumTotalSalesMatch($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','SALESMATCH')->sum('actual_amount');
	return $achiever;
}
function sumPairingToday($account_name){
	$dateNow = getDatetimeNow();
	$dateToday = explode(" ",$dateNow);
	$pairing = App\BonusIncome::where('account_name',$account_name)->where('created_at','like',$dateToday[0].'%')->where(function($query)
            {
                $query->where('TYPE', '=', 'SALESMATCH');
            })->sum('actual_amount');
	return $pairing;
}
function sumPairingTodayGC($account_name){
	$dateNow = getDatetimeNow();
	$dateToday = explode(" ",$dateNow);
	$pairing = App\BonusIncome::select('account_name','type')->where('account_name',$account_name)->where('created_at','like',$dateToday[0].'%')->where(function($query)
            {
                $query->where('TYPE', '=', 'CYCLEGC');
            })->sum('actual_amount');
	return $pairing;
}
function sumPairingTodayTotal($account_name){
	$dateNow = getDatetimeNow();
	$dateToday = explode(" ",$dateNow);
	$pairing = App\BonusIncome::select('account_name','type')->where('account_name',$account_name)->where('created_at','like',$dateToday[0].'%')->where(function($query)
            {
                $query->where('TYPE', '=', 'SALESMATCH')->orWhere('TYPE', '=', 'CYCLEGC');
            })->sum('actual_amount');
	return $pairing;
}
function getTotalWallet($username,$account_name){
	$account = App\Account::where('owner_username',$username)->where('account_name',$account_name)->get();
	if(count($account)==0){
		return 0;
	}
	

	$incomePairing = App\BonusIncome::where('username',$username)->where('account_name',$account_name)->where('inwallet','TRUE')->where('type', '=', "SALESMATCH")->sum('amount');
	$incomeDirect = App\BonusIncome::where('username',$username)->where('account_name',$account_name)->where('inwallet','TRUE')->where('type', '=', "DIRECT")->sum('amount');
	$incomeLeadership = App\BonusIncome::where('username',$username)->where('account_name',$account_name)->where('inwallet','TRUE')->where('type', '=', "LEADERSHIP")->sum('amount');
	$incomeIndirect = App\BonusIncome::where('username',$username)->where('account_name',$account_name)->where('inwallet','TRUE')->where('type', '=', "INDIRECT")->sum('amount');
    $incomeUnilevel = App\BonusIncome::where('username',$username)->where('account_name',$account_name)->where('inwallet','TRUE')->where('type', '=', "UNILEVEL")->sum('amount');

	$totalEncash = getTotalEncashment($username,$account_name);

	$subTotal =   $incomePairing + $incomeDirect + $incomeLeadership + $incomeIndirect + $incomeUnilevel;
	$total = $subTotal - $totalEncash;
	if($total<0){
		$total = 0;
	}
	return $total;
}

function getTotalWalletTesting($username,$account_name){
	$account = App\Account::where('owner_username',$username)->where('account_name',$account_name)->get();
	if(count($account)==0){
		return 0;
	}
	

	$incomePairing = App\BonusIncome::where('username',$username)->where('account_name',$account_name)->where('inwallet','TRUE')->where('type', '=', "SALESMATCH")->sum('amount');
	$incomeDirect = App\BonusIncome::where('username',$username)->where('account_name',$account_name)->where('inwallet','TRUE')->where('type', '=', "DIRECT")->sum('amount');
	$incomeLeadership = App\BonusIncome::where('username',$username)->where('account_name',$account_name)->where('inwallet','TRUE')->where('type', '=', "LEADERSHIP")->sum('amount');
	$incomeIndirect = App\BonusIncome::where('username',$username)->where('account_name',$account_name)->where('inwallet','TRUE')->where('type', '=', "INDIRECT")->sum('amount');
    $incomeUnilevel = App\BonusIncome::where('username',$username)->where('account_name',$account_name)->where('inwallet','TRUE')->where('type', '=', "UNILEVEL")->sum('amount');

	$totalEncash = getTotalEncashment($username,$account_name);

	$subTotal =   $incomePairing + $incomeDirect + $incomeLeadership + $incomeIndirect + $incomeUnilevel;
	$total = $subTotal - $totalEncash;
	if($total<0){
		$total = 0;
	}
	return $total;
}

function getTotalReferralIncomeNotEncash($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','DIRECT')->where('iswithdraw','=','FALSE')->sum('amount');
	return $achiever;
}
function getTotalIndirectIncomeNotEncash($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','INDIRECT')->where('iswithdraw','=','FALSE')->sum('amount');
	return $achiever;
}
function getTotalSalesMatchNotEncash($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','SALESMATCH')->where('iswithdraw','=','FALSE')->sum('amount');
	return $achiever;
}
function getTotalUnilevelNotEncash($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','UNILEVEL')->where('iswithdraw','=','FALSE')->sum('amount');
	return $achiever;
}
function getTotalLeadershipNotEncash($username,$account_name){
	$achiever = App\BonusIncome::where('username','=',$username)->where('account_name',$account_name)->where('TYPE','=','LEADERSHIP')->where('iswithdraw','=','FALSE')->sum('amount');
	return $achiever;
}



function getifQualified($account_name){
	$dateNow = getDatetimeNow();
	$dateToday = explode(" ",$dateNow);
	$dateYearMonthDay = explode("-",$dateToday[0]);
	$acc = App\Account::where('account_name','=',$account_name)->get();
	$qualified = 'NO';
	if(count($acc)>0){
		$productYearDate = explode("-",$acc[0]->product_points_date);
		$prodctYearDate = $productYearDate[0].'-'.$productYearDate[1];
		if($acc[0]->product_points>=150&&$prodctYearDate==$dateYearMonthDay[0].'-'.$dateYearMonthDay[1]){
			$qualified = 'YES';
		}else{
			$qualified = 'NO';
		}
	}
	return $qualified;
}
function getUnilevelPV($account_name){
	$dateNow = getDatetimeNow();
	$dateToday = explode(" ",$dateNow);
	$dateYearMonthDay = explode("-",$dateToday[0]);
	$acc = App\Account::where('account_name','=',$account_name)->get();
	$total = 0;
	// if(count($acc)>0){
	// 	$productYearDate = explode("-",$acc[0]->product_points_date);
	// 	$prodctYearDate = $productYearDate[0].'-'.$productYearDate[1];

	// 	$ownRebate = $acc[0]->own_rebate;
	// 	if($acc[0]->product_points>=150&&$prodctYearDate==$dateYearMonthDay[0].'-'.$dateYearMonthDay[1]){
	// 		$lvl = $acc[0]->lvl;
	// 		$tree = App\Referral::orderBy('lvl','asc')->descendantsOf(183);
	// 		foreach ($tree as $down) {
	// 			$points = $down->product_points;
	// 			$pointsDate = $down->product_points_date;
	// 			$isClaimed = $down->isclaimed;
	// 			$productYearMonth = explode("-",$pointsDate);
	// 			$downlineDate = $productYearMonth[0].'-'.$productYearMonth[1];
	// 			if($points>0&&$downlineDate==$dateYearMonthDay[0].'-'.$dateYearMonthDay[1]&&$isClaimed=='FALSE'){
	

	// 				if(){

	// 				}

	// 			}
	// 		}
	// 	}else{
	// 		$total = 0;
	// 	}
	// }
	return 0;
}
function getTotalEncashmentGC($username,$account_name){
	$encashment = App\EncashmentGC::where('member_username','=',$username)->where('account_name',$account_name)->where('status','!=','CANCELLED')->sum('amount');
	return $encashment;
}
function getTotalAvailableGC($username,$account_name){
	$availableGC = 0;
	$totalGC = getTotalCycleGC($username,$account_name);
	$totalGCEncash = getTotalEncashmentGC($username,$account_name);
	$availableGC = $totalGC - $totalGCEncash;
	return $availableGC;
}




function insertUnilevel($account_name,$num,$amount,$points){
	$acc = App\Account::select('id','account_name','account_sponsor','product_points_date','product_points','unilevel')->where('account_name',$account_name)->get();
	if(count($acc)>0){
		$dateNow = getDatetimeNow();
		$date = explode(" ",$dateNow);
		$dates = explode("-",$date[0]);
		$thisMonth = $dates[0].'-'.$dates[1];

		$maintainDate = $acc[0]->product_points_date;
		$date2s = explode("-",$maintainDate);
		$thisMonthMaintainDate = $date2s[0].'-'.$date2s[1];	

		if($thisMonth==$thisMonthMaintainDate){
			App\Account::where('id', $acc[0]->id)
		    ->update([
		      'unilevel'=> DB::raw('unilevel+'.$amount),
		      'isclaimed'=> 'NO',
		    ]);
		}else{
			App\Account::where('id', $acc[0]->id)
		    ->update([
		      'unilevel'=> $amount,
		      'product_points'=> 0,
		      'product_points_date'=> $date[0],
		      'isclaimed'=> 'NO',
		    ]);	
		}



		$accountName = $acc[0]->account_sponsor;
		$number = $num+1;
		if($number<10){
			insertUnilevel($accountName,$number,$amount,$points);
		}
	}
}
function getNameByUsername($username) {
	$name = "";
	$acc = App\Member::select('id','first_name','last_name','username')->where('username',$username)->get();
	if(count($acc)>0){
		$name = $acc[0]->first_name." ".$acc[0]->last_name ;
	}
	return $name;
}
?>