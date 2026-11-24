<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6 col-md-6">
                    <div class="header-top-left d-flex">
                        <div class="language-part">
                            <i class="fa fa-globe"></i>
                            <select>
                                <option>Eng</option>

                            </select>
                        </div>
                        <div class="support-part">
                            <!-- <p>TIME <=date('d/m/Y h:i:s a');?></p> -->
                            <a href="tel:{{app()->make("objSetting")->firstWhere('name', 'phone')->detail}}"><i class="fa fa-headphones"></i>Support</a>
                        </div>
                        <div class="email-part">
                            <a href="mailto:{{app()->make("objSetting")->firstWhere('name', 'email')->detail}}"><i class="fa fa-envelope"></i>{{app()->make("objSetting")->firstWhere('name', 'email')->detail}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="header-top-right">

                        @guest
                            <div class="pull-right">
                                <a href="{{route('login')}}" title="Login to Your Account">Login</a>
                            </div>
                            @if (Route::has('register'))
                                <div class="pull-right">
                                    &nbsp;   | &nbsp;
                                </div>
                                <div class="pull-right">
                                    <a href="{{route('register')}}" title="Register Your Account">Register</a>
                                </div>
                            @endif


                        @else
                            <div class="pull-right">
                                <a  href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                            <div class="pull-right">
                                &nbsp;   - &nbsp;
                            </div>
                            <div class="pull-right">
                                <a href="{{route('home')}}" title="You are Logged in"> {{ Auth::user()->name }}</a>
                            </div>

                        @endguest
                            <div class="pull-right" style="margin-right: 12px;">
                                <style>
                                    .cl-toggle-switch {
                                        position: relative;
                                    }

                                    .cl-switch {
                                        position: relative;
                                        display: inline-block;
                                    }
                                    /* Input */
                                    .cl-switch > input {
                                        appearance: none;
                                        -moz-appearance: none;
                                        -webkit-appearance: none;
                                        z-index: -1;
                                        position: absolute;
                                        right: 6px;
                                        top: -8px;
                                        display: block;
                                        margin: 0;
                                        border-radius: 50%;
                                        width: 40px;
                                        height: 40px;
                                        background-color: rgb(0, 0, 0, 0.38);
                                        outline: none;
                                        opacity: 0;
                                        transform: scale(1);
                                        pointer-events: none;
                                        transition: opacity 0.3s 0.1s, transform 0.2s 0.1s;
                                    }
                                    /* Track */
                                    .cl-switch > span::before {
                                        content: "";
                                        float: right;
                                        display: inline-block;
                                        margin: 5px 0 5px 10px;
                                        border-radius: 7px;
                                        width: 36px;
                                        height: 14px;
                                        background-color: rgb(0, 0, 0, 0.38);
                                        vertical-align: top;
                                        transition: background-color 0.2s, opacity 0.2s;
                                    }
                                    /* Thumb */
                                    .cl-switch > span::after {
                                        content: "";
                                        position: absolute;
                                        top: 2px;
                                        right: 16px;
                                        border-radius: 50%;
                                        width: 20px;
                                        height: 20px;
                                        background-color: #fff;
                                        box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
                                        transition: background-color 0.2s, transform 0.2s;
                                    }
                                    /* Checked */
                                    .cl-switch > input:checked {
                                        right: -10px;
                                        background-color: #85b8b7;
                                    }

                                    .cl-switch > input:checked + span::before {
                                        background-color: #85b8b7;
                                    }

                                    .cl-switch > input:checked + span::after {
                                        background-color: #018786;
                                        transform: translateX(16px);
                                    }
                                    /* Hover, Focus */
                                    .cl-switch:hover > input {
                                        opacity: 0.04;
                                    }

                                    .cl-switch > input:focus {
                                        opacity: 0.12;
                                    }

                                    .cl-switch:hover > input:focus {
                                        opacity: 0.16;
                                    }
                                    /* Active */
                                    .cl-switch > input:active {
                                        opacity: 1;
                                        transform: scale(0);
                                        transition: transform 0s, opacity 0s;
                                    }

                                    .cl-switch > input:active + span::before {
                                        background-color: #8f8f8f;
                                    }

                                    .cl-switch > input:checked:active + span::before {
                                        background-color: #85b8b7;
                                    }
                                    /* Disabled */
                                    .cl-switch > input:disabled {
                                        opacity: 0;
                                    }

                                    .cl-switch > input:disabled + span::before {
                                        background-color: #ddd;
                                    }

                                    .cl-switch > input:checked:disabled + span::before {
                                        background-color: #bfdbda;
                                    }

                                    .cl-switch > input:checked:disabled + span::after {
                                        background-color: #61b5b4;
                                    }
                                </style>
{{--                                <div class="cl-toggle-switch">--}}
{{--                                    <label class="cl-switch">--}}
{{--                                        <input type="checkbox" id="theme-switcher-checkbox">--}}
{{--                                        <span></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <nav class="navbar navbar-expand-xl">
                <a class="site-logo site-title" href="{{route('client.index')}}"><img src="{{ asset('assets/images/logo.png')}}" alt="site-logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu ml-auto">
                        <li><a href="{{route('client.index')}}">Home</a></li>
                        <li><a href="{{route('client.about')}}">About</a>
                        <li class=""><a href="{{route('client.games.index')}}">All Games</a>
                        </li>

                        <li class=""><a href="{{route('client.giveaway')}}">2Sure Competition</a>
                        </li>
{{--                        <li><a href="{{route('client.play')}}">How To Play</a>--}}
                        <li><a href="{{route('client.shop')}}">Shop</a>
                        <li><a href="{{route('client.contact')}}">Contact </a></li>
                    </ul>
                    <div class="header-join-part">
                        @guest


                        @else
                            @if(Auth()->user()->type == "admin")
                                <a type="button" class="cmn-btn"   href="{{route('admin.general.index')}}">Backend</a>
                            @else

                                <a type="button" class=" d-block mx-1 cmn-btn"   href="{{route('home')}}">Dashboard</a>

                            @endif
                        @endguest
                    </div>
                </div>
            </nav>
        </div>
    </div><!-- header-bottom end -->
</header>

<script>
    window.onload = function () {
        const themeSwitcher = document.getElementById("theme-switcher-checkbox");
        const body = document.body;

        // Function to toggle the theme based on the checkbox state
        function toggleTheme() {
            if (themeSwitcher.checked) {
                body.classList.add("main-dark-version");
            } else {
                body.classList.remove("main-dark-version");
            }

            // Persist the theme choice in localStorage
            localStorage.setItem("theme", themeSwitcher.checked ? "dark" : "light");
        }

        // Add event listener for checkbox changes
        themeSwitcher.addEventListener("change", toggleTheme);

        // Check for previously selected theme in localStorage
        const savedTheme = localStorage.getItem("theme");

        // Apply the saved theme on page load if available
        if (savedTheme === "dark") {
            themeSwitcher.checked = true;
            toggleTheme();
        }
    };
</script>
