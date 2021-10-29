<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LoadMobileTopUp extends Model
{
    use SoftDeletes;
	
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'top_up_tbl';
	protected $primaryKey = 'id';
	

}
