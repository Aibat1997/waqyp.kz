<?php

namespace App\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{
	
	/**
	 * @var array
	 */
	protected $sections = [
		\App\News::class => 'App\Http\Sections\News',
		\App\Project::class => 'App\Http\Sections\Project',
		\App\InProject::class => 'App\Http\Sections\InProject',
		\App\Page::class => 'App\Http\Sections\Page',
		\App\Menu::class => 'App\Http\Sections\Menu',
		\App\Block::class => 'App\Http\Sections\Block',
		\App\Category::class => 'App\Http\Sections\Category',
		\App\Post::class => 'App\Http\Sections\Post',
		\App\Report::class => 'App\Http\Sections\Report',
		\App\ReportCategory::class => 'App\Http\Sections\ReportCategory',
		\App\Volunteer::class => 'App\Http\Sections\Volunteer',
	];
	
	/**
	 * Register sections.
	 *
	 * @param \SleepingOwl\Admin\Admin $admin
	 * @return void
	 */
	public function boot(\SleepingOwl\Admin\Admin $admin)
	{
		parent::boot($admin);
		
	}
	
}
