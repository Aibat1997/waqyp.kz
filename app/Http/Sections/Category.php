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
 * Class Image
 *
 * @property \App\Image $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Category extends Section implements Initializable
{
	public function initialize()
	{
		// Добавление пункта меню и счетчика кол-ва записей в разделе
		$this->addToNavigation($priority = 8, function () {
			return \App\Category::count();
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
	protected $title = 'Сайдбар (стр)';
	
	/**
	 * @var string
	 */
	protected $alias = 'sidebar';
	
	/**
	 * @return DisplayInterface
	 */
	public function onDisplay()
	{
		
		$display = AdminDisplay::datatables();
		$display->setHtmlAttribute('class', 'table table-primary');
		$display->setColumns(
			AdminColumn::text('id', '#')->setWidth('30px'),
			AdminColumn::link('title_ru', 'Заголовок ru'),
			AdminColumn::custom('Страница', function (\Illuminate\Database\Eloquent\Model $model) {
				if (is_null($model->page)) {
					return '-';
				}
				return $model->page->title_ru;
			}),
			AdminColumn::text('created_at', 'Дата')->setWidth('150px'),
			AdminColumnEditable::text('sort')->setLabel('Сортировка')->setWidth('100px'),
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
			]))->setLabel('RU');
			
			$tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
				AdminFormElement::text('title_kk', 'Заголовок kk'),
			]))->setLabel('KK');
			$tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
				AdminFormElement::text('title_en', 'Заголовок en'),
			]))->setLabel('EN');
			
			return $tabs;
		});
		$form = AdminForm::panel()
			->addHeader([
				$tabs,
				AdminFormElement::select('page_id', 'Страница')->setModelForOptions('App\Page')->setDisplay('title_ru')->setSortable('title_ru')->required(),
				AdminFormElement::select('template', 'Шаблон', [
					0 => 'Миссия (открытый)', 1 => 'Учредители', 2 => 'Команда', 3 => 'Партнеры и друзья'
				])->required(),
				AdminFormElement::datetime('created_at', 'Дата и время')->setCurrentDate(),
				AdminFormElement::number('sort', 'Сортировка')->setDefaultValue(0),
				AdminFormElement::checkbox('status', 'Статус')->setDefaultValue(1),
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
		return 'fa fa-file-text';
	}
}
