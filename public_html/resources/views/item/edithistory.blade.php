@extends('layouts.app')
@section('page-title', __('Items'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.stockitem.view') }}">{{__('Item') }}</a>
        <li class="breadcrumb-item active">{{ __('View Update History') }}</li>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>View Update History</h3>
                </div>
                <hr>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table dataTable">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Previous Total Stock</th>
                                        <th>Updated Total Stock</th>
                                        <th>Difference</th>
                                        <th>Updated By</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($updatehistory as $update)
                                        <tr>
                                            <td>{{ $update->item_name ?? 'N/A' }}</td>
                                            <td>{{ $update->previous_stock ?? 0 }}</td>
                                            <td>{{ $update->updated_stock ?? 0 }}</td>
                                            <td>{{ ($update->updated_stock - $update->previous_stock)  ?? 0 }}</td>
                                            <td>{{ $update->updated_by ?? 'N/A' }}</td>
                                            <td>{{ $update->updated_at ?? 'N/A' }}</td>
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
