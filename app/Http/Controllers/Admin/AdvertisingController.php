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
use App\Http\Requests\Admin\Request as StoreRequest;
use App\Http\Requests\Admin\Request as UpdateRequest;

class AdvertisingController extends PanelController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->xPanel->setModel('App\Models\Advertising');
        $this->xPanel->setRoute(admin_uri('advertisings'));
        $this->xPanel->setEntityNameStrings(trans('admin.advertising'), trans('admin.advertisings'));
        $this->xPanel->denyAccess(['create', 'delete']);

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */
        // COLUMNS
        $this->xPanel->addColumn([
            'name'  => 'id',
            'label' => "ID",
        ]);
        $this->xPanel->addColumn([
            'name'  => 'slug',
            'label' => trans('admin.Slug'),
        ]);
        $this->xPanel->addColumn([
            'name'  => 'provider_name',
            'label' => trans('admin.Provider Name'),
        ]);
        $this->xPanel->addColumn([
            'name'          => 'active',
            'label'         => trans('admin.Active'),
            'type'          => 'model_function',
            'function_name' => 'getActiveHtml',
        ]);

        // FIELDS
        $this->xPanel->addField([
            'name'       => 'provider_name',
            'label'      => trans('admin.Provider Name'),
            'type'       => 'text',
            'attributes' => [
                'placeholder' => trans('admin.Provider Name'),
            ],
        ]);
        $this->xPanel->addField([
            'name'       => 'tracking_code_large',
            'label'      => trans('admin.Tracking Code') . " (" . trans('admin.Large Format') . ")",
            'type'       => 'textarea',
            'attributes' => [
                'placeholder' => trans('admin.Enter the source code here'),
            ],
        ]);
        $this->xPanel->addField([
            'name'       => 'tracking_code_medium',
            'label'      => trans('admin.Tracking Code') . " (" . trans('admin.Tablet Format') . ")",
            'type'       => 'textarea',
            'attributes' => [
                'placeholder' => trans('admin.Enter the source code here'),
            ],
        ]);
        $this->xPanel->addField([
            'name'       => 'tracking_code_small',
            'label'      => trans('admin.Tracking Code') . " (" . trans('admin.Phone Format') . ")",
            'type'       => 'textarea',
            'attributes' => [
                'placeholder' => trans('admin.Enter the source code here'),
            ],
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
