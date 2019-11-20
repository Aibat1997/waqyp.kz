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
 * Class News
 *
 * @property \App\News $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class News extends Section implements Initializable
{
	/**
	 * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
	 *
	 * @var bool
	 */
	public function initialize()
	{
		// Добавление пункта меню и счетчика кол-ва записей в разделе
		$this->addToNavigation($priority = 2, function () {
			return \App\News::count();
		});
	}
	
	protected $checkAccess = false;
	
	/**
	 * @var string
	 */
	protected $title = 'Новости';
	
	/**
	 * @var string
	 */
	protected $alias = 'news';
	
	/**
	 * @return DisplayInterface
	 */
	public function onDisplay()
	{
		$display = AdminDisplay::datatables();
		$display->setHtmlAttribute('class', 'table table-primary');
		$display->setColumns(
			AdminColumn::text('id', '#')->setWidth('30px'),
			AdminColumn::image('img', 'Картинка')->setWidth('100px'),
			AdminColumn::link('title_ru', 'Заголовок ru')->setWidth('400px'),
			AdminColumn::text('sh_desc_ru', 'Краткое описание ru'),
			AdminColumn::text('created_at', 'Дата')->setWidth('150px'),
			AdminColumnEditable::checkbox('is_archive', 'Да', 'Нет')->setLabel('Архив')->setWidth('100px'),
			AdminColumnEditable::checkbox('status', 'Видно', 'Не видно')->setLabel('Статус')->setWidth('100px')
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
		$tabs = AdminDisplay::tabbed();
		$tabs->setTabs(function ($id) {
			$tabs = [];
			$tabs[] = AdminDisplay::tab(AdminForm::elements([
				
				AdminFormElement::text('title_ru', 'Заголовок ru')->required(),
				AdminFormElement::textarea('sh_desc_ru', 'Краткое описание ru')->required(),
				AdminFormElement::wysiwyg('desc_ru', 'Описание ru')->required(),
			
			]))->setLabel('RU');
			
			$tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
				AdminFormElement::text('title_kk', 'Заголовок kk'),
				AdminFormElement::textarea('sh_desc_kk', 'Краткое описание kk'),
				AdminFormElement::wysiwyg('desc_kk', 'Описание kk'),
			]))->setLabel('KK');
			
			$tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
				AdminFormElement::text('title_en', 'Заголовок en'),
				AdminFormElement::textarea('sh_desc_en', 'Краткое описание en'),
				AdminFormElement::wysiwyg('desc_en', 'Описание en'),
			]))->setLabel('EN');
			return $tabs;
		});
		$form = AdminForm::panel()
			->addHeader([
				$tabs,
				AdminFormElement::checkbox('status', 'Статус')->setDefaultValue(1),
				AdminFormElement::checkbox('is_archive', 'Архив')->setDefaultValue(0),
				AdminFormElement::image('img', 'Картинка'),
				AdminFormElement::datetime('created_at', 'Дата и время')->setCurrentDate(),
			
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
		return 'fa fa-list';
	}
}
