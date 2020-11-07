<?php

namespace App\Http\Controllers\Admin;
use Larapen\Admin\app\Http\Controllers\PanelController;
use Illuminate\Http\Request;
use App\Models\StripeAccount;
use App\Models\Currency;
use Session;
class StripeAccountController extends PanelController
{
    // public $stripe;
    // public function __construct(){
    //     require_once('vendor/stripe/stripe-php/init.php');
    //     $stripe = new \Stripe\StripeClient(
    //         getenv("STRIPE_SECRET")
    //     );
    // }

    public function stripeConfig(){
        require_once('vendor/stripe/stripe-php/init.php');
        $stripe = new \Stripe\StripeClient(
            getenv("STRIPE_SECRET")
        );
        return $stripe;
    }
    //stripe account setup
    public function stripe(){
        // $currencies = Currency::all();
        $stripe = $this->stripeConfig();
        $account = '';
        if(auth()->user()->StripeAcc){
            // $account = auth()->user()->StripeAcc;
            $account = $stripe->accounts->retrieve(
                auth()->user()->StripeAcc->account_id,
                []
              );
        }
        // dd($account);
        if($account){
            return view('agent.stripe-setup-continue',compact('account'));
        }
        // dd($account->requirements->eventually_due);
        return view('agent.stripe-setup');
    }

    public function stripeSave(Request $request){
        $account = new StripeAccount;
        if(auth()->user()->StripeAcc){
            $account = auth()->user()->StripeAcc;
        }
        // StripeAccount::create([
            $account->user_id       = auth()->user()->id;
            $account->card_number   = $request->stripeCardNumber;
            $account->card_cvc      = $request->stripeCardCVC;
            $account->card_expiry   = $request->stripeCardExpiry;
            $account->currency      = $request->currency_code;
        // ]);
        $account->save();

        Session::flash('success', 'Stripe Account Added Successfully');

        return redirect('admin/agent-stripe');
    }

    public function stripeSetup(){
        $stripe = $this->stripeConfig();
        // dd($stripe);
          if(auth()->user()->StripeAcc){
            $account = $stripe->accounts->retrieve(
                auth()->user()->StripeAcc->account_id,
                []
              );
          }else{
            $account = $stripe->accounts->create([
                'type' => 'standard',
            ]);
            StripeAccount::create([
                'user_id'       => auth()->user()->id,
                'account_id'    => $account->id
            ]);
          }


        $link = $stripe->accountLinks->create([
            'account' => $account->id,
            'refresh_url' => admin_url('agent-stripe'),
            'return_url' => admin_url('agent-stripe'),
            'type' => 'account_onboarding'
        ]);

        return redirect($link->url);
    
        // echo 'asdf';
    }
}
