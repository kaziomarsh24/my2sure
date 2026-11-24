@extends('layouts.app')

@section('content') 
@endsection
 
@extends('client.layout')

@section('content') 

      <!-- inner-page-banner start -->
   <style type="text/css">
     .btn{
      color: #ffffff;
      font-size: 20px;
      font-family: "SegoeUI-Semibold";
      border: 2px solid;
      border-radius: 45px;
      padding: 9px 30px;
      display: inline-block;
      text-transform: capitalize;
      transition: all .3s;
      background-color: #34b5f7;
     }
   </style>

  <!-- affiliate-section start -->
       
      <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
 
      </div>
    </section>
    <!-- affiliate-section end -->


@endsection

@push('scripts')
<script>
    var clock = $('.clock').FlipClock(99000 * 24 * 3, {
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