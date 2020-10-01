<?php

namespace App\Http\Controllers\Admin;

use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\Request as StoreRequest;
use App\Http\Requests\Admin\Request as UpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Gender;
use App\Models\Agent;
use App\Models\User;
use App\Mail\SubAgentAddMail;
use Session;
use Hash;
use DB;

class SubAgentController extends PanelController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        // dd(Auth::user()->id);
        $this->xPanel->setModel('App\Models\Agent');
        $this->xPanel->addClause('where', 'parent_id','!=',0);
        // $this->xPanel->addClause('where', 'parent_id', Auth::user()->id);

        $this->xPanel->setRoute(admin_uri('sub-agent'));
        $this->xPanel->setEntityNameStrings(trans('admin.sub-agent'), trans('admin.sub-agent'));
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
            'name'  => 'voucher_code',
            'label' => 'Voucher Code',
        ]);
        $this->xPanel->addColumn([
            'name'  => 'name',
            'label' => trans('admin.name'),
        ]);
        $this->xPanel->addColumn([
            'name'  => 'email',
            'label' => trans('admin.email'),
        ]);
        $this->xPanel->addColumn([
            'name'  => 'phone',
            'label' => 'Phone',
        ]);
        $this->xPanel->addColumn([
            'name'  => 'commission',
            'label' => 'Commission',
        ]);
        // $this->xPanel->addColumn([
        //     'name'  => 'commission_validity',
        //     'label' => 'Validity',
        // ]);





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
        $this->xPanel->addField([
            'name'              => 'parent_id',
            'label'             => 'parent_id',
            'type'              => 'hidden',
            'value'              => Auth::user()->id,
            // 'wrapperAttributes' => [
            //     'class' => 'form-group col-md-6',
            // ],
        ]);

        // $this->xPanel->addField([
        //     'name'  => 'active',
        //     'label' => trans('admin.Active'),
        //     'type'  => 'checkbox',
        // ]);
    }

    public function store(StoreRequest $request)
    {
        // $this->validateForm($request);
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'voucher_code' => 'required|unique:agent,voucher_code',
            'commission' => 'required|numeric|max:100',
            'payment_method' => 'required',
            'payout_email' => 'required',
            'country' => 'required',          
            'password' => 'required',          
        ]);


        $data = [
            'name'                   => $request->name,  
            'gender'                 => $request->gender,               
            'email'                  => $request->email,
            'phone'                  => $request->phone,   
            'password'               => $request->password,             
            'country_code'           => $request->country_code,
            'verified_email'         => 1,//$request->phone_verified,
            'verified_phone'         => 1,//$request->phone_verified,
            'created_at'             => now(),
        ];

        
        // \Mail::to($data['email'])->send(new AgentAddMail($data));

        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

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
            'parent_id'              => Auth::user()->id,
            'created_at'             => now(),
        ];

        $agent = Agent::create($data);
        // dd($agent);

        $roles = [
            'model_type' => 'App\Models\User',
            'role_id' => 4,
            'model_id' => $user->id,
        ];
        DB::table('model_has_roles')->insert($roles);


        Session::flash('success', 'Agent Inserted Successfully');

        $user['password'] = $request->password;

        \Mail::to($data['email'])->send(new SubAgentAddMail($user));

        return redirect('admin/sub-agent');

        // return agent::storeCrud();
    }

    private function gender()
	{
		$entries = Gender::trans()->get();
		
		return $this->getTranslatedArray($entries);
    }
    
    private function voucherCode(){
        $lastagent = Agent::orderBy('id','DESC')->limit(1)->first();
        if($lastagent){
            return 'agent-'.sprintf('%04d',$lastagent->id+1);
        }
        return 'agent-0001';
    }

    public function refUser(){
        $users = User::where('ref_type','Sub-Agent')->with('ref')->get();
        return view('agent.ref-user',compact('users'));
    }
    // public function store(StoreRequest $request ){
    //     dd($request->all());
    // }

}
