<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\User;

use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\Request as StoreRequest;
use App\Http\Requests\Admin\Request as UpdateRequest;
use App\Models\Gender;

class AgentController extends PanelController {
    
    // public function index(){
    //     // echo 'asdf';
    //     return view('agent.index');
    // }


    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->xPanel->setModel('App\Models\Agent');
        $this->xPanel->setRoute(admin_uri('agent'));
        $this->xPanel->setEntityNameStrings(trans('admin.agent'), trans('admin.agent'));
        // $this->xPanel->denyAccess(['create', 'delete']);

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
            'name'  => 'name',
            'label' => trans('admin.name'),
        ]);





        //FIELDS
        $emailField = [
            'name'       => 'email',
            'label'      => trans('admin.Email'),
            'type'       => 'email',
            'attributes' => [
                'placeholder' => trans('admin.Email'),
            ],
            'prefix' => '<span class="input-group-text"><i class="ti-email"></i></span>',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ]
        ];
        $this->xPanel->addField($emailField);

        $passwordField = [
            'name'       => 'password',
            'label'      => trans('admin.Password'),
            'type'       => 'password',
            'attributes' => [
                'placeholder' => trans('admin.Password'),
            ],
            'prefix' => '<span class="input-group-text"><i class="ti-lock"></i></span>',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ]
        ];
        $this->xPanel->addField($passwordField, 'create');
        

        $this->xPanel->addField([
            'label'             => trans('admin.Gender'),
            'name'              => 'gender_id',
            'type'              => 'select2_from_array',
            'options'           => $this->gender(),
            'allows_null'       => false,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

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
            'name'              => 'phone',
            'label'             => trans('admin.Phone'),
            'type'              => 'text',
            'attributes'        => [
                'placeholder' => trans('admin.Phone'),
            ],
            'prefix' => '<span class="input-group-text"><i class="ti-mobile"></i></span>',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        $countryField = [
            'label'             => mb_ucfirst(trans('admin.country')),
            'name'              => 'country_code',
            'model'             => 'App\Models\Country',
            'entity'            => 'country',
            'attribute'         => 'asciiname',
            'type'              => 'select2',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ];
        $this->xPanel->addField($countryField);

        $voucherCode = [
            'label'             => 'Voucher Code',
            'name'              => 'voucher_code',
            // 'entity'            => 'country',
            'type'              => 'text',
            'value'             => 'fds',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ];
        $this->xPanel->addField($voucherCode);

        $commissionPer = [
            'name'       => 'commission_percentage',
            'label'      => 'Commission Percentage',
            'type'       => 'number',
            'attributes' => [
                'placeholder' => 'Commission Percentage',
            ],
            'prefix' => '<span class="input-group-text"><i class="ti-email"></i></span>',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ]
        ];
        $this->xPanel->addField($commissionPer);



        $this->xPanel->addField([
            'label'             => 'Payment Method',
            'name'              => 'gender_ids',
            'type'              => 'select2_from_array',
            'options'           => ['stripe','paypal'],
            'allows_null'       => false,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        $payoutEmail = [
            'name'       => 'payout_email',
            'label'      => 'Payout Email',
            'type'       => 'email',
            'attributes' => [
                'placeholder' => 'payout email',
            ],
            'prefix' => '<span class="input-group-text"><i class="ti-email"></i></span>',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ]
        ];
        $this->xPanel->addField($payoutEmail);


        $this->xPanel->addField([
            'name'              => 'verified_email',
            'label'             => trans('admin.Verified Email'),
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);
        $this->xPanel->addField([
            'name'              => 'verified_phone',
            'label'             => trans('admin.Verified Phone'),
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);
        $this->xPanel->addField([
            'name'              => 'blocked',
            'label'             => trans('admin.Blocked'),
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        // $this->xPanel->addField([
        //     'name'  => 'active',
        //     'label' => trans('admin.Active'),
        //     'type'  => 'checkbox',
        // ]);
    }

    public function store(StoreRequest $request)
    {
        echo 'asdf';
        dd($request->all());
        // return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }

    private function gender()
	{
		$entries = Gender::trans()->get();
		
		return $this->getTranslatedArray($entries);
	}
}
