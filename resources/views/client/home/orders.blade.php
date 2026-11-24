@extends('client.layout')
@section('title')
    Orders
@endsection
@section('meta_description', 'View your My2Sure order history and package details. Keep track of your premium lottery forecast subscriptions.')
@section('content')
    <!-- contact-section start -->
    <section class="inner-page-banner has_bg_image" data-background="{{asset('assets/images/inner-page-bg.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-page-banner-area">
                        <h1 class="page-title">Orders Details</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('client.index')}}">Home</a></li>
                                <li class="breadcrumb-item active">Orders Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        @include('client.slider');
    </section>
    <section class="contact-section">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-12">

                    <div class="contact-area d-flex">

                        <div class=" col-12">
                            <div class="mx-3 my-2 p-2">
                                <h3 class="title pb-3">Your Orders {{count($orders)}}</h3>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Info</th>
                                        <th>Quantity</th>
                                        <th>Total Amount</th>
                                        <th>Payment ID</th>
                                        <th>Delivery Address</th>
                                        <th>Order Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders  as $order)
                                        <tr>
                                            <td><span class="d-block">{{$loop->iteration}}</span></td>
                                            <td>
                                                <span class="d-block font-weight-bold">

                                                    {{$order->product->name}}
                                                    {{$order->variant != null ? '('.$order->variant->label.')' : '' }}

                                                </span>
                                                <span class="d-block ">${{$order->product->price}}</span>

                                            </td>
                                            <td><span class="d-block"> {{$order->quantity}}</span></td>
                                            <td><span class="d-block"> {{$order->total_amount}}</span></td>
                                            <td><span class="d-block"> {{$order->payment_id}}</span></td>
                                            <td><span class="d-block"> {{$order->address}}</span></td>
                                            <td><span class="d-block"> {{$order->created_at}}</span></td>

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('client.partials.footer_buttons')
    <!-- contact-section end -->
@endsection


