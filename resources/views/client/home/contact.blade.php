@extends('client.layout')
@section('title')
    Contact
@endsection
@section('meta_description', 'Need help with your lottery winning strategies? Contact My2Sure support for expert guidance, VIP plan inquiries, and personalized lottery winning tips in Nigeria and Ghana.')
@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap');

        /* Modern Contact Wrapper */
        .modern-contact-wrapper {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 40px 100px rgba(0,0,0,0.08);
            margin-bottom: 40px;
            display: flex;
            flex-wrap: wrap;
        }

        /* Form Area - Left Side */
        .modern-contact-form-area {
            flex: 1 1 60%;
            padding: 60px 50px;
            background: #ffffff;
        }

        .modern-contact-form-area .title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 42px;
            color: #0d1f35;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .modern-contact-form-area p {
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            color: rgba(0,0,0,0.5);
            margin-bottom: 30px;
            max-width: 90%;
        }

        .modern-form-grp {
            margin-bottom: 20px;
        }

        .modern-form-grp input,
        .modern-form-grp textarea {
            width: 100%;
            background: #f5f7fa;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 16px 20px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            color: #0d1f35;
            outline: none;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .modern-form-grp textarea {
            min-height: 150px;
            resize: vertical;
        }

        .modern-form-grp input:focus,
        .modern-form-grp textarea:focus {
            border-color: rgba(52, 181, 247, 0.5);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(52, 181, 247, 0.08);
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #34b5f7, #1a8fd1);
            border: none;
            border-radius: 10px;
            padding: 16px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 22px;
            letter-spacing: 2px;
            color: #ffffff;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 24px rgba(52, 181, 247, 0.25);
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(52, 181, 247, 0.4);
        }

        /* Address / Info Area - Right Side */
        .modern-address-area {
            flex: 1 1 40%;
            padding: 60px 50px;
            background: linear-gradient(145deg, #1a6fa8 0%, #34b5f7 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .modern-address-area::before {
            content: 'CONNECT';
            position: absolute;
            bottom: -20px;
            right: -20px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 140px;
            color: rgba(255,255,255,0.06);
            line-height: 1;
            pointer-events: none;
            user-select: none;
        }

        .modern-address-area .title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 32px;
            color: #ffffff;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .modern-address-area span {
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: rgba(255,255,255,0.8);
            display: block;
            margin-bottom: 40px;
        }

        /* Social Buttons */
        .social-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .social-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border-radius: 10px;
            color: #ffffff !important;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none !important;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
        }

        .social-btn:hover {
            transform: translateX(6px);
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Keep brand colors visible on icons */
        .social-btn.facebook i  { color: #1877f2; text-shadow: 0 0 5px rgba(24, 119, 242, 0.5); }
        .social-btn.twitter i   { color: #1da1f2; text-shadow: 0 0 5px rgba(29, 161, 242, 0.5); }
        .social-btn.google i    { color: #ea4335; text-shadow: 0 0 5px rgba(234, 67, 53, 0.5); }
        .social-btn.instagram i { color: #e6683c; text-shadow: 0 0 5px rgba(230, 104, 60, 0.5); }
        .social-btn.linkedin i  { color: #0077b5; text-shadow: 0 0 5px rgba(0, 119, 181, 0.5); }
        .social-btn.youtube i   { color: #ff0000; text-shadow: 0 0 5px rgba(255, 0, 0, 0.5); }
        .social-btn i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        /* Success Message */
        .alert-success-custom {
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            color: #2e7d32;
            padding: 15px 20px;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            margin-bottom: 20px;
            display: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modern-contact-wrapper {
                flex-direction: column;
            }
            .modern-contact-form-area,
            .modern-address-area {
                padding: 40px 30px;
            }
        }
    </style>

    <section class="inner-page-banner has_bg_image" data-background="{{asset('assets/images/inner-page-bg.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-page-banner-area">
                        <h1 class="page-title">Contact Us</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('client.index')}}">Home</a></li>
                                <li class="breadcrumb-item active">Contact us</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        @include('client.slider')
    </section>

    <section class="contact-section pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="modern-contact-wrapper">

                        <div class="modern-contact-form-area">
                            <div id="contactSuccess" class="alert-success-custom">
                                <strong>Success!</strong> Your email client has been opened. Please press Send to complete your message.
                            </div>

                            <h3 class="title">Get In Touch</h3>
                            <p>If you have any questions or queries, our helpful support team will be more than happy to assist.</p>

                            <form id="contactForm">
                                <div class="modern-form-grp">
                                    <input type="text" name="name" id="name" placeholder="Full Name" required autocomplete="name">
                                </div>
                                <div class="modern-form-grp">
                                    <input type="email" name="email" id="email" placeholder="Email Address" required autocomplete="email">
                                </div>
                                <div class="modern-form-grp">
                                    <input type="text" name="phone" id="phone" placeholder="Phone Number" required autocomplete="tel">
                                </div>
                                <div class="modern-form-grp">
                                    <input type="text" name="subject" id="subject" placeholder="Your Subject" required>
                                </div>
                                <div class="modern-form-grp">
                                    <textarea name="message" id="message" placeholder="How can we help you?" required></textarea>
                                </div>
                                <div class="modern-form-grp">
                                    <button class="btn-submit" type="submit">Send Message</button>
                                </div>
                            </form>
                        </div>

                        <div class="modern-address-area">
                            <div class="address-area-header">
                                <h3 class="title">We Are Available</h3>
                                <span>24 Hours A Day, 365 Days A Year</span>
                            </div>

                            <div class="contact-address mt-4">
                                <h3 class="title">Connect With Us</h3>
                                <div class="social-buttons">
                                    @if(!empty($social_links[0]->facebook))
                                        <a href="{{$social_links[0]->facebook}}" target="_blank" class="social-btn facebook">
                                            <i class="fa fa-facebook"></i> Facebook
                                        </a>
                                    @endif
                                    @if(!empty($social_links[0]->twitter))
                                            <a href="{{$social_links[0]->twitter}}" target="_blank" class="social-btn twitter">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" style="width:14px; height:14px; margin-right:6px;"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.259 5.622 5.905-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg> X
                                            </a>
                                    @endif
                                    @if(!empty($social_links[0]->google))
                                        <a href="{{$social_links[0]->google}}" target="_blank" class="social-btn google">
                                            <i class="fa fa-google-plus"></i> Google+
                                        </a>
                                    @endif
                                    @if(!empty($social_links[0]->instagram))
                                        <a href="{{$social_links[0]->instagram}}" target="_blank" class="social-btn instagram">
                                            <i class="fa fa-instagram"></i> Instagram
                                        </a>
                                    @endif
                                    @if(!empty($social_links[0]->linkedin))
                                        <a href="{{$social_links[0]->linkedin}}" target="_blank" class="social-btn linkedin">
                                            <i class="fa fa-linkedin"></i> LinkedIn
                                        </a>
                                    @endif
                                    @if(!empty($social_links[0]->youtube))
                                        <a href="{{$social_links[0]->youtube}}" target="_blank" class="social-btn youtube">
                                            <i class="fa fa-youtube"></i> YouTube
                                        </a>
                                    @endif
                                    @if(!empty($social_links[0]->tiktok))
                                        <a href="{{$social_links[0]->tiktok}}" target="_blank" class="social-btn tiktok">
                                            <img src="{{asset('assets/images/tiktok.png')}}" style="width:18px; filter:brightness(0) invert(1); margin-left: 3px; margin-right: 3px;"> TikTok
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('client.partials.footer_buttons')
    <div class="map-section" style="height: 220px; background: #eef2f5;"></div>
@endsection

@push('scripts')
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var name    = document.getElementById('name').value;
            var email   = document.getElementById('email').value;
            var phone   = document.getElementById('phone').value;
            var subject = document.getElementById('subject').value;
            var message = document.getElementById('message').value;

            var recipient = 'my2sure@gmail.com'; // ← replace with your email

            var body =
                'Name: '    + name    + '%0D%0A' +
                'Email: '   + email   + '%0D%0A' +
                'Phone: '   + phone   + '%0D%0A%0D%0A' +
                'Message:%0D%0A' + encodeURIComponent(message);

            window.location.href = 'mailto:' + recipient +
                '?subject=' + encodeURIComponent(subject) +
                '&body=' + body;

            document.getElementById('contactSuccess').style.display = 'block';
            document.getElementById('contactForm').reset();
        });

        if ($('.clock').length) {
            var clock = $('.clock').FlipClock(1200 * 24 * 3, {
                clockFace: 'DailyCounter',
                countdown: true
            });
        }

        jQuery(document).ready(function() {
            if (jQuery('#vmap').length) {
                jQuery('#vmap').vectorMap({
                    map: 'world_en',
                    color: '#eaedef',
                    backgroundColor: '#f7fcff',
                    hoverOpacity: 0.8,
                    selectedColor: '#eaedef',
                    scaleColors: ['#f7fcff', '#f7fcff'],
                    normalizeFunction: 'polynomial'
                });
            }
        });
    </script>
@endpush
