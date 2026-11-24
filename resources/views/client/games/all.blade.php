@extends('client.layout')
@section('title')
    All Games -  Lottery Forecasters
@endsection
@push('styles')
    <style type="text/css">
        .QuizArea {
            background: linear-gradient(to bottom, #fefefe 0%, #d0d0d0 100%);
            position: relative;
            border-radius: 6px;
            width: 100%;
            border: 1px solid #BBB;
            overflow: hidden;
            margin-bottom: 30px !important;
            box-sizing: border-box;
            padding: 25px;
        }

        .result {
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

        .lotto-ball {
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
                        <h1 class="page-title">All Games</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('client.index')}}">Home</a></li>
                                <li class="breadcrumb-item active">All Games</li>
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
                        <p>Can't decide on your lucky numbers for the next Lotto draw? Use the 'Generate Numbers' button
                            below to have a set of six numbers selected at random. If you like to play with multiple
                            entries then you can create up to 10 unique lines in one go</p>
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
                            <img src="{{ asset('uploads/'.$obj->game->logo)}}" alt="image">
                            <span class="amount">{{$obj->name}}</span>
                            <h5 class="title">{{$result}}</h5>
                            <p class="next-draw-time">End Date :
                                <span>{{date('d/M/Y')}}</span></p>
                            <a href="{{route('client.games.show',['game'=>$obj->id])}}" class="cmn-btn">Use Now!</a>
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
