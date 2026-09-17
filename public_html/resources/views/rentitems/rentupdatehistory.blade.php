@extends('layouts.app')
@section('page-title', ('Rent Update History'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.rent.view') }}">{{__('Receive Items') }}</a>
        <li class="breadcrumb-item active">{{ __('Rent Update History  ') }}</li>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5></h5>
                    <h3>Rent Update History</h3>
                </div>
                <hr>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Rent ID</th>
                                        <th>Event Name</th>
                                        <th>Item Name</th>
                                        <th>Employee Name</th>
                                        <th>Update History</th>
                                        <th>Previous Quantity </th>
                                        <th>Current Quantity </th>
                                        <th>Updated Quantity </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rent_update_history_data as $rent_id => $rent_update_history)
                                        <tr>
                                            <td>{{ $rent_id }}</td>
                                            <td>{{ $rent_update_history[0]->event_name }}</td>
                                            <td>
                                                <ol>
                                                    @foreach($rent_update_history as $update)
                                                        <li>{{ $update->item->item_name }}</li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach($rent_update_history as $update)
                                                        <li>{{ $update->employee->name }}</li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                @foreach($rent_update_history as $update)
                                                    <li>{{ $update->action }} </li>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($rent_update_history as $update)
                                                    {{ $update->previous_quantity }}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($rent_update_history as $update)
                                                    {{ $update->current_quantity }} <br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($rent_update_history as $update)
                                                    {{ $update->updated_quantity }} <br>
                                                @endforeach
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
