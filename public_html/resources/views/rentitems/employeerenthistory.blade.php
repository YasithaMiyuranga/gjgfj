@extends('layouts.employee')
@section('page-title', ('Rent'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('employee.emp.view.received.items') }}">{{('Receive Items') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3 class="pb-1">Receive Items</h3>
                <p class="mb-0">This page shows the rental items assigned by the admin, displaying event names, customer names, rent dates, and actions for easy tracking and management by employees.</p>
            </div>
            <hr>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Employee Name</th>
                                    <th>Rent Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rentdetails as $rent)
                                    <tr>
                                        <td>{{ $rent->customer_name ?? 'N/A' }}</td>
                                        <td>{{ $rent->employee_name ?? 'N/A' }}</td>
                                        <td>{{ $rent->created_at ? substr($rent->created_at, 0, 10) : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('employee.emp.view.received.items.details', $rent->rent_id) }}">
                                                <button class="btn btn-sm btn-primary " data-title="{{ ('Item Receive') }}">
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
</div>
@endsection
