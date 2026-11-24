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
    .section-padding {
        padding-top: 0px !important;
    }
</style>

<section class="affiliate-section section-padding has_bg_image" data-background="{{asset('assets/images/bg-three.jpg')}}">
    {{-- Safely fetch settings with defaults to prevent 500 errors --}}
    <input class="w3-input w3-border" value="{{ $settings->firstWhere('name', 'sub_price')->detail ?? '' }}" name="amount" type="hidden">
    <input class="w3-input w3-border" value="{{ $settings->firstWhere('name', 'sub_name')->detail ?? '' }}" name="iName" type="hidden">
    <input class="w3-input w3-border" value="{{ $settings->firstWhere('name', 'sub_details')->detail ?? '' }}" name="iDetails" type="hidden">

    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <div class="section-header text-center">

                    <div class="mx-auto col-md-8 text-center">
                        {{-- Check if user is logged in AND is a standard user --}}
                        @if(Auth::check() && Auth::user()->type == "user")

                            {{-- Shop --}}
                            <div>
                                <a type="button" style="width: 100%; background-color: #f39c12;"
                                   class="btn btn-lg my-2"
                                   href="{{!empty($settings->firstWhere('name', 'shop_button_link')->detail) ? $settings->firstWhere('name', 'shop_button_link')->detail : route('client.shop')}}">
                                    {{$settings->firstWhere('name', 'shop_button_label')->detail ?? 'Shop'}}
                                </a>
                            </div>

                            {{-- All Games --}}
                            <div>
                                <a type="button" style="width: 100%"
                                   class="btn btn-lg my-2 btn-success cBtn"
                                   href="{{route('client.games.index')}}">
                                    All Games
                                </a>
                            </div>

                            {{-- 2Sure Competition --}}
                            <div>
                                <a type="button" style="width: 100%"
                                   class="btn btn-lg my-2 btn-success cBtn"
                                   href="{{route('client.twosure.gate')}}">
                                    My2Sure Competition
                                </a>
                            </div>

                            {{-- Winning Results --}}
                            <div>
                                <a type="button" style="width: 100%; background-color: #27ae60;"
                                   class="btn btn-lg my-2"
                                   href="{{!empty($settings->firstWhere('name', 'results_button_link')->detail) ? $settings->firstWhere('name', 'results_button_link')->detail : route('client.results')}}">
                                    {{$settings->firstWhere('name', 'results_button_label')->detail ?? 'Winning Results'}}
                                </a>
                            </div>

                            {{-- VIP Room --}}
                            <div>
                                <a type="button" style="width: 100%"
                                   class="btn btn-lg my-2 btn-vip"
                                   href="{{route('client.vip.gate')}}">
                                    👑 VIP Room
                                </a>
                            </div>

                            {{-- Music --}}
                            @php $musicLink = $settings->firstWhere('name', 'music_button_link')->detail ?? null; @endphp
                            @if(!empty($musicLink))
                                <div>
                                    <a type="button" style="width: 100%; background-color: #8e44ad;"
                                       class="btn btn-lg my-2"
                                       href="{{ $musicLink }}">
                                        {{ $settings->firstWhere('name', 'music_button_label')->detail ?? 'Music' }}
                                    </a>
                                </div>
                            @endif

                            {{-- Sponsor Us --}}
                            <div>
                                <button onclick="openSponsorModal()"
                                        style="width: 100%; background-color: #e74c3c; border-color: #e74c3c;"
                                        class="btn btn-lg my-2">
                                    ❤️ Sponsor Us
                                </button>
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Sponsor Modal --}}
<div id="sponsorModalOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: #fff; border-radius: 16px; padding: 36px; max-width: 420px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); position: relative; animation: modalIn 0.3s ease; text-align: center;">
        <button onclick="closeSponsorModal()" style="position: absolute; top: 16px; right: 20px; font-size: 22px; cursor: pointer; color: #aaa; background: none; border: none; line-height: 1;">&times;</button>

        <div id="sponsorForm">
            <div style="font-size: 48px; margin-bottom: 10px;">❤️</div>
            <h3 style="font-size: 22px; font-weight: 800; color: #1a1a2e; margin-bottom: 8px;">Support My2Sure</h3>
            <p style="font-size: 14px; color: #888; margin-bottom: 24px;"> Enter any amount you'd like to contribute and pay in your local currency. Thank you.</p>

            <div style="margin-bottom: 20px; text-align: left;">
                <label style="font-size: 12px; font-weight: 600; color: #666; letter-spacing: 1px; text-transform: uppercase; display: block; margin-bottom: 6px;">Amount (USD)</label>
                <input type="number" id="sponsorAmount" min="1" placeholder="Enter amount" style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; font-size: 16px; outline: none; box-sizing: border-box;">
                <p id="sponsorAmountError" style="color: #e74c3c; font-size: 12px; margin-top: 4px; display: none;">Please enter a valid amount.</p>
            </div>

            <button onclick="initiateSponsorPayment()" id="sponsorPayBtn" style="width: 100%; background: #e74c3c; color: #fff; border: none; border-radius: 10px; padding: 14px; font-size: 16px; font-weight: 700; cursor: pointer;">
                Pay Now ❤️
            </button>
        </div>

        <div id="sponsorThankYou" style="display: none;">
            <div style="font-size: 64px; margin-bottom: 16px;">🎉</div>
            <h3 style="font-size: 24px; font-weight: 800; color: #1a1a2e; margin-bottom: 12px;">Thank You!</h3>
            <button onclick="closeSponsorModal()" style="margin-top: 20px; background: #34b5f7; color: #fff; border: none; border-radius: 10px; padding: 12px 30px; font-size: 15px; font-weight: 700; cursor: pointer;">Close</button>
        </div>
    </div>
</div>

<style>
    @keyframes modalIn {
        from { opacity: 0; transform: translateY(-30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    #sponsorModalOverlay.active { display: flex !important; }
</style>

@push('scripts')
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>
        function openSponsorModal() {
            document.getElementById('sponsorModalOverlay').classList.add('active');
            document.getElementById('sponsorForm').style.display = 'block';
            document.getElementById('sponsorThankYou').style.display = 'none';
        }

        function closeSponsorModal() {
            document.getElementById('sponsorModalOverlay').classList.remove('active');
        }

        function initiateSponsorPayment() {
            let amount = parseFloat(document.getElementById('sponsorAmount').value);
            if (!amount || amount <= 0) {
                document.getElementById('sponsorAmountError').style.display = 'block';
                return;
            }

            document.getElementById('sponsorPayBtn').disabled = true;
            document.getElementById('sponsorPayBtn').textContent = 'Opening payment...';

            fetch('{{ route("detect.country") }}')
                .then(res => res.json())
                .then(data => {
                    openSponsorCheckout(parseFloat((amount * (data.rate || 1)).toFixed(2)), data.currency || 'USD');
                })
                .catch(() => openSponsorCheckout(amount, 'USD'));
        }

        function openSponsorCheckout(amount, currency) {
            FlutterwaveCheckout({
                public_key: "{{ config('services.flutterwave.public_key') }}",
                tx_ref:     "sponsor-" + Date.now(),
                amount:     amount,
                currency:   currency,
                customer: {
                    email: "{{ Auth::check() ? Auth::user()->email : '' }}",
                    name:  "{{ Auth::check() ? Auth::user()->name : '' }}",
                },
                callback: function(response) {
                    if (response.status === "successful") {
                        document.getElementById('sponsorForm').style.display = 'none';
                        document.getElementById('sponsorThankYou').style.display = 'block';
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
