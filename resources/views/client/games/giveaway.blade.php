
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
$result="";
$schedule=$objGame->schedule;
$result = getMatchedSpecial(getCurrentDay(), getCurrentTimeFormatted(), $schedule);

?>


@extends('client.layout')
@section('title')
    {{$result}} Generate Random Numbes for Lottery - Lottery Forecasters
@endsection
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

        .checked {
            background: red !important;
            color: #FFF;
        }

        th.th-sm {
            font-size: 18px;
            font-weight: 800;
        }
    </style>

    <link rel="stylesheet" href=
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        img {
            width: 100%;
        }
        .height {
            height: 10px;
        }

        /* Image-container design */
        .image-container {
            max-width: 1500px;
            position: relative;
            margin: auto;
        }

        .next {
            right: 0;
        }

        /* Next and previous icon design */
        .previous,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            padding: 10px;
            margin-top: -25px;
        }

        /* caption decorate */
        .captionText {
            color: #000000;
            font-size: 14px;
            position: absolute;
            padding: 12px 12px;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Slider image number */
        .slideNumber {
            background-color: #5574C5;
            color: white;
            border-radius: 25px;
            right: 0;
            opacity: .5;
            margin: 5px;
            width: 30px;
            height: 30px;
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            position: absolute;
        }
        .fa {
            font-size: 32px;
        }

        .fa:hover {
            transform: rotate(360deg);
            transition: 1s;
            color: white;
        }

        .footerdot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.5s ease;
        }

        .active,
        .footerdot:hover {
            background-color: black;
        }

        .commentstable {
            width: 100%;
            display:block;
        }
        .commentshead {
            display: inline-block;
            width: 100%;
            height: 20px;
        }
        .commentsbody {
            height: 600px;
            display: inline-block;
            width: 100%;
            overflow: auto;
        }

        .display-comment .display-comment {
            margin-left: 40px
        }
        .card-body.borderblue {
            border: 1px solid #007bff;
        }
        div#bodycomment {
            border: 1px solid black;
        }
        form#bordergreen {
            border: 1px solid green;
            padding: 10px;
            margin: 20px;
        }
        .btn-outline-danger {
            color: #138737 !important;
            border-color: #138737 !important;
        }
        .btn-outline-danger:hover {
            background-color: #138737 !important;
            color: white !important;
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
                        <h1 class="page-title">{{$result}}</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('client.index')}}"></a></li>
                                <li class="breadcrumb-item active">{{$result}} </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section>
        <!-- Image container of the image slider -->
        {{--        <div class=" d-none image-container">--}}

        {{--            @foreach($objSliders as $objSlider)--}}
        {{--                <div class="slide">--}}
        {{--                    <img src="{{asset('uploads/'.$objSlider->image)}}">--}}
        {{--                </div>--}}
        {{--            @endforeach--}}
        {{--            <!-- Next and Previous icon to change images -->--}}
        {{--            <a class="previous" onclick="moveSlides(-1)">--}}
        {{--                <i class="fa fa-chevron-circle-left"></i>--}}
        {{--            </a>--}}
        {{--            <a class="next" onclick="moveSlides(1)">--}}
        {{--                <i class="fa fa-chevron-circle-right"></i>--}}
        {{--            </a>--}}
        {{--        </div>--}}

        @include('client.slider');

    </section>
    <!-- inner-page-banner end -->

    <!-- single-categories-play-section start -->
    <section class="single-categories-play-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="single-cat-play-area">
                        <div class="single-header d-flex justify-content-between">
                            <div class="left d-flex">
                                <div class="icon">
                                    <img src="{{asset('assets/images/elements/jackpot-1.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h3 class="title">{{$result}}</h3>
                                </div>
                            </div>
                            <div class="right d-flex">
                                <div class="timer-part pull-right">
                                    <div class="clock"></div>
                                </div>
                            </div>
                            <div class="right text-right">
                                <span class="draw-days">Ends on {{date('d/M/Y',strtotime($objGame->end_date))}}</span>

                            </div>

                        </div><!-- single-header end -->
                        <div class="single-body">
                            <div class="single-body-inner d-flex">

                                @for($x = 1; $x <= 1; $x++)
                                    <div class="col-md-12 QuizArea">
                                        <div class="text-center ">
                                            @for($y = 1; $y <= 90; $y++)

                                                @if(in_array($y, $objValues))

                                                    <button onclick=lottogame({{$y}}) id="checked_{{$y}}" class="result lotto-ball balls checked"> {{$y}}</button>

                                                @else

                                                    <button onclick=lottogame({{$y}}) id="checked_{{$y}}" class="result lotto-ball balls"> {{$y}}</button>

                                                @endif

                                            @endfor
                                        </div>
                                    </div>
                                @endfor
                                <div class="col-md-12 text-center" style="margin-bottom: 22px;">
                                    <button class="btn btn-lg btn-danger" onclick="playtomorrow()" id="btnLottery">ENTER MY2SURE</button>
                                    <p id="disableBtn"></p>
                                </div>

                                <input type="hidden" id="auth" value="{{Auth()->user()}}"/>
                                <input type="hidden" id="playbit" value="{{$playbit}}"/>
                                <input type="hidden" id="current_day" value="{{$current_day}}"/>
                            </div>
                        </div><!-- single-body end -->

                    </div>
                </div>

                <div class="col-lg-12">

                    <div class="col-md-12 text-center" style="margin-bottom: 22px;">
                        <h1 style="text-align:center">{{$titles->result_section}}</h1>
                    </div>
                    <table id="dtBasicExample" class="table table-borderless table-sm" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="th-sm">Name </th>
                            <th class="th-sm">Points</th>
                            <th class="th-sm">Ranks</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        @foreach($objUsers as $objUser)
                            <tr>
                                <td>{{$objUser->name}}</td>
                                <td>
                                    <a href="{{route('client.giveawaydetail',['id'=>$objUser->user_id])}}">{{$objUser->totalpoints}}</a>
                                </td>
                                <td>
                                    <b>
                                        @if($objUser->totalpoints != 0)

                                            {{$i}}

                                        @endif
                                    </b>
                                </td>
                            </tr>
                                <?php $i++; ?>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-12">
                    <div class="row justify-content-center ">
                        <div class="col-md-12 text-center" style="margin-bottom: 22px;">
                            <h1 style="text-align:center">Comments</h1>
                        </div>
                        <div class="col-md-12">
                            <div class="card p-3">
                                @if(Auth()->user() != '')
                                    <div class="card-body card rounded shadow">
                                        <h5>Leave a comment</h5>
                                        <br>
                                        <form method="post"
                                              action="{{ route('comment.store') }}">
                                            @csrf
                                            <div class="d-flex align-content-center">
                                                <div class="form-group flex-grow-2 mr-2 mb-0">
                                                    <input type="text"
                                                           name="comment"
                                                           class="form-control w-100 " required/>
                                                    <input type="hidden"
                                                           name="post_id"
                                                           value="{{ $post->id }}" />
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input type="submit"
                                                           CLASS="btn btn-primary py-2"
                                                           style="font-size: 0.8em;"
                                                           value="Add Comment" />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <br>
                                    <br>
                                @endif
                                <div class="card-body commentsbody card shadow border-0" id="bodycomment">
                                    @include('client.games.replys', ['comments' => $post->comments, 'post_id' => $post->id])
                                    <hr />
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- single-categories-play-section end -->

    <!-- overview-section start -->
    <section class="overview-section section-padding border-top section-bg" style="display:none">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-header text-center">
                        <h2 class="section-title">Quick overview</h2>
                        <p>Basic Guide for Casuals looking to step up how to get started </p>
                    </div>
                </div>
            </div>
            <div class="row m-bottom-not-30">
                <div class="col-lg-4 col-md-6">
                    <div class="overview-item text-center">
                        <div class="icon"><img src="{{asset('assets/images/svg-icons/overview-icons/1.svg')}}" alt="icon"></div>
                        <div class="content">
                            <h3 class="title">How to Play</h3>
                            <p>Select 5 numbers between 1-50 and two Lucky Stars from 1-12. Complete as many entries as you like and click the green ‘continue’ button to complete your transaction.Sit back and wait for the results. Good luck!</p>
                            <a href="#0">Go to Results page</a>
                        </div>
                    </div>
                </div><!-- overview-item end -->
                <div class="col-lg-4 col-md-6">
                    <div class="overview-item text-center">
                        <div class="icon"><img src="{{asset('assets/images/svg-icons/overview-icons/2.svg')}}" alt="icon"></div>
                        <div class="content">
                            <h3 class="title">Why play with Us</h3>
                            <p>It’s the most popular draw in Europe and it has earned its reputation with good reason. Sit back and  wait for the results. We are providing the most updated.  Complete as many entries as you like and click the green. Good luck!</p>
                            <a href="#0">See Prize breakdown</a>
                        </div>
                    </div>
                </div><!-- overview-item end -->
                <div class="col-lg-4 col-md-6">
                    <div class="overview-item text-center">
                        <div class="icon"><img src="{{asset('assets/images/svg-icons/overview-icons/3.svg')}}" alt="icon"></div>
                        <div class="content">
                            <h3 class="title">When’s the draw?</h3>
                            <p>We are aware of the fact that up-to-date and reliable lottery draw results are very important to each player. Complete as many entries as you like and click the green. We are providing the most updated lottery draw.</p>
                            <a href="#0">Go to FAQs</a>
                        </div>
                    </div>
                </div><!-- overview-item end -->
            </div>
        </div>
    </section>
    <!-- overview-section end -->

    @push('scripts')
        <script>

            // $( document ).ready(function() {
            //     $('#bodycomment').scrollTop($('#bodycomment')[0].scrollHeight);

            // });

            let starttime = '{{ date("M d, Y H:i:s",strtotime($objGame->end_date))}}';
            var clock = $('.clock').FlipClock(new Date(starttime), {
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
                let key = "{{$objGame->id}}";
                if(checkForButton(key) == true)
                {
                    NotUsable();
                }
            });

            function lottogame(id)
            {
                var auth = $('#auth').val();
                var playbit = $('#playbit').val();
                var current_day = $('#current_day').val();

                if(auth != '')
                {
                    if(playbit == 1)
                    {
                        if(current_day != 'Sun')
                        {
                            var count = $(".checked").length;
                            if(count <= 1)
                            {
                                $('#checked_'+id).addClass('checked');
                                $.ajax({
                                    type:'GET',
                                    url:'{{route("client.giveawayadd")}}',
                                    data:{id:id},
                                    success:function(data) {

                                    }
                                });

                            }else{

                                $("#disableBtn").html("You have to Wait For the Next day");
                                $("#btnLottery").addClass('disabled');
                                alert("You have to Wait For the Next day");
                            }
                        }else{

                            alert("You can only play from Monday to Saturday");

                        }
                    }else {

                        alert("You can only play from 6am to 7pm");
                    }
                }
                else
                {
                    alert("Login Please");
                }

            }
            $( document ).ready(function() {
                var count = $(".checked").length;
                if(count <= 1)
                {

                }
                else
                {
                    $("#disableBtn").html("You have to Wait For the Next day");
                    $("#btnLottery").addClass('disabled');

                }});

            function playtomorrow()
            {
                var count = $(".checked").length;

                if(count <= 1)
                {

                }
                else
                {
                    $("#disableBtn").html("You have to Wait For the Next day");
                    $("#btnLottery").addClass('disabled');
                    alert("Points will be displayed at 9 pm.");
                    window.location.reload();

                }
            }
        </script>


    @endpush
@endsection
