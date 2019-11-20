<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $table = 'reports';
	protected $guarded = ['id'];
	
	public function report_category()
	{
		return $this->hasOne('App\ReportCategory', 'id', 'report_category_id');
	}
}
