@extends('layouts.app')
@section('page-title', ('Rent'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.rent.history') }}">{{__('Rent History') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5></h5>
                    <h3>Rent History</h3>
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
                                        <th>Received Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rentdata as $rent)
                                        <tr>
                                            <td>{{ $rent->customer_name ?? 'N/A' }}</td>
                                            <td>{{ $rent->employee_name ?? 'N/A' }}</td>
                                            <td>{{ $rent->created_at ?? 'N/A' }}</td>
                                            <td>{{ $rent->updated_at ?? 'N/A' }}</td>
                                            <td>
                                                <button class="btn btn-sm" style="background-color: #a3b8fa; color: #ffffff;"
                                                    data-url="{{ route('useradmin.rent.history.view', $rent->rent_id) }}"
                                                    data-size="md" data-ajax-popup="true" data-title="{{ __('View') }}">
                                                    <i class="ti ti-eye py-1" title="View"></i>
                                                </button>
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
