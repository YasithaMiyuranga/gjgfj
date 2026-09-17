@extends('layouts.app')
@section('page-title', ('Rent'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.rent.view') }}">{{__('Receive Items') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Receive Items</h3>
            </div>
            <hr>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Employee Name</th>
                                    <th>Rent Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rentdata as $rent)
                                    <tr>
                                        <td>{{ $rent->customer_name ?? 'N/A' }}</td>
                                        <td>{{ $rent->employee_name ?? 'N/A' }}</td>
                                        <td>{{ $rent->created_at ? substr($rent->created_at, 0, 10) : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('useradmin.rent.edit', $rent->rent_id) }}">
                                                <button class="btn btn-sm btn-primary " data-title="{{ __('Item Receive') }}">
                                                    <i class="ti ti-pencil"></i>
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
