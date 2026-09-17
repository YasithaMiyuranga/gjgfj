@extends('layouts.employee')
@section('page-title', __('Salary'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('employee.emp.payments') }}">{{ __('My Monthly Salary List') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3 class="pb-1">My Monthly Salary List</h3>
                    <p class="mb-0">This page displays detailed monthly salary information, including earnings, deductions, net salary, and payment status over a specific period, helping employees track their monthly income.</p>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Basic Amount') }}</th>
                                    <th>{{ __('ETF') }}</th>
                                    <th>{{ __('EPF') }}</th>
                                    <th>{{ __('Loan Amount') }}</th>
                                    <th>{{ __('Net Salary') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Salary Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salaryDetails as $row)
                                    <tr>
                                        <td>{{ $row->basic_amount }}</td>
                                        <td>{{ $row->etf }}</td>
                                        <td>{{ $row->epf }}</td>
                                        <td>{{ $row->loan_amount }}</td>
                                        <td>{{ $row->net_salary }}</td>
                                        <td>{{ $row->start_date }}</td>
                                        <td>{{ $row->end_date }}</td>
                                        <td>{{ $row->salary_status }}</td>
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
