@extends('client.layout')
@section('title','Your Premium Lottery Forecaster')
@section('content')
<!-- banner-section start -->
    @include('client.home.partials.slider')
    <!-- banner-section end -->

    <!-- lottery-timer-section start -->
    <section class=" d-none lottery-timer-section">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-xl-5">
            <div class="timer-content">
              <h3 class="title">This is my FORECAST for today</h3>
              <p>Buy lottery tickets online to the biggest lotteries in the world offering huge jackpot prizes that you can win when you play online lottery.</p>
            </div>
          </div>
          <div class="col-xl-5 text-center">
            <div class="timer-part">
              <div class="clock"></div>
            </div>
          </div>
          <div class="col-xl-2">
            <div class="link-area text-center">
              <a href="#0" class="border-btn">register & play</a>
              <a href="#0" class="text-btn">view all offer</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- lottery-timer-section end -->

    <!-- jackpot-section start -->
    <section class="jackpot-section section-padding">
      <div class="container">
        <div class=" d-none row justify-content-center">
          <div class="col-lg-5">
            <div class="section-header text-center">
              <h2 class="section-title">Lottery Forecasters</h2>
              <p>Can't decide on your lucky numbers for the next Lotto draw? Use the 'Generate Numbers' button below to have a set of six numbers selected at random. If you like to play with multiple entries then you can create up to 10 unique lines in one go</p>
            </div>
          </div>
        </div>
        <div class="row">
          <!--   start -->
            <?php
            function getCurrentDay() {
                return date('l');
            }
            function getCurrentTimeFormatted() {
                return date("H:i"); // Returns current time in "15:00" format
            }
            function getMatchedSpecial($day, $time, $schedule) {
                $schedule = json_decode($schedule, true);



                if ($schedule === null) {
                    // JSON decoding failed
                    return "Invalid schedule data";
                }
                $currentTime = strtotime($time);
                foreach ($schedule as $slot) {
                    $startTime = strtotime($slot['startTime']);
                    $endTime = strtotime($slot['endTime']);

                    // Check if the current time falls within this slot
                    if ($currentTime >= $startTime && $currentTime <= $endTime) {
                        // Check if the specified day exists in the slot's 'days' array
                        if (isset($slot['days'][$day])) {
                            return $slot['days'][$day];
                        }
                    }
                }
                return "No match found";
            }
            ?>
          @foreach($objLotteries As $obj)
            @php
              $result="";
                   if($obj->game)
                   {
                      $schedule=$obj->game->schedule;
                      $result = getMatchedSpecial(getCurrentDay(), getCurrentTimeFormatted(), $schedule);

                   }else
                   {
                       continue;
                   }
            @endphp
          <div class="col-lg-4 col-md-6" style="    margin-bottom: 33px;">
            <div class="jackpot-item text-center">
              <img src="{{ \App\Support\MediaHelper::url($obj->game->logo, 'thumb') }}" loading="lazy" decoding="async" alt="{{ $obj->name }}">
              <span class="amount">{{$obj->name}}</span>
              <h5 class="title">{{$result}}</h5>
              <p class="next-draw-time">End Date : <span >{{date('d/M/Y')}}</span></p>
              <a href="{{route('client.games.show',['game'=>$obj->id])}}" class="cmn-btn">Use Now!</a>
            </div>
          </div>
           <!--   end -->
           @endforeach

        </div>
      </div>
    </section>
    <!-- jackpot-section start -->



    <!-- choose-us-section start -->
    <section class="choose-us-section section-padding">

      <div class="container-fluid">
        <div class=" d-none row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-title">Why Choose Us?</h2>
                    <p>My2Sure makes playing the world's largest lotteries easy and fun.</p>
                </div>
            </div>
        </div>
        <div class=" d-none row mx-0">
            <div class="col-lg-9">
            <div class="row mt-mb-15">
              <div class="col-lg-4 col-sm-6">
                <div class="choose-item text-center">
                  <div class="front">
                    <div class="icon">
                      <img src="{{ asset('assets/images/svg-icons/choose-us-icons/1.svg') }}" alt="icon">
                    </div>
                    <h4 class="title">Biggest lottery jackpots</h4>
                  </div>
                  <div class="back">
                    <p>One of the core advantages of playing an online lotto is that it is both safe and secure. So, there is no need for you to queue, or visit a retail store, to get tickets.</p>
                  </div>
                </div>
              </div><!-- choose-item end -->
              <div class="col-lg-4 col-sm-6">
                <div class="choose-item text-center">
                  <div class="front">
                    <div class="icon">
                      <img src="{{ asset('assets/images/svg-icons/choose-us-icons/2.svg') }}" alt="icon">
                    </div>
                    <h4 class="title">No commission on Winnings</h4>
                  </div>
                  <div class="back">
                    <p>One of the core advantages of playing an online lotto is that it is both safe and secure. So, there is no need for you to queue, or visit a retail store, to get tickets.</p>
                  </div>
                </div>
              </div><!-- choose-item end -->
              <div class="col-lg-4 col-sm-6">
                <div class="choose-item text-center">
                  <div class="front">
                    <div class="icon">
                      <img src="{{ asset('assets/images/svg-icons/choose-us-icons/3.svg') }}" alt="icon">
                    </div>
                    <h4 class="title"> Safe and Secure Playing</h4>
                  </div>
                  <div class="back">
                    <p>One of the core advantages of playing an online lotto is that it is both safe and secure. So, there is no need for you to queue, or visit a retail store, to get tickets.</p>
                  </div>
                </div>
              </div><!-- choose-item end -->
              <div class="col-lg-4 col-sm-6">
                <div class="choose-item text-center">
                  <div class="front">
                    <div class="icon">
                      <img src="{{ asset('assets/images/svg-icons/choose-us-icons/4.svg') }}" alt="icon">
                    </div>
                    <h4 class="title">Instant payout system</h4>
                  </div>
                  <div class="back">
                    <p>One of the core advantages of playing an online lotto is that it is both safe and secure. So, there is no need for you to queue, or visit a retail store, to get tickets.</p>
                  </div>
                </div>
              </div><!-- choose-item end -->
              <div class="col-lg-4 col-sm-6">
                <div class="choose-item text-center">
                  <div class="front">
                    <div class="icon">
                      <img src="{{ asset('assets/images/svg-icons/choose-us-icons/5.svg') }}" alt="icon">
                    </div>
                    <h4 class="title">Performance Bonuses</h4>
                  </div>
                  <div class="back">
                    <p>One of the core advantages of playing an online lotto is that it is both safe and secure. So, there is no need for you to queue, or visit a retail store, to get tickets.</p>
                  </div>
                </div>
              </div><!-- choose-item end -->
              <div class="col-lg-4 col-sm-6">
                <div class="choose-item text-center">
                  <div class="front">
                    <div class="icon">
                      <img src="{{ asset('assets/images/svg-icons/choose-us-icons/6.svg') }}" alt="icon">
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

        </div>
          @if ($socialMediaLinks !== null )
              <div class="m-3 p-3">
                  <iframe style="width: 100%; margin: auto" height="500" src="https://www.youtube.com/embed/{{$socialMediaLinks->youtube_video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
{{--                  <iframe style="width: 100%;" height="700" src="{{$socialMediaLinks->youtube_video}}" frameborder="0" allowfullscreen></iframe>--}}

              </div>
          @endif
      </div>
    </section>
    <!-- choose-us-section end -->

    <!-- work-steps-section strat -->
    <section class=" d-none work-steps-section section-padding border-top">
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
              <a href="https://www.youtube.com/embed/aFYlAzQHnY4" data-rel="lightcase:myCollection" class="play-btn"><i class="fa fa-play"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- work-steps-section strat -->

    <!-- active-user-section start -->
    <section class=" d-none active-user-section section-padding section-bg border-top">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="section-header text-center">
              <h2 class="section-title">Our Users Around The World</h2>
              <p>Over the years we have provided millions of players with tickets to lotteries across the globe and enjoyed having more than one million winners</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div id="vmap">
              <div class="position-1">
                <span class="dot"></span>
                <div class="details">
                  <h6 class="name">Gaylen Hylen</h6>
                  <p class="area">From: Argentina</p>
                </div>
              </div>
              <div class="position-2">
                <span class="dot"></span>
                <div class="details">
                  <h6 class="name">Gaylen Hylen</h6>
                  <p class="area">From: Argentina</p>
                </div>
              </div>
              <div class="position-3">
                <span class="dot"></span>
                <div class="details">
                  <h6 class="name">Gaylen Hylen</h6>
                  <p class="area">From: Argentina</p>
                </div>
              </div>
              <div class="position-4">
                <span class="dot"></span>
                <div class="details">
                  <h6 class="name">Gaylen Hylen</h6>
                  <p class="area">From: Argentina</p>
                </div>
              </div>
              <div class="position-5">
                <span class="dot"></span>
                <div class="details">
                  <h6 class="name">Gaylen Hylen</h6>
                  <p class="area">From: Argentina</p>
                </div>
              </div>
              <div class="position-6">
                <span class="dot"></span>
                <div class="details">
                  <h6 class="name">Gaylen Hylen</h6>
                  <p class="area">From: Argentina</p>
                </div>
              </div>
              <div class="position-7">
                <span class="dot"></span>
                <div class="details">
                  <h6 class="name">Gaylen Hylen</h6>
                  <p class="area">From: Argentina</p>
                </div>
              </div>
              <div class="position-8">
                <span class="dot"></span>
                <div class="details">
                  <h6 class="name">Gaylen Hylen</h6>
                  <p class="area">From: Argentina</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-6 col-6">
            <div class="active-item text-center">
              <span class="amount">3 M</span>
              <p>Registered players</p>
            </div>
          </div><!-- active-item end -->
          <div class="col-lg-3 col-md-3 col-sm-6 col-6">
            <div class="active-item text-center">
              <span class="amount">€ 1.9 BN</span>
              <p>Total in placed bets</p>
            </div>
          </div><!-- active-item end -->
          <div class="col-lg-3 col-md-3 col-sm-6 col-6">
            <div class="active-item text-center">
              <span class="amount">€ 550 M</span>
              <p>Total in payouts</p>
            </div>
          </div><!-- active-item end -->
          <div class="col-lg-3 col-md-3 col-sm-6 col-6">
            <div class="active-item text-center">
              <span class="amount">€ 44 M</span>
              <p>Biggest ever pay-out</p>
            </div>
          </div><!-- active-item end -->
          <div class="col-lg-12 text-center">
            <a href="#0" class="cmn-btn">join with us</a>
          </div>
        </div>
      </div>
    </section>
    <!-- active-user-section end -->

    <!-- testimonial-section start -->
{{--    @include('client.home.partials.reviews')--}}
    <!-- testimonial-section end -->
@endsection

@push('scripts')
<script>
    var clock = $('.clock').FlipClock(1200 * 24 * 3, {
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
