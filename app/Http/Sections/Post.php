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
class Post extends Section implements Initializable
{
	public function initialize()
	{
		// Добавление пункта меню и счетчика кол-ва записей в разделе
		$this->addToNavigation($priority = 7, function () {
			return \App\Post::count();
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
	protected $title = 'Посты (стр)';
	
	/**
	 * @var string
	 */
	protected $alias = 'post';
	
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
			AdminColumn::custom('Сайдбар', function (\Illuminate\Database\Eloquent\Model $model) {
				if (is_null($model->category)) {
					return '-';
				}
				return $model->category->title_ru;
			}),
			AdminColumnEditable::text('sort')->setLabel('Сортировка')->setWidth('150px'),
			AdminColumn::text('created_at', 'Дата')->setWidth('150px'),
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
				AdminFormElement::wysiwyg('desc_ru', 'Описание ru'),
			]))->setLabel('RU');
			
			$tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
				AdminFormElement::text('title_kk', 'Заголовок kk'),
				AdminFormElement::wysiwyg('desc_kk', 'Описание kk'),
			]))->setLabel('KK');
			$tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
				AdminFormElement::text('title_en', 'Заголовок en'),
				AdminFormElement::wysiwyg('desc_en', 'Описание en'),
			]))->setLabel('EN');
			
			return $tabs;
		});
		
		$form = AdminForm::panel()
			->addHeader([
				$tabs,
				AdminFormElement::select('category_id', 'Категория')->setModelForOptions('App\Category')->setDisplay('title_ru')->setSortable('title_ru')->required(),
				AdminFormElement::image('img', 'Картинка'),
				AdminFormElement::text('link', 'Ссылка'),
				AdminFormElement::number('sort', 'Сортировка')->setDefaultValue(0),
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
