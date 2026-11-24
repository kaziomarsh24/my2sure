@extends('client.layout')
@section('title')
{{$objGame->name}} Generate Random Numbes for Lottery - Lottery Forecasters
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
@endpush
@section('content')
  <!-- inner-page-banner start -->
  <section class="inner-page-banner has_bg_image" data-background="{{asset('assets/images/inner-page-bg.jpg')}}">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="inner-page-banner-area">
            <h1 class="page-title">{{$objGame->name}}</h1>
            <nav aria-label="breadcrumb" class="page-header-breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('client.index')}}">Home</a></li>
                <li class="breadcrumb-item active">{{$objGame->name}} </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
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
                  <h3 class="title">{{$objGame->name}}</h3>
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

          </div>
        </div>

        <div class="col-lg-12">
         <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th class="th-sm">1st Selected Number

                  </th>
                  <th class="th-sm">2nd Selected Number

                  </th>
                  <th class="th-sm">Points

                  </th>
                  <th class="th-sm">Date

                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach($objPoints as $objPint)
                <tr>
                  <td>{{$objPint->value}}</td>
                  <td>{{$objPint->value2}}</td>
                  <td>
                      {{$objPint->points}}
                  </td>
                  <td>
                      {{date('d-m-Y', strtotime($objPint->date))}}
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th class="th-sm">1st Selected Number

                  </th>
                  <th class="th-sm">2nd Selected Number

                  </th>
                  <th class="th-sm">Points

                  </th>
                  <th class="th-sm">Date

                  </th>
                </tr>
              </tfoot>
            </table>
        </div>
      </div>
    </div>
  </section>
  <!-- single-categories-play-section end -->

  <!-- overview-section start -->
  <section class="overview-section section-padding border-top section-bg">
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

                  }
                  else
                  {
                    $("#disableBtn").html("You have to Wait For the Next day");
                    $("#btnLottery").addClass('disabled');
                    alert("You have to Wait For the Next day");
                  }
              }
              else
              {
                  alert("You can only play from Monday to Saturday");
              }
          }
          else
          {
              alert("You can only play from 12 am to 7 pm");
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
