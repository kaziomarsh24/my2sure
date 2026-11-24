@extends('client.layout')

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
   </style>

  <!-- affiliate-section start -->
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
          <div class="col-lg-8">
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
        </div>

        <div class="row m-bottom-not-30 ">
          <div class="col-md-4 text-center mx-auto ">

              <button class="btn btn-lg btn-success cBtn" id="paypal_btn">SUBSCRIBE NOW </button>


                  <div id="paypal-button-container" style="display: none"></div>
                  <div id="wating" style="display: none;">
                      <div class="spinner-border text-primary" role="status">
                      </div>
                      <span class="">Please wait...</span>
                  </div>


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
<script type="text/javascript">
  function payMe(type)
  {
    if(type == "paypal")
    {
      urlToAction = "{{route('client.payWithPaypal')}}"
      $("#payment-form").attr('action',urlToAction);
    }else
    {
      urlToAction = "{{route('client.payWithCard')}}"
      $("#payment-form").attr('action',urlToAction);
    }

    $("#payment-form").submit();
  }
</script>
<script>
    var clock = $('.clock').FlipClock(99000 * 24 * 3, {
      clockFace: 'DailyCounter',
      countdown: true
    });
      jQuery(document).ready(function() {
        jQuery('#vmap').vectorMap({
          map: 'world_en',
          color: '#eaedef',
          backgroundColor: '#f7fcff',
          hoverOpacity: 0.8,
          selectedColor: '#eaedef',
          scaleColors: ['#f7fcff', '#f7fcff'],
          normalizeFunction: 'polynomial'
        });
      });
    </script>

    <script>


        let amount=`{{$settings->firstWhere('name', 'sub_price')->detail}}`;


        $('#paypal_btn').click(function(e){

            e.preventDefault();


            $("#paypal_btn").hide();


            $("#paypal-button-container").show();



            paypal.Buttons({
                createOrder: function (data, actions) {
                    // This function sets up the details of the transaction, including the amount and line item details.
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: amount,
                            }
                        }]
                    });
                },
                onApprove: function (data, actions) {

                    // This function captures the funds from the transaction.
                    return actions.order.capture().then(function (details) {

                        // This function shows a transaction success message to your buyer.
                        var pay_amount = details.purchase_units[0].amount.value;
                        var status = details.status;
                        var ctime = details.update_time;
                        var tranid = details.id;

                        if(details.status=="COMPLETED"){
                            // after payment confirmation

                            // $.ajaxSetup({
                            //     headers: {
                            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            //     }
                            // });

                            $("#paypal-button-container").hide();
                            $("#wating").show();
                            //this ajax call for place order


                            $.post('{{ route("client.paymentStatus") }}', {
                                '_token': $('meta[name=csrf-token]').attr('content'),

                                'payment_id': details.id,
                                'amount': amount,
                                'status': 'true',


                            }).done(function (data) {

                                alert("Your Subscription save successfully");
                                window.location.href = '{{route("home")}}';

                                $("#wating").hide();

                            });


                        }else{

                            alert("Your Subscription in not completed")

                        }
                    });//capture

                }//onApprove
            }).render('#paypal-button-container');

        });//paypal button click
    </script>

@endpush
