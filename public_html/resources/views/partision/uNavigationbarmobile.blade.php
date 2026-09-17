<div class="offcanvas offcanvas-top" id="navContentmenu" data-bs-backdrop="static" tabindex="-1">
    <div class="offcanvas-header">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
        <a class="navbar-brand" href="/" aria-label="nav-brands"><img
                src="{{ asset('assets/images/Company/4zeroeventslogo.png') }}" alt="logo"></a>
        @if (session('cart') && count(session('cart')) > 0)
        <div class="icon d-flex d-md-none">
            <a href="{{ route('cart.show') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="bi bi-cart3" viewBox="0 0 16 16">
                    <path fill="#ffffff" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
            </a>
        </div>
        @endif
    </div>
    <div class="offcanvas-body d-flex justify-content-center">
        <ul class="navbar-nav custom-navbar-nav mb-2 mb-lg-0">
            <li class="nav-item" data-bs-dismiss="offcanvas">
                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="/" aria-label="nav-links">Home</a>
            </li>
            <li class="nav-item" data-bs-dismiss="offcanvas">
                <a class="nav-link {{ request()->is('Packages') ? 'active' : '' }}" href="/Packages" aria-label="nav-links">Packages</a>
            </li>
            {{-- <li class="nav-item dropdown offcanvas-pages-dropdown">
                <a class="nav-link dropdown-toggle" href="#" aria-label="nav-links" data-bs-toggle="dropdown"
                    aria-expanded="false">Pages</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="blog.html" target="_blank" aria-label="single-pages">Blog</a>
                    </li>
                    <li><a class="dropdown-item" href="blog-single-1.html" target="_blank"
                            aria-label="single-pages">Blog Single 1</a></li>
                    <li><a class="dropdown-item" href="blog-single-2.html" target="_blank"
                            aria-label="single-pages">Blog Single 2</a></li>
                    <li><a class="dropdown-item" href="blog-single-3.html" target="_blank"
                            aria-label="single-pages">Blog Single 3</a></li>
                    <li><a class="dropdown-item" href="about-us.html" target="_blank" aria-label="single-pages">About
                            Us</a></li>
                    <li><a class="dropdown-item" href="contact-us.html" target="_blank"
                            aria-label="single-pages">Contact Us</a></li>
                </ul>
            </li> --}}

            <li class="nav-item" data-bs-dismiss="offcanvas">
                <a class="nav-link {{ request()->is('Gallery') ? 'active' : '' }}" href="/Gallery" aria-label="nav-links">Gallery</a>
            </li>
            <li class="nav-item" data-bs-dismiss="offcanvas">
                <a class="nav-link {{ request()->is('Events') ? 'active' : '' }}" href="/Events" aria-label="nav-links">Events</a>
            </li>
            <li class="nav-item" data-bs-dismiss="offcanvas">
                <a class="nav-link {{ request()->is('Contact') ? 'active' : '' }}" href="/Contact" aria-label="nav-links">Contact Us</a>
            </li>
            <li class="nav-item" data-bs-dismiss="offcanvas">
                <a class="nav-link {{ request()->is('About') ? 'active' : '' }}" href="/About" aria-label="nav-links">About Us</a>
            </li>
            @guest
                <li class="nav-item">
                    <a class="nav-link  text-uppercase fw-semibold"  aria-label="nav-links" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link  text-uppercase fw-semibold" aria-label="nav-links" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                </li>
            @endguest
            {{-- check user login --}}
            @if (Auth::user())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-uppercase fw-semibold" href="$" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <form action="{{ route('user.profile') }}" >
                                @csrf
                                <button type="submit" class="dropdown-item">Profile</button>
                            </form>
                            {{-- <a class="dropdown-item" href="">Profile</a> --}}
                        </li>
                        <li>
                            <form action="{{ route('user.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @if (session('cart_'.Auth::user()->id) && is_countable(session('cart_'.Auth::user()->id)) && count(session('cart_'.Auth::user()->id)) > 0)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.show') }}" aria-label="nav-links">View Cart</a>
                    </li>
                @endif 
            @endif
        </ul>
    </div>
</div>
