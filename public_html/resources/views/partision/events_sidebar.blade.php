<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->
<!-- [ navigation menu ] start -->

@if (isset($cust_theme_bg) && $cust_theme_bg == 'on')
    <nav class="dash-sidebar light-sidebar transprent-bg scroll-active">
    @else
        <nav class="dash-sidebar light-sidebar scroll-active">
@endif

<div class="navbar-wrapper" style="overflow: auto">
    <div class="m-header">
        <a href="#" class="b-brand">
            <!-- ========   change your logo hear   ============ -->
            {{-- <img src="{{isset($company_logo) && !empty($company_logo) ? $company_logo : $logo.'/logo-dark.svg'}}" alt="" class="logo logo-lg" /> --}}
            <img src="{{ asset('assets/images/Company/' . config('app.company_logo_name')) }}" class="logo-light"
                alt="logo">
        </a>
    </div>
    <div class="navbar-content">
        <ul class="dash-navbar" >

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('useradmin.event_dashboard') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="dash-mtext">{{ __('Overview') }}</span>
                    </a>
                </li>
            @endif
            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('useradmin.events.calender') }}" class="dash-link">
                        <span class="dash-micon"><i class="far fa-calendar-alt"></i></span>
                        <span class="dash-mtext">{{ __('Calendar') }}</span>
                    </a>
                </li>
            @endif
            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('useradmin.viewemployee') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-user"></i></span>
                        <span class="dash-mtext">{{ __('Employees') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu
                        {{ Route::is('useradmin.events.agent_list') ||
                        Route::is('useradmin.events.create_agent') ||
                        Route::is('useradmin.events.edit_agent') ||
                        Route::is('useradmin.events.agent_ticket_sale') ||
                        Route::is('useradmin.events.agent_paymants')
                            ? ' active dash-trigger'
                            : '' }}">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="fas fa-users"></i>
                        </span><span class="dash-mtext">{{ __('Agents') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu
                          {{ Route::is('useradmin.events.agent_list') ||
                          Route::is('useradmin.events.create_agent') ||
                          Route::is('useradmin.events.edit_agent') ||
                          Route::is('useradmin.events.agent_ticket_sale') ||
                          Route::is('useradmin.events.agent_paymants')
                              ? ' show'
                              : '' }}">

                        <li class="dash-item {{ Route::is('useradmin.events.agents_list') ? 'active' : '' }}">
                        <li
                            class="dash-item {{ (Route::is('useradmin.events.agents_list') || Route::is('useradmin.events.create_agent') || Route::is('useradmin.events.edit_agent')) && URL::previous() === route('useradmin.events.agents_list') ? 'active' : '' }}">
                            <a href="{{ route('useradmin.events.agents_list') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('List ') }}</span>
                            </a>
                        </li>
                        <li class="dash-item {{ Route::is('useradmin.events.agent_ticket_sale') ? 'active' : '' }}">
                        <li
                            class="dash-item {{ Route::is('useradmin.events.agent_ticket_sale') && URL::previous() === route('useradmin.events.agent_ticket_sale') ? 'active' : '' }}">
                            <a href="{{ route('useradmin.events.agent_ticket_sale') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('Ticket Sale ') }}</span>
                            </a>
                        </li>
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="" class="dash-link">
                                <span class="dash-mtext">{{ __('Payments') }}</span>
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu
                        {{ Route::is('useradmin.events.event_create') ||
                        Route::is('useradmin.events.event_edit') ||
                        Route::is('useradmin.events.events_list') ||
                        Route::is('useradmin.events.category') ||
                        Route::is('useradmin.agenda.view') ||
                        Route::is('useradmin.agenda.add') ||
                        Route::is('useradmin.agenda.edit')
                            ? 'active dash-trigger'
                            : '' }}">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-layout-2"></i>
                        </span><span class="dash-mtext">{{ __('Events') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu
                        {{ Route::is('useradmin.events.event_create') ||
                        Route::is('useradmin.events.events_list') ||
                        Route::is('useradmin.events.category') ||
                        Route::is('useradmin.agenda.view') ||
                        Route::is('useradmin.agenda.add') ||
                        Route::is('useradmin.agenda.edit')
                            ? 'show'
                            : '' }}">
                        <li class="dash-item {{ Route::is('useradmin.events.event_create') ? 'active' : '' }}">
                            <a href="{{ route('useradmin.events.event_create') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('Create ') }}</span>
                            </a>
                        </li>
                        <li class="dash-item {{ Route::is('useradmin.events.events_list') ? 'active' : '' }}">
                        <li
                            class="dash-item {{ (Route::is('useradmin.events.events_list') || Route::is('useradmin.events.event_edit')) && URL::previous() === route('useradmin.events.events_list') ? 'active' : '' }}">
                            <a href="{{ route('useradmin.events.events_list') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('List ') }}</span>
                            </a>
                        </li>
                        <li
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
                        </li>
                         <li
                            class="dash-item {{ (Route::is('useradmin.ticket.mark') ) ? 'active' : '' }}">
                            <a href="{{ route('useradmin.ticket.mark') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('Mark ') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif



            {{-- manager --}}
            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu
                    {{ Route::is('useradmin.viewmanager') ? 'active dash-trigger' : '' }}">
                    <a href="#!" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-users"></i></span>
                        <span class="dash-mtext">{{ __('Managers') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu
                        {{ Route::is('useradmin.viewmanager') ? 'show' : '' }}">
                        <li class="dash-item {{ Route::is('useradmin.viewmanager') ? 'active' : '' }}">
                            <a href="{{ route('useradmin.viewmanager') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('List') }}</span>
                            </a>
                        </li>

                    </ul>
                </li>
            @endif






            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="fas fa-music"></i>
                        </span><span class="dash-mtext">{{ __('Artists') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.events.artist') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('List') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="fas fa-handshake"></i>
                        </span><span class="dash-mtext">{{ 'Sponsors' }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.events.sponsor.list') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('List') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-id-badge"></i></span>
                        <span class="dash-mtext">{{ __('Tickets') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.events.ticket.list') }}" class="dash-link">
                                <span class="dash-mtext">{{ 'List' }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-gift"></i></span>
                        <span class="dash-mtext">{{ __('Coupons') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.events.ticket.coupon.list') }}" class="dash-link">
                                <span class="dash-mtext">{{ 'List' }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="fas fa-money-bill"></i>
                        </span><span class="dash-mtext">{{ __('Transactions') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.events.transaction') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('List') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="fas fa-users"></i>
                        </span><span class="dash-mtext">{{ __('Users') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.events.user_list') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('List') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
            <li class="dash-item dash-hasmenu
            {{ Route::is('useradmin.task_templates.index') ||
            Route::is('useradmin.events.task.index')
                ? 'active dash-trigger'
                : '' }}">
                <a href="#!" class="dash-link ">
                    <span class="dash-micon"><i class="fas fa-tasks"></i>
                    </span><span class="dash-mtext">{{ __('Task Manage') }}</span>
                    <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                </a>
                <ul
                    class="dash-submenu
                    {{ Route::is('useradmin.task_templates.index') ||
                    Route::is('useradmin.events.task.index')
                        ? 'show'
                        : '' }}">
                    <li
                        class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                        <a href="{{ route('useradmin.task_templates.index') }}" class="dash-link">
                            <span class="dash-mtext">{{ __('Templates') }}</span>
                        </a>
                    </li>
                    <li
                        class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                        <a href="{{ route('useradmin.events.task.index') }}" class="dash-link">
                            <span class="dash-mtext">{{ __('Event Task Manage') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-users"></i></span>
                        <span class="dash-mtext">{{ __('Teams') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.events.team') }}" class="dash-link">
                                <span class="dash-mtext">{{ 'List' }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-chess"></i></span>
                        <span class="dash-mtext">{{ __('Strategies') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.strategies.index') }}" class="dash-link">
                                <span class="dash-mtext">{{ 'List' }}</span>
                            </a>
                        </li>
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.strategies.view') }}" class="dash-link">
                                <span class="dash-mtext">{{ 'View' }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
</nav>
<!-- [ navigation menu ] end -->
