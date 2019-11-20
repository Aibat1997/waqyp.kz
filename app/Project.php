<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $table = 'projects';
	protected $guarded = ['id'];
	
	public function in_projects()
	{
		return $this->hasMany("App\InProject", 'project_id', 'id')->where('status', 1)->orderBy('sort', 'asc');
	}
}
