<?php

namespace App\Http\Controllers\Admin;
use Larapen\Admin\app\Http\Controllers\PanelController;

use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\AgentCommision;
use App\Helpers\Number;
use Omnipay\Omnipay;
use App\Models\Payout;
use Session;
class PayoutController extends PanelController
{
    public function setup(){
        $this->xPanel->setModel('App\Models\Payout');
        $this->xPanel->setRoute(admin_uri('payouts'));
        $this->xPanel->setEntityNameStrings(trans('Payouts'), trans('Payouts'));
        $this->xPanel->removeButton('create');
        $this->xPanel->removeAllButtonsFromStack('line');
        
        if(auth()->user()->hasRole('agent') || auth()->user()->hasRole('sub-agent')){
            $this->xPanel->addClause('where', 'agent_user_id', auth()->user()->id);
        }
        $this->xPanel->addFilter([
			'name'  => 'from_to',
			'type'  => 'date_range',
			'label' => trans('admin.Date range'),
		],
			false,
			function ($value) {
				$dates = json_decode($value);
				$this->xPanel->addClause('where', 'date', '>=', $dates->from);
				$this->xPanel->addClause('where', 'date', '<=', $dates->to);
            });
            

        $this->xPanel->addColumn([
            'name'  => 'date',
            'label' => "Date",
        ]);
        $this->xPanel->addColumn([
            'name'  => 'trans_id',
            'label' => "Trans Id",
        ]);

        $this->xPanel->addColumn([
            'name'  => 'agent_user_id',
            'label' => "Agent",
            'type'          => 'model_function',
			'function_name' => 'AgentName',
        ]);

        $this->xPanel->addColumn([
            'name'  => 'type',
            'label' => "type",
        ]);
        $this->xPanel->addColumn([
            'name'  => 'amount',
            'label' => "Amount",
        ]);

        $this->xPanel->addColumn([
            'name'  => 'currency',
            'label' => "Currency",
        ]);

        $this->xPanel->addColumn([
            'name'  => 'description',
            'label' => "description",
        ]);
    }



    public function stripeConfig(){
        require_once('vendor/stripe/stripe-php/init.php');
        $stripe = new \Stripe\StripeClient(
            getenv("STRIPE_SECRET")
        );
        return $stripe;
    }

    public function agentPayout(){
        $agents = Agent::where('parent_id',0)->withCount([
            'commissions as totalEarn' => function($q){
                $q->select(\DB::raw("SUM(commision)"))->where('active',1);
            },
            'commissions as totalPaid' => function($q){
                $q->select(\DB::raw("SUM(commision)"))->where('status','paid')->where('active',1);
            }
        ])->get();
        return view('agent.agent-payout',compact('agents'));
    }

    public function subAgentPayout(){
        $agents = Agent::where('parent_id','!=',0)->withCount([
            'commissions as totalEarn' => function($q){
                $q->select(\DB::raw("SUM(commision)"))->where('active',1);
            },
            'commissions as totalPaid' => function($q){
                $q->select(\DB::raw("SUM(commision)"))->where('status','paid')->where('active',1);
            }
        ])->get();
        return view('agent.agent-payout',compact('agents'));
    }

    public function payoutForm($agentId){
        $agent = Agent::with(['user.stripeAcc','commissions' => function($q){
                    $q->where('status','pending')->where('commision','>',0)->where('active',1);
                }
            ]
        )->find($agentId);
        $stripe = $this->stripeConfig();
        $account = '';
        if($agent->user->StripeAcc){
            $account = $stripe->accounts->retrieve(
                $agent->user->StripeAcc->account_id,
                []
              );
        }

        return view('agent.payout-form',compact('agent','account'));
    }

    public function payoutFormSave($agentId,Request $request){
        // default_currency
        // dd($request->all());
        $request->validate([
            // 'stripeToken'       => 'required',
            'commissionItem'    => 'required',
            // 'currency'          => 'required',
        ]);

        $agent = Agent::find($agentId);
        if(!$agent){
            flash('Agent Not Found')->error();
            return redirect()->back()->withInput();
        }
        
        if(empty($request->commissionItem)){
            flash('Pleaes Select Commission Item')->error();
            return redirect()->back()->withInput();
        }
        
        // Session::flash('success', 'We need developed the payment system here...');
        // return redirect()->back();

        // try{
            $stripe = $this->stripeConfig();
            $amount = 0;

            foreach($request->commissionItem as $com){
                $commision = AgentCommision::find($com);
                $amount +=$commision->commision;
            }

            $total = (number_format($amount, 2, '.', '') * 100); //calculate as sent

            //finding account destination
            $account = $stripe->accounts->retrieve(
                $agent->user->StripeAcc->account_id,
                []
            );

            //create a charge
            $charge = $stripe->charges->create([
                'amount' => $total,
                'currency' => $account->default_currency,
                'source' => 'tok_amex',
                'description' => 'Payment for commission',
            ]);


            //create a transfer
            $transfer = $stripe->transfers->create([
                'amount' => $total,
                'currency' => $account->default_currency,
                'destination' => $account->id,
                'source_transaction' => $charge->id,
            ]);

            

            if ($transfer->id) {
                foreach($request->commissionItem as $com){
                    $commision = AgentCommision::find($com);
                    $commision->status = 'paid';
                    $commision->save();
                }
                
                $payment = [
                    'date'          => date('Y-m-d'),
                    'trans_id'      => $transfer->id,
                    'currency'      => $account->default_currency,
                    'agent_user_id' => $agent->own_user_id,
                    'type'          => $agent->user->roles[0]->name,
                    'amount'        => $amount,
                    'description'   => "{$agent->name} || {$amount} {$account->default_currency} has been transferd into {$account->id}",
                    'payment_json'  => json_encode($transfer),
                ];

                Payout::create($payment);

                flash("payment has been transfer success")->success();
			    return redirect()->back()->withInput();
            }else{
                flash("payment transfer not success")->error();
			    return redirect()->back()->withInput();
            }

        // }catch(\Exception $e){
        //     flash($e->getMessage())->error();
		// 	return redirect()->back()->withInput();
        //     // echo 'someging else';
        // }

       
        // dd($request->all());
    }
}
