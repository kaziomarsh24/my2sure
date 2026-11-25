@extends('client.layout')
@php
    $colors = ['Black', 'Blue', 'Red', 'Green', 'White', 'Yellow', 'Pink', 'Orange', 'Purple', 'Grey', 'Gray', 'Silver', 'Gold', 'Brown', 'Beige', 'Navy', 'Maroon'];
    $foundColors = [];
    foreach ($colors as $color) {
        if (stripos($product->description, $color) !== false) {
            $foundColors[] = $color;
        }
    }
    $colorString = !empty($foundColors) ? ' - ' . implode(' & ', $foundColors) : '';
@endphp
@section('title')
    {{$product->name}}{{ $colorString }}
@endsection
@section('meta_description', 'Get ' . $colorString . ' ' . $product->name . ' for only $' . $product->price . ' on My2Sure. Boost your lottery winning chances with our premium forecast packages.')

@push('styles')
<style type="text/css">
    .QuizArea{
        background: linear-gradient(to bottom, #fefefe 0%,#d0d0d0 100%);
        position: relative;
        border-radius: 6px;
        width: 100%;
        border: 1px solid #BBB;
        overflow: hidden;
        margin-bottom: 30px !important;
        box-sizing: border-box;
        padding: 25px;
    }
    .result{
        position: relative;
        width: 75px;
        height: 75px;
        text-align: center;
        font: bold 36px/75px arial, sans-serif;
        letter-spacing: -1px;
        margin: 0 2px;
        top: 0;
        text-shadow: #333 0 2px 2px;
        border-radius: 75px;
        box-shadow: inset #000 0 0 5px;
        display: inline-block;
        *display: inline;
        zoom: 1;
    }
    .lotto-ball{
        background: #34b5f7;
        color: #FFF;
    }
    .order-modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }
    .order-modal-overlay.active {
        display: flex;
    }
    .order-modal {
        background: #fff;
        border-radius: 16px;
        padding: 36px;
        max-width: 480px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: modalIn 0.3s ease;
        position: relative;
    }
    @keyframes modalIn {
        from { opacity: 0; transform: translateY(-30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .order-modal-close {
        position: absolute;
        top: 16px; right: 20px;
        font-size: 22px;
        cursor: pointer;
        color: #aaa;
        background: none;
        border: none;
        line-height: 1;
    }
    .order-modal-close:hover { color: #333; }
    .order-modal h3 {
        font-size: 22px;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 6px;
    }
    .order-modal .modal-subtitle {
        font-size: 13px;
        color: #aaa;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f0f0f0;
    }
    .order-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f8f8f8;
        font-size: 14px;
    }
    .order-summary-row .label { color: #888; }
    .order-summary-row .value {
        font-weight: 600;
        color: #1a1a2e;
    }
    .order-summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0 0;
        font-size: 18px;
        font-weight: 800;
        color: #1a1a2e;
    }
    .order-summary-total .total-amount {
        color: #34b5f7;
    }
    .modal-pay-btn {
        width: 100%;
        background: linear-gradient(135deg, #34b5f7, #1a8fd1);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 15px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 20px;
        transition: all 0.3s;
        letter-spacing: 0.5px;
    }
    .modal-pay-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(52,181,247,0.4);
    }
    .modal-pay-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    .modal-cancel-btn {
        width: 100%;
        background: transparent;
        color: #aaa;
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 12px;
        font-size: 14px;
        cursor: pointer;
        margin-top: 10px;
        transition: all 0.2s;
    }
    .modal-cancel-btn:hover {
        background: #f8f8f8;
        color: #666;
    }
    .modal-secure-note {
        text-align: center;
        font-size: 12px;
        color: #bbb;
        margin-top: 14px;
    }
    .modal-secure-note i {
        color: #34b5f7;
        margin-right: 4px;
    }
    .modal-waiting {
        display: none;
        text-align: center;
        padding: 10px 0;
    }
    .modal-product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 12px;
    }
    .modal-product-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .modal-product-header .product-info h4 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }
    .modal-product-header .product-info span {
        font-size: 12px;
        color: #aaa;
    }
</style>
@endpush

@section('content')

<!-- inner-page-banner start -->
<section class="inner-page-banner has_bg_image py-5" data-background="{{asset('assets/images/inner-page-bg.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-page-banner-area">
                    <h1 class="page-title">{{$product->name}}</h1>
                    <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('client.index')}}">Home</a></li>
                            <li class="breadcrumb-item active">{{$product->name}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- inner-page-banner end -->

<!-- jackpot-section start -->
<section class="jackpot-section section-padding">
    <div class="container">
        <div class="d-none row justify-content-center">
            <div class="col-lg-5">
                <div class="section-header text-center">
                    <h2 class="section-title">Lottery Forecasters</h2>
                    <p>Can't decide on your lucky numbers for the next Lotto draw? Use the 'Generate Numbers' button below to have a set of six numbers selected at random. If you like to play with multiple entries then you can create up to 10 unique lines in one go</p>
                </div>
            </div>
        </div>
        <div class="row mx-auto justify-content-center">
            <input hidden id="product_id" value="{{$product->id}}">

            <div class="col-lg-6 col-md-6" style="margin-bottom: 33px;">
                <div>
                    <img class="img-fluid" src="{{ upload_url($product->logo) }}" decoding="async" alt="{{ $product->name }}">
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <h3 class="title amount">{{$product->name}}</h3>
                <h5 id="">Single Amount: ${{$product->price}}</h5>
                <p id="">Variants:</p>

                <div class="row">
                    @php $firstVariant = true; @endphp
                    @foreach($variants as $var)
                        @if($var->stock == 0) @continue @endif
                        <label style="display: flex; align-items: center;" class="">
                            <input type="radio" {{ $firstVariant ? 'checked' : '' }}
                                name="variant"
                                data-stock="{{$var->stock}}"
                                data-label="{{$var->label}}"
                                value="{{$var->id}}">
                            <span class="mx-2">{{$var['label']}}</span>
                        </label>
                        @php $firstVariant = false; @endphp
                    @endforeach
                </div>

                <div class="row align-content-center mt-3">
                    <div class="col-8">
                        <span class="fw-bold">Total Amount: $<span id="total_amount">{{$product->price}}</span></span>
                    </div>
                    <div class="col-4">
                        <input type="number" class="form-control" id="product_quantity" min="1" value="1">
                    </div>
                </div>

                <textarea class="form-control my-2" rows="3"
                    placeholder="Enter Delivered address"
                    required id="address"></textarea>

                @if(Auth::user())
                    <button id="flw_btn" class="cmn-btn my-2">Buy Now!</button>
                @else
                    <a id="" class="cmn-btn my-2" href="{{route('login')}}">Login to place order</a>
                @endif

                <p>{{$product->description}}</p>

                <div id="waiting" style="display: none;">
                    <div class="spinner-border text-primary" role="status"></div>
                    <span class="">Please wait...</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- jackpot-section end -->

<!-- Order Confirmation Modal -->
<div class="order-modal-overlay" id="orderModalOverlay">
    <div class="order-modal">
        <button class="order-modal-close" id="closeModal">&times;</button>

        <div class="modal-product-header">
            <img src="{{ asset('uploads/'.$product->logo) }}"
                alt="{{ $product->name }}"
                class="modal-product-image">
            <div class="product-info">
                <h4>{{ $product->name }}</h4>
                <span>Order Summary</span>
            </div>
        </div>

        <h3>Confirm Your Order</h3>
        <p class="modal-subtitle">Please review your order details before proceeding to payment.</p>

        <div class="order-summary-row">
            <span class="label">Product</span>
            <span class="value">{{ $product->name }}</span>
        </div>
        <div class="order-summary-row">
            <span class="label">Variant</span>
            <span class="value" id="modal_variant">—</span>
        </div>
        <div class="order-summary-row">
            <span class="label">Quantity</span>
            <span class="value" id="modal_quantity">1</span>
        </div>
        <div class="order-summary-row">
            <span class="label">Unit Price</span>
            <span class="value">${{ $product->price }}</span>
        </div>
        <div class="order-summary-row">
            <span class="label">Delivery Address</span>
            <span class="value" id="modal_address" style="max-width:200px; text-align:right;">—</span>
        </div>

        <div class="order-summary-total">
            <span>Total</span>
            <span class="total-amount">$<span id="modal_total">{{ $product->price }}</span></span>
        </div>

        <div class="modal-waiting" id="modalWaiting">
            <div class="spinner-border text-primary" role="status"></div>
            <span class="ms-2">Processing payment...</span>
        </div>

        <button class="modal-pay-btn" id="confirmPayBtn">
            <i class="fa fa-lock"></i> &nbsp; Pay Now
        </button>
        <button class="modal-cancel-btn" id="cancelModalBtn">Cancel</button>

        <p class="modal-secure-note">
            <i class="fa fa-shield"></i> Secured by Flutterwave — Your payment info is safe
        </p>
    </div>
</div>

@include('client.partials.footer_buttons')

@endsection

@push('scripts')
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>

    document.getElementById('address').innerHTML = document.getElementById('address').innerHTML.trim();

    let baseAmount       = parseFloat(`<?=$product->price?>`);
    let userEmail        = "{{ Auth::user()->email ?? '' }}";
    let userName         = "{{ Auth::user()->name ?? '' }}";
    let flwPubKey        = "{{ config('services.flutterwave.public_key') }}";
    let totalAmount      = 0;
    let selectedVariant  = null;
    let selectedQty      = 1;
    let detectedCurrency = 'USD';
    let detectedRate     = 1;

    // Detect country and rate on page load
    fetch('{{ route("detect.country") }}')
        .then(res => res.json())
        .then(data => {
            console.log('Country detection:', data);
            detectedCurrency = data.currency;
            detectedRate     = data.rate;
        })
        .catch((err) => {
            console.log('Country detection failed:', err);
            detectedCurrency = 'USD';
            detectedRate     = 1;
        });

    // Update total when quantity changes
    $("#product_quantity").change(function(e) {
        e.preventDefault();
        $("#total_amount").html('');

        let quantity     = parseInt($(this).val());
        let variantStock = $("input[name='variant']:checked").data('stock');

        if (variantStock < quantity) {
            alert("Not have required quantity in this variant");
            $(this).val(quantity - 1);
            let total = baseAmount * (quantity - 1);
            $("#total_amount").html(total);
            return;
        } else {
            let total = baseAmount * quantity;
            $("#total_amount").html(total);
        }
    });

    // Buy Now — validate and open modal
    $('#flw_btn').click(function(e) {
        e.preventDefault();

        if ($("textarea#address").val().trim() == "") {
            alert("Please enter delivery address");
            return;
        }

        let quantity     = parseInt($("#product_quantity").val());
        let variantStock = $("input[name='variant']:checked").data('stock');
        let variantLabel = $("input[name='variant']:checked").data('label');

        selectedVariant = $("input[name='variant']:checked").val();
        selectedQty     = quantity;

        if ($("input[name='variant']").length > 0 && !selectedVariant) {
            alert("Please select a variant");
            return;
        }

        if (variantStock < quantity) {
            alert("Not have required quantity in this variant");
            $("#product_quantity").val(quantity - 1);
            $("#total_amount").html(baseAmount * (quantity - 1));
            return;
        }

        totalAmount = parseFloat((baseAmount * quantity).toFixed(2));
        $("#total_amount").html(totalAmount);

        $("#modal_variant").text(variantLabel || '—');
        $("#modal_quantity").text(quantity);
        $("#modal_address").text($("textarea#address").val().trim());
        $("#modal_total").text(totalAmount.toFixed(2));

        $("#orderModalOverlay").addClass('active');
    });

    // Close modal
    $("#closeModal, #cancelModalBtn").click(function() {
        $("#orderModalOverlay").removeClass('active');
    });

    // Close on overlay click
    $("#orderModalOverlay").click(function(e) {
        if ($(e.target).is('#orderModalOverlay')) {
            $("#orderModalOverlay").removeClass('active');
        }
    });

    // Confirm Pay — trigger Flutterwave with converted amount
    $("#confirmPayBtn").click(function() {
        $("#confirmPayBtn").prop('disabled', true);
        $("#modalWaiting").show();

        let convertedAmount = parseFloat((totalAmount * detectedRate).toFixed(2));

        FlutterwaveCheckout({
            public_key: flwPubKey,
            tx_ref:     "order-" + Date.now(),
            amount:     convertedAmount,
            currency:   detectedCurrency,
            customer: {
                email: userEmail,
                name:  userName,
            },
            customizations: {
                title:       "{{ $product->name }}",
                description: "Purchase of {{ $product->name }}",
                logo:        "{{ asset('assets/images/logo.png') }}",
            },
            callback: function(response) {
                if (response.status === "successful" || response.status === "completed") {

                    $("#orderModalOverlay").removeClass('active');
                    $("#flw_btn").hide();
                    $("#waiting").show();

                    $.post('{{ route("client.place_order") }}', {
                        '_token':           $('meta[name=csrf-token]').attr('content'),
                        'product_id':       $('#product_id').val(),
                        'product_quantity': selectedQty,
                        'payment_id':       response.transaction_id,
                        'total_amount':     totalAmount,
                        'variant':          selectedVariant,
                        'address':          $("textarea#address").val(),
                    }).done(function(data) {

                        console.log(data);

                        if (data.status.trim() == "true") {
                            alert("Order placed successfully!");
                            window.location.href = '{{ route("client.my_orders") }}';
                        } else if (data.status.trim() == "less_stock") {
                            alert("Not have required quantity in this variant");
                        } else if (data.status.trim() == "not_found") {
                            alert("Variant not found. Please try again.");
                        } else {
                            alert("Order not placed. Please try again.");
                        }

                        $("#flw_btn").show();
                        $("#waiting").hide();
                        $("#confirmPayBtn").prop('disabled', false);
                        $("#modalWaiting").hide();

                    }).fail(function() {
                        alert("Something went wrong. Please try again.");
                        $("#flw_btn").show();
                        $("#waiting").hide();
                        $("#confirmPayBtn").prop('disabled', false);
                        $("#modalWaiting").hide();
                    });

                } else {
                    alert("Payment was not completed. Please try again.");
                    $("#confirmPayBtn").prop('disabled', false);
                    $("#modalWaiting").hide();
                }
            },
            onclose: function() {
                $("#confirmPayBtn").prop('disabled', false);
                $("#modalWaiting").hide();
                console.log("Payment popup closed");
            }
        });
    });

</script>
@endpush