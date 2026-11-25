@extends('client.layout')
@section('title')
    All Products
@endsection
@section('meta_description', 'Shop top-rated lottery forecast packages at My2Sure and increase your chances of winning. Buy VIP plans for Ghana Lotto, Premier Lotto, and more. Expert-approved forecasts for consistent wins.')
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

    </style>
@endpush
@section('content')
    <!-- inner-page-banner start -->
    <section class="inner-page-banner has_bg_image" data-background="{{asset('assets/images/inner-page-bg.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-page-banner-area">
                        <h1 class="page-title">All Products</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('client.index')}}">Home</a></li>
                                <li class="breadcrumb-item active">All Products </li>
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
            <div class="row">
                <!--   start -->
                @foreach($objGames As $obj)

                    <div class="col-lg-4 col-md-6" style=" margin-bottom: 33px;">
                        <div class="jackpot-item text-center">
                            <img src="{{ \App\Support\MediaHelper::url($obj->logo, 'thumb') }}" loading="lazy" decoding="async" alt="{{ $obj->name }}">
                            <span class="amount">{{$obj->name}}</span>
                            <h5 class="title">${{$obj->price}}</h5>
                            <a href="{{route('client.product_details',['id'=>$obj->id])}}" class="cmn-btn">View Details!</a>
                        </div>
                    </div>
                    <!--   end -->
                @endforeach

            </div>
        </div>
    </section>
    @include('client.partials.footer_buttons')
    <!-- jackpot-section start -->


@endsection
