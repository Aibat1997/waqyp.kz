<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportCategory extends Model
{
	protected $table = 'report_category';
	protected $guarded = ['id'];
	
	public function reports()
	{
		return $this->hasMany('App\Report', 'report_category_id', 'id')->where('status', 1)->orderBy('sort', 'asc');
	}
}
