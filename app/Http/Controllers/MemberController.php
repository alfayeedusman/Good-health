<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\LoadMobileTopUp;
use App\LoadWallet;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\MoveToWallet;
use App\Encashment;
use App\Member;
use App\Account;
use App\Referral;
use App\Epins;
use App\ProductEpins;
use App\BonusIncome;
use App\RetrieveCode;
use App\TransferCode;
use App\PurchasePointsHistory;
use App\Purchase;
use App\ShareLinks;
use App\UnilevelIncome;
use Validator;
use Auth;
use Hash;
use Session;
use DB;
use Response;
use DateTime;
use App\EncashmentGC;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendActivationMail;
class MemberController extends Controller
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
			if(checkloginAuthentication()=="USER"){
				
			// $allAccountsPaid = Account::where( 'slot', 'PAID' )->orderBy('id','asc')->get();
			// foreach ($allAccountsPaid as $accs) {
			// 	//add indirect bonus
			// 	$directBonus = 0;
			// 	if($accs->entry=='DIAMOND'){
			// 		$indirectBonus = 45;
			// 		$actualIndirectBonus = 50;
			// 		$points = 4;
			// 	}elseif($accs->entry=='GOLD'){

			// 		$indirectBonus = 22.50;
			// 		$actualIndirectBonus = 25;

			// 	}else{
	
			// 		$indirectBonus = 13.25;
			// 		$actualIndirectBonus = 15;
			
			// 	}
			// 	$direct = Account::where( 'account_name', $accs->account_sponsor )->get();
			// 	if(count($direct)>0){
			// 		$indirect = Account::where( 'account_name', $direct[0]->account_sponsor )->get();
			// 		$bool = true;
			// 		$count = 0;
			// 		while($bool){
			// 			if(count($indirect)>0){
			// 			   	if($indirect[0]->entry=='DIAMOND'){
						   	 	
			// 							 $count++;
			// 							addIncome($indirect[0]->owner_username,$indirect[0]->owner_member_id,'INDIRECT',$indirectBonus,$actualIndirectBonus,'EARNED INDIRECT BONUS ',$indirect[0]->account_name,$indirect[0]->id,'MILLIONAIRE','39922');				
								
			// 			    }
			// 			    $indirect = Account::where( 'account_name', $indirect[0]->account_sponsor )->get();
			// 				if($count>=10){
			// 					$bool = false;
			// 					break;
			// 				}
			// 			}else{
			// 				$bool = false;
			// 				break;
			// 			}
			// 		}

			// 	}
				
			// }

				


				//generateEpins();
				//$a = getDownlineFlush('admin1');
				//return $a;
				// run code after insert of new node
				//Account::fixTree();
				//return isDateInRange('2019-09-11', '2019-10-11');
				// $dateNow = getDatetimeNow();
				// $dateReg = explode(" ",$dateNow);
				// $expired_date = date('Y-m-d', strtotime($dateReg[0]. ' + 30 days'));
				// $dte_strt = $dateReg[0];
				// $dte_expired = $expired_date;
				// $countAccountsEncoded = Account::where( 'account_sponsor', 'ariels-1' )->where( 'slot', 'PAID' )->whereDate( 'created_at','>=', $dte_strt )->whereDate( 'created_at','<=', $dte_expired )->count();
				// return $dte_strt.' '.$dte_expired.' '.isDateInRange($dte_strt, $dte_expired).' '.$countAccountsEncoded;
				//$gradLine = Account::select('id','isgraduate','gradLineDate','grad_enable','owner_username','owner_member_id','account_name','slot','grad_line')->where('slot','PAID')->where('isgraduate','FALSE')->where('grad_enable','TRUE')->orderBy('grad_line','asc')->orderBy('id','asc')->get();
				//return $gradLine; 		
				//$gradAccounts = BonusIncome::where( 'type','=','LOYALTY' )->orderBy( 'created_at', "desc" )->get();
				$member_id = Auth::user()->member->id;
				$accounts = Account::where('owner_member_id',$member_id)->get();
				

				return view('layouts.member.index')->with('accounts',$accounts);
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	//profile
	public function profile(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$user = Auth::user()->member->get();


				return view('layouts.member.profile');
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postProfile(Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$member_id = Auth::user()->member->id;
				$data = $request->all();
				$rules = array(
					//'mobile'    => 'required|digits:11',
					//'address' => 'required|max:200',
					'branch' => 'required|max:200' ,
					//'mop'    => 'required|max:200',
					//'details' => 'required|max:200',

				);
				$validator = Validator::make($data , $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());  
				}else{
					if($data['branch']=="SELECT"){
						return redirect()->back()->withInput()->withErrors(['Please select branch.']);
					}
					// if($data['mop']=="SELECT"){
					// 	return redirect()->back()->withInput()->withErrors(['Please select Mode of Payment.']);
					// }
					$member = Member::find($member_id);
					//$member->mobile = $data['mobile'];
					//$member->address = $data['address'];
					$member->team = $data['branch'];
					//$member->mop = $data['mop'];
					//$member->details = $data['details'];
					$member->touch();
					$member->save();
					Session::flash('success-message', "Profile info has been updated.");
					return redirect()->back();
				}
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	
	
	//security
	public function security(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$user = Auth::user()->member->get();


				return view('layouts.member.security');
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postSecurity(Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){

				$user_id = Auth::user()->id;
				$urpassword = Auth::user()->password;
				$data = $request->all();
				$rules = array(
					'password' => 'required|string|min:6|confirmed',
					'current_password' => 'required|string|min:6' 
				);
				$validator = Validator::make($data , $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());  
				}else{
					if (Hash::check($data['current_password'] ,$urpassword)){
						$passwordEncrptd = encryptor('encrypt', $data['password'] );
						$user = User::find($user_id);
						$user->password = bcrypt($data['password']);
						$user->pwdcrptd = $passwordEncrptd;
						$user->touch();
						$user->save();
						Session::flash('success-message', "Password has been updated.");
						return redirect()->back();
					}else{
						return redirect()->back()->withInput()->withErrors(['Wrong current password!']);
					}
					
				}
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }

	//accounts
	public function accounts(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$member_id = Auth::user()->member->id;
				$accounts = Account::where('owner_member_id',$member_id)->get();
				

				$accountsPaid = Account::where('slot','PAID')->where('owner_member_id',$member_id)->get();
				$accTotal = count($accounts);
				$accTotalPaid = count($accountsPaid);
				$mem = Member::find( $member_id );
				$mem->accounts = $accTotal;
				$mem->paid_accounts = $accTotalPaid;
				$mem->touch();
				$mem->save();
				
				return view('layouts.member.accounts')
				->with('accounts',$accounts);
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postAddAccountAccounts(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$user_pin = Auth::user()->pin;
				$member_id = Auth::user()->member->id;
				$member_username = Auth::user()->member->username;
				$member_status = Auth::user()->member->member_status;
				$member_accounts = Auth::user()->member->accounts;
				$member_paid_accounts = Auth::user()->member->paid_accounts;
				$dateNow = getDatetimeNow();
				$dateReg = explode(" ",$dateNow);
				$dateYearMonth = explode("-",$dateReg[0]);

				$input = Input::all();
						
				$rules = array(
					'code' => 'required|max:50',
					'sponsor' => 'required|max:50',
					'upline' => 'required|max:50',
					'position' => 'required|max:50',
				);
				
				$validator = Validator::make($input, $rules);
				if ($validator->fails()){ 
					return redirect()->back()->withInput()->withErrors($validator->errors());
				}
				$code = $input['code'];
				$sponsor = $input['sponsor'];
				$upline = $input['upline'];
				$position = $input['position'];

				$epinCode = Epins::where('code',$code)->where('status','UNUSED')->get();
				if(count($epinCode)==0){
					return redirect()->back()->withInput()->withErrors(['Invalid Code. Code not exist or already used.']); 
				}		
				$accountSponsor = Account::where('account_name',$sponsor)->get();
				if(count($accountSponsor)==0){
					return redirect()->back()->withInput()->withErrors(['Sponsor Account name not exist.']); 
				}

				$uplineAccount = Account::where('account_name',$upline)->get();
				if(count($uplineAccount)==0){
					return redirect()->back()->withInput()->withErrors(['Upline Account name not exist.']); 
				}
				$accountPosition = Account::where('placement',$upline)->where('parent_id',$uplineAccount[0]->id)->where('position',$position)->get();
				if(count($accountPosition)>0){
					return redirect()->back()->withInput()->withErrors(['Position not available.']); 
				}

				Account::fixTree();
		

				$directBonus = 0;
				if($epinCode[0]->entry=='DIAMOND'){
					$directBonus = 450;
					$directBonusGC = 1000;
					$actualDirectBonus = 500;
					$indirectBonus = 45;
					$actualIndirectBonus = 50;
					$points = 4;
				}elseif($epinCode[0]->entry=='GOLD'){
					$directBonus = 225;	
					$directBonusGC = 500;
					$actualDirectBonus = 250;
					$indirectBonus = 22.50;
					$actualIndirectBonus = 25;
					$points = 2;
				}else{
					$directBonus = 90;
					$directBonusGC = 250;
					$actualDirectBonus = 100;
					$indirectBonus = 11.25;
					$actualIndirectBonus = 15;
					$points = 1;
				}
				
		
				$lvl = $uplineAccount[0]->lvl + 1;
				$accountname = generateAcountName($member_username);

				$account = new Account;
				$account->activation_code = $code;
				$account->account_name = $accountname;
				$account->placement = $upline;
				$account->parent_id = $uplineAccount[0]->id;
				$account->position = $position;
				$account->owner_username = $member_username;
				$account->owner_member_id = $member_id;
				$account->slot = $epinCode[0]->slot;
				$account->points = $points;
				$account->entry = $epinCode[0]->entry;
				$account->_date = $dateReg[0];
				$account->account_sponsor = $sponsor;
				$account->account_sponsor_id = $accountSponsor[0]->id;
				$account->upline_member_id = $uplineAccount[0]->owner_member_id;
				$account->sponsor_member_id = $accountSponsor[0]->owner_member_id;
				$account->product_points = 0;
				$account->product_points_date = $dateReg[0];
				$account->isclaimed = 'NO';
				$account->own_rebate = 0;
				$account->lvl = $lvl;
				$account->save();
				$inserted_id = $account->id;


	
				$epins = Epins::find( $epinCode[0]->id );
				$epins->status = "USED";
				$epins->used_by_id = $member_id;
				$epins->used_by_username = $member_username;
				$epins->used_at = getDatetimeNow();
				$epins->touch();
				$epins->save();
				
				if($member_status=="INACTIVE"){
					$mem = Member::find( $member_id );
					$mem->member_status = "ACTIVE";
					$mem->activated_at = getDatetimeNow();
					$mem->touch();
					$mem->save();
					
					
				} 
					
				if($epinCode[0]->slot=="PAID"){
					//add direct bonus
					addIncome($accountSponsor[0]->owner_username,$accountSponsor[0]->owner_member_id,'DIRECT',$directBonus,$actualDirectBonus,'EARNED DIRECT REFERRAL BONUS',$accountSponsor[0]->account_name,$accountSponsor[0]->id,Auth::user()->username,Auth::user()->member->id);
					//add direct bonus
					addIncome($accountSponsor[0]->owner_username,$accountSponsor[0]->owner_member_id,'DIRECTGC',$directBonusGC,$directBonusGC,'EARNED DIRECT REFERRAL BONUS (GC)',$accountSponsor[0]->account_name,$accountSponsor[0]->id,Auth::user()->username,Auth::user()->member->id);
				}
				


				//add indirect bonus
				$indirect = Account::where( 'account_name', $accountSponsor[0]->account_sponsor )->get();
				$bool = true;
				$count = 0;
				while($bool){
					if(count($indirect)>0){
					   	if($indirect[0]->entry=='DIAMOND'&&$epinCode[0]->slot=='PAID'){
									addIncome($indirect[0]->owner_username,$indirect[0]->owner_member_id,'INDIRECT',$indirectBonus,$actualIndirectBonus,'EARNED INDIRECT BONUS ',$indirect[0]->account_name,$indirect[0]->id,Auth::user()->username,Auth::user()->member->id);				
							
					    }
					    $count++;
					    $indirect = Account::where( 'account_name', $indirect[0]->account_sponsor )->get();
						if($count>=10){
							$bool = false;
							break;
						}
					}else{
						$bool = false;
						break;
					}
				}

				
				  
				Referral::fixTree();	
				Account::fixTree();
				insertIncome($accountname);
				Session::flash('message', "Congratulations! Account Registration Successful!");
				return redirect()->back();
							
			
			
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }

	//referrals
	public function referrals(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$username = Auth::user()->member->username;
				$referrals = Member::where('sponsor','=',$username)->get();

				return view('layouts.member.referrals')->with('referrals',$referrals);
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	//genealogy
	public function genealogy(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$member_id = Auth::user()->member->id;

				if(isset($_GET['account'])){
					if($_GET['account']!=''){
						$parent_account_name = $_GET['account'];
						$accountN2 = Account::where('account_name',$parent_account_name)->get();
						if(count($accountN2)==0){
							return redirect('/genealogy');
						}
					}
				}
				$account = Account::where('owner_member_id' ,'=',  $member_id )->orderBy('id','asc')->first();
				//return $account;
				if($account!=null){
					return  view('layouts.member.genealogy')->with('account',$account);
				}else{
					return  view('layouts.member.genealogy-no-accounts');
				}
		


				
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }

    
	//encashments
	public function encashments(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$member_id = Auth::user()->member->id;
				$accounts = Account::where('owner_member_id',$member_id)->get();
				//cleanEncashment( Auth::user()->username);
			    $encashment = Encashment::where('member_id' ,'=',  $member_id )->orderBy('id','desc')->get();
				
				return  view('layouts.member.encashments')->with('encashment',$encashment)->with('accounts',$accounts);
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	

	public function postEncashments(Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$member_id = Auth::user()->member->id;
				$member_username = Auth::user()->member->username;
				$team = Auth::user()->member->team;
				$paid_accounts = Auth::user()->member->paid_accounts;
				$pin = Auth::user()->pin;
				$data = $request->all();
				$rules = array(
					'account_name'    => 'required',
				);
				$validator = Validator::make($data , $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());  
				}else{
					
					$setting = getSettings();
					$enableEncash = $setting->enableEncash;
					if($enableEncash=='false'){
						return redirect()->back()->withInput()->withErrors(['Unable to encash. Disabled by admin.']);
					}



					$acc = Account::where('account_name',$data['account_name'])->where('owner_username',$member_username)->get();
					if(count($acc)==0){
						return redirect()->back()->withInput()->withErrors(['Invalid Account Name.']);
					}

				
					
					$wallet = getTotalWallet($member_username,$data['account_name']);
					if($wallet<=0){
						return redirect()->back()->withInput()->withErrors(['Insufficient Wallet!']); 
					}
					if($wallet<500){
						return redirect()->back()->withInput()->withErrors(['Minimum Encashment is 500!']); 
					}
					$taxamount = $wallet - 50;
					BonusIncome::where('account_name',$data['account_name'])->where(function($query){
			                $query->where('TYPE', '=', 'SALESMATCH')
			                ->orWhere('TYPE', '=', 'DIRECT')
			                ->orWhere('TYPE', '=', 'LEADERSHIP')
			                ->orWhere('TYPE', '=', 'INDIRECT')
			                ->orWhere('TYPE', '=', 'UNILEVEL');
			            })->update(['iswithdraw' => 'TRUE']);


					$encash = new Encashment;
					$encash->member_id = $member_id;
					$encash->member_username = $member_username;
					$encash->amount = $wallet;
					$encash->taxamount = $taxamount;
					$encash->team = $team;
					$encash->account_name = $acc[0]->account_name;
					$encash->account_id = $acc[0]->id;
					$encash->save();
					Session::flash('message', "Encashment Request has been sent.");
					return redirect()->back();
				}
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }

 
	public function tutorials(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){

				return  view('layouts.member.tutorials');
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
		
	}
	

	
	//added
	public function postSaveRefferalGreetings(Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$member_id = Auth::user()->member->id;
		
			
				$input = Input::all();
				$validate=Validator::make($input,array(
					 'image'=>'required|max:5000kb|Mimes:jpeg,jpg,png,pneg',
				));
				if ($validate->fails()) {
					return redirect()->back()->withInput()->withErrors($validate->errors());
				}
				try{
					$user_id = Auth::user()->id;
					$encrypted_id = encryptor( 'encrypt', $user_id );	
					$destinationPath = 'assets/members/photo'; // upload path
					$extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
					$fileName = $encrypted_id.'.'.'png'; // renameing image
					Input::file('image')->move($destinationPath, $fileName); // uploading file to given path

					Session::flash('success-message', "Profile Photo has been updated.");
					return redirect()->back();
				 }catch(\Exception $e){
					return redirect()->back()->withErrors('Image Uploading Error.');
				 }
			
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	
	//accounts
	public function accountsRegister(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$member_id = Auth::user()->member->id;
				$accounts = Account::where('owner_member_id',$member_id)->get();
				
				
				return view('layouts.member.accounts-register')
				->with('accounts',$accounts);
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	public function postAddRegisterAccounts(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$user_pin = Auth::user()->pin;
				$member_id = Auth::user()->member->id;
				$member_username = Auth::user()->member->username;
				$member_status = Auth::user()->member->member_status;
				$member_accounts = Auth::user()->member->accounts;
				$member_paid_accounts = Auth::user()->member->paid_accounts;
				$dateNow = getDatetimeNow();
				$dateReg = explode(" ",$dateNow);

				$input = Input::all();
						
				$rules = array(
					'code' => 'required|max:50',
					'sponsor' => 'required|max:50',
					'upline' => 'required|max:50',
					'position' => 'required|max:50',
				);
				
				$validator = Validator::make($input, $rules);
				if ($validator->fails()){ 
					return redirect()->back()->withInput()->withErrors($validator->errors());
				}

				$code = $input['code'];
				$sponsor = $input['sponsor'];
				$upline = $input['upline'];
				$position = $input['position'];

				$epinCode = Epins::where('code',$code)->where('status','UNUSED')->get();
				if(count($epinCode)==0){
					return redirect()->back()->withInput()->withErrors(['Invalid Code. Code not exist or already used.']); 
				}		
				$accountSponsor = Account::where('account_name',$sponsor)->get();
				if(count($accountSponsor)==0){
					return redirect()->back()->withInput()->withErrors(['Sponsor Account name not exist.']); 
				}

				


				$uplineAccount = Account::where('account_name',$upline)->get();
				if(count($uplineAccount)==0){
					return redirect()->back()->withInput()->withErrors(['Upline Account name not exist.']); 
				}
				$accountPosition = Account::where('placement',$upline)->where('parent_id',$uplineAccount[0]->id)->where('position',$position)->get();
				if(count($accountPosition)>0){
					return redirect()->back()->withInput()->withErrors(['Position not available.']); 
				}

				$msg = "Congratulations! Account Activation Successfull!.";

				$Ownerusername = $member_username;
				$Ownermemid = $member_id;
				if($input['username']!=""||$input['password']!=""||$input['first_name']!=""||$input['last_name']!=""){
					$rules2 = array(
						'username' => 'required|string|max:255|unique:users|alpha_dash',
			            'password' => 'required|string|min:6|confirmed',
						'first_name' => 'required|string|max:100',
						'last_name' => 'required|string|max:100',
						'birthday' => 'required',
					);
					$validator2 = Validator::make($input, $rules2);
					if ($validator2->fails()){ 
						return redirect()->back()->withInput()->withErrors($validator2->errors());
					}
					$username = $input['username'];
					$password = $input['password'];
					$first_name = $input['first_name'];
					$last_name = $input['last_name'];
					$birthday = $input['birthday'];
					
        			$today = date("Y-m-d");			
           		 	$diff = date_diff(date_create($birthday), date_create($today));
            		$age = $diff->format('%y');
            		if($age<18){
						return redirect()->back()->withInput()->withErrors(['You must be 18 years old and above to join.']);
            		}

					$passwordEncrptd = encryptor('encrypt', $password );
					$user = new User;
					$user->username = $username;
					//$user->email = $email;
					$user->password = bcrypt($password); 
					$user->pwdcrptd = $password;
					$user->login_status = "ACTIVE";
					$user->role = "USER";
					$user->save();
					$inserted_id = $user->id;
					
					$member = new Member;
					$member->first_name = $first_name;
					$member->last_name = $last_name;
					$member->username = $username;
					$member->birthday = $birthday;
					$member->user_id = $inserted_id;
					$member->deleted_at = null;
					$member->save();
					$inserted_memid = $member->id;

					$Ownerusername = $username;
					$Ownermemid = $inserted_memid;

					$msg = "Congratulations! Registration and Account Activation Successful! You can now login your account.";

				}
				
				

				Account::fixTree();
	
				
				$directBonus = 0;
				if($epinCode[0]->entry=='DIAMOND'){
					$directBonus = 450;
					$directBonusGC = 1000;
					$actualDirectBonus = 500;
					$indirectBonus = 45;
					$actualIndirectBonus = 50;
					$points = 4;
				}elseif($epinCode[0]->entry=='GOLD'){
					$directBonus = 225;	
					$directBonusGC = 500;
					$actualDirectBonus = 250;
					$indirectBonus = 22.50;
					$actualIndirectBonus = 25;
					$points = 2;
				}else{
					$directBonus = 90;
					$directBonusGC = 250;
					$actualDirectBonus = 100;
					$indirectBonus = 11.25;
					$actualIndirectBonus = 15;
					$points = 1;
				}
					



				$accountname = generateAcountName($Ownerusername);

				$lvl = $uplineAccount[0]->lvl + 1;

				$account = new Account;
				$account->activation_code = $code;
				$account->account_name = $accountname;
				$account->placement = $upline;
				$account->parent_id = $uplineAccount[0]->id;
				$account->position = $position;
				$account->owner_username = $Ownerusername;
				$account->owner_member_id = $Ownermemid;
				$account->slot = $epinCode[0]->slot;
				$account->points = $points;
				$account->entry = $epinCode[0]->entry;
				$account->_date = $dateReg[0];
				$account->account_sponsor = $sponsor;
				$account->account_sponsor_id = $accountSponsor[0]->id;
				$account->upline_member_id = $uplineAccount[0]->owner_member_id;
				$account->sponsor_member_id = $accountSponsor[0]->owner_member_id;
				$account->product_points = 0;
				$account->product_points_date = $dateReg[0];
				$account->isclaimed = 'NO';
				$account->own_rebate = 0;
				$account->lvl = $lvl;
				$account->save();
				$inserted_id = $account->id;

	
				$epins = Epins::find( $epinCode[0]->id );
				$epins->status = "USED";
				$epins->used_by_id = $Ownermemid;
				$epins->used_by_username = $Ownerusername;
				$epins->used_at = getDatetimeNow();
				$epins->touch();
				$epins->save();
				
				if($member_status=="INACTIVE"){
					$mem = Member::find( $Ownermemid );
					$mem->member_status = "ACTIVE";
					$mem->activated_at = getDatetimeNow();
					$mem->touch();
					$mem->save();
				} 
					
				//add direct sponsor bonus
				$directBonus = 0;
				if($epinCode[0]->entry=='DIAMOND'){
					$directBonus = 450;
					$directBonusGC = 1000;
					$actualDirectBonus = 500;
					$indirectBonus = 45;
					$actualIndirectBonus = 50;
				}elseif($epinCode[0]->entry=='GOLD'){
					$directBonus = 225;	
					$directBonusGC = 500;
					$actualDirectBonus = 250;
					$indirectBonus = 22.50;
					$actualIndirectBonus = 25;
				}else{
					$directBonus = 90;
					$directBonusGC = 250;
					$actualDirectBonus = 100;
					$indirectBonus = 11.25;
					$actualIndirectBonus = 15;
				}

				if($epinCode[0]->slot=="PAID"){
				//add direct bonus
				addIncome($accountSponsor[0]->owner_username,$accountSponsor[0]->owner_member_id,'DIRECT',$directBonus,$actualDirectBonus,'EARNED DIRECT REFERRAL BONUS',$accountSponsor[0]->account_name,$accountSponsor[0]->id,Auth::user()->username,Auth::user()->member->id);
				//add direct bonus
				addIncome($accountSponsor[0]->owner_username,$accountSponsor[0]->owner_member_id,'DIRECTGC',$directBonusGC,$actualDirectBonus,'EARNED DIRECT REFERRAL BONUS (GC)',$accountSponsor[0]->account_name,$accountSponsor[0]->id,Auth::user()->username,Auth::user()->member->id);

				}

				//add indirect bonus
				
				$indirect = Account::where( 'account_name', $accountSponsor[0]->account_sponsor )->get();
				$bool = true;
				$count = 0;
				while($bool){
					if(count($indirect)>0){
					   	if($indirect[0]->entry=='DIAMOND'&&$epinCode[0]->slot=='PAID'){
							addIncome($indirect[0]->owner_username,$indirect[0]->owner_member_id,'INDIRECT',$indirectBonus,$actualIndirectBonus,'EARNED INDIRECT BONUS ',$indirect[0]->account_name,$indirect[0]->id,Auth::user()->username,Auth::user()->member->id);
					    }
					    $count++;
					    $indirect = Account::where( 'account_name', $indirect[0]->account_sponsor )->get();
						if($count>=10){
							$bool = false;
							break;
						}
					}else{
						$bool = false;
						break;
					}
				}

				
				
				
				Referral::fixTree();	
				Account::fixTree();
				insertIncome($accountname);
		


				Session::flash('success-message-with-account', $msg);
				return redirect('/genealogy');	
							
			
			
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }


    public function unilevel(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$member_id = Auth::user()->member->id;
				$accounts = Account::where('owner_member_id',$member_id)->get();
				

				$accountsPaid = Account::where('slot','PAID')->where('owner_member_id',$member_id)->get();
				$accTotal = count($accounts);
				$accTotalPaid = count($accountsPaid);
				$mem = Member::find( $member_id );
				$mem->accounts = $accTotal;
				$mem->paid_accounts = $accTotalPaid;
				$mem->touch();
				$mem->save();
				
				return view('layouts.member.accounts-unilevel')
				->with('accounts',$accounts);
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
    public function postUnilevel(Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				
				$user_id = Auth::user()->id;
				$username = Auth::user()->username;
				$urpassword = Auth::user()->password;
				$data = $request->all();
				$rules = array(
					'account_name' => 'required',
					'code' => 'required' 
				);

				$dateNow = getDatetimeNow();
				$dateToday = explode(" ",$dateNow);
				$dateYearMonthDay = explode("-",$dateToday[0]);
				$day = intval($dateYearMonthDay[2]);
				if($day>=1&&$day<=25){

				}else{
					return redirect()->back()->withErrors('Cut off of product points is every 25th of the month.');
				}

				$validator = Validator::make($data , $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());  
				}else{
					$code = $data['code'];
					$account_name = $data['account_name'];
					$acc = Account::where('account_name',$account_name)->get();
					if(count($acc)==0){
						return redirect()->back()->withErrors('Account name Invalid.');
					}
					$codes = ProductEpins::where('code',$code)->where('status','UNUSED')->get();
					if(count($codes)==0){
						return redirect()->back()->withErrors('Product Code Invalid! Either not exist or already used.');
					}
					$epin = ProductEpins::find($codes[0]->id);
					$epin->used_by_username = $username;
					$epin->used_by_id = $user_id;
					$epin->used_by_account_name = $acc[0]->account_name;
					$epin->used_by_account_id = $acc[0]->id;
					$epin->status = 'USED';
					$epin->used_at = getDatetimeNow();
					$epin->touch();
					$epin->save();

	
					$accs = Account::where('id','=',$acc[0]->id)->where('product_points_date','like',$dateYearMonthDay[0].'-'.$dateYearMonthDay[1].'%')->get();
					if(count($accs)>0){
						Account::where('id', $acc[0]->id)
						    ->update([
						      'product_points'=> DB::raw('product_points+'.$codes[0]->points), 
						      'unilevel'=> DB::raw('unilevel+'.$codes[0]->unilevel),
						      'isclaimed' => 'NO'
						    ]);
					}else{
						$account = Account::find($acc[0]->id);
						$account->product_points = $codes[0]->points;
						$account->product_points_date = $dateToday[0];
						$account->unilevel = $codes[0]->unilevel;
						$account->isclaimed = 'NO';
						$account->save();
					}
					insertUnilevel($acc[0]->account_sponsor,1,$codes[0]->unilevel,$codes[0]->points);
					
					
				

					Session::flash('message', "Congratulations! Product Points has been encoded!");
					return redirect()->back();	
					
				}
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
  

     public function unilevelClaim(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$member_id = Auth::user()->member->id;
				$dateNow = getDatetimeNow();
				$dateToday = explode(" ",$dateNow);
				$dateYearMonthDay = explode("-",$dateToday[0]);
				$previousMonth = date("Y-m-d", strtotime("first day of previous month"));

				$date = new DateTime('now');
				$date->modify('last day of this month');
				//echo $date->format('Y-m-d');


				$lastDayMonth = new DateTime('last day of this month');
				$dateNow = getDatetimeNow();
				$dateToday = explode(" ",$dateNow);
				$dateYearMonthDay = explode("-",$dateToday[0]);
				$day = intval($dateYearMonthDay[2]);
				if($day>=1&&$day<=25){
					return redirect()->back()->withErrors('You can only claim your Unilevel Bonus on 26th of the month until the end of the month.');
				}else{
					
			
			
					if(isset($_GET['account'])){
						$account = $_GET['account'];
						$acc = Account::where('account_name',$account)->where('owner_member_id',$member_id)->get();
						if(count($acc)==0){
							return redirect()->back()->withErrors('Invalid Account');
						}
						if($acc[0]->unilevel<=0){
							return redirect()->back()->withErrors('Insufficient Unilevel');
						}
						if($acc[0]->product_points<500){
							return redirect()->back()->withErrors('Maintaining Points did not reach.');
						}

						
							addIncome($acc[0]->owner_username,$acc[0]->owner_member_id,'UNILEVEL',$acc[0]->unilevel,$acc[0]->unilevel,'EARNED UNILEVEL BONUS ',$acc[0]->account_name,$acc[0]->id,Auth::user()->username,Auth::user()->member->id);

							$account = Account::find($acc[0]->id);
							$account->product_points = 0;
							$account->product_points_date = $dateToday[0];
							$account->unilevel = 0;
							$account->isclaimed = 'YES';
							$account->save();

	
							Session::flash('message', "Unilevel Move to Wallet Success!");
						return redirect()->back();
					}else{
						return redirect()->back()->withErrors('Error Occur');
					}

		
				}
				
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
    
    
    
    //encashments
	public function encashmentsGC(){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$member_id = Auth::user()->member->id;
				$accounts = Account::where('owner_member_id',$member_id)->get();
				//cleanEncashment( Auth::user()->username);

			    $encashment = EncashmentGC::where('member_id' ,'=',  $member_id )->orderBy('id','desc')->get();
				
				return  view('layouts.member.encashmentsGC')->with('encashment',$encashment)->with('accounts',$accounts);
				
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }
	

	public function postEncashmentsGC(Request $request){
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$member_id = Auth::user()->member->id;
				$member_username = Auth::user()->member->username;
				$team = Auth::user()->member->team;
				$paid_accounts = Auth::user()->member->paid_accounts;
				$pin = Auth::user()->pin;
				$data = $request->all();
				$rules = array(
					'account_name'    => 'required',
					'product'    => 'required',
					'qty'    => 'required|numeric',
				);
				$validator = Validator::make($data , $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());  
				}else{
					
					$setting = getSettings();
					$enableEncash = $setting->enableEncash;
					if($enableEncash=='false'){
						return redirect()->back()->withInput()->withErrors(['Unable to encash. Disabled by admin.']);
					}



					$acc = Account::where('account_name',$data['account_name'])->where('owner_username',$member_username)->get();
					if(count($acc)==0){
						return redirect()->back()->withInput()->withErrors(['Invalid Account Name.']);
					}

					$amount = 0;
					if($data['product']=="3IN1SOAP"||$data['product']=="LOTION"||$data['product']=="AROMAOIL"||$data['product']=="VITAMINC"||$data['product']=="SERPENTINA"||$data['product']=="GLUTACAPSUL"||$data['product']=="SPIRULINA"||$data['product']=="OATMEALSOAP"){
						if($data['product']=="3IN1SOAP"){
							$amount = 250;
						}elseif($data['product']=="LOTION"){
							$amount = 350;
						}elseif($data['product']=="AROMAOIL"){
							$amount = 300;
						}elseif($data['product']=="VITAMINC"){
							$amount = 375;
						}elseif($data['product']=="SERPENTINA"){
							$amount = 485;
						}elseif($data['product']=="GLUTACAPSUL"){
							$amount = 1500;
						}elseif($data['product']=="SPIRULINA"){
							$amount = 750;
						}elseif($data['product']=="OATMEALSOAP"){
							$amount = 250;
						}

					}else{
						return redirect()->back()->withInput()->withErrors(['Invalid Product.']);
					}
		
					$availableGC = getTotalAvailableGC($member_username,$data['account_name']);

					$total_amount = $amount * $data['qty'];
					if($total_amount>$availableGC){
						return redirect()->back()->withInput()->withErrors(['Insufficient GC.']);
					}

					$encashGC = new EncashmentGC;
					$encashGC->member_id = $member_id;
					$encashGC->member_username = $member_username;
					$encashGC->amount = $total_amount;
					$encashGC->product = $data['product'];
					$encashGC->qty = $data['qty'];
					$encashGC->team = $team;
					$encashGC->account_name = $acc[0]->account_name;
					$encashGC->account_id = $acc[0]->id;
					$encashGC->save();

					
					// $wallet = getTotalWallet($member_username,$data['account_name']);
					// if($wallet<=0){
					// 	return redirect()->back()->withInput()->withErrors(['Insufficient Wallet!']); 
					// }
					// if($wallet<200){
					// 	return redirect()->back()->withInput()->withErrors(['Minimum Encashment is 200!']); 
					// }
					// $taxamount = $wallet - 50;
					// BonusIncome::where('account_name',$data['account_name'])->where(function($query){
			  //               $query->where('TYPE', '=', 'SALESMATCH')
			  //               ->orWhere('TYPE', '=', 'DIRECT')
			  //               ->orWhere('TYPE', '=', 'LEADERSHIP')
			  //               ->orWhere('TYPE', '=', 'INDIRECT')
			  //               ->orWhere('TYPE', '=', 'UNILEVEL');
			  //           })->update(['iswithdraw' => 'TRUE']);


					// $encash = new Encashment;
					// $encash->member_id = $member_id;
					// $encash->member_username = $member_username;
					// $encash->amount = $wallet;
					// $encash->taxamount = $taxamount;
					// $encash->team = $team;
					// $encash->account_name = $acc[0]->account_name;
					// $encash->account_id = $acc[0]->id;
					// $encash->save();
					Session::flash('message', "Encashment Request has been sent.");
					return redirect()->back();
				}
			}else if(checkloginAuthentication()=="ADMIN"){
				Auth::logout(); //
				return redirect('/login');	
			}
		}else{
			return redirect('/login');	
		} 
    }


	
}
