<!-- Static navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">MyAncestralScotland</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url('/search') }}"><span class="glyphicon glyphicon-search"></span> Search</a>
                </li>
                <li>
                    <a href="{{url('/about')}}">About</a>
                </li>
                <li>
                    <a href="{{url('/FAQs')}}">FAQ</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (!Auth::check())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Sign Up</a></li>
                @else
                    @if(Auth::user()->type === 'admin')
                        <li><a href="{{ url('/admin/adminMain') }}"> Overview</a></li>
                    @elseif(Auth::user()->type === 'visitor' && App\Visitor::where('user_id',Auth::user()->user_id)->first()->member == 0)
                        <li><a href="{{ url('/profile/dashboard') }}">My Profile</a></li>
                    @else
                        <li><a href="{{ url('/profile/dashboard/messages') }}"><span
                                        class="glyphicon glyphicon-envelope"></span> Messages
                                <sup> {{ \MessagesHelper::getNumberOfUnreadMessages(Auth::User()) }}</sup></a></li>
                        <li><a href="{{ url('/profile/dashboard') }}">My Profile</a></li>
                    @endif
                    <li><a href="{{ url('/logout') }}">Logout</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

