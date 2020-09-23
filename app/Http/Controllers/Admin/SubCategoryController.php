<?php
/**
 * Laravel Classified
 *  All Rights Reserved
 *
 * 
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice
 * 
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CategoryRequest as StoreRequest;
use App\Http\Requests\Admin\CategoryRequest as UpdateRequest;
use App\Models\Category;
use Larapen\Admin\app\Http\Controllers\PanelController;

class SubCategoryController extends PanelController
{
	public $parentId = null;
	
	public function setup()
	{
		// Get the Parent ID
		$this->parentId = request()->segment(3);
		
		// Get Parent Category name
		$parent = Category::findTransOrFail($this->parentId);
		
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\Category');
		$this->xPanel->setRoute(admin_uri('categories/' . $this->parentId . '/subcategories'));
		$this->xPanel->setEntityNameStrings(
			trans('admin.subcategory') . ' &rarr; ' . '<strong>' . $parent->name . '</strong>',
			trans('admin.subcategories') . ' &rarr; ' . '<strong>' . $parent->name . '</strong>'
		);
		$this->xPanel->enableReorder('name', 1);
		$this->xPanel->enableDetailsRow();
		if (!request()->input('order')) {
			$this->xPanel->orderBy('lft', 'ASC');
		}
		
		$this->xPanel->enableParentEntity();
		$this->xPanel->setParentKeyField('parent_id');
		$this->xPanel->addClause('where', 'parent_id', '=', $this->parentId);
		$this->xPanel->setParentRoute(admin_uri('categories'));
		$this->xPanel->setParentEntityNameStrings('parent ' . trans('admin.category'), 'parent ' . trans('admin.categories'));
		$this->xPanel->allowAccess(['reorder', 'details_row', 'parent']);
		
		$this->xPanel->addButtonFromModelFunction('top', 'bulk_delete_btn', 'bulkDeleteBtn', 'end');
		$this->xPanel->addButtonFromModelFunction('line', 'custom_fields', 'customFieldsBtn', 'beginning');
		
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		// COLUMNS
		$this->xPanel->addColumn([
			'name'  => 'id',
			'label' => '',
			'type'  => 'checkbox',
			'orderable' => false,
		]);
		$this->xPanel->addColumn([
			'name'          => 'name',
			'label'         => trans('admin.Name'),
			'type'          => 'model_function',
			'function_name' => 'getNameHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'active',
			'label'         => trans('admin.Active'),
			'type'          => 'model_function',
			'function_name' => 'getActiveHtml',
			'on_display'    => 'checkbox',
		]);
		
		
		// FIELDS
		$this->xPanel->addField([
			'name'  => 'parent_id',
			'type'  => 'hidden',
			'value' => $this->parentId,
		], 'create');
		$this->xPanel->addField([
			'name'              => 'name',
			'label'             => trans('admin.Name'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans('admin.Name'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'slug',
			'label'             => trans('admin.Slug'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans('admin.Will be automatically generated from your name, if left empty'),
			],
			'hint'              => trans('admin.Will be automatically generated from your name, if left empty'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'       => 'description',
			'label'      => trans('admin.Description'),
			'type'       => 'textarea',
			'attributes' => [
				'placeholder' => trans('admin.Description'),
			],
		]);
		$this->xPanel->addField([
			'name'  => 'type',
			'label' => mb_ucfirst(trans('admin.type')),
			'type'  => 'enum',
		]);
		$this->xPanel->addField([
			'name'  => 'active',
			'label' => trans('admin.Active'),
			'type'  => 'checkbox',
		]);
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
}
