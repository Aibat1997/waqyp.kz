<?php

namespace App\Http\Sections;

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
 * Class Block
 *
 * @property \App\Block $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Block extends Section implements Initializable
{
	public function initialize()
	{
		// Добавление пункта меню и счетчика кол-ва записей в разделе
		$this->addToNavigation($priority = 11, function () {
			return \App\Block::count();
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
	protected $title = 'Блоки';
	
	/**
	 * @var string
	 */
	protected $alias = 'block';
	
	/**
	 * @return DisplayInterface
	 */
	public function onDisplay()
	{
		return AdminDisplay::table()/*->with('users')*/
		->setHtmlAttribute('class', 'table-primary')
			->setColumns(
				AdminColumn::text('id', '#')->setWidth('30px'),
				AdminColumn::link('title_ru', 'Заголовок ru'),
				AdminColumn::text('created_at', 'Дата')->setWidth('150px'),
				AdminColumnEditable::checkbox('status', 'Видно', 'Не видно')->setLabel('Статус')->setWidth('100px')
			)->paginate(20);
	}
	
	/**
	 * @param int $id
	 *
	 * @return FormInterface
	 */
	public function onEdit($id)
	{
		$tabs = AdminDisplay::tabbed();
		$tabs->setTabs(function ($id) {
			$tabs = [];
			$tabs[] = AdminDisplay::tab(AdminForm::elements([
				
				AdminFormElement::text('title_ru', 'Заголовок ru')->required(),
				AdminFormElement::textarea('desc_ru', 'Описание ru')->required(),
			]))->setLabel('RU');
			
			$tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
				AdminFormElement::text('title_kk', 'Заголовок kk'),
				AdminFormElement::textarea('desc_kk', 'Описание kk'),
			]))->setLabel('KK');
			$tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
				AdminFormElement::text('title_en', 'Заголовок en'),
				AdminFormElement::textarea('desc_en', 'Описание en'),
			]))->setLabel('EN');
			
			return $tabs;
		});
		
		$form = AdminForm::panel()
			->addHeader([
				$tabs,
				AdminFormElement::datetime('created_at', 'Дата и время')->setCurrentDate(),
				AdminFormElement::checkbox('status', 'Статус')->setDefaultValue(1)
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
		return 'fa  fa-th';
	}
}
