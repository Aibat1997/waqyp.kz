<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $table = 'menus';
	protected $guarded = ['id'];
	
	public function parent()
	{
		return $this->hasOne('App\Menu', 'id', 'parent_id');
	}
	
	public function child()
	{
		return $this->hasMany('App\Menu', 'parent_id', 'id')->orderBy('sort', 'asc');
	}
}
