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

use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\PackageRequest as StoreRequest;
use App\Http\Requests\Admin\PackageRequest as UpdateRequest;

class PackageController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\Package');
		$this->xPanel->setRoute(admin_uri('packages'));
		$this->xPanel->setEntityNameStrings(trans('admin.package'), trans('admin.packages'));
		$this->xPanel->enableReorder('name', 1);
		$this->xPanel->enableDetailsRow();
		$this->xPanel->allowAccess(['reorder', 'details_row']);
		if (!request()->input('order')) {
			$this->xPanel->orderBy('lft', 'ASC');
		}
		
		$this->xPanel->addButtonFromModelFunction('top', 'bulk_delete_btn', 'bulkDeleteBtn', 'end');
		
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
			'name'  => 'name',
			'label' => trans('admin.Name'),
		]);
		$this->xPanel->addColumn([
			'name'  => 'price',
			'label' => trans('admin.Price'),
		]);
		$this->xPanel->addColumn([
			'name'  => 'currency_code',
			'label' => trans('admin.Currency'),
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
			'name'              => 'short_name',
			'label'             => trans('admin.Short Name'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans('admin.Short Name'),
			],
			'hint'              => trans('admin.Short name for ribbon label'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'ribbon',
			'label'             => trans('admin.Ribbon'),
			'type'              => 'enum',
			'hint'              => trans('admin.Show ads with ribbon when viewing ads in search results list'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'has_badge',
			'label'             => trans('admin.Show ads with a badge'),
			'type'              => 'checkbox',
			'hint'              => '<br><br>',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'price',
			'label'             => trans('admin.Price'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans('admin.Price'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'label'             => trans('admin.Currency'),
			'name'              => 'currency_code',
			'model'             => 'App\Models\Currency',
			'entity'            => 'currency',
			'attribute'         => 'code',
			'type'              => 'select2',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'duration',
			'label'             => trans('admin.Duration'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans('admin.duration_in_days'),
			],
			'hint'              => trans('admin.Duration to show posts'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'       => 'description',
			'label'      => trans('admin.Description'),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => trans('admin.Description'),
			],
		]);
		$this->xPanel->addField([
			'name'              => 'lft',
			'label'             => trans('admin.Position'),
			'type'              => 'text',
			'hint'              => trans('admin.Quick Reorder') . ': '
				. trans('admin.Enter a position number') . ' '
				. trans('admin.position_number_note'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'active',
			'label'             => trans('admin.Active'),
			'type'              => 'checkbox',
			'hint'              => '<br><br>',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
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
