<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Epins extends Model
{
    use SoftDeletes;
	
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'epins_tbl';
	protected $primaryKey = 'id';
	
	// public function account(){
		 // return $this->belongsTo('App\Account', 'code', 'activation_code');
	// }
	// public function member(){
		 // return $this->belongsTo('App\Member', 'owned_by', 'id');
	// }
	
	
	

}
