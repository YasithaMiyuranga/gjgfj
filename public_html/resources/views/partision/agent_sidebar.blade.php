<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->

<!-- [ navigation menu ] start -->
@if (isset($cust_theme_bg) && $cust_theme_bg == 'on')
    <nav class="dash-sidebar light-sidebar transparent-bg scroll-active">
@else
    <nav class="dash-sidebar light-sidebar scroll-active">
@endif
<div class="navbar-wrapper">
    <div class="m-header">
        <a href="/agent/dashboard" class="b-brand">
            <!-- ========   change your logo here   ============ -->
            <img src="{{ asset('assets/images/Company/' . config('app.company_logo_name')) }}" class="logo-light" alt="logo">
        </a>
    </div>
    <div class="navbar-content">
        <ul class="dash-navbar">
            @if (\Auth::guard('agent')->user())
                <!-- Overview -->
                <li class="dash-item {{ Request::routeIs('agent.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('agent.dashboard') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="dash-mtext">{{ __('Overview') }}</span>
                    </a>
                </li>

                <!-- Assigned Events -->
                <li class="dash-item {{ Request::routeIs('agent.viewevents') ? 'active' : '' }}">
                    <a href="{{ route('agent.events') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-calendar-alt"></i></span>
                        <span class="dash-mtext">{{ __('Assigned Events') }}</span>
                    </a>
                </li>

                <!-- Ticket Management -->
                <li class="dash-item {{ Request::routeIs('agent.tickets') ? 'active' : '' }}">
                    <a href="{{ route('agent.tickets') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-ticket-alt"></i></span>
                        <span class="dash-mtext">{{ __('Tickets') }}</span>
                    </a>
                </li>

                <!-- Profit Monitoring -->
                <li class="dash-item {{ Request::routeIs('agent.profit') ? 'active' : '' }}">
                    <a href="{{ route('agent.profit') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-chart-line"></i></span>
                        <span class="dash-mtext">{{ __('Profit') }}</span>
                    </a>
                </li>

                <!-- Customer Offers -->
                <li class="dash-item {{ Request::routeIs('agent.offers') ? 'active' : '' }}">
                    <a href="{{ route('agent.offers') }}" class="dash-link" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-gift"></i></span>
                        <span class="dash-mtext">{{ __('Customer Offers') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
</nav>
<!-- [ navigation menu ] end -->
