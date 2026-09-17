{{-- @php
    $currantLang = \Auth::user()->lang;
    if ($currantLang == null) {
        $currantLang = 'en';
    }
    $user = \Auth::user();
    /*  $current_store = \App\Models\Store::where('id', $user->current_store)->first(); */
@endphp --}}

@if (isset($cust_theme_bg) && $cust_theme_bg == 'on')
    <header class="dash-header transprent-bg">
    @else
        <header class="dash-header">
@endif
<div class="header-wrapper">
    <div class="me-auto dash-mob-drp">
        <ul class="list-unstyled">
            <li class="dash-h-item mob-hamburger">
                <a href="#!" class="dash-head-link" id="mobile-collapse">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="dash-h-item dsk-hamburger">
                <a href="#!" class="dash-head-link">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="dash-h-item dsk-back-arrow">
                <a href="#!" class="dash-head-link">
                    <div class="hamburger hamburger--arrowturn is-active">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="dropdown dash-h-item drp-company">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="theme-avtar">
                        <img alt="#" style="width:30px;"
                            src="{{ !empty(Auth::guard('admin')->user()->profile_image) ? asset(Auth::guard('admin')->user()->profile_image) : asset('assets/images/profile/Avatar.png') }}"
                            class="header-avtar">

                    </span>
                    <span class="hide-mob ms-2">
                        @if (!Auth::guest())
                            {{ __('Hi, ') }}{{ !empty(Auth::guard('admin')->user()) ? Auth::guard('admin')->user()->name : '' }}!
                        @else
                            {{ __('Guest') }}
                        @endif
                    </span>
                    <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                </a>
                <div class="dropdown-menu dash-h-dropdown">

                    <a href="{{ route('useradmin.profile') }}" class="dropdown-item">
                        <i class="ti ti-user"></i>
                        <span>{{ __('Profile') }}</span>
                    </a>
                    <form method="POST" action="{{ route('useradmin.logout') }}" id="form_logout">
                        <a href="route('useradmin.logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">
                            <i class="ti ti-power"></i>
                            @csrf
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="ms-auto">

    </div>
</div>
</header>
