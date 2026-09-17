@extends('layouts.app')
@section('page-title', __('Suppliers'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.supplier.view') }}">{{__('Supplier List') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Supplier List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2" data-url="{{ route('useradmin.supplier.addform') }}" data-size="md"
                        data-ajax-popup="true" data-title="{{ __('Add Supplier') }}">
                        <i class="ti ti-plus py-1" title="Add"></i> {{ __('Add Supplier') }}
                    </button>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>Supplier Name</th>
                                    <th>Contact Number</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->supplier_name ?? 'N/A' }}</td>
                                        <td>{{ $supplier->contact_number ?? 'N/A' }}</td>
                                        <td>{{ $supplier->city ?? 'N/A' }}</td>
                                        <td>{{ $supplier->address ?? 'N/A' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                data-url="{{ route('useradmin.supplier.edit', $supplier->id) }}"
                                                data-size="md" data-ajax-popup="true"
                                                data-title="{{ __('Supplier Edit') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-info"
                                                data-url="{{ route('useradmin.supplier.credits', $supplier->id) }}"
                                                data-size="md" data-ajax-popup="true"
                                                data-title="{{ __('Supplier Credits') }}">
                                                <i class="fas fa-money-bill-wave py-1" data-bs-toggle="tooltip"
                                                    title="Add Payment"></i>
                                            </button>
                                            <form action="{{ route('useradmin.supplier.delete', $supplier->id) }}"
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

@endsection
