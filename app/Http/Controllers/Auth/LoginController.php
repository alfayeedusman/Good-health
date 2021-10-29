<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Member;
use Validator;
use Auth;
use Hash;
use Session;
use DB;
use Input;
use Crypt;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\AdminUser;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
	public function getLogout() {
        Auth::logout(); // logout user
		return redirect('/login');
	}
	function showLoginForm()
	{
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$user = Auth::user()->member->get();
				return redirect('/dashboard');	
			}else if(checkloginAuthentication()=="ADMIN"){
				return redirect('/admin/dashboard');	
			}
		}else{
			return view('auth.login');
		}
	}
	// public function postLogin(Request $request)
    // {

			// if (Auth::check()){
				// if(checkloginAuthentication()=="USER"){
					// $user = Auth::user()->member->get();
					// return redirect('/dashboard');	
				// }else if(checkloginAuthentication()=="ADMIN"){
					// return redirect('/admin/dashboard');	
				// }
			// }else{
			
				
			// }
		
			// // validate the info, create rules for the inputs
			// $rules = array(
				// 'username'    => 'required|max:60', // make sure the email is an actual email
				// 'password' => 'required|alphaNum|min:6|max:20' // password can only be alphanumeric and has to be greater than 6 characters
			// );

			// // run the validation rules on the inputs from the form
			// $validator = Validator::make(Input::all(), $rules);

			// // if the validator fails, redirect back to the form
			// if ($validator->fails()) {
				// return redirect('/login')
					// ->withErrors($validator) // send back all errors to the login form
					// ->withInput(Input::except('password'))->with('mode','login'); // send back the input (not the password) so that we can repopulate the form
			// } else {
			
				// // create our user data for the authentication
				// $userdata = array(
					// 'username'     => Input::get('username'),
					// 'password'  => Input::get('password'),
				// );

				// //return $userdata;
				// // attempt to do the login
				// if (Auth::attempt($userdata)) {

						// $id = Auth::user()->member->id;
						// $active = Auth::user()->member->active;
						// $role = Auth::user()->role;
						// $date = getDatetimeNow();
						// $date = explode(' ',$date);
						// $datenow = $date[0];
						
						// if($role == "ADMIN"){
							// return redirect('/admin/dashboard');
						// }elseif($role == "USER"){
							// return redirect('/dashboard');
						// }
				// } else {        
						// return redirect()->back()->withInput()->withErrors('Wrong username/password combination.')->with('mode','login');
				// }
			// }
		
	// }
	public function postLogin(Request $request)
    {
	
		if (Auth::check()){
			if(checkloginAuthentication()=="USER"){
				$user = Auth::user()->member->get();
				return redirect('/dashboard');	
			}else if(checkloginAuthentication()=="ADMIN"){
				return redirect('/admin/dashboard');	
			}
		}else{
		}
		//Session::flash('error-message', "system is currently under maintenance.");
		//return redirect()->back();	
			
		   
		$data = $request->all();
		$username = $data['username'];
		$password = $data['password'];

		$userdata = array(
			'username'     => $username,
			'password'  => $password,
		);
		// attempt to do the login
		
		// $secret = '6LewuJ4UAAAAALeqSgROCHQXiTf1dcEP0a0-GK71';
		// $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		// $responseData = json_decode($verifyResponse);
		// if($responseData->success)
		// {
			// //$succMsg = 'Your contact request have submitted successfully.';
		// }
		// else
		// {
			// Session::flash('error-message', "Robot verification failed, please try again" );
			// return redirect()->back();
			// //$errMsg = 'Robot verification failed, please try again.';
		// }
		   
		if (Auth::attempt($userdata)) {
				$id = Auth::user()->member->id;
				$active = Auth::user()->member->active;
				$loginstatus = Auth::user()->login_status;
				$loginremarks = Auth::user()->login_remarks;
				$role = Auth::user()->role;
				
				if($role == "ADMIN"){
					return redirect('/admin/dashboard');
				}elseif($role == "USER"){
					if($loginstatus == "BANNED" || $loginstatus == "DEACTIVATED" || $loginstatus == "INACTIVE"){
						Auth::logout();
						Session::flash('error-message', "Warning!!. " .$loginremarks );
						return redirect()->back();	
					}if($loginstatus == "VERIFICATION" ){
						Auth::logout();
						Session::flash('error-message', "Your account needs email verification. Please check your email to verify.");
						return redirect()->back();	
					}else{
						return redirect('/dashboard');
					}
				}
		} else {   
			Session::flash('error-message', "Wrong username/password combinations.");
			return redirect()->back();	
		}
	}
}
