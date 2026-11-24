@extends('client.layout')

@section('content')

    <!-- inner-page-banner start -->
    <style type="text/css">
        .btn{
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
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-header text-center">
                            {{--              <h2 class="section-title">{{$status}}</h2>--}}
                            {{--              <p>{!! $msg  !!}</p>--}}
                            <h4 class="section-title">{{Auth::user()->name}} Logged in</h4>
                            @if(Auth::user()->expiry_date == null)
                                <p>Welcome   {{Auth::user()->name}} . Your Dont have Any Subscription Yet Please Purchase a Subscription for Accessing all Lotery Forecasters <br/>
                                    <a class="btn btn-lg btn-success cBtn" href="{{route('client.payWithPaypal')}}"><i class="fa fa-paypal"></i> Purchase  {{$settings->firstWhere('name', 'sub_name')->detail}} For ${{$settings->firstWhere('name', 'sub_price')->detail}} </a>
                                </p>

                            @elseif(Auth::user()->expiry_date < date('Y-m-d'))

                                <p>Welcome Back {{Auth::user()->name}} . Your Current Subscription Expired on {{Auth::user()->expiry_date}} <br/>   You cannot Purchase Until Your Previous Subscription Expires <br/> After Expire You can Renew it</p>
                                <p><a class="btn btn-lg btn-success cBtn" href="{{route('client.payWithPaypal')}}"><i class="fa fa-paypal"></i> Renew Your Subscription At ${{$settings->firstWhere("name", "sub_price")->detail}} </a></p>

                            @else
                                <p>Welcome Back {{Auth::user()->name}} . Your Current Subscription Expires on {{Auth::user()->expiry_date}} <br/> You have Access of all Lottery Forecasters Enjoy unlimited Numbers of Forecasters and Get Lucky</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </form>
    <!-- affiliate-section end -->


@endsection

@push('scripts')
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
@endpush
