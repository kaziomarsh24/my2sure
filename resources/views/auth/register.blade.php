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

            <div class="col-lg-8">

                <div class="section-header text-center">

                    <div class="col-md-12"><h2 class="section-title">{{ __('Register') }}</h2></div>

                    <hr/>

                    <div class="col-md-12">

                        <form method="POST" action="{{ route('register_user') }}">

                            @csrf





                            <div class="form-group row">

                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>



                                <div class="col-md-6">

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>



                                    @error('name')

                                    <span class="invalid-feedback" role="alert">

<strong>{{ $message }}</strong>

</span>

                                    @enderror

                                </div>

                            </div>



                            <div class="form-group row">

                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>



                                <div class="col-md-6">

                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">



                                    @error('email')

                                    <span class="invalid-feedback" role="alert">

<strong>{{ $message }}</strong>

</span>

                                    @enderror

                                </div>

                            </div>



                            <div class="form-group row">

                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>



                                <div class="col-md-6">

                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">



                                    @error('password')

                                    <span class="invalid-feedback" role="alert">

<strong>{{ $message }}</strong>

</span>

                                    @enderror

                                </div>

                            </div>



                            <div class="form-group row">

                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>



                                <div class="col-md-6">

                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                </div>

                            </div>



                            <div class="form-group row">

                                <label for="email" class="col-md-4 col-form-label text-md-right">Referral Code</label>



                                <div class="col-md-6">



                                    <input type="text" class="form-control @error('from_ref_code') is-invalid @enderror" name="from_ref_code" value="{{ $from_ref_code == "" ? "ADMIN" : $from_ref_code }}" placeholder="Enter Referral Code">

                                    @error('from_ref_code')

                                    <span class="invalid-feedback" role="alert">

<strong>{{ $message }}</strong>

</span>

                                    @enderror

                                </div>

                            </div>

                            <div class="form-group row mb-0">

                                <div class="col-md-6 offset-md-4">

                                    <button type="submit" class="btn btn-primary">

                                        {{ __('Register') }}

                                    </button>

                                </div>

                            </div>

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
