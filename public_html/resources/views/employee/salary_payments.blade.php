@extends('layouts.app')
@section('page-title', __('Employees'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.emp.salary_pauments_view') }}">{{ __('Emp Payments') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Payment List</h3>
            </div>
            <hr>
            <div class="card-header pb-0">
                <a href="{{ route('useradmin.emp.salary.payment.create') }}">
                    <button class="btn btn-sm btn-primary me-2"
                        data-title="{{ __('Add payments') }}">
                       <i class="ti ti-plus py-1" title="Add Payment"></i> {{ __('Add Payments') }}
                    </button>
                </a>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table descending-order">
                        <thead>
                                <th>Id</th>
                                <th>Emp Name</th>
                                <th>Emp type</th>
                                <th>payment amount</th>
                                <th>Date</th>
                                <th>payment status</th>
                                <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($details as $row)
                                <tr>
                                    <td>{{$row->id }}</td>
                                    <td>{{$row->name }}</td>
                                    <td>{{$row->emp_type }}</td>
                                    <td>{{$row->pay_amount }}</td>
                                    <td>{{$row->date}}</td>
                                    <td>{{$row->payment_status }}</td>
                                    <td>
                                        {{-- <button class="btn btn-sm btn-primary me-2"
                                            data-url="{{ route('useradmin.emp.salary.payment.edit', $row->id) }}"
                                            data-size="md" data-ajax-popup="true" data-title="{{ __('Edit Employee Payment') }}">
                                            <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                        </button> --}}
                                        <form action="{{ route('useradmin.emp.salary.payment.delete', $row->id) }} " method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger show_confirm" >
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
@endsection
