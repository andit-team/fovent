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
<div class="row">
    <div class="col-sm-12">
        <div class="card rounded">
					
            <div class="card-header with-border">
                {{-- <a href="https://localhost/fovent/admin/agent/create" class="btn btn-primary shadow ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fas fa-plus"></i> Add Agent</span></a> --}}
                <div id="datatable_button_stack" class="pull-right text-right"></div>
            </div>

        <div class="card-body">
						
            <form id="postForm" method="post" action="{{url('admin/agent-stripe')}}">
                @csrf
                <div class="payment-plugin" id="stripePayment" style="display: none;">
                    <div class="col-md-12 col-sm-12 box-center center mt-4 mb-0">
                        <div class="row">
                            
                            <div class="col-xl-12 text-center">
                                <img class="img-fluid" src="{{ url('images/stripe/payment.png') }}" title="{{ trans('stripe::messages.Payment with Stripe') }}">
                            </div>
                    
                            <div class="col-xl-12 mt-3">
                                <!-- CREDIT CARD FORM STARTS HERE -->
                                <div class="card card-default credit-card-box">
                                
                                    <div class="card-header">
                                        <h3 class="panel-title">
                                            {{ trans('stripe::messages.Payment Details') }}
                                        </h3>
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="stripeCardNumber">{{ trans('stripe::messages.Card Number') }}</label>
                                                    <div class="input-group">
                                                        <input
                                                                type="tel"
                                                                class="form-control"
                                                                name="stripeCardNumber"
                                                                placeholder="{{ trans('stripe::messages.Valid Card Number') }}"
                                                                autocomplete="cc-number"
                                                                required
                                                                value="{{$account ? $account->card_number : ''}}"
                                                        />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="stripeCardExpiry">{!! trans('stripe::messages.Expiration Date') !!}</label>
                                                            <input
                                                                    type="tel"
                                                                    class="form-control"
                                                                    name="stripeCardExpiry"
                                                                    placeholder="{{ trans('stripe::messages.MM / YY') }}"
                                                                    autocomplete="cc-exp"
                                                                    required
                                                                    value="{{$account ? $account->card_expiry : ''}}"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pull-right">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="stripeCardCVC">{{ trans('stripe::messages.CV Code') }}</label>
                                                            <input
                                                                    type="tel"
                                                                    class="form-control"
                                                                    name="stripeCardCVC"
                                                                    placeholder="{{ trans('stripe::messages.CVC') }}"
                                                                    autocomplete="cc-csc"
                                                                    required
                                                                    value="{{$account ? $account->card_cvc : ''}}"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="stripePaymentErrors" style="display:none;">
                                                <div class="col-xs-12">
                                                    <p class="payment-errors"></p>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Currency</label>
                                                <select name="currency_code" style="width: 100%" class="form-control select2_field " tabindex="-1" aria-hidden="true" required>

                                                    <option value="">Select Currency</option>
                                                    @foreach($currencies as $currency)
                                                        <option value="{{$currency->code}}" {{$account ? $account->currency == $currency->code ?'selected':'' : ''}}>{{$currency->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            
                                </div>
                            </div> 
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right" id="submitPostForm">Save</button>
                </div>                
            </form>
        
        </div>
        </div>
</div>
</div>
@section('after_styles')
{{-- <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/> --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
    label#stripeCardNumber-error {
        color: red;
    }
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        height: 37px;
    }
</style>
@endsection



@section('after_scripts')
                    @parent
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
                    @if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js'))
                        <script src="{{ url('/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js') }}" type="text/javascript"></script>
                    @endif
                    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
                    {{-- <script src="{{ asset('assets/plugins/select2/js/select2.js') }}"></script> --}}
                    <script>
                        $(document).ready(function() {
                            $('.select2_field').select2();
                        });
                    </script>
                    <script>
                        $(document).ready(function ()
                        {
                            checkPaymentMethodForStripe('stripe', 100);
                    
                    
                            /* Fancy restrictive input formatting via jQuery.payment library */
                            $('input[name=stripeCardNumber]').payment('formatCardNumber');
                            $('input[name=stripeCardCVC]').payment('formatCardCVC');
                            $('input[name=stripeCardExpiry]').payment('formatCardExpiry');
                            
                            
                            /* Send Payment Request */
                            $('#submitPostForm').on('click', function (e)
                            {
                                e.preventDefault();
                                
                                paymentMethod = 'stripe';//$('#paymentMethodId').find('option:selected').data('name');
                                
                                if (paymentMethod != 'stripe') {
                                    return false;
                                }
                                
                                if (!ccFormValidationForStripe()) {
                                    return false;
                                }
                    
                                /* Call the token request function */
                                payWithStripe();
                    
                                /* Prevent form from submitting */
                                return false;
                            });
                        });
                        
                
                        /* Check the Payment Method */
                        function checkPaymentMethodForStripe(paymentMethod, packagePrice)
                        {
                            var $form = $('#postForm');
                            
                            $form.find('#submitPostForm').html('{{ t('submit') }}').prop('disabled', false);
                    
                            /* Hide errors on the form */
                            $form.find('#stripePaymentErrors').hide();
                            $form.find('#stripePaymentErrors').find('.payment-errors').text('');
                    
                            if (paymentMethod == 'stripe' && packagePrice > 0) {
                                $('#stripePayment').show();
                            } else {
                                $('#stripePayment').hide();
                            }
                        }
                
                        /* Pay with the Payment Method */
                        function payWithStripe()
                        {
                            var $form = $('#postForm');
                            
                            /* Visual feedback */
                            $form.find('#submitPostForm').html('{{ trans('stripe::messages.Validating') }} <i class="fa fa-spinner fa-pulse"></i>').prop('disabled', true);
                    
                            var PublishableKey = '{!! config('payment.stripe.key') !!}'; /* Replace with your API publishable key */
                            Stripe.setPublishableKey(PublishableKey);
                    
                            /* Create token */
                            var expiry = $form.find('[name=stripeCardExpiry]').payment('cardExpiryVal');
                            var ccData = {
                                number: $form.find('[name=stripeCardNumber]').val().replace(/\s/g,''),
                                cvc: $form.find('[name=stripeCardCVC]').val(),
                                exp_month: expiry.month,
                                exp_year: expiry.year
                            };
                            Stripe.card.createToken(ccData, function stripeResponseHandler(status, response)
                            {
                                if (response.error)
                                {
                                    /* Visual feedback */
                                    $form.find('#submitPostForm').html('{{ trans('stripe::messages.Try again') }}').prop('disabled', false);
                                    
                                    /* Show errors on the form */
                                    $form.find('#stripePaymentErrors').find('.payment-errors').text(response.error.message);
                                    $form.find('#stripePaymentErrors').show();
                                }
                                else
                                {
                                    /* Visual feedback */
                                    $form.find('#submitPostForm').html('{{ trans('stripe::messages.Processing') }} <i class="fa fa-spinner fa-pulse"></i>');
                                    
                                    /* Hide Stripe errors on the form */
                                    $form.find('#stripePaymentErrors').hide();
                                    $form.find('#stripePaymentErrors').find('.payment-errors').text('');
                                    
                                    /* Response contains id and card, which contains additional card details */
                                    // console.log(response.id);
                                    // console.log(response.card);
                                    var stripeToken = response.id;
                                
                                    /* Insert the token into the form so it gets submitted to the server */
                                    $form.append($('<input type="hidden" name="stripeToken" />').val(stripeToken));
                                    
                                    /* and submit */
                                    $form.submit();
                                }
                            });
                        }
                
                        function ccFormValidationForStripe()
                        {
                            var $form = $('#postForm');
                    
                            /* Form validation using Stripe client-side validation helpers */
                            jQuery.validator.addMethod('stripeCardNumber', function(value, element) {
                                return this.optional(element) || Stripe.card.validateCardNumber(value);
                            }, "{{ trans('stripe::messages.Please specify a valid credit card number') }}");
                    
                            jQuery.validator.addMethod('stripeCardExpiry', function(value, element) {
                                /* Parsing month/year uses jQuery.payment library */
                                value = $.payment.cardExpiryVal(value);
                                return this.optional(element) || Stripe.card.validateExpiry(value.month, value.year);
                            }, "{{ trans('stripe::messages.Invalid expiration date') }}");
                    
                            jQuery.validator.addMethod('stripeCardCVC', function(value, element) {
                                return this.optional(element) || Stripe.card.validateCVC(value);
                            }, "{{ trans('stripe::messages.Invalid CVC') }}");
                    
                            var validator = $form.validate({
                                rules: {
                                    stripeCardNumber: {
                                        required: true,
                                        stripeCardNumber: true
                                    },
                                    stripeCardExpiry: {
                                        required: true,
                                        stripeCardExpiry: true
                                    },
                                    stripeCardCVC: {
                                        required: true,
                                        stripeCardCVC: true
                                    }
                                },
                                highlight: function(element) {
                                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                                },
                                unhighlight: function(element) {
                                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                                },
                                errorPlacement: function(error, element) {
                                    $(element).closest('.form-group').append(error);
                                }
                            });
                    
                            paymentFormReady = function() {
                                if ($form.find('[name=stripeCardNumber]').closest('.form-group').hasClass('has-success') &&
                                    $form.find('[name=stripeCardExpiry]').closest('.form-group').hasClass('has-success') &&
                                    $form.find('[name=stripeCardCVC]').val().length > 1) {
                                    return true;
                                } else {
                                    return false;
                                }
                            };
                    
                            $form.find('#submitPostForm').prop('disabled', true);
                            var readyInterval = setInterval(function() {
                                if (paymentFormReady()) {
                                    $form.find('#submitPostForm').prop('disabled', false);
                                    clearInterval(readyInterval);
                                }
                            }, 250);
                    
                            /* Abort if invalid form data */
                            if (!validator.form()) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                        
                    </script>
                @endsection

@endsection









