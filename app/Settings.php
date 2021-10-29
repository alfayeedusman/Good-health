<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Settings extends Model
{
    use SoftDeletes;
	
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'setting_tbl';
	protected $primaryKey = 'id';
	
	// public function member(){
		 // return $this->belongsTo('App\Member', 'owned_by', 'id');
	// }
	// public function placement(){
		 // return $this->belongsTo('App\Account', 'placement', 'account_name');
	// }
}
