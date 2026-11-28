<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from pixner.net/My2Sure/My2Sure/home-one.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 25 May 2020 20:36:13 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @php
        $default_desc = "The Best Lottery Forecaster In Africa. Take The Chance To Change Your Life. Use Our Premium Forecasting Website To Increase Your Chance Of Receiving Winning Numbers For Lottery Games In Nigeria, Ghana And Africa.";
        $current_url = url()->current();
    @endphp
    <title>@yield('title') - {{app()->make("objSetting")->firstWhere('name', 'site_title')->detail}}</title>
    
    <meta name="description" content="@yield('meta_description', $default_desc)">
    
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ str_replace('https://my2sure.com', 'https://www.my2sure.com', $current_url) }}">
    <meta property="og:title" content="@yield('title') - {{app()->make("objSetting")->firstWhere('name', 'site_title')->detail}}">
    <meta property="og:description" content="@yield('meta_description', $default_desc)">
    <meta property="og:image" content="{{ asset('assets/images/logo.png') }}">

    <!-- Schema.org Markup -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "My2Sure Limited",
      "url": "https://www.my2sure.com",
      "logo": "https://my2sure.com/assets/images/logo.png",
      "description": "{{ $default_desc }}",
      "email": "my2sure@gmail.com",
      "sameAs": ["https://www.tiktok.com/@my2sure.com"],
      "areaServed": ["Nigeria", "Ghana", "West Africa"],
      "contactPoint": {
        "@type": "ContactPoint",
        "contactType": "customer support",
        "email": "my2sure@gmail.com"
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "My2Sure",
      "url": "https://www.my2sure.com",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://my2sure.com/games?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>

    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @stack('meta')

    <!-- site favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/favicon.html')}}">
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css')}}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <!-- non-critical plugin css loaded asynchronously -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css')}}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('assets/css/lightcase.css')}}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('assets/slick/css/slick.css')}}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('assets/slick/css/slick-theme.css')}}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css')}}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('assets/css/flipclock.css')}}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('assets/css/jqvmap.min.css')}}" media="print" onload="this.media='all'">
    <!-- main style css link -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
    <!-- responsive css link -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">

    <!-- paypal -->
    <script defer src="https://www.paypal.com/sdk/js?client-id=AWyK3T8QAfiWEClAnnw10oSLjBcmljlJhFN1_fKOtyVlj_90CuYImu687-Rwhsh-JLS1HzhZQwT8maCc&currency=USD&disable-funding=card,credit,sepa,giropay,sofort">
    </script>
{{--    <script src="https://www.paypal.com/sdk/js?client-id=AYEAtszqFLBb8JwGTRRUPqK6tn6o-6dVV4sFho-pArw4XxK8siXSR2eKPHkoedxYXFodDaqisgF1JSBc&currency=USD&disable-funding=card,credit,sepa,giropay,sofort">--}}
{{--    </script>--}}


    @stack('styles')
</head>
<body>



<div class="main-light-version">
    <!--  header-section start  -->
    @include('client.header')
    <!--  header-section end  -->
    <!--login registration Modal -->
    <div class="modal fade login-registration-modal" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="login-registration-area">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="registration-tab" data-toggle="tab" href="#registration" role="tab" aria-controls="registration" aria-selected="false">Registration</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                <form class="login-form cmn-frm">
                                    <div class="frm-group">
                                        <label>Username or Email Address</label>
                                        <input type="email" name="login_email" id="login_email" placeholder="Username or Email Address">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="frm-group">
                                        <label>Password</label>
                                        <input type="password" name="login_pass" id="login_pass" placeholder="Enter Password">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                    <div class="frm-group">
                                        <input type="submit" name="registration_submit2" id="registration_submit2" value="login">
                                    </div>
                                    <div class="frm-group">
                                        <div class="checkbox-area">
                                            <input type="checkbox" id="login_remember_pass">
                                            <label for="login_remember_pass">Remember Password</label>
                                        </div>
                                        <div class="forgot-pass-area">
                                            <a href="#0">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <div class="frm-group">
                                        <div class="or-text">
                                            <span>Or login with</span>
                                        </div>
                                    </div>
                                    <div class="frm-group">
                                        <div class="login-with-area">
                                            <a href="#" class="facebook"><i class="fa fa-facebook-f"></i>facebook</a>
                                            <a href="#" class="google"><i class="fa fa-google-plus"></i>facebook</a>
                                            <a href="#" class="twitter"><i class="fa fa-twitter"></i>facebook</a>
                                        </div>
                                    </div>
                                </form>
                                <div class="have-not-account">
                                    <p>You don’t have an account?<a href="#0">Register Now</a></p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="registration" role="tabpanel" aria-labelledby="registration-tab">
                                <form class="registration-form cmn-frm">
                                    <div class="frm-group">
                                        <label>Username or Email Address</label>
                                        <input type="email" name="registration_email" id="registration_email" placeholder="Username or Email Address">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="frm-group">
                                        <label>Password</label>
                                        <input type="password" name="registration_pass" id="registration_pass" placeholder="Enter Password">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                    <div class="frm-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="registration_re_pass" id="registration_re_pass" placeholder="Enter Password">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                    <div class="frm-group">
                                        <input type="submit" name="registration_submit" id="registration_submit" value="Registration">
                                    </div>
                                    <div class="frm-group">
                                        <div class="checkbox-area">
                                            <input type="checkbox" id="registration_remember_pass">
                                            <label for="registration_remember_pass">I Agree with the Terms of Use</label>
                                        </div>
                                        <div class="forgot-pass-area">
                                            <a href="#0">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <div class="frm-group">
                                        <div class="or-text">
                                            <span>Or login with</span>
                                        </div>
                                    </div>
                                    <div class="frm-group">
                                        <div class="login-with-area">
                                            <a href="#" class="facebook"><i class="fa fa-facebook-f"></i>facebook</a>
                                            <a href="#" class="google"><i class="fa fa-google-plus"></i>facebook</a>
                                            <a href="#" class="twitter"><i class="fa fa-twitter"></i>facebook</a>
                                        </div>
                                    </div>
                                </form>
                                <div class="have-not-account">
                                    <p>Already have an account?<a href="#0">Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <!-- footer-section start -->
    @include('client.footer')
    <!-- footer-section end -->

</div>

<!-- scroll-to-top start -->
{{--  <div class=" scroll-to-top">--}}
{{--    <span class="scroll-icon">--}}
{{--      <i class="fa fa-angle-up"></i>--}}
{{--    </span>--}}
{{--  </div>--}}
<!-- scroll-to-top end -->

<!-- jquery library js file -->
<script src="{{ asset('assets/js/jquery-3.3.1.min.js')}}"></script>
<!-- bootstrap js file -->
<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<!-- flipclock js file -->
<script src="{{ asset('assets/js/flipclock.min.js')}}"></script>
<!-- countdown js file -->
<script src="{{ asset('assets/js/jquery.countdown.min.js')}}"></script>
<!-- slick js file -->
{{--  <script src="{{ asset('assets/js/slick.min.js')}}"></script>--}}
<script src="{{ asset('assets/slick/js/jquery-migrate-1.2.1.min.js')}}"></script>
<script src="{{ asset('assets/slick/js/slick.js')}}"></script>

<!-- swiper js file -->
<script src="{{ asset('assets/js/swiper.min.js')}}"></script>
<!-- lightcase js file -->
<script src="{{ asset('assets/js/lightcase.js')}}"></script>
<!-- wow js file -->
<script src="{{ asset('assets/js/wow.min.js')}}"></script>
<!-- vamp js files -->
<script src="{{ asset('assets/js/jquery.vmap.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.vmap.world.js')}}"></script>
<!-- main script js file -->
<script src="{{ asset('assets/js/main.js')}}"></script>


@stack('scripts')

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/64b9769e94cf5d49dc64da26/1h5q7emqo';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
{{--slick slider--}}
<script>
    // $('.responsive').slick({
    //     dots: true,
    //     arrows: true,
    //     infinite: true,
    //     autoplay: true,
    //     autoplaySpeed: 1500,
    //     speed: 1500,
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     adaptiveHeight: false,
    //     prevArrow: '<button type="button" class="slick-prev"></button>',
    //     nextArrow: '<button type="button" class="slick-next"></button>',
    // });

</script>
</body>

</html>
