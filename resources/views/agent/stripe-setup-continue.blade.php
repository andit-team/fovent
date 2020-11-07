@extends('admin::layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-6 col-12 align-self-center">
        <h3 class="mb-0">
            <span class="text-capitalize">Agent</span>
            <small><span>Stripe</span></small>
        </h3>
    </div>
    <div class="col-md-6 col-12 align-self-center d-none d-md-block">
        <ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
            <li class="breadcrumb-item"><a href="{{admin_url('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{admin_url('agent-stripe')}}" class="text-capitalize">Stripe</a></li>
        </ol>
    </div>
</div>

@if($account->details_submitted == false)
<div class="jumbotron text-center">
    <h1>Fovent care for your earth and your food</h1>
  <h3>  Hi Dear, {{Auth::user()->name}} !</h3>
    <h4 class ="p-2">Please continue the setup process</h4>
    <br>
    <br>
    <br>
    <br>
    <br>
    <a class="btn btn-large btn-primary creatLink" target="_blank" href="{{admin_url('setup-stripe')}}">Click to Continue</a>
    <p class="p-4">A Standard Stripe account is a conventional Stripe account controlled directly by the account holder (i.e., your platform’s user). A user with a Standard account has a relationship with Stripe, is able to log in to the Dashboard, can process charges on their own, and can disconnect their account from your platform. For more details <a href="https://stripe.com/docs/connect/standard-accounts">Click Here</a></p>

    <div class="mt-3 text-left" >
        <h3>Some essential information still needed</h3>
        <ul>
            @foreach($account->requirements->eventually_due as $item)
            <li>{{$item}}</li>
            @endforeach
        </ul>
    </div>
</div>
@else
<div class="jumbotron text-center">
    <h1>Fovent care for your earth and your food</h1>
  <h3>  Hi Dear, {{Auth::user()->name}} !</h3>
    <h4 class ="p-2">Your Stripe setup has been done</h4> 
    <br>
    <br>
    <br>
    <br>
    <br>
    <a class="btn btn-large btn-primary" href="{{admin_url('dashboard')}}">Dashboard</a>
    <p class="p-4">Account Id : {{$account->id}}</p>
</div>
@endif

  

@endsection
