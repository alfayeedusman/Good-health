<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Downline extends Model
{
    use NodeTrait;
	protected $dates = ['created_at', 'updated_at'];
    protected $table = 'account_tbl';
	protected $primaryKey = 'id';
}
