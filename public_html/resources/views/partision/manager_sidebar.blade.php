<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->
<!-- [ navigation menu ] start -->
@if (isset($cust_theme_bg) && $cust_theme_bg == 'on')
    <nav class="dash-sidebar light-sidebar transprent-bg">
    @else
        <nav class="dash-sidebar light-sidebar">
@endif
<div class="navbar-wrapper">
    <div class="m-header">
        <a href="#" class="b-brand">
            <!-- ========   change your logo hear   ============ -->
            {{-- <img src="{{isset($company_logo) && !empty($company_logo) ? $company_logo : $logo.'/logo-dark.svg'}}" alt="" class="logo logo-lg" /> --}}
            <img src="{{ asset('assets/images/Company/' . config('app.company_logo_name')) }}" class="logo-light" alt="logo">
        </a>
    </div>
    <div class="navbar-content">
        <ul class="dash-navbar">
            @if (\Auth::guard('manager')->user() )
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('manager.man.managerdashboard') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="dash-mtext">{{ ('Overview') }}</span>
                    </a>
                </li>
            @endif
            @if (\Auth::guard('manager')->user() )
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('manager.man.viewcalendar') }}" class="dash-link">
                        <span class="dash-micon"><i class="far fa-calendar-alt"></i></span>
                        <span class="dash-mtext">{{ ('Calendar') }}</span>
                    </a>
                </li>
            @endif
           

            @if (\Auth::guard('manager')->user())
                <li
                    class="dash-item dash-hasmenu
                        {{
                        Route::is('useradmin.events.events_list')
                            ? 'active dash-trigger'
                            : '' }}">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-layout-2"></i>
                        </span><span class="dash-mtext">{{ __('Events') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu
                        {{
                        Route::is('manager.events.events_list') 
                 
                            ? 'show'
                            : '' }}">
                        {{-- <li class="dash-item {{ Route::is('useradmin.events.event_create') ? 'active' : '' }}">
                            <a href="{{ route('manager.events.event_create') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('Create ') }}</span>
                            </a>
                        </li> --}}
                        <li class="dash-item {{ Route::is('manager.events.events_list') ? 'active' : '' }}">
                        <li
                            class="dash-item {{ (Route::is('manager.events.events_list'))  && URL::previous() === route('manager.events.events_list') ? 'active' : '' }}">
                            <a href="{{ route('manager.events.events_list') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('List ') }}</span>
                            </a>
                        </li>
                        {{-- <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.events.category') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('Category') }}</span>
                            </a>
                        </li>
                        <li class="dash-item {{ Route::is('useradmin.agenda.view') ? 'active' : '' }}">
                        <li
                            class="dash-item {{ (Route::is('useradmin.agenda.view') || Route::is('useradmin.agenda.add') || Route::is('useradmin.agenda.edit')) && URL::previous() === route('useradmin.agenda.view') ? 'active' : '' }}">
                            <a href="{{ route('useradmin.agenda.view') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('Agenda ') }}</span>
                            </a>
                        </li> --}}
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
</nav>
<!-- [ navigation menu ] end -->
