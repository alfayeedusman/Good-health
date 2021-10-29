<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Encashment extends Model
{
    use SoftDeletes;
	
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'encashment_tbl';
	protected $primaryKey = 'id';
	
	public function member(){
		 return $this->belongsTo('App\Member', 'member_id', 'id');
    }
}
