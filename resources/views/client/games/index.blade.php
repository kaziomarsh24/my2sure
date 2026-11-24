<?php
global $startTime_g;
global $endTime_g;
global $currentTime_g;

function getCurrentDay()
{
    return date('l');
}
function getCurrentTimeFormatted()
{
    return date("H:i");
}
function getMatchedSpecial($day, $time, $schedule)
{
    global $startTime_g;
    global $endTime_g;
    global $currentTime_g;

    $schedule = json_decode($schedule, true);
    if ($schedule === null) {
        return "Invalid schedule data";
    }
    foreach ($schedule as $slot) {
        $currentTime = date('H:i', strtotime($time));
        $startTime   = date('H:i', strtotime($slot['startTime']));

        if ($slot['endTime'] == '24:00') {
            $endTime = date('H:i', strtotime('23:59'));
        } else {
            $endTime = date('H:i', strtotime($slot['endTime']));
        }

        if ($currentTime >= $startTime && $currentTime <= $endTime) {
            $startTime_g   = $startTime;
            $endTime_g     = $endTime;
            $currentTime_g = $currentTime;

            if (isset($slot['days'][$day])) {
                return $slot['days'][$day];
            }
        }
    }
    return "No match found";
}

$schedule = $objGame->game->schedule;
$result   = getMatchedSpecial(getCurrentDay(), getCurrentTimeFormatted(), $schedule);
?>

@extends('client.layout')
@section('title')
    {{$objGame->name}} / {{$result}} Generate Random Numbers for Lottery - Lottery Forecasters
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
        .btn {
            color: #ffffff;
            font-size: 20px;
            font-family: "SegoeUI-Semibold";
            border: 2px solid;
            border-radius: 45px;
            padding: 9px 30px;
            display: inline-block;
            text-transform: capitalize;
            transition: all .3s;
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
        .reward-winner-msg {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            border: 1px solid rgba(191,149,63,0.4);
            border-radius: 12px;
            padding: 20px 30px;
            display: inline-block;
            margin-top: 16px;
            color: rgba(255,255,255,0.8);
            font-size: 15px;
        }
        .reward-winner-msg strong {
            color: #FCF6BA;
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
                        <h1 class="page-title">{{$objGame->name}} / {{$result}}</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('client.index')}}">Home</a></li>
                                <li class="breadcrumb-item active">{{$objGame->name}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- inner-page-banner end -->

    <section>
        @include('client.slider')
    </section>

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
                                    <h3 class="title">{{$objGame->name}}</h3>
                                    <span class="amount">{{$result}}</span>
                                </div>
                            </div>
                            <div class="d-none right text-right">
                                <span class="draw-days">Ends on {{date('d/M/Y')}}</span>
                            </div>
                        </div><!-- single-header end -->

                        <div class="single-body">
                            <div class="single-body-inner d-flex">
                                <div class="col-md-12 text-center" style="margin-bottom: 22px;"></div>

                                @for($j = 0; $j < $objGame->sets; $j++)
                                    <div class="col-md-12 QuizArea">
                                        <div class="text-left">
                                            <h5 style="text-transform: uppercase;">Set {{($j + 1)}}</h5>
                                        </div>
                                        <div class="text-center" id="balls_{{$j}}">
                                            @for($i = 0; $i < $objGame->permutation; $i++)
                                                <span class="result lotto-ball balls_{{$j}}" data-true='0'>?</span>
                                            @endfor
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Buttons area --}}
                        <div class="text-center mt-3">
                            <p id="disableBtn"></p>

                            @if($isWinner)
                                <div class="reward-winner-msg">
                                    <strong>Congratulations!</strong> You Received Winning Numbers From My2sure.com Now You Have To Reward To Receive Numbers For All Games
                                </div>
                                <button class="btn btn-lg btn-info" id="rewardBtn">
                                    Reward Now
                                </button>
                                <div id="rewardWaiting" style="display:none;" class="mt-3">
                                    <div class="spinner-border text-warning" role="status"></div>
                                    <span class="ml-2">Processing reward payment...</span>
                                </div>
                            @else
                                @if($result != "Invalid schedule data" && $result != "No match found")
                                    @if($canChoose)
                                        <button class="btn " style="background-color: #e74c3c;"
                                                onclick="checkAndRandomizeNumber({{$objGame->id}}, 10, 100)"
                                                id="btnLottery">
                                            Choose For Me
                                        </button>
                                    @else
                                        {{-- No active All Games subscription — send to payment, then back here --}}
                                        <a class="btn " style="background-color: #e74c3c;"
                                           href="{{ route('client.allgames.gate', ['game' => $objGame->id]) }}">
                                            Choose For Me
                                        </a>
                                    @endif
                                @endif
                            @endif

                            <div class="mt-3 d-flex justify-content-center">
                                <div>
                                    <a type="button" style="width: 100%" class="btn btn-lg my-2 btn-vip"
                                       href="{{route('client.vip.gate')}}">
                                         {{$settings->firstWhere('name', 'vip_button_label')->detail ?? 'VIP Room'}}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div><!-- single-cat-play-area end -->
                </div>
            </div>
        </div>
    </section>
    <!-- single-categories-play-section end -->

    @include('client.partials.footer_buttons')

@endsection

@push('scripts')
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>

        let starttime  = '{{ date("M d, Y H:i:s", strtotime($objGame->game->end_date)) }}';
        var start_time;
        var end_time;
        var current_time;

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

            let key      = "{{$objGame->id}}";
            start_time   = "{{$startTime_g}}";
            end_time     = "{{$endTime_g}}";
            current_time = "{{$currentTime_g}}";

            @if(!$isWinner)
            if (checkForButton(key) == true) {
                NotUsable();
            } else {
                Usable();
            }
            @endif
        });

        function unixto24hrs(timestamp) {
            const date    = new Date(timestamp);
            const hours   = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        function isCurrentTimeInSlot(current_time, start_time, end_time) {
            const currentTimeObj = new Date(current_time);
            const today          = new Date();

            if (
                currentTimeObj.getDate() === today.getDate() &&
                currentTimeObj.getMonth() === today.getMonth() &&
                currentTimeObj.getFullYear() === today.getFullYear()
            ) {
                const currentHours   = currentTimeObj.getHours();
                const currentMinutes = currentTimeObj.getMinutes();
                const startTimeArray = start_time.split(':');
                const endTimeArray   = end_time.split(':');
                const startHours     = parseInt(startTimeArray[0]);
                const startMinutes   = parseInt(startTimeArray[1]);
                const endHours       = parseInt(endTimeArray[0]);
                const endMinutes     = parseInt(endTimeArray[1]);

                if (
                    (currentHours > startHours || (currentHours === startHours && currentMinutes >= startMinutes)) &&
                    (currentHours < endHours   || (currentHours === endHours   && currentMinutes <= endMinutes))
                ) {
                    return true;
                }
            }
            return false;
        }

        const enableKey = 'MDR00L';
        var Count       = 0;
        const _userId   = '{{Auth()->user()->id}}';

        function NotUsable() {
            $("#disableBtn").html("You have to wait for the next game");
            $("#btnLottery").addClass('disabled');
            $("#btnLottery").attr("disabled", true);
        }

        function Usable() {
            $("#disableBtn").html("");
            $("#btnLottery").removeClass('disabled');
            $("#btnLottery").attr("disabled", false);
        }

        function checkAndRandomizeNumber(key, min, max) {
            if (checkForButton(key) == false) {
                RandomizeNumbers(key, min, max);
                var today = new Date();
                localStorage.setItem(enableKey + "." + key + "." + _userId, today);
                NotUsable();
            } else {
                alert('You have to wait for the next game');
            }
        }

        function RandomizeNumbers(key, min, max) {
            _usedNumbers = [];
            for (i = 0; i < 100; i++) {
                $(".lotto-ball").each(function() {
                    if ($(this).attr("data-true") == '0') {
                        $(this).html(getRandomizer(min, max));
                    }
                });
            }
            if (Count < 30) {
                setTimeout(function() { RandomizeNumbers(key, 1, 100); }, 50);
                Count++;
            } else {
                var totalSets       = '{{$objGame->sets}}';
                var selected_number = JSON.parse('{!! $selected_number !!}');
                let selectedNumbers = [];
                let k = parseInt(totalSets);

                for (let i = 0; i < k; i++) {
                    let arr = selected_number[i].split(",");
                    selectedNumbers.push(selected_number[i]);
                    let cc = 0;
                    $(".balls_" + i).each(function() {
                        if ($(this).attr("data-true") == '0') {
                            $(this).html(arr[cc]);
                            cc++;
                        }
                    });
                }

                Count = 0;

                $.post('{{route("client.games.savePlay")}}', {
                    '_token':  $('meta[name=csrf-token]').attr('content'),
                    gameId:    key,
                    game_name: `{{$result}}`,
                    numbers:   selectedNumbers
                });
            }
        }

        function getUnsedNumbers(num) {
            var getNum = num;
            let loop   = 1;
            while (loop > 0) {
                if (_usedNumbers.includes(getNum)) {
                    getNum = getRandomizer(0, (_Plans.length - 1));
                    if (loop > 10) { return getNum; }
                    loop++;
                } else {
                    _usedNumbers.push(getNum);
                    loop = 0;
                }
            }
            return getNum;
        }

        function getRandomizer(bottom, top) {
            return parseInt(Math.floor(Math.random() * (1 + top - bottom)) + bottom);
        }

        var _Plans       = <?= json_encode($objPlans) ?>;
        var _usedNumbers = [];

        function checkForButton(key) {
            let c = localStorage.getItem(enableKey + "." + key + "." + _userId);
            if (c == null) {
                return false;
            } else {
                let isInSlot = isCurrentTimeInSlot(c, start_time, end_time);
                clearLocalStorage(c, key);
                return isInSlot;
            }
        }

        function clearLocalStorage(c, key) {
            var date1 = new Date(c);
            var date2 = new Date();
            var Difference_In_Time = date2.getTime() - date1.getTime();
            var totalDays = Difference_In_Time / (1000 * 3600 * 24);
            if (totalDays >= 1) {
                localStorage.removeItem(enableKey + "." + key + "." + _userId);
            }
        }

        function lottogame() {
            alert("ok");
        }

        @if($isWinner)
        let flwPubKey    = "{{ config('services.flutterwave.public_key') }}";
        let baseRewardAmount = {{ $rewardAmount }};
        let userEmail    = "{{ Auth::user()->email }}";
        let userName     = "{{ Auth::user()->name }}";
        let lotteryId    = "{{ $objGame->id }}";

        $('#rewardBtn').click(function() {
            fetch('{{ route("detect.country") }}')
                .then(res => res.json())
                .then(data => {
                    let currency        = data.currency;
                    let rate            = data.rate;
                    let convertedAmount = parseFloat((baseRewardAmount * rate).toFixed(2));
                    openRewardPayment(currency, convertedAmount);
                })
                .catch(() => {
                    openRewardPayment('USD', baseRewardAmount);
                });
        });

        function openRewardPayment(currency, amount) {
            FlutterwaveCheckout({
                public_key: flwPubKey,
                tx_ref:     "reward-" + lotteryId + "-" + Date.now(),
                amount:     amount,
                currency:   currency,
                customer: {
                    email: userEmail,
                    name:  userName,
                },
                customizations: {
                    title:       "Reward Payment",
                    description: "Claim your winning reward",
                    logo:        "{{ asset('assets/images/logo.png') }}",
                },
                callback: function(response) {
                    if (response.status === "successful" || response.status === "completed") {
                        $('#rewardBtn').hide();
                        $('#rewardWaiting').show();

                        $.post('{{ route("client.reward.pay") }}', {
                            '_token':     $('meta[name=csrf-token]').attr('content'),
                            'lottery_id': lotteryId,
                            'payment_id': response.transaction_id,
                        }).done(function(data) {
                            if (data.status === 'success') {
                                alert('Reward claimed successfully! You can now play again.');
                                window.location.reload();
                            } else {
                                alert('Something went wrong. Please contact support.');
                                $('#rewardBtn').show();
                                $('#rewardWaiting').hide();
                            }
                        }).fail(function() {
                            alert('Something went wrong. Please try again.');
                            $('#rewardBtn').show();
                            $('#rewardWaiting').hide();
                        });
                    } else {
                        alert('Payment was not completed. Please try again.');
                    }
                },
                onclose: function() {
                    console.log('Reward payment popup closed');
                }
            });
        }
        @endif

    </script>
@endpush
