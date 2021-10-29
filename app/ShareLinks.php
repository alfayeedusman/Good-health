<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShareLinks extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'share_links_tbl';
	protected $primaryKey = 'id';
	
}