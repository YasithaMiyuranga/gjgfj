@extends('layouts.app')
@section('page-title', __('Employees'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.emp.job.amount.view') }}">{{ __('Emp Job Amount') }}</a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Job Amount List</h3>
                </div>
                <hr>
                <div class="card-header pb-0" style="display: flex">
                    <a href="{{ route('useradmin.emp.job.amount.create') }}">
                        <button class="btn btn-sm btn-primary me-2"
                            data-title="{{ __('Add JOb Amount') }}">
                           <i class="ti ti-plus py-1" title="Add Job Amount"></i> {{ __('Add Job Amount') }}
                        </button>
                    </a>
                    <button class="btn btn-sm btn-primary me-2"
                        style="float: right;"
                        data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="ti ti-filter py-1" title="Filter by Date"></i> {{ __('Filter by Date') }}
                    </button>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Employee Name</th>
                                        <th>Booking Date</th>
                                        <th>Job Amount</th>
                                        <th>Payment Status</th>
                                        <th>Payment Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($details as $row)
                                        <tr>
                                            <td>{{ $row->order_id }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->booking_date }}</td>
                                            <td>{{ $row->job_amount }}</td>
                                            <td>{{ $row->payment_status }}</td>
                                            <td>{{ $row->payment_date }}</td>
                                            <td>
                                                <form action=" {{ route('useradmin.emp.job.amount.delete', $row->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger show_confirm"
                                                        {{ $row->payment_status !== 'Paid' ? '' : 'disabled' }}>
                                                        <i class="fas fa-trash-alt" data-bs-toggle="tooltip" title="edit"></i>
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
        </div>
    </div>
    @include('employee.job_amount_filter')
@endsection
