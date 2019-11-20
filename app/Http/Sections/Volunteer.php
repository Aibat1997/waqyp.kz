<?php

namespace App\Http\Sections;


use Carbon\Carbon;
use SleepingOwl\Admin\Contracts\DisplayInterface;
use SleepingOwl\Admin\Contracts\FormInterface;
use SleepingOwl\Admin\Section;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
use SleepingOwl\Admin\Contracts\Initializable;

/**
 * Class Category
 *
 * @property \App\Category $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Volunteer extends Section implements Initializable
{
	public function initialize()
	{
		// Добавление пункта меню и счетчика кол-ва записей в разделе
		$this->addToNavigation($priority = 12, function () {
			return \App\Volunteer::count();
		});
	}
	
	/**
	 * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
	 *
	 * @var bool
	 */
	protected $checkAccess = false;
	
	/**
	 * @var string
	 */
	protected $title = 'Волонтеры';
	
	/**
	 * @var string
	 */
	protected $alias = 'volunteer';
	
	/**
	 * @return DisplayInterface
	 */
	public function onDisplay()
	{
		
		$display = AdminDisplay::datatables();
		$display->setHtmlAttribute('class', 'table table-primary');
		$display->setColumns(
			AdminColumn::text('id', '#')->setWidth('30px'),
			AdminColumn::link('first_name', 'Имя'),
			AdminColumn::text('last_name', 'Фамилия'),
			AdminColumn::text('phone', 'Телефон'),
			AdminColumn::text('email', 'Email'),
			AdminColumn::text('created_at', 'Дата')->setWidth('150px')
		);
		$display->setDisplaySearch(true);
		$display->paginate(20);
		return $display;
		
	}
	
	/**
	 * @param int $id
	 *
	 * @return FormInterface
	 */
	public function onEdit($id)
	{
		$form = AdminForm::panel()
			->addHeader([
				AdminFormElement::text('first_name', 'Имя')->required(),
				AdminFormElement::text('last_name', 'Фамилия'),
				AdminFormElement::text('phone', 'Телефон'),
				AdminFormElement::text('email', 'Email'),
				AdminFormElement::textarea('about', 'О себе'),
				AdminFormElement::datetime('created_at', 'Дата и время')->setCurrentDate()
			]);
		return $form;
	}
	
	/**
	 * @return FormInterface
	 */
	public function onCreate()
	{
		return $this->onEdit(null);
	}
	
	/**
	 * @return void
	 */
	public function onDelete($id)
	{
		// remove if unused
	}
	
	/**
	 * @return void
	 */
	public function onRestore($id)
	{
		// remove if unused
	}
	
	public function getIcon()
	{
		return 'fa fa-list-alt';
	}
}
