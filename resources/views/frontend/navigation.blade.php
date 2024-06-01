<!-- Navigation panel -->
<nav class="main-nav stick-fixed">
    <div class="container-1400 relative clearfix">
        <!-- Logo ( * your text or image into link tag *) -->
        <div class="nav-logo-wrap local-scroll">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ Helpers::getsingleimage('header_section_1') }}" alt="TNSACS" />
            </a>
        </div>

        <div class="inner-nav-logo">
            <div class="me-4"><img src="{{ Helpers::getsingleimage('header_section_2') }}"></div>
            <div class="me-4"><img src="{{ Helpers::getsingleimage('header_section_3') }}"></div>
            <div><img src="{{ Helpers::getsingleimage('header_section_4') }}"></div>
        </div>
        
    </div>
</nav>
<!-- End Navigation panel -->

<nav class="main-menu">
    <div class="container-1400 relative clearfix">
        <div class="mobile-nav" role="button" tabindex="0">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Menu</span>
        </div>
        
        <!-- Main Menu -->
        <div class="inner-nav desktop-nav">
            <ul class="mainmenu">
                <li><a href="{{ url('/modules') }}">Modules</a></li>
                <li><a href="{{ url('/certificates') }}">Certificates</a></li>
                <li><a href="{{ url('mobile-app') }}">Mobile App</a></li>
                <li><a href="{{ url('contact-uss') }}">Contact Us</a></li>
            </ul>
            @if(Auth::check())
                <ul class="admincta">
                    <li><a href="{{ url('logout') }}"><span class="btn btn-mod btn-color btn-circle btn-medium">Logout</span></a></li>
                </ul>
            @else
                <ul class="admincta">
                    <li><a href="{{ url('signin') }}"><span class="btn btn-mod btn-color btn-circle btn-medium">Login</span></a></li>
                </ul>
            @endif
        </div>
        <!-- End Main Menu -->
    </div>
</nav>