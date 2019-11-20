<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';
	protected $guarded = ['id'];
	
	public function page()
	{
		return $this->hasOne('App\Page', 'id', 'page_id');
	}
	
	public function posts()
	{
		return $this->hasMany('App\Post', 'category_id', 'id');
	}
}
