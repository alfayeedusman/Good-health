<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MoveToWallet extends Model
{
    use SoftDeletes;
	
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'move_to_wallet_tbl';
	protected $primaryKey = 'id';
	
	// public function member(){
		 // return $this->belongsTo('App\Member', 'owned_by', 'id');
	// }
	// public function placement(){
		 // return $this->belongsTo('App\Account', 'placement', 'account_name');
	// }
}
