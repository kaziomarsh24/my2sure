<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <li class="mt">
                <a class="active" href="{{route('admin.general.index')}}">
                    <i class="fa fa-dashboard"></i>
                    <span>General</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-desktop"></i>
                    <span>slider</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('admin.slider.index')}}">All Sliders</a></li>
                    <li><a href="{{route('admin.slider.create')}}">Add New</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-desktop"></i>
                    <span>Games</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('admin.games.index')}}">All Games</a></li>
                    <li><a href="{{route('admin.games.create')}}">Add New</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-desktop"></i>
                    <span>Shop</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('admin.shop.index')}}">All products</a></li>
                    <li><a href="{{route('admin.shop.create')}}">Add New</a></li>
                    <li><a href="{{route('admin.orders')}}">Orders</a></li>
                    <li><a href="{{route('admin.transactions')}}">Transactions</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-book"></i>
                    <span>Lotteries</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('admin.lottery.index')}}">All Loteries</a></li>
                    <li><a href="{{route('admin.lottery.create')}}">Add New</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-book"></i>
                    <span>Plans</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('admin.plans.index')}}">All Plans</a></li>
{{--                    <li><a href="{{route('admin.plans.create')}}">Add New</a></li>--}}
                    <li><a href="{{route('admin.source_plan')}}">Add Source Plan</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-book"></i>
                    <span>Members</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('admin.users.index')}}">All Members</a></li>
                    <li><a href="{{route('admin.users.create')}}">Add New</a></li>
                    <li><a href="{{route('admin.bulkEmail')}}">Send Bulk Email</a></li>
                    <li><a href="{{route('admin.users.prediction')}}">All prediction</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-book"></i>
                    <span>GiveAway</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('admin.giveaway.index')}}">Points Settings</a></li>
                    <li><a href="{{ route('admin.comments.index') }}">Manage 2sure Comments</a></li>
                    <li><a href="{{route('admin.title.index')}}">Title</a></li>
                    <li><a href="{{ route('admin.socialMediaLinksedit', ['id' => 1]) }}">Social media link Settings</a></li>            </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-credit-card"></i>
                    <span>Subscriptions</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('admin.subscriptions.index') }}">All Subscriptions</a></li>
                    <li><a href="{{ route('admin.subscriptions.create') }}">Add Manual</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-trophy"></i>
                    <span>Winners</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('admin.winners.index') }}">All Winners</a></li>
                    <li><a href="{{ route('admin.users.prediction') }}">Mark Winners</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-trophy"></i>
                    <span>Result Posts</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('admin.board.result.index')}}">All Posts</a></li>
                    <li><a href="{{route('admin.board.result.create')}}">Add New</a></li>
                    <li><a href="{{route('admin.board.result.comments')}}">Manage Comments</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-star"></i>
                    <span>VIP Room Posts</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('admin.board.vip.index')}}">All Posts</a></li>
                    <li><a href="{{route('admin.board.vip.create')}}">Add New</a></li>
                    <li><a href="{{route('admin.board.vip.comments')}}">Manage Comments</a></li>
                </ul>
            </li>

            <!-- <li class="sub-menu">
              <a href="javascript:;">
                <i class="fa fa-book"></i>
                <span>Extra Pages</span>
                </a>
              <ul class="sub">
                <li><a href="blank.html">Blank Page</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="lock_screen.html">Lock Screen</a></li>
                <li><a href="profile.html">Profile</a></li>
                <li><a href="invoice.html">Invoice</a></li>
                <li><a href="pricing_table.html">Pricing Table</a></li>
                <li><a href="faq.html">FAQ</a></li>
                <li><a href="404.html">404 Error</a></li>
                <li><a href="500.html">500 Error</a></li>
              </ul>
            </li>
            <li class="sub-menu">
              <a href="javascript:;">
                <i class="fa fa-tasks"></i>
                <span>Forms</span>
                </a>
              <ul class="sub">
                <li><a href="form_component.html">Form Components</a></li>
                <li><a href="advanced_form_components.html">Advanced Components</a></li>
                <li><a href="form_validation.html">Form Validation</a></li>
                <li><a href="contactform.html">Contact Form</a></li>
              </ul>
            </li>
            <li class="sub-menu">
              <a href="javascript:;">
                <i class="fa fa-th"></i>
                <span>Data Tables</span>
                </a>
              <ul class="sub">
                <li><a href="basic_table.html">Basic Table</a></li>
                <li><a href="responsive_table.html">Responsive Table</a></li>
                <li><a href="advanced_table.html">Advanced Table</a></li>
              </ul>
            </li>
            <li>
              <a href="inbox.html">
                <i class="fa fa-envelope"></i>
                <span>Mail </span>
                <span class="label label-theme pull-right mail-info">2</span>
                </a>
            </li>
            <li class="sub-menu">
              <a href="javascript:;">
                <i class=" fa fa-bar-chart-o"></i>
                <span>Charts</span>
                </a>
              <ul class="sub">
                <li><a href="morris.html">Morris</a></li>
                <li><a href="chartjs.html">Chartjs</a></li>
                <li><a href="flot_chart.html">Flot Charts</a></li>
                <li><a href="xchart.html">xChart</a></li>
              </ul>
            </li>
            <li class="sub-menu">
              <a href="javascript:;">
                <i class="fa fa-comments-o"></i>
                <span>Chat Room</span>
                </a>
              <ul class="sub">
                <li><a href="lobby.html">Lobby</a></li>
                <li><a href="chat_room.html"> Chat Room</a></li>
              </ul>
            </li>
            <li>
              <a href="google_maps.html">
                <i class="fa fa-map-marker"></i>
                <span>Google Maps </span>
                </a>
            </li> -->
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
