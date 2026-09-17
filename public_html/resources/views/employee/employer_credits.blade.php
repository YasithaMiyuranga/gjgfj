@extends('layouts.app')
@section('page-title', __('Employees'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.emp.credits.view') }}">{{ __('Emp Credits') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Credit List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <a href="{{ route('useradmin.emp.credits.create') }}">
                        <button class="btn btn-sm btn-primary me-2"
                            data-title="{{ __('Add Employee Credit') }}">
                            <i class="ti ti-plus py-1" title="Add Package"></i> {{ __('Add Employee Credit') }}
                        </button>
                    </a>
                </div>
                    <div class="card-body card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table viewemp_credits descending-order">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Credit Amount</th>
                                        <th>Credit Date</th>
                                        <th>Paid Date </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($credits as $credit)
                                        <tr>
                                            <td>{{ $credit->emp_name ?? 'N/A' }}</td>
                                            <td>{{ $credit->credit_amount ?? 'N/A' }}</td>
                                            <td>{{ $credit->credit_date ?? 'N/A' }}</td>
                                            <td>{{ $credit->paid_date ?? 'N/A' }}</td>
                                            <td>{{ $credit->credit_status ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('useradmin.emp.credits.edit', $credit->Employee_credit_id) }}">
                                                    <button class="btn btn-sm btn-primary" data-title="{{ __('View / Edit') }}">   <i class="ti  ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                                    </button>
                                                </a>
                                                <form action="{{ route('useradmin.emp.credits.delete', $credit->Employee_credit_id) }}"
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
        </div>
    </div>
@endsection

