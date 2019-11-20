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
 * Class Menu
 *
 * @property \App\Menu $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Menu extends Section implements Initializable
{
	public function initialize()
	{
		// Добавление пункта меню и счетчика кол-ва записей в разделе
		$this->addToNavigation($priority = 10, function () {
			return \App\Menu::count();
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
	protected $title = 'Меню';
	
	/**
	 * @var string
	 */
	protected $alias = 'menu';
	
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
			AdminColumn::custom('Родитель', function (\Illuminate\Database\Eloquent\Model $model) {
				if (is_null($model->parent)) {
					return '-';
				}
				return $model->parent->title_ru;
			}),
			AdminColumn::text('created_at', 'Дата')->setWidth('150px'),
			AdminColumnEditable::text('sort')->setLabel('Сортировка')->setWidth('150px'),
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
				$columns = AdminFormElement::columns([
					[AdminFormElement::text('link', 'Ссылка')->required()], [AdminFormElement::number('sort', 'Сортировка')->setDefaultValue(0)->required()], [AdminFormElement::datetime('created_at', 'Дата и время')->setCurrentDate()->required()],
				]),
				AdminFormElement::checkbox('status', 'Статус')->setDefaultValue(1),
				AdminFormElement::checkbox('target', 'Открыть новом окне')->setDefaultValue(0),
				AdminFormElement::select('parent_id', 'Родитель')->setModelForOptions('App\Menu')->setLoadOptionsQueryPreparer(function ($element, $query) {
					return $query
						->where('parent_id', null);
				})->setDisplay('title_ru')->setSortable('title_ru'),
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
		return 'fa fa-bars';
	}
}
