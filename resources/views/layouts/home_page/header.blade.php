<!-- Header Start -->
<header>
    <div class="top_bar" style="background: rgba(0,0,0,0.2); padding: 2px 0;">
        <div class="container">
            <ul class="top_links" style="display: flex; gap: 20px; list-style: none; padding: 0; margin: 0;">
                <li><a href="{{ url('/login') }}" style="color: #fff; font-size: 13px; font-weight: 500;">Admin login</a></li>
                <li><a href="{{ url('/login') }}" style="color: #fff; font-size: 13px; font-weight: 500;">Teacher login</a></li>
                <li><a href="{{ url('/login') }}" style="color: #fff; font-size: 13px; font-weight: 500;">School login</a></li>
            </ul>
        </div>
    </div>
    <!-- container start -->
    <div class="container">
        <!-- navigation bar -->
        <nav class="navbar navbar-expand-lg" style="padding-top: 5px;">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/web-site-images/logo.png') }}" alt="image" style="width: 200px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                    <!-- <i class="icofont-navigation-menu ico_menu"></i> -->
                    <div class="toggle-wrap">
                        <span class="toggle-bar"></span>
                    </div>
                </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <!-- secondery menu start -->

                    <li class="nav-item has_dropdown">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <!-- secondery menu end -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#features') }}">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about-us') }}">About Us</a>
                    </li>
                    <!-- secondery menu start -->

                    <!-- secondery menu end -->

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pricing') }}">Pricing</a>
                    </li>

                    <!-- secondery menu start -->

                    <!-- secondery menu end -->

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact-us') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dark_btn" href="{{ route('onboarding') }}">GET STARTED</a>
                    </li>
                </ul>

            </div>
        </nav>
        <!-- navigation end -->
    </div>
    <!-- container end -->
</header>