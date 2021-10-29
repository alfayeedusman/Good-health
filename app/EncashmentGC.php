<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EncashmentGC extends Model
{
    use SoftDeletes;
	
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'encashmentgc_tbl';
	protected $primaryKey = 'id';
	
	public function member(){
		 return $this->belongsTo('App\Member', 'member_id', 'id');
    }
}
