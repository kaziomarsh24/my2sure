
<footer class="footer-section mb-5">
    <div class="pb-4">
        <div class="footer-top border-top border-bottom has_bg_image" data-background="assets/images/bg-four.jpg">
            <div class="footer-top-first">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-5 col-sm-4 text-center text-sm-left">
                            <a href="{{route('client.index')}}" class="site-logo"><img src="{{ asset('assets/images/logo.png')}}" alt="logo"></a>
                        </div>
                        <div class="col-lg-6 col-md-7 col-sm-8">
                            <div class="number-count-part d-flex">
                                <div class="number-count-item">
                                    @if ($socialMediaLinks !== null )
                                        <span class="number">{{number_format($socialMediaLinks->total_users)}}</span>
                                        <h3>Total Members</h3>
                                    @endif

                                </div>
                                {{--                  <div class="number-count-item">--}}
                                {{--                    <span class="number">1,9402,575</span>--}}
                                {{--                    <p>TOTAL winner</p>--}}
                                {{--                  </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" d-none footer-top-second">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6">
                            <div class="footer-widget widget-about">
                                <h3 class="widget-title">About My2Sure</h3>
                                <ul class="footer-list-menu">
                                    <li><a href="#0">About us</a></li>
                                    <li><a href="#0">How it Works</a></li>
                                    <li><a href="#0">Contact us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6">
                            <div class="footer-widget widget-links">
                                <h3 class="widget-title">Quick links</h3>
                                <ul class="footer-list-menu">
                                    <li><a href="#0">Terms & Conditions</a></li>
                                    <li><a href="#0">Privacy Policy</a></li>
                                    <li><a href="#0">My2Sure Licenses</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="footer-widget widget-subscribe">
                                <h3 class="widget-title">email newsletters</h3>
                                <div class="subscribe-part">
                                    <p>Subscribe now and receive weekly newsletter for latest draw and offer news and much more!</p>
                                    <form class="subscribe-form">
                                        <input type="email" name="subs_email" id="subs_email" placeholder="Email address">
                                        <input type="submit" value="subscribe">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6 col-sm-7">
                        <div class="copy-right-text">
                            <p>© <?=date('Y')?> <a href="{{route('client.index')}}">My2Sure Limited</a> - All Rights Reserved.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-5">
                        <ul class="footer-social-links d-flex justify-content-end">

                            @if ($socialMediaLinks !== null )
                                @if($socialMediaLinks->facebook !="")
                                    <li><a target="_blank" href="{{ $socialMediaLinks->facebook}}"><i class="fa fa-facebook fa-2x"></i></a></li>
                                @endif
                                @if($socialMediaLinks->twitter !="")
                                    <li><a target="_blank" href="{{ $socialMediaLinks->twitter}}"><i class="fa fa-twitter fa-2x"></i></a></li>
                                @endif
                                @if($socialMediaLinks->google !="")

                                    <li><a target="_blank" href="{{ $socialMediaLinks->google}}"><i class="fa fa-google-plus fa-2x"></i></a></li>
                                @endif
                                @if($socialMediaLinks->instagram !="")
                                    <li><a target="_blank" href="{{ $socialMediaLinks->instagram}}"><i class="fa fa-instagram fa-2x"></i></a></li>
                                @endif
                                @if($socialMediaLinks->linkedin !="")
                                    <li><a target="_blank" href="{{ $socialMediaLinks->linkedin}}"><i class="fa fa-linkedin fa-2x"></i></a></li>
                                @endif
                                @if($socialMediaLinks->youtube !="")
                                    <li><a target="_blank" href="{{ $socialMediaLinks->youtube}}"><i class="fa fa-youtube fa-2x"></i></a></li>
                                @endif
                                @if($socialMediaLinks->tiktok !="")
                                    <li><a target="_blank" href="{{ $socialMediaLinks->tiktok}}"><img src="{{ asset('assets/images/tiktok.png') }}"></a></li>
                                @endif
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div style="position: relative">
    <div style="position: fixed; width: 100%; bottom: -5px;">
        <marquee class="m-0 py-3 px-2" bgcolor="Yellow" direction="left" loop="">
            @if ($socialMediaLinks !== null )
                <p class="m-0 h1 font-weight-bold" style="display: inline-block;">{{$socialMediaLinks->notification}}</p>
            @endif
        </marquee>
    </div>
</div>


