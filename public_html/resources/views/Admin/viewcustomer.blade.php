@extends('layouts.app')
@section('page-title', __('Customers'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.viewcustomer') }}">{{ __('Customers') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Customer View</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2" data-url="{{ route('useradmin.customer.store') }}"
                        data-size="lg" data-ajax-popup="true" data-title="{{ __('Add Customer') }}">
                       <i class="ti ti-plus py-1" title="Add Customer"></i> {{ __('Add Customer') }}
                    </button>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table dataTable">
                                <thead>
                                    <th>Customer Id</th>
                                    <th>Customer Name</th>
                                    <th>Phone No</th>
                                    <th>Location</th>
                                    <th>NIC</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Status</th>
                                    <th>Points</th>
                                    <th>Register Date</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($viewcustomers as $row)
                                        <tr>
                                            <td>{{ $row->customer_id }}</td>
                                            <td>{{ $row->customer_name }}</td>
                                            <td>{{ $row->customer_phone }}</td>
                                            <td>{{ $row->location }}</td>
                                            <td>{{ $row->nic }}</td>
                                            <td>{{ $row->address }}</td>
                                            <td>{{ $row->city }}</td>
                                            <td>{{ $row->status }}</td>
                                            <td>{{ $row->points }}</td>
                                            <td>{{ $row->register_date->format('d-m-Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"
                                                    data-url="{{ route('useradmin.customer.edit', $row->customer_id) }}"
                                                    data-size="lg" data-ajax-popup="true"
                                                    data-title="{{ __('Edit Customer') }}">
                                                    <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                                </button>
                                                <form action="{{ route('useradmin.customer.delete', $row->customer_id) }}"
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
