<?php

namespace App\Http\Controllers\Admin;
use Larapen\Admin\app\Http\Controllers\PanelController;
use Illuminate\Http\Request;
use App\Models\StripeAccount;
use App\Models\Currency;
use Session;
class StripeAccountController extends PanelController
{
    //stripe account setup
    public function stripe(){
        $currencies = Currency::all();
        $account = '';
        if(auth()->user()->StripeAcc){
            $account = auth()->user()->StripeAcc;
        }
        return view('agent.stripe-setup',compact('account','currencies'));
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
}
