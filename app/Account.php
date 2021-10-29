<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
class Account extends Model
{
    use NodeTrait;
	
    protected $dates = ['created_at', 'updated_at'];
    protected $table = 'account_tbl';
	protected $primaryKey = 'id';
	
	public function member(){
		 return $this->belongsTo('App\Member', 'owner_member_id', 'id');
	}
	public function memberSponsor(){
		 return $this->belongsTo('App\Member', 'sponsor_member_id', 'id');
	}
	public function memberUpline(){
		 return $this->belongsTo('App\Member', 'upline_member_id', 'id');
	}
	// public function placement(){
		 // return $this->belongsTo('App\Account', 'placement', 'account_name');
	// }
}
