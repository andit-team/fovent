<?php

namespace App\Http\Controllers\Admin;
use Larapen\Admin\app\Http\Controllers\PanelController;

use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\AgentCommision;
use App\Helpers\Number;
use Omnipay\Omnipay;
// use Stripe;
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

        $this->xPanel->addColumn([
            'name'  => 'date',
            'label' => "Date",
        ]);
        $this->xPanel->addColumn([
            'name'  => 'agent_user_id',
            'label' => "Agent",
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
            'name'  => 'description',
            'label' => "description",
        ]);
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
        return view('agent.payout-form',compact('agent'));
    }

    public function payoutFormSave($agentId,Request $request){
        // dd($request->all());
        $request->validate([
            'stripeToken'       => 'required',
            'commissionItem'    => 'required',
            'currency'          => 'required',
        ]);

        $agent = Agent::find($agentId);
        if(!$agent){
            return redirect()->back();
        }
        
        if(empty($request->commissionItem)){
            return redirect()->back();
        }
        
        Session::flash('success', 'We need developed the payment system here...');
        return redirect()->back();

        try{
            $total = 0;

            foreach($request->commissionItem as $com){
                $commision = AgentCommision::find($com);
                $total +=$commission->commision;
            }


            //Payment issue
            // $providerParams = [
            //     'amount' => 100,
            //     'currency' => 'BDT',
            //     'destination' => 'acct_1HbhPsFFZ360zdyZ',
            //     'transfer_group' => 'ORDER_95',
            // ];
            // $gateway = Omnipay::create('Stripe');
            // $gateway->setApiKey(config('payment.stripe.secret'));
            // $response = $gateway->transfer($providerParams)->send();

			
			// // Get raw data
			// $rawData = $response->getData();
            // dd($rawData);
            
            // // Save the Transaction ID at the Provider
            
			// if (isset($rawData['id'])) {
			// 	echo $rawData['id'];
			// }
            
            // if ($response->isSuccessful()) {
            //     echo 'done';
            // }else{
            //     echo 'not done';
            // }

        }catch(\Exception $e){
            echo 'someging else';
        }

       
        // dd($request->all());
    }
}
