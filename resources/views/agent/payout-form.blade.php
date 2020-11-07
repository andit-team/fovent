@extends('admin::layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-6 col-12 align-self-center">
        <h3 class="mb-0">
            <span class="text-capitalize">Agent</span>
            <small>All  <span>Agent</span> in the database.</small>
        </h3>
    </div>
    <div class="col-md-6 col-12 align-self-center d-none d-md-block">
        <ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
            <li class="breadcrumb-item"><a href="https://localhost/fovent/admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="https://localhost/fovent/admin/agent" class="text-capitalize">Agent</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>
@include('post.inc.notification')
<div class="row">
    <div class="col-sm-4">
        <div class="card rounded">
            <div class="card-header">
                <h3>Agent Information</h3>
            </div>  
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th width="150">Name</th>
                        <td width="5">:</td>
                        <td>{{$agent->name}}</td>
                    </tr>
                    <tr>
                        <th width="150">Registered On</th>
                        <td width="5">:</td>
                        <td>{{date('d F Y',strtotime($agent->created_at))}} / {{date('h:i a',strtotime($agent->created_at))}}</td>
                    </tr>
                    <tr>
                        <th width="150">Email</th>
                        <td width="5">:</td>
                        <td>{{$agent->email}}</td>
                    </tr>
                    <tr>
                        <th width="150">Payout Email</th>
                        <td width="5">:</td>
                        <td>{{$agent->payout_email}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card rounded">
            <div class="card-header">
                <h3>Card Information</h3>
            </div>  
            <div class="card-body">
                @if($agent->user->stripeAcc)
                <table class="table table-striped">
                    <tr>
                        <th width="150">Stripe Account</th>
                        <td width="5">:</td>
                        <td>{{$agent->user->stripeAcc->account_id}}</td>
                    </tr>
                </table>
                @else
                    <h4>No stripe account has been setup yet. You can't send money ... :(</h4>
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="card rounded">
            <div class="card-header">
                <h3>Payout Information</h3>
            </div>  
            <div class="card-body">
                <form action="{{admin_url('payout')}}/{{$agent->id}}" method="post" id="sendPayment">
                    @csrf
                    {{-- <input type="hidden" name="stripeToken" id="stripeToken" value=""> --}}
                    <input type="hidden" name="currency" id="currency" value="">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll" data-amount="0" class="itemChk form-conrtol"></th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Commission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agent->commissions as $com)
                                <tr>
                                    <td><input type="checkbox" class="itemChk form-conrtol" name="commissionItem[]" value="{{$com->id}}" data-amount="{{$com->commision}}"></td>
                                    <td>{{date('d F Y',strtotime($com->created_at))}} / {{date('h:i a',strtotime($com->created_at))}}</td>
                                    <td>{{$com->description}}</td>
                                    <td>{{$com->commision}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-right pt-3">Total</td>
                                <td><input id="totalAmount" type="number" readonly value="0.00"></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="card-footer">
                {{-- @if($agent->user->stripeAcc) --}}
                    <button class="btn btn-primary
                        {{$account && $account->details_submitted ? '' : 'disabled pointNone'}}
                    " id="submitForm">Click to Pay</button>
                {{--@else 
                     <button class="btn btn-primary disabled" title="First add to payment card">Click to Pay</button> --}}
                {{-- @endif --}}
            </div>   
        </div>
    </div>
</div>

@section('after_styles')
<style>
    .pointNone {
        pointer-events: none;
    }
</style>
@endsection


@section('after_scripts')
{{-- <script type="text/javascript" src="https://js.stripe.com/v2/"></script> --}}
    <script>
        $(document).ready(function() {
            $("#checkAll").click(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $('.itemChk').on('change',function(){
                var total = 0;
                $('input[type="checkbox"]').each(function(){
                    if($(this).is(":checked")){
                        total = total + parseFloat($(this).data('amount'))||0;
                    }
                });
                $('#totalAmount').val(parseFloat(total).toFixed(2));
            });
            // $('#submitForm').click(function(e){
            //     if(confirm("Are you sure?")){
            //         $('#sendPayment').submit();
            //     }
            // });
        });
        
  

            //submitForm
             @if($agent->user->stripeAcc)
                 $('#submitForm').click(function(e){
                     if(confirm("Are you sure?")){
                        $('#sendPayment').submit();
                     }else{
                         e.preventDefault();
                     }
                 });
             @endif
            </script>
 

@endsection

@endsection

