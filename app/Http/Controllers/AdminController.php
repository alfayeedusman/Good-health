<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\LoadMobileTopUp;
use App\LoadWallet;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\YepBonus;
use App\Settings;
use App\User;
use App\GoldEncashment;
use App\ShareLinks;
use App\Encashment;
use App\EncashmentGC;
use App\YepEncashment;
use App\Purchase;
use App\Epins;
use App\ProductEpins;
use App\Account;
use App\RetrieveCode;
use App\TransferCode;
use App\Member;
use App\BonusIncome;
use Validator;
use Auth;
use Hash;
use Session;
use DB;
use Response;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');	
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				$user = Auth::user()->member->get();
                //generateEpins();
				//$aa = getDownline("","");
				//return json_encode($aa);
				if(isset($_GET['filter'])){
					$filter = $_GET['filter'];
					if($filter=="week"){
						 $topEncash = DB::table('bonus_income_tbl')
		                 ->select(DB::raw('sum(amount) as amount'),'account_name','username')
		                 ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
		                 ->orderBy('amount','desc')
		                 ->groupBy('account_name','username')
		                 ->take(100)
		                 ->get();
					}elseif($filter=="month"){
						 $topEncash = DB::table('bonus_income_tbl')
		                 ->select(DB::raw('sum(amount) as amount'),'account_name','username')
		                 ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
		                 ->orderBy('amount','desc')
		                 ->groupBy('account_name','username')
		                 ->take(100)
		                 ->get();


					}elseif($filter=="lastweek"){
						 $topEncash = DB::table('bonus_income_tbl')
		                 ->select(DB::raw('sum(amount) as amount'),'account_name','username')
		                 ->whereBetween('created_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])
		                 ->orderBy('amount','desc')
		                 ->groupBy('account_name','username')
		                 ->take(100)
		                 ->get();
					}else{
					     $topEncash = DB::table('bonus_income_tbl')
    	                 ->select(DB::raw('sum(amount) as amount'),'account_name','username')
    	                 ->orderBy('amount','desc')
    	                 ->groupBy('account_name','username')
    	                 ->take(50)
    	                 ->get();
					}
					
				}elseif(isset($_GET['from'])&&isset($_GET['to'])){
						$from = $_GET['from'];
						$to = $_GET['to'];	
						$topEncash = DB::table('bonus_income_tbl')
		                 ->select(DB::raw('sum(amount) as amount'),'account_name','username')
		                 ->whereBetween('created_at', [$from, $to])
		                 ->orderBy('amount','desc')
		                 ->groupBy('account_name','username')
		                 ->take(100)
		                 ->get();
				}else{
					 $topEncash = DB::table('bonus_income_tbl')
	                 ->select(DB::raw('sum(amount) as amount'),'account_name','username')
	                 ->orderBy('amount','desc')
	                 ->groupBy('account_name','username')
	                 ->take(100)
	                 ->get();
				}
				
				return view('layouts.admin.index')->with('topEncash',$topEncash);
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function members(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				if(isset($_GET['sponsor'])){
					$sponsor = $_GET['sponsor'];	
					$members = Member::where('role','=','MEMBER')->where('sponsor','=',$sponsor)->orderBy('created_at','=','desc')->paginate(100);
				}else{
					if(isset($_GET['search'])){
						$search = $_GET['search'];	
						$members = Member::where('role','=','MEMBER')
						->where(function($query) use($search){
							$query->where('first_name', 'LIKE', $search.'%' )
								->orWhere('last_name', 'LIKE',  $search.'%')
								->orWhere('username', 'LIKE',  $search.'%');
						})
						->orderBy('created_at','=','desc')->paginate(100);
					}else{
						$members = Member::where('role','=','MEMBER')->orderBy('created_at','=','desc')->paginate(100);
					}
				}
				return  view('layouts.admin.members')->with('members',$members);

				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function membersInfo($id){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				$user = Auth::user()->member->get();
				$decryptedid = encryptor('decrypt', $id );
				$member = Member::with('user')->where('id',$decryptedid )->get();
				return view('layouts.admin.member-info')
				->with('member',$member);
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postProfile($id,Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				$decryptedmemid = encryptor('decrypt', $id );
				$data = $request->all();
				$rules = array(
					'mobile'    => 'required|digits:11',
					'address' => 'required|max:200' 
				);
				$validator = Validator::make($data , $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());  
				}else{
					$member = Member::find($decryptedid);
					$member->mobile = $data['mobile'];
					$member->address = $data['address'];
					$member->touch();
					$member->save();
					Session::flash('success-message', "Contact info has been updated.");
					return redirect()->back();
				}
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postSecurity($id,Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				$decrypteduserid = encryptor('decrypt', $id );
				$data = $request->all();
				$rules = array(
					'password' => 'required|string|min:6|confirmed',
				);
				$validator = Validator::make($data , $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());  
				}else{
					$passwordEncrptd = encryptor('encrypt', $data['password'] );
					$user = User::find($decrypteduserid);
					$user->password = bcrypt($data['password']);
					$user->pwdcrptd = $passwordEncrptd;
					$user->touch();
					$user->save();
					Session::flash('success-message', "Password has been updated.");
					return redirect()->back();
				}
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postSecurityPin($id,Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				$decrypteduserid = encryptor('decrypt', $id );
				$data = $request->all();
				$rules = array(
					'new_pin' => 'required|digits:4' ,
					'confirm_pin' => 'required|digits:4',
				);
				$validator = Validator::make($data , $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());  
				}else{
					if($data['new_pin']==$data['confirm_pin']){
						$user = User::find($decrypteduserid);
						$user->pin = $data['new_pin'];
						$user->touch();
						$user->save();
						Session::flash('success-message', "Pin has been updated.");
						return redirect()->back();
					}else{
						return redirect()->back()->withInput()->withErrors(['Pin did not match!']);
					}
				}
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postProfileStatus($id,Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				$decrypteduserid = encryptor('decrypt', $id );
				$data = $request->all();
				$rules = array(
					'login_status' => 'required|max:20' ,
					'remarks' => 'required|max:200',
				);
				$validator = Validator::make($data , $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());  
				}else{
				
						$user = User::find($decrypteduserid);
						$user->login_status = $data['login_status'];
						$user->login_remarks = $data['remarks'];
						$user->touch();
						$user->save();
						Session::flash('success-message', "Login Status has been updated.");
						return redirect()->back();
					
				}
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function activationCodes(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				if(isset($_GET['entry'])&&isset($_GET['slot'])&&isset($_GET['status'])){
					$entry = $_GET['entry'];
					$slot = $_GET['slot'];
					$status = $_GET['status'];	
		
					$ePins = Epins::where('entry','=',$entry)->where('slot','=',$slot)->where('status','=',$status)->orderBy('created_at','desc')->paginate(1000);
				}else{
			
					$ePins = Epins::orderBy('created_at','desc')->paginate(1000);
				}
				return  view('layouts.admin.activation-codes')
				->with('ePins',$ePins);

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postActivationCodes(Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			
				$data = $request->all();
				$rules = array(
					'code' => 'required' ,
					'qty' => 'required|numeric',
					'entry' => 'required',
					'slot' => 'required|max:200',
				);
				$validator = Validator::make($data , $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());  
				}else{
				$points = 0;
				if($data['entry']=='DIAMOND'){
					$points = 4;	
				}elseif($data['entry']=='GOLD'){
					$points = 2;
				}else{
					$points = 1;
				}


				generateEpins2($data['code'],$data['slot'],$points,$data['entry'],$data['qty']);		






				Session::flash('success-message', "Login Status has been updated.");
				return redirect()->back();
					
				}
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 	
	}






	// public function activationCodesRetrieve($id){
	// 	if (Auth::check()){
	// 		if(checkloginAuthentication()=="ADMIN"){
	// 		    if(isPermitted()==false){
	// 				return  view('layouts.admin.blank');
	// 			}
	// 			$decryptedid = encryptor('decrypt',$id);
	// 			$adminID = Auth::user()->member->id;
	// 			$adminUsername = Auth::user()->member->username;

	// 			$code = Epins::where('id',$decryptedid)->where('status',"UNUSED")->get();
	// 			if(count($code)>0){	
	// 				$member = Member::where('id',$code[0]->owned_by_id )->get();
	// 				if(count($member)>0){	
					
	// 					$epin = Epins::find( $decryptedid );
	// 					$epin->owned_by_id = "0";
	// 					$epin->owned_by_username = null;
	// 					$epin->used_by_username = null;
	// 					$epin->used_by_id = null;
	// 					$epin->owned_at = null;
	// 					$epin->transfered_at = null;
	// 					$epin->transfered_by_username = null;
	// 					$epin->transfered_by_id = null;
	// 					$epin->entry = null;
	// 					$epin->points = null;
	// 					$epin->slot = null;
	// 					$epin->touch();
	// 					$epin->save();
						
	// 					$retrieve = new RetrieveCode;
	// 					$retrieve->retrieve_by = $adminID;
	// 					$retrieve->retrieve_to = $member[0]->id;
	// 					$retrieve->code = $code[0]->code;
	// 					$retrieve->retrieve_name = $member[0]->username;
	// 					$retrieve->retrieve_byname = $adminUsername;
	// 					$retrieve->save();	
	// 					$adminuser = Auth::user()->member->username;

	// 					Session::flash('message', "Code ".$code[0]->code." has been retrieve from ".$member[0]->username);
	// 					return redirect()->back();
	// 				}else{
	// 					return redirect()->back()->withInput()->withErrors(['Something went wrong. Please try again']);
	// 				}
					
	// 			}else{
	// 				return redirect()->back()->withInput()->withErrors(['Something went wrong. Please try again']);
	// 			}
				
				

	// 		}else if(checkloginAuthentication()=="USER"){
	// 			Auth::logout(); //
	// 			return redirect('/login');	
	// 		}
	// 	}else{
	// 		return redirect('/login');	
	// 	} 
 //    }
	// public function activationCodesRetrieveAll($id){
	// 	if (Auth::check()){
	// 		if(checkloginAuthentication()=="ADMIN"){
	// 		    if(isPermitted()==false){
	// 				return  view('layouts.admin.blank');
	// 			}
	// 			$adminID = Auth::user()->member->id;
	// 			$adminUsername = Auth::user()->member->username;
	// 			$decryptedmid = encryptor('decrypt',$id);
	// 			$member = Member::where('id',$decryptedmid )->get();
	// 			if(count($member)>0){	
	// 				$code = Epins::where('owned_by_id',$decryptedmid)->where('status',"UNUSED")->get();
	// 				if(count($code)>0){	
	// 					foreach($code as $codes){
	// 						$epin = Epins::find( $codes->id );
	// 						$epin->owned_by_id = "0";
	// 						$epin->owned_by_username = null;
	// 						$epin->used_by_username = null;
	// 						$epin->used_by_id = null;
	// 						$epin->owned_at = null;
	// 						$epin->transfered_at = null;
	// 						$epin->transfered_by_username = null;
	// 						$epin->transfered_by_id = null;
	// 						$epin->entry = null;
	// 						$epin->points = null;
	// 						$epin->slot = null;
	// 						$epin->touch();
	// 						$epin->save();
							
	// 						$retrieve = new RetrieveCode;
	// 						$retrieve->retrieve_by = $adminID;
	// 						$retrieve->retrieve_to = $decryptedmid;
	// 						$retrieve->code = $codes->code;
	// 						$retrieve->retrieve_name = $member[0]->username;
	// 						$retrieve->retrieve_byname = $adminUsername;
	// 						$retrieve->save();	
	// 					}	

	// 					Session::flash('message', "All UNUSED codes has been retrieve from ".$member[0]->username);
	// 					return redirect()->back();
	// 				}else{
	// 					return redirect()->back()->withInput()->withErrors(['No Unused Code.']);
	// 				}
	// 			}else{
	// 				return redirect()->back()->withInput()->withErrors(['Member doesnt exist!']);
	// 			}
				

	// 		}else if(checkloginAuthentication()=="USER"){
	// 			Auth::logout(); //
	// 			return redirect('/login');	
	// 		}
	// 	}else{
	// 		return redirect('/login');	
	// 	} 
 //    }
	
	public function transferCodes(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$ePins = Epins::select('id','code')->where('owned_by_id','0')->where('status','UNUSED')->orderBy('created_at','desc')->get();
				$transferCodes = TransferCode::orderBy('created_at','desc')->paginate(100);
				return view('layouts.admin.transfer-codes')
				->with('transferCodes',$transferCodes)
				->with('ePins',$ePins);
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postTransferCodes(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$adminUsername = Auth::user()->member->username;
				$adminID = Auth::user()->member->id;
				$rules = array(
					'username' => 'required',
					'entry' => 'required',
					'slot' => 'required',
					'quantity' => 'required|numeric',
				);
				
				$input = Input::all();
				$validator = Validator::make($input, $rules);
				if ($validator->fails()){
					return redirect()->back()->withInput()->withErrors($validator->errors());
				}else{
				
						//$activation_code = $input['activation_code'];
						$username = $input['username'];
						$entry = $input['entry'];
						$slot = $input['slot'];
						$entryPoints = 0;
						
						// $ePins = Epins::where('owned_by_id','0')->where('code',$activation_code)->where('status','UNUSED')->get();
						// if(count($ePins)==0){
							// return redirect()->back()->withInput()->withErrors(['Something went wrong with your activation code.']);
						// }
						$member = Member::where('username',$username)->get();
						if(count($member)==0){
							return redirect()->back()->withInput()->withErrors(['Username doesnt exist.']);
						}
						
						if($entry=="1500"){
							
						}else{
							return redirect()->back()->withInput()->withErrors(['Please select Entry.']); 
						}
						
						if($slot=="PAID"){
							
						}else{
							return redirect()->back()->withInput()->withErrors(['Please select Slot.']); 
						}
						
						if($slot=="PAID"){
							if($entry=="1500"){
								$entryPoints = 100;
							}
						}
						
						
						$quantity = $input['quantity'];
						
						$ePinsCodes = Epins::where('owned_by_id','0')->where('status','UNUSED')->orderBy('created_at','desc')->take($quantity)->get();
						foreach($ePinsCodes as $codes){
						
							$epin = Epins::find($codes->id);
							$epin->owned_by_id = $member[0]->id;
							$epin->owned_by_username = $member[0]->username;
							$epin->used_by_username = null;
							$epin->used_by_id = null;
							$epin->transfered_by_username = $adminUsername;
							$epin->transfered_by_id = $adminID;
							$epin->owned_at = getDatetimeNow();
							$epin->transfered_at = getDatetimeNow();
							$epin->points = $entryPoints;
							$epin->entry = $entry;
							$epin->slot = $slot;
							$epin->touch();
							$epin->save();
							
							$transfer = new TransferCode;
							$transfer->transfer_by = $adminID;
							$transfer->transfer_to = $member[0]->id;
							$transfer->code = $codes->code;
							$transfer->transfered_name = $member[0]->username;
							$transfer->transfer_byname = $adminUsername;
							$transfer->points = $entryPoints;
							$transfer->entry = $entry;
							$transfer->slot = $slot;
							$transfer->save();	
						}
						
	
	
				Session::flash('message', "Activation Code Successfully transfered!");
				return redirect()->back();	
				
				
				}

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	public function accounts(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			if(isset($_GET['mid'])){
					$mid = $_GET['mid'];
					$decryptedmid = encryptor('decrypt', $mid );					
					$accounts = Account::where('owner_member_id', '=', $decryptedmid  )->orderBy('created_at','desc')->paginate(100);
					
			}else{
				if(isset($_GET['search'])){
					$search = $_GET['search'];	
					$accounts = Account::where('account_name', 'LIKE', $search.'%' )->orderBy('created_at','=','desc')->paginate(100);
				}else{
					$accounts = Account::orderBy('created_at','=','desc')->paginate(100);
				}
			}
				return  view('layouts.admin.accounts')->with('accounts',$accounts);

				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postAccounts(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){ 
		    	if(isPermitted()==false){
					return redirect()->back()->withInput()->withErrors(['You dont have permission to add accounts.']);
				}
				
				$input = Input::all();
						
				$rules = array(
					'username' => 'required|max:100',
					'account_qty' => 'required|numeric',
					'account_sponsor' => 'required|max:100',
					'placement' => 'required|max:100',
					'position' => 'required|max:20',
					'entry' => 'required|max:20',
					'slot' => 'required|max:20',
				);
				
				$validator = Validator::make($input, $rules);
				if ($validator->fails()){ 
					return redirect()->back()->withInput()->withErrors($validator->errors());
				}
				$qty = $input['account_qty'];
				$position = $input['position'];
				$entry = $input['entry'];
				$slot = $input['slot'];
				$username = $input['username'];
				$member = Member::where('username',$username)->get();
				if(count($member)==0){
					return redirect()->back()->withInput()->withErrors(['Username doesnt exist.']);
				}
				$member_id = $member[0]->id;
				$member_username = $member[0]->username;
				$member_status = $member[0]->member_status;
				$member_accounts = $member[0]->accounts;
				$member_paid_accounts = $member[0]->paid_accounts;
				$sponsor = $member[0]->sponsor;
				$sponsor_data = Member::select('id','username')->where('username',$sponsor)->get();
				
				$points = 0;
				if($entry=="1500"
				){
								
				}else{
					return redirect()->back()->withInput()->withErrors(['Please select Code Entry Type.']); 
				}			
				if($slot=="FREE"||$slot=="PAID"){
							
				}else{
					return redirect()->back()->withInput()->withErrors(['Please select Slot Type.']); 
				}	
				// $ownedAccount = Account::where('owner_member_id',$member_id)->count();
				// $ownedAcc = $ownedAccount + $qty;
				// if($ownedAcc>15){
					// return redirect()->back()->withInput()->withErrors(['Maximum account for member is 15.']);
				// }
		
				$placement = $input['placement'];
				$plcmnt = Account::where('account_name',$placement)->get();
				if(count($plcmnt)==0){
					return redirect()->back()->withInput()->withErrors(['Placement doesnt exist.']);
				}
				
				$plcmntPos = Account::where('placement',$placement)->where('position',$position)->count();
				if($plcmntPos>0){
					return redirect()->back()->withInput()->withErrors(['Position is not available.']);
				}
				
				$account_sponsor = $input['account_sponsor'];
				$accountSponsor = Account::where('account_name',$account_sponsor )->get();
				if(count($accountSponsor)==0){
					return redirect()->back()->withInput()->withErrors(['Account sponsor doesnt exist.']);
				}
				$account_sponsor_id=$accountSponsor[0]->id;
				$account_sponsor_member_id=$accountSponsor[0]->owner_member_id;
				$account_sponsor_member_username=$accountSponsor[0]->owner_username;
				
				$ePins = Epins::where('owned_by_id',"0")->where('status','UNUSED')->take($qty)->get();
				if(count($ePins)<$qty){
					return redirect()->back()->withInput()->withErrors(['Insuficient codes.']);
				}
					
			
			
				$parent_id = $plcmnt[0]->id;
		
				
				$placementArry = Array();
				$ePinDate = "";
				foreach($ePins as $ePin){
					$ePinDate = $ePin->created_at;
					$accountname = generateAcountName($username);	

					
					
					$paid = 0;
					$refBonus = 0;
					$points = 0;

					if($slot == 'PAID'){

						$paid = 1;
						if($entry=='1500'){
							$refBonus = 100;
							$points = 100;

						}
					}
					
					
					
					
					
					$dateNow = getDatetimeNow();
					$dateReg = explode(" ",$dateNow);
					
					$account = new Account;
					$account->activation_code = $ePin->code;
					$account->account_name = $accountname;
					$account->placement = $placement;
					$account->parent_id = $parent_id;
					$account->position = $position;
					$account->owner_username = $member_username;
					$account->owner_member_id = $member_id;
					$account->slot = $slot;
					$account->points = $points;
					$account->entry = $entry;
					$account->_date = $dateReg[0];
					$account->account_sponsor = $account_sponsor;
					$account->save();
					$inserted_id = $account->id;
					
					$epins = Epins::find( $ePin->id );
					$epins->status = "USED";
					$epins->used_by_id = $member_id;
					$epins->used_by_username = $member_username;
					$epins->used_at = getDatetimeNow();
					$epins->points = $points;
					$epins->entry = $entry;
					$epins->slot = $slot;
					$epins->owned_at = getDatetimeNow();
					$epins->owned_by_id = $member_id;
					$epins->owned_by_username = $member_username;
					$epins->touch();
					$epins->save();
					
					
					if (!in_array( $accountname , $placementArry)) {
						array_push( $placementArry , $accountname );
						foreach($placementArry as $arry){
							$place = Account::where( 'placement', $arry )->count();
							if($place==0){
								$placement = $arry;
								$position = 'LEFT';
								break;
							}elseif($place==1){
								$placement = $arry;
								$position = 'RIGHT';
								break;
							}
						}
					}
					
					$plc = Account::where( 'account_name', $placement )->get();
					$parent_id = $plc[0]->id;
					
					$member_accounts = $member_accounts + 1;
					$member_paid_accounts = $member_paid_accounts + $paid;
					$mem = Member::find( $member_id );
					$mem->accounts = $member_accounts;
					$mem->paid_accounts = $member_paid_accounts;
					$mem->touch();
					$mem->save();
					
					$placementOwner = $member_id;
					

					
					Account::fixTree();
					//insertIncome($accountname);
					if($paid == 1){
					
					}
				}
				if($member_status=="INACTIVE"){
				
					$mem = Member::find( $member_id );
					$mem->member_status = "ACTIVE";
					$mem->activated_at = getDatetimeNow();
					$mem->touch();
					$mem->save();
				
				}
				
				//Account::fixTree();
				Session::flash('message', "New Account has been added!");
				return redirect()->back();	
			
			
			
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function genealogy(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){

				if(isset($_GET['account'])){
					if($_GET['account']!=''){
						$parent_account_name = $_GET['account'];
						$accountN2 = Account::where('account_name',$parent_account_name)->get();
						if(count($accountN2)==0){
							return redirect('/admin/genealogy');
						}
					}
				}
				$account = Account::where('account_name','admin')->orderBy('id','asc')->first();
				//return json_encode($account);
				return  view('layouts.admin.genealogy')->with('account',$account);

				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	
	
	public function encashments(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				if(isset($_GET['status'])){
					$status = $_GET['status'];
					if($status=='ALL'){
						$encashment = Encashment::with('member')->orderBy('created_at','desc')->get();
					}else{
						$encashment = Encashment::with('member')->where('status','=',$status)->orderBy('created_at','desc')->get();
					}
				}else{
					$encashment = Encashment::with('member')->where('status','=','PENDING')->orderBy('created_at','desc')->get();
				}
				
				return  view('layouts.admin.encashment')->with('encashment',$encashment);

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function encashmentsStatus($id,$status){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				$decryptedEncashmentId = encryptor('decrypt',$id);
				$encash = Encashment::find($decryptedEncashmentId);
				$encash->status = $status;
				$encash->touch();
				$encash->save();
				Session::flash('message', "Encashment has been change.");
				return redirect()->back();

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	public function encashmentsGc(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				if(isset($_GET['status'])){
					$status = $_GET['status'];
					if($status=='ALL'){
						$encashment = EncashmentGC::with('member')->orderBy('member_id','asc')->get();
					}else{
						$encashment = EncashmentGC::with('member')->where('status','=',$status)->orderBy('member_id','asc')->get();
					}
				}else{
					$encashment = EncashmentGC::with('member')->where('status','=','PENDING')->orderBy('member_id','asc')->get();
				}
				return  view('layouts.admin.encashmentgc')->with('encashment',$encashment);

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function encashmentsStatusGc($id,$status){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				$decryptedEncashmentId = encryptor('decrypt',$id);
				$encash = EncashmentGC::find($decryptedEncashmentId);
				$encash->status = $status;
				$encash->touch();
				$encash->save();
				Session::flash('message', "Encashment has been change.");
				return redirect()->back();

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	
	
	
	public function settings(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$user = Auth::user()->member->get();

				$settings = getSettings();
				return view('layouts.admin.settings')->with('settings',$settings);
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postSettings(Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$user = Auth::user()->member->get();
				$rules = array(
					'enableEncash' => 'required',
				);
				$data = $request->all();
				$validator = Validator::make($data, $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors()); 
				} else {
				
					$setarry = array(
					"enableEncash" => $data['enableEncash'],
					);
				
					$settings = Settings::find(1);
					$settings->settings = json_encode($setarry);
					$settings->touch();
					$settings->save();
				
					Session::flash('message', "Settings has been updated.");
					return redirect()->back();	
				}
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
    public function yep(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$user = Auth::user()->member->get();
				$yepBonus = YepBonus::orderBy('created_at','desc')->get();
				return view('layouts.admin.yep')->with('yepBonus',$yepBonus);
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postYep(Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$user = Auth::user()->member->get();
				$rules = array(
					'amount' => 'required',
					'shares' => 'required',
				);
				$data = $request->all();
				$validator = Validator::make($data, $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors()); 
				} else {
					$yepBonus = new YepBonus;
					$yepBonus->amount = $data['amount'];
					$yepBonus->shares = $data['shares'];
					$yepBonus->save();
					
					Session::flash('message', "Yep Bonus has been added.");
					return redirect()->back();	
				}
				
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
    	
	
	// update loading
	
	
	
	
	public function getLoading(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$id = Auth::user()->member->id;

				$loadWallet =  LoadWallet::orderBy('created_at','desc')->paginate(10);
				return  view('layouts.admin.loading')->with('loadWallet',$loadWallet);
				
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 		
	}
	
	public function postLoading(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$id = Auth::user()->member->id;
				$adminname = Auth::user()->member->username;

				$input = Input::all();
				$rules = array(
					'username' => 'required|max:50',
					'amount' => 'required'
				);
				$validator = Validator::make($input, $rules);
				if ($validator->fails()){
					return redirect()->back()->withInput()->withErrors(['Please fill all with valid inputs.']);
				}else{
					$username = $input['username'];
					$amount = $input['amount'];
					
					$member =  Member::where('username', '=', $username )->get();
					if(count($member)==0){
						return redirect()->back()->withInput()->withErrors(['Username do not exist.']);
					}
				
					
					$loadWallet = new LoadWallet;
					$loadWallet->amount = $amount;
					$loadWallet->username = $username;
					$loadWallet->member_id = $member[0]->id;
					$loadWallet->transact_by = $adminname;
					$loadWallet->save();
					
					$currentWallet = $member[0]->load_wallet;
					$newWallet = $currentWallet + $amount;
					$mem = Member::find($member[0]->id);
					$mem->load_wallet = $newWallet ;
					$mem->touch();
					$mem->save(); 
					
					Session::flash('message', "Wallet has been loaded!");
					return redirect()->back();
				}
				
				
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
				
	}
	
	public function getLoadingTransaction(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$id = Auth::user()->member->id;
						
				$loadTopUp = LoadMobileTopUp::orderBy('created_at','desc')->paginate(100);
				return  view('layouts.admin.loading-transaction')->with('loadTopUp',$loadTopUp);	
				
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
					
	}
	public function upgradeAccount($id){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				$user = Auth::user()->member->get();
				$decryptedaccID = encryptor('decrypt', $id );
				$account = Account::where('id','=',$decryptedaccID)->get();
				if(count($account)==0){
					return redirect()->back()->withInput()->withErrors(['Account doesnt exist!']);
				}
				if($account[0]->slot=="PAID"){
					return redirect()->back()->withInput()->withErrors(['Account already upgraded!']);
				}
				$pinCode = $account[0]->activation_code;
				$pinData = Epins::where('code','=',$pinCode)->get();
				if(count($pinData)==0){
					return redirect()->back()->withInput()->withErrors(['Pin Code doesnt exist!']);
				}
				$entry = $account[0]->entry;
				$points = 10;
				if($entry == '1K-ENTRY'){
					$points = 10;
				}elseif($entry == '70K-ENTRY'){
					$points = 300;
				}
				$yep = 0;
				$yepBonus = getYepBonus(); 
				$yepBonusid = $yepBonus[0]->id;
				$yepBonusShare = $yepBonus[0]->shares;
				$mem = Member::where('id','=',$account[0]->owner_member_id)->get();
				$yep_claim = $mem[0]->yep_claim;
				if($yep_claim==""||$yep_claim == null){
					$yep_claim = '[]';
				}
				$newarry =  json_decode($yep_claim);
				if(in_array($yepBonusid, $newarry)){
					$yep = $yep + $yepBonusShare;
				}
				
				
				$epins = Epins::find($pinData[0]->id);
				$epins->slot = 'PAID';
				$epins->points = $points;
				$epins->touch();
				$epins->save();
				
				
				$acc = Account::find($account[0]->id);
				$acc->slot = 'PAID';
				$acc->points = $points;
				//$acc->yep = $yep;
				$acc->touch();
				$acc->save();
				
				
				
				Session::flash('message', "Account has been upgraded!");
				return redirect()->back();
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
    
     public function adminUsers(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$user = Auth::user()->member->get();

				$adminusers = User::where('role','=','ADMIN')->orderBy('created_at','desc')->get();
				return view('layouts.admin.admin-users')->with('adminusers',$adminusers);
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function adminUsersSubmit(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$user = Auth::user()->member->get();
				$input = Input::all();
				$rules = array(
					'username' => 'required|string|max:255|unique:users',
					'email' => 'required|string|email|max:255|unique:users',
					'password' => 'required|string|min:6|confirmed',
					'first_name' => 'required|string|max:100',
					'last_name' => 'required|string|max:100'
				);
				$validator = Validator::make($input, $rules);
				if ($validator->fails()){
					return redirect()->back()->withInput()->withErrors($validator->errors());
				}else{
					$username = $input['username'];
					$email = $input['email'];
					$password = $input['password'];
					$first_name = $input['first_name'];
					$last_name = $input['last_name'];
					
					$passwordEncrptd = encryptor('encrypt', $password );
			
					$user = new User;
					$user->username = $username;
					$user->email = $email;
					$user->password = bcrypt($password); 
					$user->pwdcrptd = $passwordEncrptd;
					$user->login_status = "ACTIVE";
					$user->role = "ADMIN";
					$user->save();
					$inserted_id = $user->id;
					
					$member = new Member;
					$member->first_name = $first_name;
					$member->last_name = $last_name;
					$member->username = $username;
					$member->email = $email;
					$member->user_id = $inserted_id;
					$member->role = "ADMIN";
			        $member->deleted_at = null;
					$member->save();
					
					Session::flash('message', "New admin user has been added!");
					return redirect()->back();
				}					
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
    
    public function goldencashments(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				if(isset($_GET['status'])){
					$status = $_GET['status'];
					if($status=='ALL'){
						$encashment = GoldEncashment::with('member')->orderBy('created_at','desc')->get();
					}else{
						$encashment = GoldEncashment::with('member')->where('status','=',$status)->orderBy('created_at','desc')->get();
					}
				}else{
					$encashment = GoldEncashment::with('member')->where('status','=','PENDING')->orderBy('created_at','desc')->get();
				}
				
				return  view('layouts.admin.gold-encashment')->with('encashment',$encashment);

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function goldencashmentsStatus($id,$status){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				$decryptedEncashmentId = encryptor('decrypt',$id);
				$encash = GoldEncashment::find($decryptedEncashmentId);
				$encash->status = $status;
				$encash->touch();
				$encash->save();
				Session::flash('message', "Encashment has been change.");
				return redirect()->back();

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
    
	 public function bonusIncome(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				
				$bonus = BonusIncome::orderBy('created_at','desc')->paginate(100);
				return  view('layouts.admin.bonus-income')->with('bonus',$bonus);

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	public function postBonusIncome(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$user = Auth::user()->member->get();
				$input = Input::all();
				$rules = array(
					'type' => 'required|string|max:50',
					'account_name' => 'required|string|max:50',
					'amount' => 'required|string|max:100',
				);
				$validator = Validator::make($input, $rules);
				if ($validator->fails()){
					return redirect()->back()->withInput()->withErrors($validator->errors());
				}else{
					$type = $input['type'];
					$account_name = $input['account_name'];
					$amount = $input['amount'];
					$remarks = $input['remarks'];
					
					$acc = Account::where('account_name',$account_name)->get();
					if(count($acc)==0){
						return redirect()->back()->withInput()->withErrors(['account name doesnt exist!']);	
					}
					$bonus = new BonusIncome;
					$bonus->username = $acc[0]->owner_username;
					$bonus->member_id = $acc[0]->owner_member_id;
					$bonus->account_id = $acc[0]->id;
					$bonus->account_name = $acc[0]->account_name;
					$bonus->type = $type; 
					$bonus->amount = $amount;
					$bonus->remarks = "MANUAL ADDED BONUS: ".$remarks;
					$bonus->updated_by_id = Auth::user()->member->id;
					$bonus->updated_by_username = Auth::user()->username;
					$bonus->save();
				
	
					
					Session::flash('message', "Bonus income has been added!");
					return redirect()->back();
				}					
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	public function postBonusIncomeProductPool(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$user = Auth::user()->member->get();
				$input = Input::all();
				$rules = array(
					'amount' => 'required|string|max:100',
				);
				$validator = Validator::make($input, $rules);
				if ($validator->fails()){
					return redirect()->back()->withInput()->withErrors($validator->errors());
				}else{

					$amount = $input['amount'];

					DB::table('account_tbl')->where('slot','=','PAID')->increment('product_pool_bonus', $amount);
					$bonus = new BonusIncome;
					$bonus->username = "";
					$bonus->member_id = "0";
					$bonus->account_id = "0";
					$bonus->account_name = "";
					$bonus->type = "OTHER"; 
					$bonus->amount = $amount;
					$bonus->remarks = "MANUAL ADDED BONUS: "."PRODUCT POOL BONUS has been added to all accounts";
					$bonus->updated_by_id = Auth::user()->member->id;
					$bonus->updated_by_username = Auth::user()->username;
					$bonus->save();
					
					Session::flash('message', "Product Pool Bonus income has been added to all accounts!");
					return redirect()->back();
				}					
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	public function purchases(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$purchases = Purchase::orderBy('created_at','desc')->paginate(100);
				return  view('layouts.admin.purchases')->with('purchases',$purchases);

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postPurchases(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$adminUsername = Auth::user()->member->username;
				$adminID = Auth::user()->member->id;
				$rules = array(
					'username' => 'required',
					'product' => 'required',
					'quantity' => 'required|numeric',
				);
				
				$input = Input::all();
				$validator = Validator::make($input, $rules);
				if ($validator->fails()){
					return redirect()->back()->withInput()->withErrors($validator->errors());
				}else{	
					$quantity = $input['quantity'];
					$product = $input['product'];
					$username = $input['username'];
					//if($product!="PURPLE CORN"){
					//	return redirect()->back()->withInput()->withErrors(['Please select product.']);
					//}
					$member = Member::where('username',$username)->get();
					if(count($member)==0){
						return redirect()->back()->withInput()->withErrors(['Username doesnt exist.']);
					}
					
					
					$currentPoints = $member[0]->available_prod_points;
					$points = 1;
					$total_points = $points * $quantity;
					$available_prod_points = $total_points + $currentPoints;
			
					$purchase = new Purchase;
					$purchase->product = $product;
					$purchase->qty = $quantity;
					$purchase->points = $points;
					$purchase->total_points = $total_points;
					$purchase->added_by_username = $adminUsername;
					$purchase->added_by_id = $adminID;
					$purchase->member_id = $member[0]->id;
					$purchase->member_username = $member[0]->username;
					$purchase->save();	
					
					$mem = Member::find($member[0]->id);
					$mem->available_prod_points = $available_prod_points;
					$mem->touch();
					$mem->save();
					
					Session::flash('message', "New Purchase added.");
					return redirect()->back();	
				}
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	public function purchasesDelete($id){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$decryptedPurchaseId = encryptor('decrypt',$id);
				$purchase = Purchase::where('id',$decryptedPurchaseId)->get();
				if(count($purchase)>0){
					
					Purchase::where('id', $decryptedPurchaseId)->forcedelete();
					Session::flash('message', "Purchase has been deleted.");
					return redirect()->back();
				}else{
					return redirect()->back()->withInput()->withErrors(['Please try again.']);
				}
				

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	public function shareLinks(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
				
				$shareLinks = ShareLinks::orderBy('created_at','desc')->get();
				return  view('layouts.admin.share-links')->with('shareLinks',$shareLinks);

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	public function postShareLinks(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$adminUsername = Auth::user()->member->username;
				$adminID = Auth::user()->member->id;
				$rules = array(
					'title' => 'required',
					'description' => 'required',
					'link' => 'required',
				);
				
				$input = Input::all();
				$validator = Validator::make($input, $rules);
				if ($validator->fails()){
					return redirect()->back()->withInput()->withErrors($validator->errors());
				}else{	
					$title = $input['title'];
					$description = $input['description'];
					$link = $input['link'];
			
				
					$shareLinks = new ShareLinks;
					$shareLinks->title = $title;
					$shareLinks->description = $description;
					$shareLinks->link = $link;
					$shareLinks->save();	
					

					Session::flash('message', "New Link added.");
					return redirect()->back();	
				}
				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function linksDelete($id){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				$decryptedLinkId = encryptor('decrypt',$id);
				$share = ShareLinks::where('id',$decryptedLinkId)->get();
				
				if(count($share)>0){
					
					ShareLinks::where('id', $decryptedLinkId)->forcedelete();
					Session::flash('message', "Share link has been deleted.");
					return redirect()->back();
				}else{
					return redirect()->back()->withInput()->withErrors(['Please try again.']);
				}
				

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	public function reactivate(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){

				if(isset($_GET['account'])){
					if($_GET['account']!=''){
						$account_name = $_GET['account'];
						$accountN2 = Account::where('account_name',$account_name)->get();
						if(count($accountN2)>0){
							if($accountN2[0]->isgraduate=="TRUE"&&$accountN2[0]->grad_enable=="FALSE"){
								$time = time();
								if($accountN2[0]->slot=="PAID"){
								$addPoints = $accountN2[0]->points + 100;
								$accountCount = $accountN2[0]->account_count + 1;
								$acc = Account::find( $accountN2[0]->id);
								$acc->isgraduate = "FALSE";
								$acc->grad_enable = "TRUE";
								$acc->points = $addPoints;
								$acc->gradLineDate = getDatetimeNow();
								$acc->start_date = null;
								$acc->expired_date = null;
								$acc->account_count = $accountCount;
								$acc->grad_line = $time;
								$acc->touch();	
								$acc->save();
								$accountSponsor = Account::where('account_name',$accountN2[0]->account_sponsor)->get();
								if(count($accountSponsor)>0){
								addIncome($accountSponsor[0]->owner_username,$accountSponsor[0]->owner_member_id,'REFERRAL',$refBonus,'EARNED DIRECT REFERRAL BONUS FROM ACCOUNT - '.$account_name,$accountSponsor[0]->account_name,$accountSponsor[0]->id,Auth::user()->username,Auth::user()->member->id,'FALSE');		
								}
								insertIncome($accountN2[0]->account_name);
								
								return redirect()->back()->withInput()->withErrors(['Reactivate Success!.']);
								}else{
									return redirect()->back()->withInput()->withErrors(['Only Paid Accounts can Reactivate.']);
								}								
							}else{
									return redirect()->back()->withInput()->withErrors(['Only Graduate Account can reactivate.']);
							}
						}else{
							return redirect()->back()->withInput()->withErrors(['Please try again.']);
						}
					}
				}else{
					return redirect()->back('/admin/accounts');
				}
				
				

				
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }


    public function unilevelCodes(){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    if(isPermitted()==false){
					return  view('layouts.admin.blank');
				}
				if(isset($_GET['product'])&&isset($_GET['status'])){
					$product = $_GET['product'];
					$status = $_GET['status'];	
		
					$ePins = ProductEpins::where('product','=',$product)->where('status','=',$status)->orderBy('created_at','desc')->paginate(1000);
				}else{
			
					$ePins = ProductEpins::orderBy('created_at','desc')->paginate(1000);
				}
				return  view('layouts.admin.unilevel-codes')
				->with('ePins',$ePins);

			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postUnilevelCodes(Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="ADMIN"){
			    //return redirect()->back()->withInput()->withErrors(['Currently Unavailable.']);
				$data = $request->all();
				$rules = array(
					'code' => 'required' ,
					'qty' => 'required|numeric',
					'product' => 'required',
					'points' => 'required|numeric',
					'unilevel' => 'required|numeric',
				);
				$validator = Validator::make($data , $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());  
				}else{
				$code = $data['code'];
				$qty = $data['qty'];
				$points = $data['points'];
				$unilevel = $data['unilevel'];
				$product = $data['product'];
		

				generateProductEpins($code,$product,$points,$qty,$unilevel);


				Session::flash('message', "Unilevel Codes has been generated.");
				return redirect()->back();
					
				}
			}else if(checkloginAuthentication()=="USER"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 	
	}
    
}
