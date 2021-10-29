<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Member;
use App\Account;
use App\Epins;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users|alpha_dash',
            //'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
			'first_name' => 'required|string|max:100',
			'last_name' => 'required|string|max:100',
			'birthday' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    // protected function create(array $data)
    // {

		// return User::create([
			// 'name' => $data['name'],
			// 'email' => $data['email'],
			// 'password' => bcrypt($data['password']),
			// 'refer_id' => '',
			// 'refer_by' => '',
		// ]);
		
    // }
	public function showRegistrationForm(){
        return view('auth.register');
    }
	public function register(Request $request){
	
		$data = $request->all();
		$validator = $this->validator($request->all());
		if ($validator->fails()) {	
		   return redirect()->back()->withInput()->withErrors($validator->errors()); 
		}
		//$email = $data['email'];
		$username = $data['username'];
		$password = $data['password'];
		$first_name = $data['first_name'];
		$last_name = $data['last_name'];
		$birthday = $data['birthday'];
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






		$dateNow = getDatetimeNow();
		$dateReg = explode(" ",$dateNow);
		$dateYearMonth = explode("-",$dateReg[0]);



		$sponsor = $data['sponsor'];
		$upline = $data['upline'];
		$code = $data['code'];
		$position = $data['position'];

		if($sponsor!=""||$upline!=""||$code!=""||$position!=""){
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
			$accountname = generateAcountName($username);

			$account = new Account;
			$account->activation_code = $code;
			$account->account_name = $accountname;
			$account->placement = $upline;
			$account->parent_id = $uplineAccount[0]->id;
			$account->position = $position;
			$account->owner_username = $username;
			$account->owner_member_id = $inserted_memid;
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
			$epins->used_by_id = $inserted_memid;
			$epins->used_by_username = $username;
			$epins->used_at = getDatetimeNow();
			$epins->touch();
			$epins->save();
			
			$mem = Member::find( $inserted_memid );
			$mem->member_status = "ACTIVE";
			$mem->activated_at = getDatetimeNow();
			$mem->touch();
			$mem->save();
			

			//add direct bonus
			if($epinCode[0]->slot=='PAID'){

				addIncome($accountSponsor[0]->owner_username,$accountSponsor[0]->owner_member_id,'DIRECT',$directBonus,$actualDirectBonus,'EARNED DIRECT REFERRAL BONUS',$accountSponsor[0]->account_name,$accountSponsor[0]->id,$username,$inserted_memid);
				//add direct bonus
				addIncome($accountSponsor[0]->owner_username,$accountSponsor[0]->owner_member_id,'DIRECTGC',$directBonusGC,$directBonusGC,'EARNED DIRECT REFERRAL BONUS (GC)',$accountSponsor[0]->account_name,$accountSponsor[0]->id,$username,$inserted_memid);

			}
				


				//add indirect bonus
				$indirect = Account::where( 'account_name', $accountSponsor[0]->account_sponsor )->get();
				$bool = true;
				$count = 0;
				while($bool){
					if(count($indirect)>0){
					   	if($indirect[0]->entry=='DIAMOND'&&$epinCode[0]->slot=='PAID'){
					   	
						addIncome($indirect[0]->owner_username,$indirect[0]->owner_member_id,'INDIRECT',$indirectBonus,$actualIndirectBonus,'EARNED INDIRECT BONUS',$indirect[0]->account_name,$indirect[0]->id,$username,$inserted_memid);				
							
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

				
				  
			
				Account::fixTree();
				insertIncome($accountname);



				



			Session::flash('success-message-with-account', "Congratulations! Registration and Account Activation Successful! You can now login your account.");
			return redirect()->back();	
		}else{
			Session::flash('success-message', "Congratulations! Registration Successful! You can now login your account.");
			return redirect()->back();	

		}
		
		
		
    }
	 public function verifyRegistration($id){
        $id = encryptor('decrypt', $id );
		$user = User::where('id', $id)->get();
		if(count($user)>0){
			if($user[0]->login_status != "VERIFICATION"){
				$user = User::find();
				$user->login_status = 'ACTIVE';
				$user->touch();
				$user->save();
				
				Session::flash('success-message', "Verification Successful! You can login now. Happy Earnings!!");
				return redirect('/login');
			}
		}else{
		    return redirect('/login');
		}
    }
}
