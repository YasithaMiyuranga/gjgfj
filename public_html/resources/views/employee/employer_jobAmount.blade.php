@extends('layouts.employee')

@section('page-title', __('Salary'))

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('employee.emp.viewjobamount') }}">{{ __('My Job Amount List') }}</a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3 class="pb-1">My Job Amount List</h3>
                    <p class="mb-0">This page shows salary-related events in a table, helping employees track payments, statuses, and dates easily.</p>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Event Name') }}</th>
                                    <th>{{ __('Event Date') }}</th>
                                    <th>{{ __('Job Amount') }}</th>
                                    <th>{{ __('Payment Status') }}</th>
                                    <th>{{ __('Payment Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobAmounts as $row)
                                    <tr>
                                        <td>{{ $row->event_name }}</td>
                                        <td>{{ ($row->event_date)}}</td>
                                        <td>{{ $row->job_amount }}</td>
                                        <td>{{ $row->payment_status }}</td>
                                        <td>{{ $row->payment_date }}</td>
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
