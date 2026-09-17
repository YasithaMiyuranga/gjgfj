@extends('layouts.employee')

@section('page-title', __(' Events'))
@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('employee.emp.viewevents') }}">{{ __('My Events') }}</a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3 class="pb-1">My Events</h3>
                    <p class="mb-0">This page displays the events assigned to employees, with details like event names, customer names, start and end times, locations, and order statuses for efficient event tracking.</p>
                </div>
                <hr>
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Customer Name</th>
                                    <th>Event Start Time</th>
                                    <th>Event End Time</th>
                                    <th>Location</th>
                                    <th>Order Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $row)
                                    <tr>
                                        <td>{{ $row->event_name }}</td>
                                        <td>{{ $row->customer_name }}</td>
                                        <td>{{ $row->start_time }}</td>
                                        <td>{{ $row->end_time }}</td>
                                        <td>{{ $row->location }}</td>
                                        <td>{{ $row->order_status }}</td>
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
