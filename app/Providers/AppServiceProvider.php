<?php

namespace App\Providers;

use App\Block;
use App\Menu;
use App\Tour;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		
	}
	
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$locale = App::getLocale();
		$menu = Menu::whereNull('parent_id')
			->with("child")
			->orderBy('sort', 'asc')
			->get();
		View::share(["lang" => $locale, 'menu' => $menu]);
	}
}
