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
use Omnipay\Omnipay;
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
        if(auth()->user()->hasRole('agent')){
            $this->xPanel->addClause('where', 'parent_id', Auth::user()->id);
        }
        // $this->xPanel->removeButton('create');
        // dd(auth()->user());
        if(auth()->user()->hasRole('super-admin')){
            $this->xPanel->denyAccess(['create', 'delete']);
        }

        $this->xPanel->setRoute(admin_uri('sub-agent'));
        $this->xPanel->setEntityNameStrings(trans('sub-agent'), trans('sub-agent'));
        

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
            'type'              => 'select_from_array_val',
            'options'           => $this->commission_validity(),
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
            // 'country' => 'required',          
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
        $users = User::where('ref_type','agent')->with('ref')->get();
        return view('agent.ref-user',compact('users'));
    }

    public function refAgentUser(){
        $users = User::where('ref_type','sub-agent')->with('ref')->get();
        return view('agent.ref-user',compact('users'));
    }

    public function refAgentUserlist(){

        $subagents = Agent::where('parent_id',Auth::user()->id)->with('user.ref')->get();
        // dd($subagents);
        // $users = User::where('ref_type','agent')->where('ref_id',Auth::user()->id)->get();

        // dd($users);

        return view('agent.ref-agent-user',compact('subagents'));

    }
    
    public function subAgentCommission(){
        $providerParams = [
			'amount'   => 100,
			'currency' => 'EUR',
			'token'    => 'adsf8fda6adf8',
        ];
        
        $gateway = Omnipay::create('Stripe');
        $gateway->setApiKey(config('payment.stripe.secret'));
        // $formData = array('number' => '4000056655665556', 'expiryMonth' => '6', 'expiryYear' => '2021', 'cvv' => '123');
        // $response = $gateway->purchase(array('amount' => '10.00', 'currency' => 'USD', 'token' => 'asdfasda2222df'))->send();

        // Make the payment
			$response = $gateway->purchase($providerParams)->send();
			
			// Get raw data
            $rawData = $response->getData();
        //    dd($rawData);
        // $stripe = new \Stripe\StripeClient(
        //     'sk_test_51HZDMaL1AAIMeAhON8nsJx9m9oVjzlltX13CtzcflK35hjSGfJyLYowDiXI76LAmR6yo0JfW6XvfbxNj5wdXhpJg00IF7bZQiZ'
        //   );
        // $stripe->transfers->create([
        //     'amount' => 400,
        //     'currency' => 'usd',
        //     'destination' => 'acct_1HZDMaL1AAIMeAhO',
        //     'transfer_group' => 'ORDER_95',
        // ]);




        $subagents = Agent::where('parent_id',Auth::user()->id)->with('user.commission')->get();
        // dd($subagents);
        return view('agent.sub-agent-commission',compact('subagents'));
    }

    public function refSubAgentUser(){
        $users = User::where('ref_type','agent')->with('ref')->get();
        return view('agent.ref-user',compact('users'));
    }

    public function commission_validity(){
        $arr = [
            '3 months','6 months','9 months','1 year','1.5 years','2 years','2.5 years','3 years','3.5 years','4 years','5 years'
        ];
        if(auth()->user()->hasRole('agent')) {
            $parent_val = Auth::user()->agent->commission_validity;
            $index = array_search($parent_val,$arr);
            array_splice($arr, $index+1);
        }
        return $arr;
    }

    
    // public function store(StoreRequest $request ){
    //     dd($request->all());
    // }

}
