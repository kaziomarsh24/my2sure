@extends('client.layout')
@section('title')
How to Play
@endsection
@section('meta_description', 'Learn how to play and win with My2Sure. Follow our simple steps to register, choose your lottery, and get your lucky forecast numbers today.')
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
            <h1 class="page-title">How to Play</h1>
            <nav aria-label="breadcrumb" class="page-header-breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('client.index')}}">Home</a></li>
                <li class="breadcrumb-item active">How to Play</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- inner-page-banner end -->

 <!-- work-steps-section strat -->
    <section class="work-steps-section section-padding border-top">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-7">
            <div class="section-header text-center">
              <h2 class="section-title">how it works</h2>
              <p>My2Sure is the best way to play these exciting lotteries from anywhere in the world.</p>
            </div>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="work-steps-items-part d-flex">
              <div class="line"><img src="{{ asset('assets/images/elements/line.png')}}" alt="line-image"></div>
              <div class="work-steps-item">
                <div class="work-steps-item-inner">
                  <div class="icon"><img src="{{ asset('assets/images/svg-icons/how-work-icons/1.svg') }}" alt="icon">
                    <span class="count-num">01</span></div>
                  <h4 class="title">choose</h4>
                  <p>Choose your lottery & pick your numbers</p>
                </div>
              </div><!-- work-steps-item end -->
              <div class="work-steps-item">
                <div class="work-steps-item-inner">
                  <div class="icon"><img src="{{ asset('assets/images/svg-icons/how-work-icons/2.svg') }}" alt="icon">
                    <span class="count-num">02</span></div>
                  <h4 class="title">Play</h4>
                  <p>Complete your purchase</p>
                </div>
              </div><!-- work-steps-item end -->
              <div class="work-steps-item">
                <div class="work-steps-item-inner">
                  <div class="icon"><img src="{{ asset('assets/images/svg-icons/how-work-icons/3.svg') }}" alt="icon">
                    <span class="count-num">01</span></div>
                  <h4 class="title">Get Lucky</h4>
                  <p>Start dreaming, you're almost there</p>
                </div>
              </div><!-- work-steps-item end -->
            </div>
          </div>
          <div class="col-lg-6">
            <div class="work-steps-thumb-part">
              <img src="{{ asset('assets/images/elements/step.png')}}" alt="work-step-image">
              <a href="https://www.youtube.com/embed/aFsYlAzQHnY4" data-rel="lightcase:myCollection" class="play-btn"><i class="fa fa-play"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- work-steps-section strat -->

  <!-- reward-section start -->
  <section class="reward-section section-padding border-top has_bg_image" data-background="assets/images/bg-five.jpg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7">
          <div class="section-header text-center">
            <h2 class="section-title">Lucky-Forecasters</h2>
            <p>We at My2Sure offer you the most generous and innovative lotto Lucky Numbers. How would you feel with an attractive deposit bonus, a risk free lottery ticket</p>
          </div>
        </div>
      </div>
      <div class="row m-bottom-not-30">
        <div class="col-lg-4 col-md-6">
          <div class="reward-item text-center">
            <div class="icon">
              <img src="assets/images/svg-icons/reward/1.svg" alt="image">
            </div>
            <div class="content">
              <h3 class="title">Register Your Account</h3>
              <p>For playing any forecaster Game you need to register with mysure.com by click Register at the top of menu .</p>
            </div>
          </div>
        </div><!-- reward-item end-->
        <div class="col-lg-4 col-md-6">
          <div class="reward-item text-center">
            <div class="icon">
              <img src="assets/images/svg-icons/reward/3.svg" alt="image">
            </div>
            <div class="content">
              <h3 class="title">Purchase Subscription</h3>
              <p> getting Access the all Forecaster Games in the My2Sure.com and Get More Lucky you have to purchase a Annual Subscription After Registration </p>
            </div>
          </div>
        </div><!-- reward-item end-->
        <div class="col-lg-4 col-md-6">
          <div class="reward-item text-center">
            <div class="icon">
              <img src="assets/images/svg-icons/reward/2.svg" alt="image">
            </div>
            <div class="content">
              <h3 class="title">Play & Get Lucky</h3>
              <p>Now you have Access of the All Forecaster Games Library in the My2Sure.com .Click Choose for Me Sit Back and get lucky.</p>
            </div>
          </div>
        </div><!-- reward-item end-->
      </div>
    </div>
  </section>
  <!-- reward-section end -->


  <!-- question-section start -->
  <section class="question-section border-top section-padding section-bg">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-lg-4">
          <div class="thumb text-lg-right text-center">
            <img src="assets/images/elements/faq.png" alt="image">
          </div>
        </div>
        <div class="col-lg-7">
          <div class="content">
            <h2 class="title">If you have any questions</h2>
            <p>Our top priorities are to protect your privacy, provide secure transactions, and safeguard your data. When you're ready to play, registering an account is required so we know you're of legal age and so no one else can use your account.We answer the most commonly asked lotto questions..</p>
            <a href="{{route('client.contact')}}" class="cmn-btn">Contact Us</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  @include('client.partials.footer_buttons')
  <!-- question-section end -->
@push('scripts')

@endpush
@endsection
