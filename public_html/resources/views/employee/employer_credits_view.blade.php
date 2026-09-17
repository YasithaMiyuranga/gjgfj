@extends('layouts.employee')
@section('page-title', __('Salary'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('employee.emp.credits') }}">{{ __('Credit List') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3 class="mb-1">Credit List</h3>
                    <p class="mb-0">This page displays employee loan records, including the credit and paid dates, loan amounts, and status, making it easy to track the details of loans taken through the company.</p>
                </div>
                <hr>
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>Credit Date</th>
                                    <th>Credit Amount</th>
                                    <th>Paid Date </th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($credits as $credit)
                                    <tr>
                                        <td>{{ $credit->credit_date ?? 'N/A' }}</td>
                                        <td>{{ $credit->credit_amount ?? 'N/A' }}</td>
                                        <td>{{ $credit->paid_date ?? 'N/A' }}</td>
                                        <td>{{ $credit->credit_status ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
