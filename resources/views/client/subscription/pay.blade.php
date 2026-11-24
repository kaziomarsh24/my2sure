@extends('client.layout')
@section('title', 'Subscribe')
@section('content')

    <section class="inner-page-banner has_bg_image" data-background="{{ asset('assets/images/inner-page-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-page-banner-area">
                        <h1 class="page-title">Processing...</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    {{-- Bank transfer note (shown for both All Games & VIP payments) --}}
                    <div class="alert" role="alert"
                         style="background:#fff8e1;border:1px solid #f0c36d;border-radius:10px;
                                padding:18px 22px;color:#5c4400;font-size:15px;line-height:1.6;">
                        <strong>NOTE:</strong> If you are having issues paying with your card,
                        Transfer The Naira equivalent to <strong>3003514743&nbsp; MY2SURE LIMITED&nbsp; KUDA BANK</strong>
                        and send a notification message to <strong>my2sure@gmail.com</strong>
                    </div>

                    <div class="text-center mt-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-3">Please wait, redirecting to payment...</p>
                        <button id="retryPayBtn" class="btn btn-lg btn-success mt-2" style="display:none;">
                            Pay With Card
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>
        let baseAmount = {{ $price }};

        function startPayment() {
            fetch('{{ route("detect.country") }}')
                .then(res => res.json())
                .then(data => {
                    let currency        = data.currency;
                    let rate            = data.rate;
                    let convertedAmount = parseFloat((baseAmount * rate).toFixed(2));
                    initiatePayment(currency, convertedAmount);
                })
                .catch(() => {
                    initiatePayment('USD', baseAmount);
                });
        }

        // Auto-launch on load, and allow re-launch via the button.
        startPayment();
        document.getElementById('retryPayBtn').addEventListener('click', startPayment);

        function initiatePayment(currency, amount) {
            FlutterwaveCheckout({
                public_key: "{{ $pubKey }}",
                tx_ref:     "sub-{{ $type }}-" + Date.now(),
                amount:     amount,
                currency:   currency,
                customer: {
                    email: "{{ $user->email }}",
                    name:  "{{ $user->name }}",
                },
                customizations: {
                    title:       "My2Sure Subscription",
                    description: "{{ ucfirst(str_replace('_', ' ', $type)) }} Subscription",
                    logo:        "{{ asset('assets/images/logo.png') }}",
                },
                callback: function(response) {
                    if (response.status === "successful" || response.status === "completed") {
                        $.post('{{ route("client.subscription.success") }}', {
                            '_token':     $('meta[name=csrf-token]').attr('content'),
                            'type':       '{{ $type }}',
                            'payment_id': response.transaction_id,
                            'amount':     baseAmount,
                            'currency':   currency,
                            'duration':   '{{ $duration ?? "" }}',
                            'redirect':   '{{ $redirect ?? "" }}',
                        }).done(function(data) {
                            window.location.href = data.redirect;
                        });
                    } else {
                        // Keep the user on this page so the bank-transfer note stays visible.
                        document.getElementById('retryPayBtn').style.display = 'inline-block';
                    }
                },
                onclose: function() {
                    // Keep the user on this page so the bank-transfer note stays visible.
                    document.getElementById('retryPayBtn').style.display = 'inline-block';
                }
            });
        }
    </script>
@endpush