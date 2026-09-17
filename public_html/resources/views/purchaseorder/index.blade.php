@extends('layouts.app')
@section('page-title', __('Purchase Orders'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.purchaseorder.view') }}">{{__('Purchase Orders') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Purchase Order List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <a href="{{ route('useradmin.purchaseorder.addform') }}" class="btn btn-primary me-2 btn-sm">
                        <i class="ti ti-plus py-1" title="Add"></i> {{ __('Add Purchase Order') }}
                    </a>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Supplier Name</th>
                                        <th>Total Price</th>
                                        <th>Purchase Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchaseorders as $purchaseorder)
                                        <tr>
                                            <td>{{ $purchaseorder->id ?? 'N/A' }}</td>
                                            <td>{{ $purchaseorder->supplierName ?? 'N/A' }}</td>
                                            <td>{{ $purchaseorder->total_price ?? 0.00 }}</td>
                                            <td>{{ $purchaseorder->purchase_date->format('Y-m-d') ?? 'N/A' }}</td>
                                            <td>
                                            <a href="{{ route('useradmin.purchaseorder.details', $purchaseorder->id) }}">
                                                    <button class="btn btn-sm" style="background-color: #a3b8fa; color: #ffffff;" data-title="{{ ('View') }}">
                                                        <i class="ti ti-eye py-1" title="View"></i>
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
