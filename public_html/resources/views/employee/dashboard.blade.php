
@extends('layouts.employee')
@section('page-title', __('Employee Dashboard'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('employee.emp.empdashboard') }}">{{ __('Overview') }}</a>
    </li>
@endsection
@section('content')

    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Employee Dashboard') }}</div>

                    <div class="card-body">
                        <p>Welcome to the Employee dashboard,
                            <strong>{{ Auth::user()->UserName }}</strong>!
                        </p>
                        <form method="POST" action="{{ route('emp.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- recent orders --}}
    <div class="row">
        <div class="col-12">
            <div class="row mb-4 gy-3">
                <div class="col-xxl-7">
                    <div class="row gy-3">
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-home"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Total Events') }}</h6>
                                    <h3 class="mb-0">{{ $allEventsCount }} <span class="text-success text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-click"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Today Events') }}</h6>
                                    <h3 class="mb-0">{{ $todayEventsCount }} <span class="text-danger text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __(' Upcoming Events') }}</h6>
                                    <h3 class="mb-0">{{ $upcomingEventsCount }} <span class="text-success text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-warning">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __(' Monthly Salary') }}</h6>
                                    <h3 class="mb-0"> <span class="text-success text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- quick add --}}
                <div class="col-xxl-5">
                    <div class="card stats-wrapper">
                        <div class="card-body stats welcome-card">
                            <div class="row align-items-center">
                                <div class="col-xxl-12">
                                    <h3 class="mb-1" id="greetings"></h3>
                                    <h4 class="f-w-400">
                                    </h4>
                                    <p>{{ __("Have a great day! Stay on top of your tasks by managing your assigned duties, tracking progress, updating job statuses, and staying aligned with team goals. Focus on excellence and productivity!") }}
                                    </p>
                                    <div class="dropdown quick-add-btn">
                                        <a class="btn btn-primary btn-q-add dropdown-toggle" data-bs-toggle="dropdown"
                                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="ti ti-plus drp-icon"></i>
                                            <span class="ms-2 me-2">{{ __('Quick add') }}</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            {{-- <a href="javascript:void(0)"
                                                data-size="lg"
                                                data-url="{{ route('employee.emp.payments') }}"
                                                data-ajax-popup="true"
                                                data-title="{{('Your Payments') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Your Payments') }}</span>
                                            </a> --}}
                                            <a href="{{ route('employee.emp.payments') }}"
                                                {{-- data-size="lg" --}}
                                                {{-- data-url= --}}
                                                {{-- data-ajax-popup="true" --}}
                                                data-title="{{('Your Payments') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Your Payments') }}</span>
                                            </a>
                                            <a href="{{ route('employee.emp.viewjobamount') }}"
                                                {{-- data-size="lg" --}}
                                                {{-- data-url= --}}
                                                {{-- data-ajax-popup="true" --}}
                                                data-title="{{('Your Job Amounts') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Your Job Amount') }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-12">
                    <div class="row mb-4 gy-3 dash-height">
                        <div class="col-xxl-7 dash-height">
                            <div class="row gy-3 dash-height">
                                <div class="col-lg-3 col-6">
                                     <div class="card stats-wrapper">
                                        <div class="card-body stats">
                                            <div class="theme-avtar bg-warning">
                                                <i class="ti ti-report-money"></i>
                                            </div>
                                            <h6 class="mt-4 mb-2">{{ __('Null') }}</h6>
                                            <h4 class="mb-0"><span class="text-success text-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="card stats-wrapper">
                                        <div class="card-body stats">
                                            <div class="theme-avtar bg-info">
                                                <i class="ti ti-wallet"></i>
                                            </div>
                                            <h6 class="mt-4 mb-2">{{ __('Null') }}</h6>
                                           <h4 class="mb-0"><span class="text-danger text-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="card stats-wrapper">
                                        <div class="card-body stats">
                                            <div class="theme-avtar bg-warning">
                                                <i class="ti ti-building"></i>
                                            </div>
                                            <h6 class="mt-4 mb-2">{{ __('Null') }}</h6>
                                            <h4 class="mb-0"><span class="text-success text-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="card stats-wrapper">
                                         <div class="card-body stats">
                                            <div class="theme-avtar bg-info">
                                                <i class="ti ti-credit-card"></i>
                                            </div>
                                            <h6 class="mt-4 mb-2">{{ __('Null') }}</h6>
                                            <h4 class="mb-0"><span class="text-danger text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-5">
                            <div class="stats-wrapper overflow-auto contact-scroll">
                                <div class="card mb-0 contact-card">
                                    <div class="card-header  contact-heder">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5>{{ __('Contact Us') }}</h5>
                                            </div>
                                            <div class="col-6 bank-wrap">
                                                <h5>Bank Details</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="row m-0">
                                            <div class="col-6 contact-wrap">
                                                <address>
                                                    <h6>{{ Str::title(str_replace('-', ' ', config('app.company_name'))) }}</h6>
                                                    {{ Str::title(str_replace('-', ' ', config('app.company_address_line_one'))) }}<br>
                                                    {{ Str::title(str_replace('-', ' ', config('app.company_address_line_two'))) }}<br>
                                                    Tel - {{ config('app.company_contact') }}
                                                </address>
                                            </div>
                                            <div class="col-6 contact-wrap">
                                                Bank Name    : {{ Str::upper(str_replace('-', ' ', config('app.bank_name'))) }}<br>
                                                Branch Name  : {{ Str::upper(str_replace('-', ' ', config('app.bank_branch_name'))) }}<br>
                                                Bank Account : {{ config('app.bank_account_no') }}<br>
                                                Account Name : {{ Str::upper(str_replace('-', ' ', config('app.bank_account_name'))) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- Upcoming Events --}}
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5>{{ __('Upcoming Events') }}</h5>
                        </div>
                        <hr>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable">
                                    <thead>
                                        <tr>
                                            <th>Event Name</th>
                                            <th>Customer Name</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Location</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($eventsUpcoming as $event)
                                            <tr>
                                                <td>{{ $event->event_name ?? 'N/A' }}</td>
                                                <td>{{ $event->customer_name ?? 'N/A' }}</td>
                                                <td>{{ $event->start_time ?? 'N/A' }}</td>
                                                <td>{{ $event->end_time ?? 'N/A' }}</td>
                                                <td>{{ ucfirst($event->location) ?? 'N/A' }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-2"
                                                         data-url="{{ route('employee.emp.order.expenses.create', $event->order_id) }}"
                                                        data-size="md" data-ajax-popup="true" data-title="{{ __('Add Expense') }}">Add Expense
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Today Events --}}
                <div class="col-sm-12">
                    <div class="card bg-light">
                        <div class="card-header d-flex justify-content-between">
                            <h5>{{ __('Today Events') }}</h5>
                        </div>
                        <hr>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable">
                                    <thead>
                                        <tr>
                                            <th>Event Name</th>
                                            <th>Customer Name</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Location</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($todayEvents as $todayEvent)
                                            <tr class="bg-light text-success">
                                                <td>{{ $todayEvent->event_name }}</td>
                                                <td>{{ $todayEvent->customer_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($todayEvent->start_time)->format('H:i') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($todayEvent->end_time)->format('H:i') }}</td>
                                                <td>{{ ucfirst($todayEvent->location) }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-2"
                                                        data-url="{{ route('employee.emp.order.expenses.create', $todayEvent->order_id) }}"
                                                        data-size="md" data-ajax-popup="true" data-title="{{ __('Add Expense') }}">Add Expense
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- EVENTS ADDITIONAL EXPENSE --}}
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5>{{ __('Additional Expenses') }}</h5>
                        </div>
                        <hr>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Order ID') }}</th>
                                            <th>{{ __('Expense Name') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Description') }}</th>
                                            <th>{{ __('Expense Date') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($additionalExpenseOrders as $order)
                                            @foreach ($order->additional_expenses as $additionalExpense)
                                                <tr>
                                                    <td>{{ $additionalExpense->order_id ?? 'N/A' }}</td>
                                                    <td>{{ $additionalExpense->expense_name ?? 'N/A' }}</td>
                                                    <td>{{ $additionalExpense->amount ?? 'N/A' }}</td>
                                                    <td >{{ $additionalExpense->description ?? 'N/A' }}</td>
                                                    <td>{{ $additionalExpense->expense_date ?? 'N/A' }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary me-2"
                                                            data-url="{{ route('employee.emp.order.expenses.edit', $additionalExpense->id) }}"
                                                            data-size="md" data-ajax-popup="true" data-title="{{ __('Edit Expense') }}">Edit
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5>{{ __('Rent Items') }}</h5>
                        </div>
                        <hr>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable">
                                    <thead>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Rent Date</th>
                                            <th>Rent Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rents as $rent)
                                            <tr>
                                                <td>{{ $rent->customer_name ?? 'N/A' }}</td>
                                                <td>{{ $rent->created_at ?? 'N/A' }}</td>
                                                <td>{{ $rent->rent_status ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('employee.emp.assign.rent.view', $rent->rent_id) }}">
                                                      <button class="btn btn-sm" style="background-color: #a3b8fa; color: #ffffff;"
                                                        data-title="{{ __('View') }}">
                                                        <i class="ti ti-eye py-1" title="View"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5>{{ __('Pending Job Amounts') }}</h5>
                        </div>
                        <hr>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable">
                                    <thead>
                                        <tr>
                                            <th>Event Name</th>
                                            <th>Event Date</th>
                                            <th>Job Amount</th>
                                            <th>Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendingJobAmounts as $pendingJobAmount)
                                            <tr>
                                                <td>{{ $pendingJobAmount->event_name ?? 'N/A' }}</td>
                                                <td>{{ $pendingJobAmount->event_date ?? 'N/A' }}</td>
                                                <td>{{ $pendingJobAmount->job_amount ?? 'N/A' }}</td>
                                                <td>{{ $pendingJobAmount->payment_status ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
