@extends('client.layout')
@section('title',  __('Login')  )
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
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>

    <!-- inner-page-banner start -->
    <section class="inner-page-banner has_bg_image" data-background="{{asset('assets/images/inner-page-bg.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-page-banner-area">
                        <h1 class="page-title">{{ __('Login') }}</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('client.index')}}">Home</a></li>
                                <li class="breadcrumb-item active">{{ __('Login') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- inner-page-banner end -->

    <!-- - about-section start -->
    <section class="about-section section-padding">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-header text-center">
                    <div class="col-md-12"><h2 class="section-title">{{ __('Login') }}</h2></div>
                    <hr/>
                    <div class="col-md-12" >
                        <form method="POST" action="{{ route('login') }}" id="loginForm" autocomplete="off">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>

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
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('register'))
                                        <a class="btn" href="{{ route('register') }}" style="background-color: #28a745; margin-left: 10px;">
                                            {{ __('Register') }}
                                        </a>
                                    @endif

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('register') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
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
        // Simple solution to prevent auto submission and double clicks
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            let isSubmitting = false;

            loginForm.addEventListener('submit', function(e) {
                if (isSubmitting) {
                    e.preventDefault();
                    return false;
                }

                isSubmitting = true;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Logging in...';
            });

            // Prevent Chrome from auto-submitting on autofill
            let autofillTimer;
            const inputs = loginForm.querySelectorAll('input[type="email"], input[type="password"]');

            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    // Clear any existing timer
                    clearTimeout(autofillTimer);

                    // If Chrome tries to auto-submit, prevent it
                    autofillTimer = setTimeout(() => {
                        if (!isSubmitting) {
                            // Just reset the form state if needed
                            submitBtn.disabled = false;
                            submitBtn.textContent = '{{ __("Login") }}';
                        }
                    }, 100);
                });
            });
        });

        // Your existing scripts
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
