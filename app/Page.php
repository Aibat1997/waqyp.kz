<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $guarded = ['id'];
	protected $table = 'pages';
	
	public function categories()
	{
		return $this->hasMany('App\Category', 'page_id', 'id')->where('status', 1)->orderBy('sort', 'asc');
	}
}
