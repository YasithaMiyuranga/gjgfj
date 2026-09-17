@php
    $currantLang = Auth::user()->lang ?? 'en';
    $user = Auth::user();
@endphp

<header class="dash-header {{ isset($cust_theme_bg) && $cust_theme_bg == 'on' ? 'transprent-bg' : '' }}">
    <div class="header-wrapper">
        <div class="dash-mob-drp w-100">
            <ul class="list-unstyled w-100 justify-content-between justify-content-lg-start">
                {{-- Mobile Hamburger --}}
                <li class="dash-h-item mob-hamburger">
                    <a href="#!" class="dash-head-link" id="mobile-collapse">
                        <div class="hamburger hamburger--arrowturn">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                </li>

                {{-- Desktop Hamburger --}}
                <li class="dash-h-item dsk-hamburger dis-none">
                    <a href="#!" class="dash-head-link">
                        <div class="hamburger hamburger--arrowturn">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                </li>

                {{-- Desktop Back Arrow --}}
                <li class="dash-h-item dsk-back-arrow dis-none">
                    <a href="#!" class="dash-head-link">
                        <div class="hamburger hamburger--arrowturn is-active">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                </li>

                {{-- User Dropdown --}}
                <li class="dropdown dash-h-item drp-company">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="theme-avtar">
                            <img alt="#" style="width:30px;"
                                src="{{ asset(Auth::guard('agent')->user()->profile_image ?? 'assets/images/profile/Avatar.png') }}"
                                class="header-avtar">
                        </span>
                        <span class="hide-mob ms-2">
                            @if (!Auth::guest())
                                {{ __('Hi, ') }}{{ Auth::guard('agent')->user()->name ?? '' }}!
                            @else
                                {{ __('Guest') }}
                            @endif
                        </span>
                        <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown">
                        <a href="{{ route('agent.profile') }}" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span>{{ __('Profile') }}</span>
                        </a>
                        <form method="POST" action="{{ route('agent.logout') }}" id="form_logout">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); document.getElementById('form_logout').submit();" class="dropdown-item">
                                <i class="ti ti-power"></i>
                                <span>{{ __('Log Out') }}</span>
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="ms-auto">
            {{-- Additional Right-Side Content --}}
        </div>
    </div>
</header>
