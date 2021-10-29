<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function user(){
		 return $this->hasOne('App\User', 'id', 'user_id');
	}
	public function accountlist(){
		 return $this->hasMany('App\Account', 'owner_member_id', 'id');
	}
	public function paidaccountlist(){
		 return $this->hasMany('App\Account', 'owner_member_id', 'id')->where('slot','=','PAID');
	}
}
