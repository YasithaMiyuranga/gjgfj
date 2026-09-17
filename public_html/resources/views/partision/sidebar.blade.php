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
<div class="navbar-wrapper">
    <div class="m-header">
        <a href="/useradmin/dashboard" class="b-brand">
            <!-- ========   change your logo hear   ============ -->
            {{-- <img src="{{isset($company_logo) && !empty($company_logo) ? $company_logo : $logo.'/logo-dark.svg'}}" alt="" class="logo logo-lg" /> --}}
            <img src="{{ asset('assets/images/Company/' . config('app.company_logo_name')) }}" class="logo-light"
                alt="logo">
        </a>
    </div>
    <div class="navbar-content">
        <ul class="dash-navbar">

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('useradmin.dashboard') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="dash-mtext">{{ __('Overview') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('useradmin.order.calendar') }}" class="dash-link">
                        <span class="dash-micon"><i class="far fa-calendar-alt"></i></span>
                        <span class="dash-mtext">{{ __('Calendar') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('useradmin.viewcustomer') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-user"></i></span>
                        <span class="dash-mtext">{{ __('Customers') }}</span>
                    </a>
                </li>


                {{-- @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li
                        class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                        <a href="{{ route('useradmin.viewemployee') }}" class="dash-link">
                            <span class="dash-micon"><i class="fas fa-users"></i></span>
                            <span class="dash-mtext">{{ __('Employees') }}</span>
                        </a>
                    </li>
                @endif --}}

                @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li
                        class="dash-item dash-hasmenu
                        {{ Route::is('useradmin.viewemployee') ||
                        Route::is('useradmin.emp.job.amount.view') ||
                        Route::is('useradmin.emp.salaryview') ||
                        Route::is('useradmin.emp.salary_pauments_view') ||
                        Route::is('useradmin.emp.credits.view') ||
                        Route::is('useradmin.emp.credits.edit') ||
                        Route::is('useradmin.emp.credits.create') ||
                        Route::is('useradmin.emp.salary.payment.create') ||
                        Route::is('useradmin.emp.job.amount.create') ||
                        Route::is('useradmin.emp.job.amount.event.create') ||
                        Route::is('useradmin.event.base.salaryview') ||
                        Route::is('useradmin.permissions.index') ||
                        Route::is('useradmin.permissions.create')
                            ? 'active dash-trigger'
                            : '' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="fas fa-users"></i></span>
                            <span class="dash-mtext">{{ __('Employees') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul
                            class="dash-submenu
                            {{ Route::is('useradmin.viewemployee') ||
                            Route::is('useradmin.emp.job.amount.view') ||
                            Route::is('useradmin.emp.salaryview') ||
                            Route::is('useradmin.emp.salary_pauments_view') ||
                            Route::is('useradmin.emp.credits.view') ||
                            Route::is('useradmin.emp.credits.edit') ||
                            Route::is('useradmin.emp.credits.create') ||
                            Route::is('useradmin.emp.salary.payment.create') ||
                            Route::is('useradmin.emp.job.amount.event.create') ||
                            Route::is('useradmin.emp.job.amount.create') ||
                            Route::is('useradmin.event.base.salaryview') ||
                            Route::is('useradmin.permissions.index')
                                ? 'show'
                                : '' }}">
                            <li class="dash-item {{ Route::is('useradmin.viewemployee') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.viewemployee') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Register') }}</span>
                                </a>
                            </li>
                            {{-- <li class="dash-item {{ Route::is('useradmin.emp.job.amount.view') ? 'active' : '' }}"> --}}
                            <li
                                class="dash-item {{ (Route::is('useradmin.emp.job.amount.view') || Route::is('useradmin.emp.job.amount.create') || Route::is('useradmin.emp.job.amount.event.create')) && (URL::previous() === route('useradmin.emp.job.amount.view') || URL::previous() === route('useradmin.order.calendar')) ? 'active' : '' }}">
                                <a href="{{ route('useradmin.emp.job.amount.view') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Job Amount') }}</span>
                                </a>
                            </li>
                            <li class="dash-item {{ Route::is('useradmin.emp.salaryview') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.emp.salaryview') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Salary') }}</span>
                                </a>
                            </li>
                            <li class="dash-item {{ Route::is('useradmin.event.base.salaryview') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.event.base.salaryview') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Event Base Salary') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ (Route::is('useradmin.emp.salary_pauments_view') || Route::is('useradmin.emp.salary.payment.create')) && URL::previous() === route('useradmin.emp.salary_pauments_view') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.emp.salary_pauments_view') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Payments') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ (Route::is('useradmin.emp.credits.view') || Route::is('useradmin.emp.credits.edit') || Route::is('useradmin.emp.credits.create')) && URL::previous() === route('useradmin.emp.credits.view') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.emp.credits.view') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Credits') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ (Route::is('useradmin.permissions.index') || Route::is('useradmin.permissions.create') || Route::is('useradmin.permissions.edit')) && URL::previous() === route('useradmin.permissions.index') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.permissions.index') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Permissions') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ Route::is('useradmin.vacations') || Route::is('useradmin.vacations.edit') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.vacations') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Vacations') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif








                @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li
                        class="dash-item dash-hasmenu
                        {{ (Route::is('useradmin.agreement_categories.index') ||
                        Route::is('useradmin.agreement_categories.create') ||
                        Route::is('useradmin.agreement_templates.edit') ||
                        Route::is('useradmin.agreement_templates.create') ||
                        Route::is('useradmin.show_agreement_employee') ||
                        Route::is('useradmin.agreement.view_event') ||
                        Route::is('useradmin.agreement.view') ||
                        Route::is('useradmin.agreement.edit') ||
                        Route::is('useradmin.agreement.generate_event') ||
                        Route::is('useradmin.agreement.edit_event') ||
                        Route::is('useradmin.agreement_templates.index') )
                            ? 'active dash-trigger'
                            : '' }}">

                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="fas fa-file-contract"></i></span>
                            <span class="dash-mtext">{{ __('Agreements') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul
                            class="dash-submenu
                            {{ Route::is('useradmin.agreement_categories.index') ||
                            Route::is('useradmin.agreement_categories.create') ||
                            Route::is('useradmin.agreement_templates.create') ||
                            Route::is('useradmin.show_agreement_employee') ||
                            Route::is('useradmin.agreement.view') ||
                            Route::is('useradmin.agreement.view_event') ||
                            Route::is('useradmin.agreement.edit') ||
                            Route::is('useradmin.agreement.generate_event') ||
                            Route::is('useradmin.agreement.edit_event') ||
                            Route::is('useradmin.agreement_templates.index')
                                ? 'active'
                                : '' }}">

                            <li class="dash-item {{ Route::is('useradmin.show_agreement_employee') || (Route::is('useradmin.agreement.view') || Route::is('useradmin.agreement.edit') && URL::previous() === route('useradmin.show_agreement_employee')) ? 'active' : '' }}">
                                <a href="{{ route('useradmin.show_agreement_employee') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Emp Agreements') }}</span>
                                </a>
                            </li>
                            <li class="dash-item {{ Route::is('useradmin.show_agreement_event') || (Route::is('useradmin.agreement.view_event') || Route::is('useradmin.agreement.edit') || Route::is('useradmin.agreement.generate_event')|| Route::is('useradmin.agreement.edit_event') && (URL::previous() === route('useradmin.show_agreement_event') || URL::previous() === route('useradmin.order.calendar'))) ? 'active' : '' }}">
                                <a href="{{ route('useradmin.show_agreement_event') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Event Agreements') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ Route::is('useradmin.agreement_categories.index') || (Route::is('useradmin.agreement_categories.create') && URL::previous() === route('useradmin.agreement_categories.index')) ? 'active' : '' }}">
                                <a href="{{ route('useradmin.agreement_categories.index') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Categories') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ Route::is('useradmin.agreement_templates.index') || (Route::is('useradmin.agreement_templates.create') || (Route::is('useradmin.agreement_templates.edit') && URL::previous() === route('useradmin.agreement_templates.index'))) ? 'active' : '' }}">
                                <a href="{{ route('useradmin.agreement_templates.index') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __(' Agreement Templates') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif


                @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li
                        class="dash-item dash-hasmenu
                        {{ Route::is('useradmin.order.create') ||
                        Route::is('useradmin.order.createByEvent') ||
                        Route::is('useradmin.order.view') ||
                        Route::is('useradmin.order.vieworderitems.edit') ||
                        Route::is('useradmin.order.invoiceOrder') ||
                        Route::is('useradmin.order.quotationorder') ||
                        Route::is('useradmin.order.cashflow') ||
                        Route::is('useradmin.events.cashflow') ||
                        Route::is('useradmin.viewTermsAndConditions') ||
                        Route::is('useradmin.order.bookorder')
                            ? 'active dash-trigger'
                            : '' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="fas fa-shopping-cart"></i></span>
                            <span class="dash-mtext">{{ __('Orders') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul
                            class="dash-submenu
                            {{ Route::is('useradmin.order.create') ||
                            Route::is('useradmin.order.view') ||
                            Route::is('useradmin.order.vieworderitems.edit') ||
                            Route::is('useradmin.order.invoiceOrder') ||
                            Route::is('useradmin.order.quotationorder') ||
                            Route::is('useradmin.order.cashflow') ||
                            Route::is('useradmin.events.cashflow') ||
                            Route::is('useradmin.viewTermsAndConditions') ||
                            Route::is('useradmin.order.bookorder')
                                ? 'show'
                                : '' }}">
                            <li
                                class="dash-item {{ (Route::is('useradmin.order.create') || Route::is('useradmin.order.createByEvent')) && (URL::previous() === route('useradmin.order.calendar') || URL::previous() === route('useradmin.order.create')) ? 'active' : '' }}">
                                <a href="{{ route('useradmin.order.create') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Order Create') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ (Route::is('useradmin.order.view') || Route::is('useradmin.order.vieworderitems.edit') || Route::is('useradmin.order.cashflow') || Route::is('useradmin.events.cashflow')) && (URL::previous() === route('useradmin.order.view') || URL::previous() === route('useradmin.order.calendar')) ? 'active' : '' }}">
                                <a href="{{ route('useradmin.order.view') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Order History') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ (Route::is('useradmin.order.invoiceOrder') || Route::is('useradmin.order.vieworderitems.edit') || Route::is('useradmin.order.cashflow') || Route::is('useradmin.events.cashflow')) && URL::previous() === route('useradmin.order.invoiceOrder') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.order.invoiceOrder') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Order Invoice') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ (Route::is('useradmin.order.quotationorder') || Route::is('useradmin.order.vieworderitems.edit')) && URL::previous() === route('useradmin.order.quotationorder') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.order.quotationorder') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Order Quotation') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ (Route::is('useradmin.order.bookorder') || Route::is('useradmin.order.vieworderitems.edit')) && URL::previous() === route('useradmin.order.bookorder') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.order.bookorder') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Bookings') }}</span>
                                </a>
                            </li>
                            <li class="dash-item {{ Route::is('useradmin.viewTermsAndConditions') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.viewTermsAndConditions') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Terms and Conditions') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link ">
                            <span class="dash-micon"><i class="fas fa-money-bill"></i></span>
                            </span><span class="dash-mtext">{{ __('Accounts') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul
                            class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">

                            <li
                                class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                                <a href="{{ route('useradmin.order.creditorder') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Credit Orders') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                                <a href="{{ route('useradmin.order.creditorder.payments.view') }}"
                                    class="dash-link">
                                    <span class="dash-mtext">{{ __('Credit Order Payments') }}</span>
                                </a>
                            </li>

                            <li
                                class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                                <a href="{{ route('useradmin.order.advanceorder') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Payments Orders') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                                <a href="{{ route('useradmin.order.completeorder') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Complete Orders') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                                <a href="{{ route('useradmin.order.expense.view') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Additional Expenses') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif


                @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li
                        class="dash-item dash-hasmenu
                        {{ Route::is('useradmin.stockitem.view') ||
                        Route::is('useradmin.stockcategory.view') ||
                        Route::is('useradmin.updatehistory.view')
                            ? 'active dash-trigger'
                            : '' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="fas fa-archive"></i></span>
                            <span class="dash-mtext">{{ __('Items') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul
                            class="dash-submenu
                            {{ Route::is('useradmin.stockitem.view') ||
                            Route::is('useradmin.stockcategory.view') ||
                            Route::is('useradmin.updatehistory.view')
                                ? 'show'
                                : '' }}">
                            <li
                                class="dash-item {{ (Route::is('useradmin.stockitem.view') || Route::is('useradmin.updatehistory.view')) && URL::previous() === route('useradmin.stockitem.view') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.stockitem.view') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Items') }}</span>
                                </a>
                            </li>
                            <li class="dash-item {{ Route::is('useradmin.stockcategory.view') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.stockcategory.view') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Categories') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link ">
                            <span class="dash-micon"><i class="fas fa-list"></i>
                            </span><span class="dash-mtext">{{ __('Rent') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul
                            class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                            <li
                                class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                                <a href="{{ route('useradmin.send.form') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Send Items') }}</span>
                                </a>
                            </li>

                    </li>
                @endif --}}
                @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li
                        class="dash-item dash-hasmenu
                        {{ Route::is('useradmin.send.form') ||
                        Route::is('useradmin.send.history') ||
                        Route::is('useradmin.send.edit') ||
                        Route::is('useradmin.rent.view') ||
                        Route::is('useradmin.rent.history') ||
                        Route::is('useradmin.rent.missing') ||
                        Route::is('useradmin.rent.damage') ||
                        Route::is('useradmin.rent.edit') ||
                        Route::is('useradmin.saverentitems') ||
                        Route::is('useradmin.rent.update.view') ||
                        Route::is('useradmin.missing.edit') ||
                        Route::is('useradmin.event_rent_packages.index') ||
                        Route::is('useradmin.event_rent_packages.create') ||
                        Route::is('useradmin.event_rent_packages.edit') ||
                        Route::is('useradmin.event_rent_packages.eventCreate')
                            ? 'active dash-trigger'
                            : '' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="fas fa-list"></i></span>
                            <span class="dash-mtext">{{ __('Rent') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul
                            class="dash-submenu
                            {{ Route::is('useradmin.send.form') ||
                            Route::is('useradmin.send.history') ||
                            Route::is('useradmin.send.edit') ||
                            Route::is('useradmin.rent.view') ||
                            Route::is('useradmin.rent.history') ||
                            Route::is('useradmin.rent.missing') ||
                            Route::is('useradmin.rent.damage') ||
                            Route::is('useradmin.rent.edit') ||
                            Route::is('useradmin.saverentitems') ||
                            Route::is('useradmin.rent.update.view') ||
                            Route::is('useradmin.missing.edit') ||
                            Route::is('useradmin.event_rent_packages.index') ||
                            Route::is('useradmin.event_rent_packages.create') ||
                            Route::is('useradmin.event_rent_packages.edit') ||
                            Route::is('useradmin.event_rent_packages.eventCreate') ||
                            Route::is('useradmin.event_rent_packages.edit')
                                ? 'show'
                                : '' }}">

                            <li
                                class="dash-item {{ (Route::is('useradmin.event_rent_packages.index') || Route::is('useradmin.event_rent_packages.create') || Route::is('useradmin.event_rent_packages.edit') || Route::is('useradmin.event_rent_packages.eventCreate')) && (URL::previous() === route('useradmin.event_rent_packages.index') || URL::previous() === route('useradmin.order.calendar')) ? 'active' : '' }}">
                                <a href="{{ route('useradmin.event_rent_packages.index') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Rent Packages') }}</span>
                                </a>
                            </li>

                            <li
                                class="dash-item {{ (Route::is('useradmin.send.history') || Route::is('useradmin.saverentitems') || Route::is('useradmin.send.form') || Route::is('useradmin.send.edit') || Route::is('useradmin.rent.update.view')) && URL::previous() === route('useradmin.send.history') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.send.history') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Send History') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ (Route::is('useradmin.rent.view') || Route::is('useradmin.rent.edit')) && URL::previous() === route('useradmin.rent.view') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.rent.view') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Receive Items') }}</span>
                                </a>
                            </li>
                            <li class="dash-item {{ Route::is('useradmin.rent.history') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.rent.history') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Rent History') }}</span>
                                </a>
                            </li>
                            <li
                                class="dash-item {{ (Route::is('useradmin.rent.missing') || Route::is('useradmin.missing.edit')) && URL::previous() === route('useradmin.rent.missing') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.rent.missing') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Missing Items') }}</span>
                                </a>
                            </li>
                            <li class="dash-item {{ Route::is('useradmin.rent.damage') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.rent.damage') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Damage Items') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li
                        class="dash-item dash-hasmenu
                        {{ Route::is('useradmin.package') || Route::is('useradmin.package.images') ? 'active dash-trigger' : '' }}">

                        <a href="{{ route('useradmin.package.all') }}" class="dash-link">
                            <span class="dash-micon"><i class="fas fa-box-open light-icon"></i></span>
                            <span class="dash-mtext">{{ __('Packages') }}</span>
                        </a>
                    </li>
                @endif

                @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li
                        class="dash-item dash-hasmenu
                        {{ Route::is('useradmin.predefined.all') ||
                        Route::is('useradmin.predefined') ||
                        Route::is('useradmin.predefined.categories')
                            ? 'active dash-trigger'
                            : '' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="fas fa-box"></i></span>
                            <span class="dash-mtext">{{ __('Predefined Package') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul
                            class="dash-submenu
                            {{ Route::is('useradmin.predefined.all') ||
                            Route::is('useradmin.predefined') ||
                            Route::is('useradmin.predefined.categories')
                                ? 'show'
                                : '' }}">
                            <li
                                class="dash-item {{ (Route::is('useradmin.predefined.all') || Route::is('useradmin.predefined')) && URL::previous() === route('useradmin.predefined.all') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.predefined.all') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Packages') }}</span>
                                </a>
                            </li>
                            <li class="dash-item {{ Route::is('useradmin.predefined.categories') ? 'active' : '' }}">
                                <a href="{{ route('useradmin.predefined.categories') }}" class="dash-link">
                                    <span class="dash-mtext">{{ __('Category') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li
                        class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                        <a href="{{ route('useradmin.gallery.view') }}" class="dash-link">
                            <span class="dash-micon"><i class="fas fa-images"></i></span>
                            <span class="dash-mtext">{{ __('Gallery') }}</span>
                        </a>
                    </li>
                @endif
                @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                    <li
                        class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                        <a href="{{ route('useradmin.events.view') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-layout-2"></i></span>
                            <span class="dash-mtext">{{ __('Events') }}</span>
                        </a>
                    </li>
                @endif
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('useradmin.supplier.view') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-truck"></i></span>
                        <span class="dash-mtext">{{ __('Suppliers') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu
                    {{ Route::is('useradmin.purchaseorder.view') ||
                    Route::is('useradmin.purchaseorder.details') ||
                    Route::is('useradmin.purchaseorder.addform')
                        ? 'active dash-trigger'
                        : '' }}">
                    <a href="{{ route('useradmin.purchaseorder.view') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-file-invoice"></i></span>
                        <span class="dash-mtext">{{ __('Purchase Order') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('useradmin.subscribers.view') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-bell"></i></span>
                        <span class="dash-mtext">{{ __('Subscribed Users') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu

                    {{ Route::is('useradmin.manual.expenses.income.view') ||
                    Route::is('manual.expenses.income.create') ||
                    Route::is('manual.expenses.income.edit')
                        ? 'active dash-trigger'
                        : '' }}">
                    <a href="{{ route('useradmin.manual.expenses.income.view') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-hand-holding-usd"></i></span>
                        <span class="dash-mtext">{{ __('Manual Inc. & Exp.') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu
                    {{ Route::is('useradmin.cashflow.manage') ||
                    Route::is('useradmin.cashflow.view') ||
                    Route::is('useradmin.cashflow.logs')
                        ? 'active dash-trigger'
                        : '' }}">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="fas fa-box"></i>
                        </span><span class="dash-mtext">{{ __('Cash Flows') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.cashflow.manage') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('Manage') }}</span>
                            </a>
                        </li>
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.cashflow.view') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('View') }}</span>
                            </a>
                        </li>
                        <li class="dash-item {{ Route::is('useradmin.cashflow.logs') ? 'active' : '' }}">
                            <a href="{{ route('useradmin.cashflow.logs') }}" class="dash-link">
                                <span class="dash-mtext">{{ 'Logs' }}</span>
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
                    <span class="dash-micon"><i class="fas fa-bars"></i>
                    </span><span class="dash-mtext">{{ __('Task Management') }}</span>
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
            <li
                class="dash-item dash-hasmenu{{ Route::is('useradmin.equipment.investment') || Route::is('useradmin.equipment.wastage')
                ? 'active dash-trigger'
                : '' }}">
            <a href="#!" class="dash-link">
                <span class="dash-micon"><i class="fas fa-chart-line"></i></span>
                <span class="dash-mtext">{{ __('Equipment') }}</span>
                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>

            </a>
            <ul
                class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                <li
                    class="dash-item {{ Route::is('useradmin.equipment.investment') ? ' active' : '' }}">
                    <a href="{{ route('useradmin.equipment.investment') }}" class="dash-link">
                        <span class="dash-mtext">{{ __('Analysis') }}</span>
                    </a>
                </li>
                <li
                    class="dash-item {{ Route::is('useradmin.equipment.wastage') ? ' active' : '' }}">
                    <a href="{{ route('useradmin.equipment.wastage') }}" class="dash-link">
                        <span class="dash-mtext">{{ __('Wastage Management') }}</span>
                    </a>
                </li>
            </ul>
        @endif
            @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                {{-- <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('useradmin.seo.show') }}" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-search"></i></span> <!-- SEO Icon -->
                        <span class="dash-mtext">{{ __('SEO') }}</span>
                    </a>

                </li> --}}

                <li
                    class="dash-item dash-hasmenu
                    {{ Route::is('useradmin.seo.show') ||
                    Route::is('useradmin.cashflow.view') ||
                    Route::is('useradmin.cashflow.logs')
                        ? 'active dash-trigger'
                        : '' }}">
                    <a href="#!" class="dash-link">
                        <span class="dash-micon"><i class="fas fa-search"></i></span> <!-- SEO Icon -->
                        <span class="dash-mtext">{{ __('SEO') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>

                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.seo.show') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('Main') }}</span>
                            </a>
                        </li>
                        <li
                            class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                            <a href="{{ route('useradmin.seo.home') }}" class="dash-link">
                                <span class="dash-mtext">{{ __('Home') }}</span>
                            </a>
                        </li>
                        <li class="dash-item {{ Route::is('useradmin.seo.packages') ? 'active' : '' }}">
                            <a href="{{ route('useradmin.seo.packages') }}" class="dash-link">
                                <span class="dash-mtext">{{ 'Packages' }}</span>
                            </a>
                        </li>
                        <li class="dash-item {{ Route::is('useradmin.seo.contact') ? 'active' : '' }}">
                            <a href="{{ route('useradmin.seo.contact') }}" class="dash-link">
                                <span class="dash-mtext">{{ 'Contact Us' }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif


            {{--   @if (\Auth::guard('admin')->user()->type == 'admin')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('admin.app-setting.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="fa fa-spinner"></i></span>
                        <span class="dash-mtext">{{ __('Store Setting') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' && env('IS_MOBILE') == 'yes')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('admin.mobilescreen.content') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-device-mobile"></i></span>
                        <span class="dash-mtext">{{ __('Mobile App Setting') }}</span>
                    </a>
                </li>
            @endif --}}

            {{-- Product related section --}}
            {{-- @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin') --}}
            {{-- <li class="dash-item dash-hasmenu">
                <a href="#!" class="dash-link ">
                    <span class="dash-micon"><i class="ti ti-list"></i>
                    </span><span class="dash-mtext">{{__('Products')}}</span>
                    <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                </a>
                <ul class="dash-submenu {{ (Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category')?'show':''}}">
                    <li class="dash-item {{ in_array(Request::segment(1), ['main-category']) ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('admin.main-category.index') }}">{{__('Main Category')}}</a>
                    </li>

                    @if ($ThemeSubcategory)
                        <li class="dash-item {{ in_array(Request::segment(1), ['sub-category']) ? ' active' : '' }}">
                            <a class="dash-link" href="{{ route('admin.sub-category.index') }}">{{ __('Sub Category') }}</a>
                        </li>
                    @endif

                    <li class="dash-item {{ in_array(Request::segment(1), ['product', 'product-variant']) ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('admin.product.index') }}">{{ __('Product') }}</a>
                    </li>

                    <li class="dash-item {{ in_array(Request::segment(1), ['coupon']) ? ' active' : '' }}">
		                <a class="dash-link" href="{{ route('admin.coupon.index') }}">{{__('Coupon')}}</a>
		            </li>

		            <li class="dash-item {{ in_array(Request::segment(1), ['shipping']) ? ' active' : '' }}">
		                <a class="dash-link" href="{{ route('admin.shipping.index') }}">{{__('Shipping')}}</a>
		            </li>

                    <li class="dash-item {{ in_array(Request::segment(1), ['tax']) ? ' active' : '' }}">
                        <a href="{{ route('admin.tax.index') }}" class="dash-link">
                            {{ __('Tax') }}
                        </a>
                    </li>

                    <li class="dash-item {{ in_array(Request::segment(1), ['review']) ? ' active' : '' }}">
                        <a href="{{ route('admin.review.index') }}" class="dash-link">
                            {{ __('Review') }}
                        </a>
                    </li>

                </ul>
            </li> --}}
            {{-- @endif --}}

            {{-- order related section --}}
            {{-- @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin') --}}
            {{-- <li class="dash-item dash-hasmenu">
		        <a href="#!" class="dash-link ">
		            <span class="dash-micon"><i class="ti ti-briefcase"></i>
		            </span><span class="dash-mtext">{{__('Orders')}}</span>
		            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
		        </a>
		        <ul class="dash-submenu {{ (Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category')?'show':''}}">
		            <li class="dash-item {{ in_array(Request::segment(1), ['order', 'order-view']) ? ' active' : '' }}">
		                <a class="dash-link" href="{{ route('admin.order.index') }}">{{__('Order')}}</a>
		            </li>

		            <li class="dash-item {{ in_array(Request::segment(1), ['wishlist']) ? ' active' : '' }}">
		                <a class="dash-link" href="{{ route('admin.wishlist.index') }}">{{__('Wishlist')}}</a>
		            </li>
		        </ul>
            </li> --}}
            {{-- @endif --}}

            {{-- @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['pages']) ? ' active' : '' }}">
                    <a href="{{ route('admin.pages.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-file"></i></span>
                        <span class="dash-mtext">{{ __('Pages') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin')
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['blogs']) ? ' active' : '' }}">
                    <a class="dash-link" href="{{ route('admin.blogs.index') }}">
                        <span class="dash-micon"><i class="ti ti-files"></i></span>
                        <span class="dash-mtext">{{ __('Blog') }}</span>
                    </a>
                </li>
            @endif --}}

            {{-- FAQ & Blog --}}
            {{--  @if (\Auth::guard('admin')->user()->type == 'admin')
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-help"></i>
                        </span><span class="dash-mtext">{{__('Help')}}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>

                    <ul class="dash-submenu {{ (Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category')?'show':''}}">
                        <li class="dash-item {{ in_array(Request::segment(1), ['faqs']) ? ' active' : '' }}">
                            <a class="dash-link" href="{{ route('admin.faqs.index') }}">{{__('FAQs')}}</a>
                        </li>

                        <li class="dash-item {{ in_array(Request::segment(1), ['contacts']) ? ' active' : '' }}">
                            <a class="dash-link" href="{{ route('admin.contacts.index') }}">{{ __('Contact Us') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin')
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['newsletter']) ? ' active' : '' }}">
                    <a href="{{ route('admin.newsletter.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-news"></i></span>
                        <span class="dash-mtext">{{ __('Newsletter') }}</span>
                    </a>
                </li>
            @endif


            @if (\Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['dashboard']) ? ' active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-home"></i></span>
                        <span class="dash-mtext">{{ __('Dashboard') }}</span>
                    </a>
                </li>
            @endif

                 @if (\Auth::guard('admin')->user()->type == 'superadmin')
                 <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['stores']) ? ' active' : '' }}">
                    <a href="{{ route('admin.stores.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-user"></i></span>
                        <span class="dash-mtext">{{ __('Store') }}</span>
                    </a>
                 </li>
                 @endif


                 @if (\Auth::guard('admin')->user()->type == 'superadmin')
                 <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['plan-coupon']) ? ' active' : '' }}">
                    <a href="{{ route('admin.plan-coupon.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-gift"></i></span>
                        <span class="dash-mtext">{{ __('Coupons') }}</span>
                    </a>
                 </li>
                 @endif

                 @if (\Auth::guard('admin')->user()->type == 'superadmin' || \Auth::guard('admin')->user()->type == 'admin')
                 <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['plan']) ? ' active' : '' }}">
                    <a href="{{ route('admin.plan.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-trophy"></i></span>
                        <span class="dash-mtext">{{ __('Plan') }}</span>
                    </a>
                 </li>
                 @endif

                 @if (\Auth::guard('admin')->user()->type == 'superadmin')
                 <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['plan-request']) ? ' active' : '' }}">
                    <a href="{{ route('admin.plan-request.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-arrow-up-right-circle"></i></span>
                        <span class="dash-mtext">{{ __('Plan Requests') }}</span>
                    </a>
                 </li>
                 @endif

                 @if (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')
                 <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['setting']) ? ' active' : '' }}">
                    <a href="{{ route('admin.setting.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-settings"></i></span>
                        <span class="dash-mtext">{{ __('Setting') }}</span>
                    </a>
                 </li>
                 @endif

                 @if (\Auth::guard('admin')->user()->type == 'superadmin')
                 <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['addon']) ? ' active' : '' }}">
                    <a href="{{ route('admin.addon.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-layout-2"></i></span>
                        <span class="dash-mtext">{{ __('Add-on Theme') }}</span>
                    </a>
                 </li>
                 @endif

                 @if (\Auth::guard('admin')->user()->type == 'superadmin')
                 <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['addon']) ? ' active' : '' }}">
                    <a href="{{ route('admin.addon.apps') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-layout-2"></i></span>
                        <span class="dash-mtext">{{ __('Add-on Apps') }}</span>
                    </a>
                 </li>
                 @endif --}}


        </ul>
    </div>
</div>
</nav>
<!-- [ navigation menu ] end -->
