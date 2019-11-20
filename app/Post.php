<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $table = 'posts';
	protected $guarded = ['id'];
	
	public function category()
	{
		return $this->hasOne('App\Category', 'id', 'category_id');
	}
}
