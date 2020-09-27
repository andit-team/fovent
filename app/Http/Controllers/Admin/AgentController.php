<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\User;

use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\Request as StoreRequest;
use App\Http\Requests\Admin\Request as UpdateRequest;
use App\Models\Gender;
use App\Models\Agent;
use App\Models\User;
use App\Mail\AgentAddMail;
use Session;
use Hash;
use DB;

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
        $this->xPanel->addColumn([
            'name'  => 'email',
            'label' => trans('admin.email'),
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
            'name'              => 'gender',
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
            'value'             => $this->voucherCode(),
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ];
        $this->xPanel->addField($voucherCode);

        $commissionPer = [
            'name'       => 'commission',
            'label'      => 'Commission Percentage',
            'type'       => 'number',
            'attributes' => [
                'placeholder' => 'Commission Percentage',
            ],
            'prefix' => '<span class="input-group-text">%</span>',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ]
        ];
        $this->xPanel->addField($commissionPer);



        $this->xPanel->addField([
            'label'             => 'Payment Method',
            'name'              => 'payment_method',
            'type'              => 'select2_from_array',
            'options'           => ['stripe','paypal'],
            'allows_null'       => false,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        $this->xPanel->addField([
            'label'             => 'Commission Validity',
            'name'              => 'commission_validity',
            'type'              => 'select2_from_array',
            'options'           => ['1 year','2 years','6 months','3 years'],
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
            'name'              => 'phone_verified',
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

    public function store(Agent $agent,User $user,StoreRequest $request )
    {
        $this->validateForm($request);

        $data = [
            'name'                   => $request->name,  
            'gender'                 => $request->gender,               
            'email'                  => $request->email,
            'phone'                  => $request->phone,   
            'password'               => Hash::make($request->password),             
            'country_code'           => $request->country_code,                      
            'created_at'             => now(),
        ];

        $user = User::create($data);

        \Mail::to($data['email'])->send(new AgentAddMail($data));

        $data = [
                'name'                   => $request->name,  
                'gender'                 => $request->gender,               
                'email'                  => $request->email,
                'phone'                  => $request->phone,
                'voucher_code'           => $request->voucher_code,
                'commission'             => $request->commission,
                'commission_validity'    => $request->commission_validity,
                'payment_method'         => $request->payment_method,
                'payout_email'           => $request->payout_email,
                'country_code'           => $request->country_code,
                'phone_verified'         => $request->phone_verified,   
                'own_user_id'            => $user->id,   
                'created_at'             => now(),
            ];
    
            $agent = Agent::create($data);



            $roles = [
                'model_type' => 'App\Models\User',
                'role_id' => 2,
                'model_id' => $user->id,
            ];

            DB::table('model_has_roles')->insert($roles);


       Session::flash('success', 'Agent Inserted Successfully');

       return back();

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
    
    private function voucherCode(){
        $lastagent = Agent::orderBy('id','DESC')->limit(1)->first();
        return 'agent-'.sprintf('%04d',$lastagent->id+1);
        
    }

    private function validateForm($request){
        $validatedData = $request->validate([
            'name' => 'required',
            'gender' => '',
            'email' => 'required',
            // 'email' => 'required|email|unique:agents,email',
            'phone' => 'required',
            'voucher_code' => 'required',
            'commission' => '',
            'payment_method' => 'required',
            'payout_email' => 'required',
            'country' => '',          
        ]);
    }
}
