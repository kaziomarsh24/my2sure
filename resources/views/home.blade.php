@extends('client.layout')

@section('content')

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

        .btn-vip {
            background: linear-gradient(45deg, #BF953F, #FCF6BA, #B38728, #FBF5B7, #AA771C);
            color: #000000 !important;
            border: 1px solid #AA771C !important;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-vip:hover {
            background: linear-gradient(45deg, #AA771C, #FBF5B7, #B38728, #FCF6BA, #BF953F);
            box-shadow: 0px 6px 20px rgba(191, 149, 63, 0.4);
            transform: translateY(-2px);
            color: #000000 !important;
        }
    </style>

    <section class="affiliate-section section-padding has_bg_image" data-background="{{asset('assets/images/bg-three.jpg')}}">
        <input class="w3-input w3-border" value="{{$settings->firstWhere('name', 'sub_price')->detail}}" name="amount" type="hidden">
        <input class="w3-input w3-border" value="{{$settings->firstWhere('name', 'sub_name')->detail}}" name="iName" type="hidden">
        <input class="w3-input w3-border" value="{{$settings->firstWhere('name', 'sub_details')->detail}}" name="iDetails" type="hidden">

        <div class="container">
            <div class="row mb-5">
                <div class="col-md-6 mx-auto">
                    <div class="section-header text-center">

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(Auth::user())
                            <p class="" style="font-size: 20px; padding: 0px">
                                Hi <span style="font-weight: bold">{{Auth::user()->name}}</span>,
                                Welcome to <a class="" href="https://my2sure.com/">My2sure.com</a>
                            </p>
                            <p style="font-size: 20px; padding: 0px">The Best Lottery Forecaster In Africa.</p>
                        @endif

                        <div class="mx-auto col-md-8 text-center">
                            @if(Auth()->user()->type == "user")

                                {{-- VIP Room --}}
                                <div>
                                    <a type="button" style="width: 100%"
                                       class="btn btn-lg my-2 btn-vip"
                                       href="{{route('client.vip.gate')}}">
                                         {{$settings->firstWhere('name', 'vip_button_label')->detail ?? 'VIP Room'}}
                                    </a>
                                </div>

                                {{-- All Games --}}
                                <div>
                                    <a type="button" style="width: 100%"
                                       class="btn btn-lg my-2"
                                       href="{{route('client.games.index')}}">
                                        All Games (Free)
                                    </a>
                                </div>

                                {{-- 2Sure Competition --}}
                                <div>
                                    <a type="button" style="width: 100%"
                                       class="btn btn-lg my-2"
                                       href="{{route('client.twosure.gate')}}">
                                        My2Sure Competition
                                    </a>
                                </div>

                                {{-- Shop --}}
                                <div>
                                    <a type="button" style="width: 100%"
                                       class="btn btn-lg my-2"
                                       href="{{!empty($settings->firstWhere('name', 'shop_button_link')->detail) ? $settings->firstWhere('name', 'shop_button_link')->detail : route('client.shop')}}">
                                        {{$settings->firstWhere('name', 'shop_button_label')->detail ?? 'Shop'}}
                                    </a>
                                </div>

                                {{-- Music --}}
                                @if(!empty($settings->firstWhere('name', 'music_button_link')->detail))
                                    <div>
                                        <a type="button" style="width: 100%"
                                           class="btn btn-lg my-2"
                                           href="{{$settings->firstWhere('name', 'music_button_link')->detail}}">
                                            {{$settings->firstWhere('name', 'music_button_label')->detail ?? 'Music'}}
                                        </a>
                                    </div>
                                @endif

                                {{-- Winning Results --}}
                                <div>
                                    <a type="button" style="width: 100%"
                                       class="btn btn-lg my-2"
                                       href="{{!empty($settings->firstWhere('name', 'results_button_link')->detail) ? $settings->firstWhere('name', 'results_button_link')->detail : route('client.results')}}">
                                        {{$settings->firstWhere('name', 'results_button_label')->detail ?? 'Winning Results'}}
                                    </a>
                                </div>

                                {{-- Orders --}}
                                <div>
                                    <a type="button" style="width: 100%"
                                       class="btn btn-lg my-2"
                                       href="{{route('client.my_orders')}}">
                                        Orders
                                    </a>
                                </div>

                                {{-- Referrals --}}
                                <div>
                                    <a type="button" style="width: 100%"
                                       class="btn btn-lg my-2"
                                       href="{{route('client.referralpage')}}">
                                        Referrals &amp; Bank Account
                                    </a>
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Sponsor Modal --}}
    <div id="sponsorModalOverlay" style="
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    z-index: 9999;
    justify-content: center;
    align-items: center;
">
        <div style="
        background: #fff;
        border-radius: 16px;
        padding: 36px;
        max-width: 420px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        position: relative;
        animation: modalIn 0.3s ease;
        text-align: center;
    ">
            <button onclick="closeSponsorModal()" style="
            position: absolute;
            top: 16px; right: 20px;
            font-size: 22px;
            cursor: pointer;
            color: #aaa;
            background: none;
            border: none;
            line-height: 1;
        ">&times;</button>

            <div id="sponsorForm">
                <div style="font-size: 48px; margin-bottom: 10px;">❤️</div>
                <h3 style="font-size: 22px; font-weight: 800; color: #1a1a2e; margin-bottom: 8px;">Support My2Sure</h3>
                <p style="font-size: 14px; color: #888; margin-bottom: 24px;">
                    Your support helps us keep improving. Enter any amount you'd like to contribute and pay in your local currency.
                </p>
                <div style="margin-bottom: 20px; text-align: left;">
                    <label style="font-size: 12px; font-weight: 600; color: #666; letter-spacing: 1px; text-transform: uppercase; display: block; margin-bottom: 6px;">
                        Amount (USD)
                    </label>
                    <input type="number"
                           id="sponsorAmount"
                           min="1"
                           placeholder="Enter amount"
                           style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 16px; outline: none; box-sizing: border-box;">
                    <p id="sponsorAmountError" style="color: #e74c3c; font-size: 12px; margin-top: 4px; display: none;">
                        Please enter a valid amount.
                    </p>
                </div>
                <button onclick="initiateSponsorPayment()"
                        id="sponsorPayBtn"
                        style="width: 100%; background: #e74c3c; color: #fff; border: none; border-radius: 10px; padding: 14px; font-size: 16px; font-weight: 700; cursor: pointer;">
                    Pay Now ❤️
                </button>
                <p style="font-size: 12px; color: #bbb; margin-top: 12px;">
                    <i class="fa fa-shield"></i> Secured by Flutterwave
                </p>
            </div>

            <div id="sponsorThankYou" style="display: none;">
                <div style="font-size: 64px; margin-bottom: 16px;">🎉</div>
                <h3 style="font-size: 24px; font-weight: 800; color: #1a1a2e; margin-bottom: 12px;">Thank You!</h3>
                <p style="font-size: 15px; color: #666; line-height: 1.7;">
                    Your generous support means the world to us.<br>
                    We truly appreciate your contribution to My2Sure!
                </p>
                <button onclick="closeSponsorModal()" style="margin-top: 20px; background: #34b5f7; color: #fff; border: none; border-radius: 10px; padding: 12px 30px; font-size: 15px; font-weight: 700; cursor: pointer;">
                    Close
                </button>
            </div>
        </div>
    </div>

    <style>
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(-30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        #sponsorModalOverlay.active { display: flex !important; }
        #sponsorAmount:focus { border-color: #e74c3c; box-shadow: 0 0 0 3px rgba(231,76,60,0.1); }
    </style>

@endsection

@push('scripts')
    <script src="https://checkout.flutterwave.com/v3.js"></script>
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

        function openSponsorModal() {
            document.getElementById('sponsorModalOverlay').classList.add('active');
            document.getElementById('sponsorForm').style.display = 'block';
            document.getElementById('sponsorThankYou').style.display = 'none';
            document.getElementById('sponsorAmount').value = '';
            document.getElementById('sponsorAmountError').style.display = 'none';
            document.getElementById('sponsorPayBtn').disabled = false;
            document.getElementById('sponsorPayBtn').textContent = 'Pay Now ❤️';
        }

        function closeSponsorModal() {
            document.getElementById('sponsorModalOverlay').classList.remove('active');
        }

        document.getElementById('sponsorModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeSponsorModal();
        });

        function initiateSponsorPayment() {
            let amount = parseFloat(document.getElementById('sponsorAmount').value);

            if (!amount || amount <= 0) {
                document.getElementById('sponsorAmountError').style.display = 'block';
                return;
            }

            document.getElementById('sponsorAmountError').style.display = 'none';
            document.getElementById('sponsorPayBtn').disabled = true;
            document.getElementById('sponsorPayBtn').textContent = 'Opening payment...';

            fetch('{{ route("detect.country") }}')
                .then(res => res.json())
                .then(data => {
                    let currency  = data.currency;
                    let rate      = data.rate;
                    let newamount = parseFloat((amount * rate).toFixed(2));
                    openSponsorCheckout(newamount, currency);
                })
                .catch(() => {
                    openSponsorCheckout(amount, 'USD');
                });
        }

        function openSponsorCheckout(amount, currency) {
            FlutterwaveCheckout({
                public_key: "{{ config('services.flutterwave.public_key') }}",
                tx_ref:     "sponsor-" + Date.now(),
                amount:     amount,
                currency:   currency,
                customer: {
                    email: "{{ Auth::user()->email }}",
                    name:  "{{ Auth::user()->name }}",
                },
                customizations: {
                    title:       "Sponsor My2Sure",
                    description: "Support My2Sure Platform",
                    logo:        "{{ asset('assets/images/logo.png') }}",
                },
                callback: function(response) {
                    if (response.status === "successful" || response.status === "completed") {
                        document.getElementById('sponsorForm').style.display = 'none';
                        document.getElementById('sponsorThankYou').style.display = 'block';
                    } else {
                        alert('Payment was not completed. Please try again.');
                        document.getElementById('sponsorPayBtn').disabled = false;
                        document.getElementById('sponsorPayBtn').textContent = 'Pay Now ❤️';
                    }
                },
                onclose: function() {
                    document.getElementById('sponsorPayBtn').disabled = false;
                    document.getElementById('sponsorPayBtn').textContent = 'Pay Now ❤️';
                }
            });
        }
    </script>
@endpush
