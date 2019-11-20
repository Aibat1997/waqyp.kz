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
class Report extends Section implements Initializable
{
	public function initialize()
	{
		// Добавление пункта меню и счетчика кол-ва записей в разделе
		$this->addToNavigation($priority = 6, function () {
			return \App\Report::count();
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
	protected $title = 'Отчеты';
	
	/**
	 * @var string
	 */
	protected $alias = 'reports';
	
	/**
	 * @return DisplayInterface
	 */
	public function onDisplay()
	{
		
		$display = AdminDisplay::datatables();
		$display->setHtmlAttribute('class', 'table table-primary');
		$display->setColumns(
			AdminColumn::text('id', '#')->setWidth('30px'),
			AdminColumn::custom('Отчет', function (\Illuminate\Database\Eloquent\Model $model) {
				if (is_null($model->report_category)) return '-';
				return $model->report_category->title_ru;
			}),
			AdminColumn::text('sum_ru', 'Сумма')->setWidth('150px'),
			AdminColumn::text('recipient_ru', 'Получатели помощи')->setWidth('200px'),
			AdminColumn::text('helped_ru', 'Помагали')->setWidth('150px'),
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
				AdminFormElement::text('sum_ru', 'Сумма ru')->required(),
				AdminFormElement::text('recipient_ru', 'Получатели помощи ru')->required(),
				AdminFormElement::text('helped_ru', 'Помогали ru')->required(),
				AdminFormElement::textarea('target_ru', 'Цель ru')->required(),
			]))->setLabel('RU');
			
			$tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
				AdminFormElement::text('sum_kk', 'Сумма kk')->required(),
				AdminFormElement::text('recipient_kk', 'Получатели помощи kk')->required(),
				AdminFormElement::text('helped_kk', 'Помогали kk')->required(),
				AdminFormElement::textarea('target_kk', 'Цель kk')->required(),
			]))->setLabel('KK');
			$tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
				AdminFormElement::text('sum_en', 'Сумма en')->required(),
				AdminFormElement::text('recipient_en', 'Получатели помощи en')->required(),
				AdminFormElement::text('helped_en', 'Помогали en')->required(),
				AdminFormElement::textarea('target_en', 'Цель en')->required(),
			]))->setLabel('EN');
			
			return $tabs;
		});
		$form = AdminForm::panel()
			->addHeader([
				$tabs,
				AdminFormElement::select('report_category_id', 'Отчет (категория)')->setModelForOptions('App\ReportCategory')->setDisplay('title_ru')->setSortable('title_ru')->required(),
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
		return 'fa fa-list-alt';
	}
}
