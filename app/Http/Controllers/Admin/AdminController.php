<?php

namespace App\Http\Controllers\Admin;


use App\Tap;
use App\BidCoins;
use App\Winner;
use Validator;
use DateTime;
use Input;
use Auth;
use URL;
use Hash;
use DB;
use Session;
use App\Http\Requests;
use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    public function index()
    {
		$role = Auth::user()->role;
		if($role == "ADMIN"){
			return redirect('/admin/tap');
			//return view('admin.index');
		}elseif($role == "USER"){
			Auth::logout(); //
			return redirect('/login');
		}
        
    }
	public function getTap()
    {
		$role = Auth::user()->role;
		if($role == "ADMIN"){
			$date = getDatetimeNow();
			$tapStarted = Tap::where('start_date', '!=' , '')->where('start_date', '<' , $date )->where('end_date', '>' , $date )->orderBy('start_date','desc')->get();
			$tapReady = Tap::where('start_date', '!=' , '')->where('start_date', '>' , $date )->where('end_date', '>' , $date )->orderBy('start_date','desc')->get();
			$tapEnded = Tap::where('start_date', '!=' , '')->where('end_date', '<' , $date )->orderBy('start_date','desc')->get();
			$tapUpcomming = Tap::whereNull('start_date')->get();
			return view('admin.tap')->with('tapReady',$tapReady)->with('tapStarted',$tapStarted)->with('tapUpcomming',$tapUpcomming)->with('tapEnded',$tapEnded);
		}elseif($role == "USER"){
			Auth::logout(); //
			return redirect('/login');
		}
       
    }
	public function postTapDonate(Request $request){
		$role = Auth::user()->role;
		if($role == "ADMIN"){
			$rules = array(
					'title'    => 'required|max:300',
					'image'=>'required|max:5000kb|Mimes:jpeg,jpg,png,pneg',
					'minimum_coins'    => 'required|numeric',
					'coins_per_tap'    => 'required|numeric',		
					'description'    => 'required',
				);
				$input = Input::all();
				$validator = Validator::make($input, $rules);
				if ($validator->fails()) {
					return redirect()->back()->withInput()->withErrors($validator->errors());
				} 
								
				try{
				
				if($input['minimum_coins'] < $input['coins_per_tap']) {
					return redirect()->back()->withInput()->withErrors(['Minimum Points must greater than Points Per Tap']);
				}

			
				$tap = new Tap;
				$tap->product_name = $input['title'];
				$tap->minimum_coins = $input['minimum_coins'];
				$tap->coins_per_tap = $input['coins_per_tap'];
				$tap->description = $input['description'];
				$tap->save();
				$inserted_id = $tap->id;

				$destinationPath = 'assets/tap/';
				$extension = Input::file('image')->getClientOriginalExtension();
				$fileName = $inserted_id.'.'.'png'; // renameing image
				Input::file('image')->move($destinationPath, $fileName);
				
				Session::flash('message', "Product for Tap and donate has been added!");
				return redirect()->back();
				}catch(\Exception $e){
					return redirect()->back()->withInput()->withErrors(['Something went wrong.'.$e]); 
				}	
			
		}elseif($role == "USER"){
			Auth::logout(); //
			return redirect('/login');
		}
	
				
	}
	public function postTapDonateStart(Request $request){
		$role = Auth::user()->role;
		if($role == "ADMIN"){
			$rules = array(
				'start_date'    => 'required',
				'end_date'    => 'required',
				'id'    => 'required',

			);
			$input = Input::all();
			$validator = Validator::make($input, $rules);
			if ($validator->fails()) {
				return redirect()->back()->withInput()->withErrors($validator->errors());
			} 
			try{

			$start_date = new DateTime(''.$input['start_date']);
			$end_date = new DateTime(''.$input['end_date']);
			if($end_date < $start_date) {
				return redirect()->back()->withInput()->withErrors(['End date must greater than Start date']);
			}
						
			$tap = Tap::find($input['id']);
			$tap->start_date = $input['start_date'];
			$tap->end_date = $input['end_date'];
			$tap->touch();
			$tap->save();

			Session::flash('message', "Product for Tap and donate has been set!");
			return redirect()->back();
			}catch(\Exception $e){
				return redirect()->back()->withInput()->withErrors(['Something went wrong.'.$e]); 
			}	
		}elseif($role == "USER"){
			Auth::logout(); //
			return redirect('/login');
		}
	
			
	}
	
	
	public function getTapDelete($id){
		if (Auth::check()){
			if(checkloginAuthentication()==2){
				$user = Auth::user()->member;
				$umid = Auth::user()->member->id;
				if(isPermitted($umid,'manage_tap_donate')=='false'){
					return redirect()->back()->withInput()->withErrors(['You dont have permission to manage tap donate.']);
				}
				$id = encryptor('decrypt',$id );
				Tap::where('id', $id)->forcedelete();
				$adminuser = Auth::user()->member->username;
				saveLogs( 'DELETE' , 'TAP', $adminuser.' delete tap donate with id: '.$id);
				
				Session::flash('message', "Tap Donate has been deleted!");
				return redirect()->back();
			}else{
				return redirect('/admin/login');
			}
		}else{
			return redirect('/admin/login');
		}			
	}
	
	
	
	
	
	
	
	
	
	
	
	public function getTapHistory()
    {
		$role = Auth::user()->role;
		if($role == "ADMIN"){
			if(isset($_GET['type'])){
				$type = $_GET['type'];
				if(isset($_GET['tapid'])){
					$tapid = $_GET['tapid'];
					$tap = BidCoins::where('type','=',$type)->where('tap_id','=',$tapid)->orderBy('created_at','desc')->paginate(100);
				}else{
					$tap = BidCoins::where('type','=',$type)->orderBy('created_at','desc')->paginate(100);
				}

			}else{
				$tap = BidCoins::where('type','=','joined')->orderBy('created_at','desc')->paginate(100);
			}

			return view('admin.history')->with('tap',$tap);
		}elseif($role == "USER"){
			Auth::logout(); //
			return redirect('/login');
		}
    }
	public function getTapWinners($id)
    {
		$role = Auth::user()->role;
		if($role == "ADMIN"){
			$date = getDatetimeNow();
			$decrptdid = encryptor('decrypt',$id);
			$tap = Tap::where('id','=',$decrptdid)->get();
			$taptitle = $tap[0]->product_name;
			$startDate = $tap[0]->start_date;
			$endDate = $tap[0]->end_date;
			$bid = BidCoins::where('tap_id','=',$decrptdid)
			->where('type','=', "TAP")
			->where('created_at','<=', $endDate)
			->where('created_at','>=', $startDate)
			->orderBy('id','desc')->get();
			
			$tapWinner = Winner::where('tap_id','=',$decrptdid)->orderBy('id','asc')->get();
			
			return view('admin.load.load-winners')
			->with('bid',$bid)
			->with('taplistid',$decrptdid)
			->with('taptitle',$taptitle)
			->with('tapWinner',$tapWinner);
		}elseif($role == "USER"){
			Auth::logout(); //
			return redirect('/login');
		}
       
    }
	public function postSetWinner(Request $request){
				
		if ($request->ajax()) {
			if (Auth::check()){
				if(checkloginAuthentication()=="ADMIN"){
					$data = $request->all();
					$bidid = $data['id'];
					
				
					$bid = BidCoins::where('id','=',$bidid)->get();
					$win = new Winner;
					$win->tap_id = $bid[0]->tap_id;
					$win->bid_id = $bidid;
					$win->username = $bid[0]->username;
					$win->member_id = $bid[0]->member_id;
					$win->save();
				
					return Response::json(array(
						'success' => 'true',
						'message'   => 'Winner has been added.'
					));	
					
					
				}else if(checkloginAuthentication()=="ADMIN"){
					return Response::json(array(
						'success' => 'false',
						'message'   => 'Something Went Wrong. Please Reload.'
					));	
				}
			}else{
				return Response::json(array(
					'success' => 'false',
					'message'   => 'Something Went Wrong. Please Reload.'
				));	
			} 
		}else{
			return redirect()->back();
		}
			
    }
	public function postRemoveWinner(Request $request){
				
		if ($request->ajax()) {
			if (Auth::check()){
				if(checkloginAuthentication()=="ADMIN"){
					$data = $request->all();
					$winid = $data['id'];
					
				
					Winner::where('id', $winid)->forcedelete();
				
					return Response::json(array(
						'success' => 'true',
						'message'   => 'Winner has been removed.'
					));	
					
					
				}else if(checkloginAuthentication()=="ADMIN"){
					return Response::json(array(
						'success' => 'false',
						'message'   => 'Something Went Wrong. Please Reload.'
					));	
				}
			}else{
				return Response::json(array(
					'success' => 'false',
					'message'   => 'Something Went Wrong. Please Reload.'
				));	
			} 
		}else{
			return redirect()->back();
		}
			
    }
	public function postGenerateWinner(Request $request){
				
		if ($request->ajax()) {
			if (Auth::check()){
				if(checkloginAuthentication()=="ADMIN"){
					$data = $request->all();
					$tapid = $data['id'];
					$num = $data['num'];
					$decrptdid = encryptor('decrypt',$tapid);
					$tap = Tap::where('id','=',$decrptdid)->get();
					
					$startDate = $tap[0]->start_date;
					$endDate = $tap[0]->end_date;
					
					$bids = BidCoins::where('tap_id','=',$decrptdid)
					->where('type','=', "TAP")
					->where('created_at','<=', $endDate)
					->where('created_at','>=', $startDate)
					->inRandomOrder()->get();
					
					$count = 0;
					foreach($bids as $bidlist){
						$count++;
						$winner = Winner::where('tap_id','=',$bidlist->tap_id)->where('member_id','=',$bidlist->member_id)->get();
						if($count<=$num){
							if(count($winner)==0){
								$win = new Winner;
								$win->tap_id = $bidlist->tap_id;
								$win->bid_id = $bidlist->id;
								$win->username = $bidlist->username;
								$win->member_id = $bidlist->member_id;
								$win->save();
							}
						}else{
							break;
						}
					}
			
					return Response::json(array(
						'success' => 'true',
						'message'   => 'Winners has been randomly generated.'
					));	
					
					
				}else if(checkloginAuthentication()=="ADMIN"){
					return Response::json(array(
						'success' => 'false',
						'message'   => 'Something Went Wrong. Please Reload.'
					));	
				}
			}else{
				return Response::json(array(
					'success' => 'false',
					'message'   => 'Something Went Wrong. Please Reload.'
				));	
			} 
		}else{
			return redirect()->back();
		}
			
    }
}
