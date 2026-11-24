@extends('client.layout')
@section('title','Pay With Credit Card')
@section('content')

<!-- inner-page-banner start -->
<style type="text/css">
 .cBtn{
  color: #ffffff;
  font-size: 20px;
  font-family: "SegoeUI-Semibold";
  border: 2px solid;
  border-radius: 45px;
  padding: 9px 30px;
  display: inline-block;
  text-transform: capitalize;
  transition: all .3s;
  background-color: #34b5f7;
}
.hide{
  display: none;;
}
</style>

<!-- affiliate-section start -->
<form role="form" action="{{ route('stripe.post',['user'=>$objUser->id]) }}" method="post" class="require-validation"
                                                     data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                                    id="payment-form">
              {{ csrf_field() }}
<input class="w3-input w3-border" value="{{$settings->firstWhere('name', 'sub_price')->detail}}" name="amount" type="hidden">
<input class="w3-input w3-border" value="{{$settings->firstWhere('name', 'sub_name')->detail}}" name="iName" type="hidden">
<input class="w3-input w3-border" value="{{$settings->firstWhere('name', 'sub_details')->detail}} " name="iDetails" type="hidden">
@if(empty(Auth::user()) && empty($objUser))

@else
<input class="w3-input w3-border" value="{{(!empty(Auth::user())) ? Auth::user()->id : $objUser->id}} " name="user_id" type="hidden"></p>
@endif

  <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"  action="{{route('client.payWithPaypal')}}">
              {{ csrf_field() }}
    <section class="affiliate-section section-padding has_bg_image" data-background="{{asset('assets/images/bg-three.jpg')}}">
<input class="w3-input w3-border" value="{{$settings->firstWhere('name', 'sub_price')->detail}}" name="amount" type="hidden"></p>
<input class="w3-input w3-border" value="{{$settings->firstWhere('name', 'sub_name')->detail}}" name="iName" type="hidden"></p>
<input class="w3-input w3-border" value="{{$settings->firstWhere('name', 'sub_details')->detail}} " name="iDetails" type="hidden"></p>
@if(empty(Auth::user()) && empty($objUser))

@else
<input class="w3-input w3-border" value="{{(!empty(Auth::user())) ? Auth::user()->id : $objUser->id}} " name="user_id" type="hidden"></p>
@endif
      <div class="container">
        <div class="row justify-content-center">
              <div class="col-md-8">
                 <div class="section-header text-center">
                  <h2 class="section-title">{{$settings->firstWhere('name', 'sub_name')->detail}}</h2>
                  @if(!empty(Auth::user()))
                    @if(Auth::user()->expiry_date == null)
                      <p><b>{{Auth::user()->name}}</b> Your need to Complete the payment Process to activate your account and enjoy unlimited Forecasters </p>
                    @else
                      <p> <b>{{Auth::user()->name}}</b> Your Current Subscription is Expired  at {{Auth::user()->expiry_date }} please Renew </p>
                    @endif
                  @elseif(!empty($objUser))
                      <p><b>{{$objUser->name}}</b> Your need to Complete the payment Process to activate your account and enjoy unlimited Forecasters </p>
                  @endif
                  <p>{{$settings->firstWhere('name', 'sub_details')->detail}}</p>
                </div>
              </div>
          <div class="col-lg-8">

              <!-- FORM BOX -->
              <div class="box box-solid  ">
                <div class="box-header with-border"  >
                  <b class="box-title">Pay  With Credit Card  / Payment Information</b>
                </div>
                <!-- /.box-header -->
                <div class="box-body wizard-content">
                  <div class=" row">
                    @if (Session::has('success'))
                          <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
                     @if (Session::has('error'))
                        <div class="alert alert-danger text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('error') }}</p>
                        </div>
                    @endif
                    <div class="form-group col-md-12 text-left required">
                     <label class='control-label'>Name on Card</label>
                     <input class='form-control card-name' size='4' type='text'  placeholder='Your Name'>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group col-md-12 text-left required">
                      <label class='control-label'>Card Number</label>
                      <input autocomplete='off' class='form-control card-number'  placeholder='4121 1212...' size='20' type='text' value="">
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group col-md-4 text-left required">
                      <label class='control-label'>CVC</label>
                      <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' value="">
                    </div>

                     <div class="form-group col-md-4 text-left required">
                      <label class='control-label'>Expiration Month</label>
                      <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text' value="">
                    </div>


                     <div class="form-group col-md-4 text-left required">
                      <label class='control-label'>Expiration Year</label>
                      <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' value="">
                    </div>

                    <div class='form-row col-md-12'>

                            <div class="alert alert-danger  error text-center hide col-md-12">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                              <p class=" alert-danger alert ">Please correct the errors and try again</p>
                          </div>
                        </div>


                      <div class="col-md-12">
                            <div class="table-responsive col-xs-12 col-md-12">
                              <table class="table">
                                    <thead>
                                        <th>Item</th>
                                        <th>Price</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left"><input type="radio" checked  >{{$settings->firstWhere('name', 'sub_name')->detail}}  Yearly Subscription</td>
                                            <td class="text-left">${{$settings->firstWhere('name', 'sub_price')->detail}}/Year</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                  </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- FORM BOX -->

          </div>
        </div>

        <div class="row m-bottom-not-30">
          <div class="col-md-12 text-center">
            @if(empty(Auth::user()) && empty($objUser))
              <button class="btn btn-success cBtn btn-lg btn-block" type="submit">Pay ${{$settings->firstWhere('name', 'sub_price')->detail}} & Get Started</button>

              <p>Please Pay the Annual Subscription and Complete your Registration </p>
            @else
              <button class="btn btn-success cBtn btn-lg btn-block" type="submit">Pay ${{$settings->firstWhere('name', 'sub_price')->detail}} & Get Started</button>
              <p>Please Pay the Annual Subscription and Complete your Registration </p>
            @endif

            <div class="col-md-12 text-center">
              <div class="pricing-accept-top"> <img class="accept-img" src="https://www.instantscripts.com/hosted/images/bf/d40d3899ca4d8c8d6fad8f79317e69/202020418_Payment_Options_CZ_v1.png" alt="" /></div>
            </div>
            <br/>
          </div>

            <div class="d-none" style="display: none">
          <div class="col-lg-3 col-sm-6">
            <div class="affiliate-item text-center">
              <div class="icon">
                <div class="icon-inner">
                  <img src="assets/images/svg-icons/affiliate-icons/1.svg" alt="icon">
                </div>
              </div>
              <div class="content">
                <h4 class="title">High Revenues</h4>
                <p>Your Chances of winning is 90% higher with our Lottery Forecaster.</p>
              </div>
            </div>
          </div><!-- affiliate-item end -->
          <div class="col-lg-3 col-sm-6">
            <div class="affiliate-item text-center">
              <div class="icon">
                <div class="icon-inner">
                  <img src="assets/images/svg-icons/affiliate-icons/4.svg" alt="icon">
                </div>
              </div>
              <div class="content">
                <h4 class="title">Number Generators</h4>
                <p>We offer the best Lucky numbers in the market and provide proven for different Games.</p>
              </div>
            </div>
          </div><!-- affiliate-item end -->
          <div class="col-lg-3 col-sm-6">
            <div class="affiliate-item text-center">
              <div class="icon">
                <div class="icon-inner">
                  <img src="assets/images/svg-icons/affiliate-icons/2.svg" alt="icon">
                </div>
              </div>
              <div class="content">
                <h4 class="title">Unlimited Forecasters</h4>
                <p>Thee is no limit  using our lottery Forecasters .Access to All forecasters in a second.</p>
              </div>
            </div>
          </div><!-- affiliate-item end -->
          <div class="col-lg-3 col-sm-6">
            <div class="affiliate-item text-center">
              <div class="icon">
                <div class="icon-inner">
                  <img src="assets/images/svg-icons/affiliate-icons/3.svg" alt="icon">
                </div>
              </div>
              <div class="content">
                <h4 class="title">Dedicated Support</h4>
                <p>Our dedicated technical support team works with you to understand and identify</p>
              </div>
            </div>
          </div><!-- affiliate-item end -->
            </div>
        </div>
      </div>
    </section>
  </form>
    <!-- affiliate-section end -->


@endsection

@push('scripts')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
$(function() {
    var $form         = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');

        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
      }
    });
    if( $('.card-name').val() == ''  )
    {
      alert('Please add Card Name');return(false);
    }else if(   $('.card-phone').val() == '')
    {
      alert('Dont miss out to fill the Phone Number go back and fill the required Phone number');return(false);
    }
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        name:             $('.card-name').val(),
        address_line1:    $('.card-address').val(),
        address_city:     $('.card-city').val(),
        address_state:    $('.card-state').val(),
        address_country:  $('.card-country').val(),
        customer:         $('.card-email').val(),
        number:           $('.card-number').val(),
        cvc:              $('.card-cvc').val(),
        exp_month:        $('.card-expiry-month').val(),
        exp_year:         $('.card-expiry-year').val()
      }, stripeResponseHandler);

      $(".cBtn").addClass('disabled');
    }

  });

  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }

});
</script>
@endpush
