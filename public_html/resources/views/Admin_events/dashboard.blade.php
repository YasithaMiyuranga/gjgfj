@extends('layouts.events')
@section('page-title', __('Events Dashboard'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.event_dashboard') }}">{{ __('Overview') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="row mb-4 gy-3">
            <div class="col-xxl-7">
                <div class="row gy-3">
                    <div class="col-6 col-lg-3 ">
                        <div class="card stats-wrapper">
                            <div class="card-body stats">
                                <div class="theme-avtar btn-light-primary dashbord-card">
                                    <i class="ti ti-layout-2"></i>
                                </div>
                                <a href="{{ route('useradmin.dashboard') }}"><br>
                                    <h6 class="dash-mtext"> {{ __('Products') }}</h6>
                                    <h6 class="dash-mtext"> {{ __('Dashboard') }}</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="card stats-wrapper">
                            <div class="card-body stats">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-users"></i>
                                </div>
                                <h6 class="mt-4 mb-2">{{ __('Total Users') }}</h6>
                                <h4 class="mb-0">{{  $activeUsersCount }} <span class="text-success text-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="card stats-wrapper">
                            <div class="card-body stats">
                                <div class="theme-avtar bg-info">
                                    <i class="ti ti-users"></i>
                                </div>
                                <h6 class="mt-4 mb-2">{{ __('Total Agents') }}</h6>
                                <h4 class="mb-0">{{ $totalAgents}} <span class="text-danger text-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="card stats-wrapper">
                            <div class="card-body stats">
                                <div class="theme-avtar bg-warning">
                                    <i class="fas fa-music"></i>
                                </div>
                                <h6 class="mt-4 mb-2">{{ __('Total Artists') }}</h6>
                                <h4 class="mb-0">{{ $totalArtists }} <span class="text-success text-sm">
                            </div>
                        </div>
                    </div>

                      {{-- <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats ps-3 pe-3">
                                    <h6 class="">{{ 'store name' }}</h6>
                                    <div class="mb-3 qrcode">
                                    </div>
                                    <a href="#!" class="btn btn-light-primary btn-sm w-100 cp_link"
                                        data-link="{{ 'theamurl' }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ __('Click to copy link') }}">
                                        {{ __('Theme Link') }}
                                        <i class="ms-3"data-feather="copy"></i>
                                    </a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-xxl-5">
                    <div class="card stats-wrapper">
                        <div class="card-body stats welcome-card">
                            <div class="row align-items-center">
                                <div class="col-xxl-12">
                                    <h3 class="mb-1" id="greetings"></h3>
                                    <h4 class="f-w-400">
                                    </h4>
                                    <p>{{ __("Have a great day! Don't forget, you can easily manage your business by adding new events, adding new agents, adding new event coupons, and more. Stay organized and focused on growth!") }}</p>
                                    <div class="dropdown quick-add-btn">
                                        <a class="btn btn-primary btn-q-add dropdown-toggle" data-bs-toggle="dropdown"
                                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="ti ti-plus drp-icon"></i>
                                            <span class="ms-2 me-2">{{ __('Quick add') }}</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('useradmin.events.event_create') }}"
                                                data-title="{{('Create Event') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Create Event') }}</span>
                                            </a>
                                            <a href="{{ route('useradmin.events.create_agent') }}"
                                                data-title="{{('Create Agent') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Create Agent') }}</span>
                                            </a>
                                            <a href="javascript:void(0)"
                                                data-size="md"
                                                data-url="{{ route('useradmin.events.category_create') }}"
                                                data-ajax-popup="true"
                                                data-title="{{('Create Event Category') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Create Event Category') }}</span>
                                            </a>
                                            <a href="javascript:void(0)"
                                                data-size="lg"
                                                data-url="{{ route('useradmin.events.ticket_create') }}"
                                                data-ajax-popup="true"
                                                data-title="{{('Create Event Tickets') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Create Event Ticket') }}</span>
                                            </a>
                                            <a href="javascript:void(0)"
                                                data-size="md"
                                                data-url="{{ route('useradmin.events.ticket.coupon_create') }}"
                                                data-ajax-popup="true"
                                                data-title="{{('Create Coupon') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Create Event Coupon') }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row mb-4 gy-3 dash-height">
                <div class="col-xxl-7 dash-height">
                    <div class="row gy-3 dash-height">
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-credit-card"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Total Events') }}</h6>
                                    <h4 class="mb-0">{{ $events->count() }} <span class="text-danger text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Total Transactions') }}</h6>
                                    <h3 class="mb-0">{{ 'Rs 0' }} <span class="text-danger text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-home"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Today SMS') }}</h6>
                                    <h3 class="mb-0">{{  ' 0' }} <span class="text-success text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-click"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('SMS Amount') }}</h6>
                                    <h4 class="mb-0">{{ 'Rs 0' }} <span class="text-danger text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5">
                    <div class="stats-wrapper overflow-auto contact-scroll">
                        <div class="card mb-0 contact-card">
                            <div class="card-header contact-heder">
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
        </div>
         {{--Active Events --}}
         <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{ ('Events') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>LOGO</th>
                                    <th>BANNER</th>
                                    <th>EVENT NAME</th>
                                    <th>LOCATION</th>
                                    <th>DATE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $row)
                                <tr>
                                    <td><img src="{{ asset($row->logo) }}" class="card-img-top" style="width: 50px; height: 50px;" alt="Album Image"></td>
                                    <td><img src="{{ asset($row->banner) }}" class="card-img-top" style="width: 50px; height: 50px;" alt="Album Image"></td>
                                    <td>{{ $row->event_name }}</td>
                                    <td>{{ $row->location }}</td>
                                    <td>{{ $row->event_date }}</td>
                                    <td>
                                        <a href="{{ route('useradmin.events.event_edit', $row->eid) }} ">
                                            <button class="btn btn-sm btn-primary me-2">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{--Active Sales Ticket --}}
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{ ('Tickets') }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <div class="card-header pb-0">
                            <a href="{{ route('useradmin.events.ticket_report_generate') }}">
                                 <button class="btn btn-sm btn-primary me-2">
                                     <i class="ti ti-report py-1" data-bs-toggle="tooltip" title="Generate Tickets REport"></i>
                                     Generate Report
                                 </button>
                             </a>
                         </div>
                        <table class="table descending-order">
                            <thead>
                                <th>EVENT NAME</th>
                                <th>TICKETS_CATEGORY</th>
                                <th>NUMBER OF TICKETS</th>
                                <th>REMAINING TICKETS</th>
                                <th>SOLD TICKETS</th>
                                <th>ACTION</th>
                            </thead>  
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->event->event_name ?? 'N/A' }}</td>
                                        <td>{{ $ticket->tickets_category }}</td>
                                        <td>{{ $ticket->number_of_tickets }}</td>
                                        <td>{{ $ticket->number_of_tickets - $ticket->baught_tickets_count }}</td> <!-- Remaining -->
                                        <td>{{ $ticket->baught_tickets_count ?? 'N/A'}}</td> <!-- Sold -->
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                data-url="{{ route('useradmin.events.ticket_edit', $ticket->id) }} "
                                                data-size="lg" data-ajax-popup="true" data-title="{{ __('Edit Tickets Details') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger"
                                                data-url="{{ route('useradmin.events.ticket_delete_view', $ticket->id) }} "
                                                data-size="md" data-ajax-popup="true"
                                                data-title="{{ __('Delete Event Ticket') }}">
                                                <i class="ti ti-trash py-1" data-bs-toggle="tooltip" title="delete"></i>
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
    </div>
</div>
@endsection
