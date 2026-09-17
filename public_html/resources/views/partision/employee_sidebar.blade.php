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
            @if (\Auth::guard('employee')->user() )
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('employee.emp.empdashboard') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="dash-mtext">{{ ('Overview') }}</span>
                    </a>
                </li>
            @endif
            @if (\Auth::guard('employee')->user() )
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('employee.emp.viewcalendar') }}" class="dash-link">
                        <span class="dash-micon"><i class="far fa-calendar-alt"></i></span>
                        <span class="dash-mtext">{{ ('Calendar') }}</span>
                    </a>
                </li>
            @endif
            @if (\Auth::guard('employee')->user())
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-briefcase"></i></span>
                        <span class="dash-mtext">{{ ('Salary') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="dash-submenu {{ in_array(Request::segment(1), ['main-category', 'sub-category']) ? 'show' : '' }}">
                        <li class="dash-item {{ Request::segment(1) === 'app-setting' ? 'active' : '' }}">
                            <a href="{{ route('employee.emp.viewjobamount') }}" class="dash-link">
                                <span class="dash-mtext">{{ ('Job Amount') }}</span>
                            </a>
                        </li>
                        @if (\Auth::guard('employee')->user()->emp_type == "Permanent Employee")
                            <li class="dash-item {{ Request::segment(1) === 'app-setting' ? 'active' : '' }}">
                                <a href="{{ route('employee.emp.payments') }}" class="dash-link">
                                    <span class="dash-mtext">{{ ('Payments') }}</span>
                                </a>
                            </li>
                        @endif
                        <li class="dash-item {{ Request::segment(1) === 'app-setting' ? 'active' : '' }}">
                            <a href="{{ route('employee.emp.credits') }}" class="dash-link">
                                <span class="dash-mtext">{{ ('Credits') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (\Auth::guard('employee')->user() )
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('employee.emp.viewevents') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-layout-2"></i></span>
                        <span class="dash-mtext">{{ ('Events') }}</span>
                    </a>
                </li>
            @endif
            @if (\Auth::guard('employee')->user() )
                 <li class="dash-item dash-hasmenu
                    {{  Route::is('employee.emp.assign.rent') ||
                    Route::is('employee.emp.view.received.items') ||
                    Route::is('employee.emp.view.received.items.details')  ||
                    Route::is('employee.emp.rent.create') ||
                    Route::is('employee.emp.assign.rent.view')   ? ' active dash-trigger' : '' }}">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="fas fa-list"></i>
                        </span><span class="dash-mtext">{{ ('Rent') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu
                        {{  Route::is('employee.emp.assign.rent') ||
                        Route::is('employee.emp.view.received.items') ||
                        Route::is('employee.emp.rent.create') ||
                        Route::is('employee.emp.assign.rent.view')  ? ' show' : '' }}">

                        <li class="dash-item {{ Route::is('employee.emp.assign.rent') || (Route::is('employee.emp.assign.rent.view') ||  Route::is('employee.emp.rent.create') && URL::previous() === route('employee.emp.assign.rent')) ? 'active' : '' }}">
                            <a href="{{ route('employee.emp.assign.rent') }}" class="dash-link">
                                <span class="dash-mtext">{{ ('Sent Items ') }}</span>
                            </a>
                        </li>
                        <li class="dash-item {{ Route::is('employee.emp.view.received.items') || (Route::is('employee.emp.view.received.items.details') && URL::previous() === route('employee.emp.view.received.items')) ? 'active' : '' }}">
                            <a href="{{ route('employee.emp.view.received.items') }}" class="dash-link">
                                <span class="dash-mtext">{{ ('Received Items') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (\Auth::guard('employee')->user() )
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('employee.vacations') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-plane"></i></span>
                        <span class="dash-mtext">{{ ('Vacations') }}</span>
                    </a>
                </li>
            @endif
            @if (\Auth::guard('employee')->user() )
                <li
                class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{route('employee.taskmanage.employee.show')}}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-bars"></i></span>
                        <span class="dash-mtext">{{ ('Task Management') }}</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</div>
</nav>
<!-- [ navigation menu ] end -->
