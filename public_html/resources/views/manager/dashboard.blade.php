@extends('layouts.manager')
@section('page-title', __('manager Dashboard'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('manager.man.managerdashboard') }}">{{ __('Overview') }}</a>
    </li>
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="row mb-4 gy-3">
            <div class="col-xxl-7">
                <div class="row gy-3">
                    <div class="col-lg-3 col-6">
                        <div class="card stats-wrapper">
                            <div class="card-body stats">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-home"></i>
                                </div>
                                <h6 class="mt-4 mb-2">{{ __('Total Events') }}</h6>
                                <h3 class="mb-0">{{ $allEventCount }} <span class="text-success text-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="card stats-wrapper">
                            <div class="card-body stats">
                                <div class="theme-avtar bg-info">
                                    <i class="ti ti-click"></i>
                                </div>
                                <h6 class="mt-4 mb-2">{{ __('Today Events') }}</h6>
                                <h3 class="mb-0">{{ $todayEventCount }} <span class="text-danger text-sm">
                            </div>
                        </div>
                    </div>
                    
                   
                </div>
            </div>
            {{-- quick add --}}
            <div class="col-xxl-5">
                <div class="card stats-wrapper">
                    <div class="card-body stats welcome-card">
                        <div class="row align-items-center">
                            <div class="col-xxl-12">
                                <h3 class="mb-1" id="greetings"></h3>
                                <h4 class="f-w-400">
                                </h4>
                                <p>{{ __("Have a great day! Stay on top of your tasks by managing your assigned duties, tracking progress, updating job statuses, and staying aligned with team goals. Focus on excellence and productivity!") }}
                                </p>
                                
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            
            {{-- Upcoming Events --}}
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ __('Events') }}</h5>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table dataTable">
                                <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Customer Name</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Location</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($events as $event)
                                        <tr>
                                            <td>{{ $event->event_name ?? 'N/A' }}</td>
                                            <td>{{ $event->customer->customer_name ?? 'N/A' }}</td>
                                            <td>{{ $event->start_datetime ?? 'N/A' }}</td>
                                            <td>{{ $event->end_datetime ?? 'N/A' }}</td>
                                            <td>{{ ucfirst($event->location) ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Today Events --}}
            <div class="col-sm-12">
                <div class="card bg-light">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ __('Today Events') }}</h5>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table dataTable">
                                <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Customer Name</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todayEvents as $todayEvent)
                                        <tr class="bg-light text-success">
                                            <td>{{ $todayEvent->event_name }}</td>
                                            <td>{{ $todayEvent->customer->customer_name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($todayEvent->start_time)->format('H:i') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($todayEvent->end_time)->format('H:i') }}</td>
                                            <td>{{ ucfirst($todayEvent->location) }}</td>
                                           
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
