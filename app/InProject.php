<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InProject extends Model
{
	protected $table = 'in_projects';
	protected $guarded = ['id'];
	
	public function project()
	{
		return $this->hasOne('App\Project', 'id', 'project_id');
	}
	
	public function reports()
	{
		return $this->hasMany('App\ReportCategory', 'in_project_id', 'id');
	}
}
