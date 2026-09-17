@extends('layouts.app')
@section('page-title', __('Overview'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.dashboard') }}">{{ __('Overview') }}</a>
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
                                    <div class="theme-avtar event-avatar">
                                        <i class="ti ti-layout-2"></i>
                                    </div>
                                    <a href="{{ route('useradmin.event_dashboard') }}"><br>
                                        <h6 class="dash-mtext"> {{ __('Events') }}</h6>
                                        <h6 class="dash-mtext"> {{ __('Dashboard') }}</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-package"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Total Products') }}</h6>
                                    <h4 class="mb-0">{{ $totalProducts }} <span class="text-success text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-shopping-cart"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Total Orders') }}</h6>
                                    <h4 class="mb-0">{{ $completeOrdersCount }} <span class="text-success text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-music"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Total Events') }}</h6>
                                    <h4 class="mb-0">{{ $totalEvents }} <span class="text-danger text-sm">
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
                                    <p>{{ __("Have a great day! Don't forget, you can easily manage your business by adding new items, add expenses, adding products, sending items, adding customers, and more. Stay organized and focused on growth!") }}
                                    </p>
                                    <div class="dropdown quick-add-btn">
                                        <a class="btn btn-primary btn-q-add dropdown-toggle" data-bs-toggle="dropdown"
                                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="ti ti-plus drp-icon"></i>
                                            <span class="ms-2 me-2">{{ __('Quick add') }}</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a href="javascript:void(0)"
                                                data-size="lg"
                                                data-url="{{ route('useradmin.stockitem.addform') }}"
                                                data-ajax-popup="true"
                                                data-title="{{('Add new item') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Add new item') }}</span>
                                            </a>
                                            <a href="javascript:void(0)"
                                                data-size="lg"
                                                data-url="{{ route('useradmin.order.expenses.create', 0) }}"
                                                data-ajax-popup="true"
                                                data-title="{{('Add expenses') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Add expenses') }}</span>
                                            </a>
                                            <a href="{{ route('useradmin.order.create') }}"
                                                data-title="{{('Add Product') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Create Order') }}</span>
                                            </a>
                                            <a href="{{ route('useradmin.send.form') }}"
                                                data-title="{{('Send Items') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Send Items') }}</span>
                                            </a>
                                            <a href="javascript:void(0)"
                                                data-size="lg"
                                                data-url="{{ route('useradmin.customer.store') }}"
                                                data-ajax-popup="true"
                                                data-title="{{('Add Product') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Add New Customer') }}</span>
                                            </a>
                                            <a href="javascript:void(0)"
                                                data-size="lg"
                                                data-url="{{ route('useradmin.order.event.create') }}"
                                                data-ajax-popup="true"
                                                data-title="{{('Add Product') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Create event option') }}</span>
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
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Total Credit Amount') }}</h6>
                                    <h4 class="mb-0">Rs.{{ number_format($creditAmounts,2) }} <span class="text-success text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-wallet"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Monthly Employee Salary') }}</h6>
                                   <h4 class="mb-0">Rs.{{ number_format($totalPayAmounts, 2) }} <span class="text-danger text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                <div class="card-body stats">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-building"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Monthly Expenses') }}</h6>
                                    <h4 class="mb-0">Rs.{{ $totalExpences }} <span class="text-success text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card stats-wrapper">
                                 <div class="card-body stats">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-credit-card"></i>
                                    </div>
                                    <h6 class="mt-4 mb-2">{{ __('Monthly Payments') }}</h6>
                                    <h4 class="mb-0">Rs.{{ number_format($totalPayments,2) }} <span class="text-danger text-sm">
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
                                        @foreach ($bankAccounts as $bankAccount)
                                            @if($bankAccount->is_default == 1)
                                                <div class="bank-wrap">
                                                    Bank Name    : {{ Str::upper($bankAccount->bank_name) }}<br>
                                                    Branch Name  : {{ Str::upper($bankAccount->branch_name) }}<br>
                                                    Bank Account : {{ $bankAccount->account_number }}<br>
                                                    Account Name : {{ Str::upper($bankAccount->account_name) }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Bank Details --}}
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h5>{{ __('Bank Details') }}</h5>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.bank_accounts.create')}}"
                        data-size="md" data-ajax-popup="true" data-title="{{ __('Add Bank Account') }}">
                     <i class="ti ti-plus py-1" title="Add Bank Account"></i> {{ ('Add Bank Account') }}
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Bank Name') }}</th>
                                    <th>{{ __('Branch Name') }}</th>
                                    <th>{{ __('Account No') }}</th>
                                    <th>{{ __('Account Name') }}</th>
                                    <th>{{ __('Default') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bankAccounts as $account)
                                <tr>
                                    <td>{{ $account->bank_name }}</td>
                                    <td>{{ $account->branch_name }}</td>
                                    <td>{{ $account->account_number }}</td>
                                    <td>{{ $account->account_name }}</td>
                                    <td>{{ $account->is_default ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info"  onclick="copyBankDetails('{{ $account->bank_name }}', '{{ $account->branch_name }}', '{{ $account->account_number }}', '{{ $account->account_name }}')">
                                            <i class="ti ti-copy py-1" data-bs-toggle="tooltip" title="Copy Bank Details"></i>
                                        </button>
                                        <button class="btn btn-sm btn-primary"
                                            data-url="{{ route('useradmin.bank_accounts.edit', $account->id) }}"
                                            data-size="md" data-ajax-popup="true"
                                            data-title="{{ __('Edit Bank Account') }}">
                                            <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                        </button>
                                        <form action="{{ route('useradmin.bank_accounts.destroy', $account->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                <i class="fas fa-trash-alt" data-bs-toggle="tooltip" title="delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Today Booking Order --}}
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h5>{{ __(' Today Booking Orders') }}</h5>
                </div>
                <hr>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Order Id') }}</th>
                                    <th>{{ __('Event Name') }}</th>
                                    <th>{{ __('customer Name') }}</th>
                                    <th>{{ __('Location') }}</th>
                                    <th>{{ __('Customer Phone') }}</th>
                                    <th>{{ __('Start Time') }}</th>
                                    <th>{{ __('End Time') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($todayOrders as $row)
                                    <tr>
                                        <td>{{ $row->order_id }}</td>
                                        <td>{{ $row->event_name }}</td>
                                        <td>{{ $row->customer_name }}</td>
                                        <td>{{ $row->location }}</td>
                                        <td>{{ $row->customer_phone }}</td>
                                        <td>{{ $row->start_time }}</td>
                                        <td>{{ $row->end_time }}</td>
                                        <td>
                                          <a href="javascript:void(0)"
                                              data-size="lg"
                                              data-url="{{ route('useradmin.order.expenses.create', $row->order_id) }}"
                                              data-ajax-popup="true"
                                              data-bs-placement="top"
                                              class="dropdown-item"
                                              data-title="{{('Add Expenses') }}">
                                              <button class="btn btn-primary btn-sm">
                                                  Add Expenses
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
        {{-- Customer Requirement --}}
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h5>{{ ('Customer Requirement') }}</h5>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.customer.requirement.create') }}"
                        data-size="md" data-ajax-popup="true" data-title="{{ ('Customer Requirement') }}">
                     <i class="ti ti-plus py-1" title="Add Customer Requirement"></i> {{ ('Customer Requirement') }}
                    </button>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>{{ ('Name') }}</th>
                                    <th style="white-space: normal; word-wrap: break-word; max-width: 150px;">{{ ('Description') }}</th>
                                    <th>{{ ('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customerRequirements as $row)
                                    <tr>
                                        <td>{{ $row->name }}</td>
                                        <td style="white-space: normal; word-wrap: break-word; max-width: 150px;">{{ ($row->description) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info"  onclick="copyRequirement('{{ $row->name }}', '{{ $row->description }}')">
                                                <i class="ti ti-copy py-1" data-bs-toggle="tooltip" title="Copy Requirement"></i>
                                            </button>
                                            <button class="btn btn-sm btn-primary"
                                                data-url="{{ route('useradmin.customer.requirement.edit', $row->id) }}"
                                                data-size="md" data-ajax-popup="true"
                                                data-title="{{ ('Edit Customer Requirement') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            <form action="{{ route('useradmin.customer.requirement.delete', $row->id) }} " method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger show_confirm" >
                                                    <i class="fas fa-trash-alt" data-bs-toggle="tooltip" title="delete"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Monthly Booking Order --}}
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{ __(' Montly Booking Order List') }}</h5>
                </div>
                <hr>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Order Id') }}</th>
                                    <th>{{ __('Event Name') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Location') }}</th>
                                    <th>{{ __('Order Status') }}</th>
                                    <th>{{ __('Customer Phone') }}</th>
                                    <th>{{ __('Start Time') }}</th>
                                    <th>{{ __('End Time') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($thisMonthOrders as $row)
                                    <tr>
                                        <td>{{ $row->order_id }}</td>
                                        <td>{{ $row->event_name }}</td>
                                        <td>{{ $row->customer_name }}</td>
                                        <td>{{ $row->location }}</td>
                                        <td>{{ $row->order_status }}</td>
                                        <td>{{ $row->customer_phone }}</td>
                                        <td>{{ $row->start_time }}</td>
                                        <td>{{ $row->end_time }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- recent orders --}}
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h5>{{ __('Booking Orders') }}</h5>
                </div>
                <hr>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Order Type</th>
                                    <th>Booking Date</th>
                                    <th>Invoice Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $order)
                                    <tr>
                                        <td>{{ $order->customer_name ?? 'N/A' }}</td>
                                        <td>{{ $order->order_type ?? 'N/A' }}</td>
                                        <td>{{ $order->booking_date ?? 'N/A' }}</td>
                                        <td>{{ $order->inv_date ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('useradmin.order.vieworderitems.edit', $order->order_id) }}">
                                                <button class="btn btn-sm btn-primary " data-title="{{ __('Edit Order Items') }}">
                                                    <i class="ti ti-pencil"></i>
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
    </div>
<script>
function copyBankDetails(bank_name, branch_name, account_number, account_name) {
    try {
        const copyBankData = 'Bank Name: ' + bank_name + '\n' +
            'Branch Name: ' + branch_name + '\n' +
            'Account Number: ' + account_number + '\n' +
            'Account Name: ' + account_name;
        navigator.clipboard.writeText(copyBankData).then(function() {
            showCustomAlert('Bank details copied to clipboard', 'success');
        }).catch(function(err) {
            showCustomAlert('Error copying bank details: ' + err, 'error');
        });
    } catch (error) {
        showCustomAlert('Error processing bank details: ' + error.message, 'error');
    }
}
function copyRequirement( name, description) {
    const nameDescription = `Name: ${name}\nDescription: ${description}`;
    navigator.clipboard.writeText(nameDescription).then(function() {
            showCustomAlert('Name and description copied to clipboard', 'success');
        }, function(err) {
            showCustomAlert('Error copying email: ', err);
        });
}
</script>
@endsection
