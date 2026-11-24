@extends('client.layout')
@section('title')
    About Us
@endsection
@section('meta_description', 'Since 2007, My2Sure Limited has been dedicated to providing premium quality solution to the extremely low winning chance of lottery players in lottery games across Africa. My2sure Limited is focused on Ghana Lottery, Premier Lottery, Golden Chance Lottery and R&S Lottery Operating in Ghana & Nigeria.')
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
                        <h1 class="page-title">About Us</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('client.index')}}">Home</a></li>
                                <li class="breadcrumb-item active">About us</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- inner-page-banner end -->
    <section>
        @include('client.slider');
    </section>
    <!-- - about-section start -->
    <section class="about-section section-padding">
        <div class="container">
            <div class="row justify-content-center">
                {{--        <div class="col-xl-5 p-xl-0">--}}
                {{--          <div class="thumb">--}}
                {{--            <img src="assets/images/about-image.jpg" alt="image">--}}
                {{--          </div>--}}
                {{--        </div>--}}
                {{--        <div class="col-12 p-xl-0">--}}
                <div class="col-md-12">
                    <div class="col-md-12">
                        <h2 class="title" style="color: #343280">A FEW WORDS ABOUT US</h2>
                        {!! $settings->firstWhere('name', 'about_us_content')->detail ?? '' !!}
                    </div>
            </div>
        </div>
    </section>
    <!-- about-section end -->


    <!-- choose-us-section start -->
    <section class="d-none choose-us-section section-padding border-top border-bottom has_bg_image" data-background="assets/images/inner-page-banner.jpg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-header text-center">
                        <h2 class="section-title">Why Choose Us?</h2>
                        <p>With a selection of the world’s biggest and best international jackpots to choose from, there are already millions of reasons why you should be getting Lucky with My2sure. But you don’t need a million reasons. All you need is four - and every one of them’s a winner:</p>
                    </div>
                </div>
            </div>
            <div class="row mt-mb-15">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="choose-item text-center choose-item--gray-border">
                        <div class="front">
                            <div class="icon">
                                <img src="assets/images/svg-icons/choose-us-icons/1.svg" alt="icon">
                            </div>
                            <h4 class="title">Biggest lottery jackpots</h4>
                        </div>
                        <div class="back">
                            <p>One of the core advantages of playing an online lotto is that it is both safe and secure. So, there is no need for you to queue, or visit a retail store, to get tickets.</p>
                        </div>
                    </div>
                </div><!-- choose-item end -->
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="choose-item text-center choose-item--gray-border">
                        <div class="front">
                            <div class="icon">
                                <img src="assets/images/svg-icons/choose-us-icons/2.svg" alt="icon">
                            </div>
                            <h4 class="title">No commission on Winnings</h4>
                        </div>
                        <div class="back">
                            <p>One of the core advantages of playing an online lotto is that it is both safe and secure. So, there is no need for you to queue, or visit a retail store, to get tickets.</p>
                        </div>
                    </div>
                </div><!-- choose-item end -->
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="choose-item text-center choose-item--gray-border">
                        <div class="front">
                            <div class="icon">
                                <img src="assets/images/svg-icons/choose-us-icons/3.svg" alt="icon">
                            </div>
                            <h4 class="title"> Safe and Secure Playing</h4>
                        </div>
                        <div class="back">
                            <p>One of the core advantages of playing an online lotto is that it is both safe and secure. So, there is no need for you to queue, or visit a retail store, to get tickets.</p>
                        </div>
                    </div>
                </div><!-- choose-item end -->
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="choose-item text-center choose-item--gray-border">
                        <div class="front">
                            <div class="icon">
                                <img src="assets/images/svg-icons/choose-us-icons/6.svg" alt="icon">
                            </div>
                            <h4 class="title">Dedicated Support</h4>
                        </div>
                        <div class="back">
                            <p>One of the core advantages of playing an online lotto is that it is both safe and secure. So, there is no need for you to queue, or visit a retail store, to get tickets.</p>
                        </div>
                    </div>
                </div><!-- choose-item end -->
            </div>
        </div>
    </section>
    @include('client.partials.footer_buttons')
    <!-- choose-us-section end -->
    @push('scripts')

    @endpush
@endsection
