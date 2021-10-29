<?php

namespace App\Console\Commands;
use App\Account;
use App\Member;
use App\Cron;
use DB;
use Illuminate\Console\Command;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		
		
		
        $dateNow = getDatetimeNow();
		$dateToday = explode(" ",$dateNow);
		
		
		
		$date=date_create($dateToday[0]);
		date_sub($date,date_interval_create_from_date_string("1 day"));
		$dateYesterday = date_format($date,"Y-m-d");
		
		$accEncoded = Account::where('slot','=','PAID')->where('entry','=','1500')->where('is_distributed','=','NO')->where('_date','=',$dateYesterday)->count();
		$totalPremiumAccountAMOUNT = $accEncoded * 100;
		$accEncoded2 = Account::where('slot','=','PAID')->where('entry','=','599')->where('is_distributed','=','NO')->where('_date','=',$dateYesterday)->count();
		$totalAccountAMOUNT = $accEncoded2 * 20;
		$totalAmount = $totalPremiumAccountAMOUNT + $totalAccountAMOUNT;
	
	
	
		// $date=date_create($dateYesterday);
		// date_sub($date,date_interval_create_from_date_string("1 day"));
		// $dateBeforeYesterday = date_format($date,"Y-m-d");
		
		
		$allAccountsQualified = Account::where('slot','=','PAID')->where('_date','<',$dateYesterday)->count();
		$royalty = $totalAmount / $allAccountsQualified;
		
		DB::table('account_tbl')->where('slot','=','PAID')->where('_date','<',$dateYesterday)->increment('royalty_bonus', $royalty);	
		DB::table('account_tbl')->where('is_distributed','=','NO')->where('_date','<',$dateYesterday)->update(['is_distributed' => 'YES']);
			
		$cron = new Cron;
		$cron->total_amount = $totalAmount;
		$cron->total_account = $accEncoded2;
		$cron->total_account_premium = $accEncoded;
		$cron->total_qualified = $allAccountsQualified;
		$cron->amount_distributed = $royalty;
		$cron->_date = $dateToday[0];
		$cron->save();
		
		
    }
}
