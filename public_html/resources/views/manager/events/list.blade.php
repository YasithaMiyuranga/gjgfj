@extends('layouts.manager')

@section('page-title', __('Events'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.events_list') }}">{{ __('Events List') }}</a>
    </li>
@endsection


@section('content')

    <div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Events List</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <th>Id</th>
                                <th>LOGO</th>
                                <th>BANNER</th>
                                <th>EVENT NAME</th>
                                <th>Location</th>
                                <th>Event Manager</th>
                                <th>PHONE NO</th>
                                <th>Event Date</th>
                                <th>Artist Names</th>
                                <th>SPONSOR</th>
                                <th>STATUS</th>
                                <th>Details Docs</th>
                                <Th class="text-center">ACTION</Th>
                            </thead>
                            <tbody>
                                @foreach ($events as $row)
                                    <tr>
                                        <td>{{ $row->eid }}</td>
                                        <td><img src="{{ asset($row->logo) }}" class="card-img-top" style="width: 50px; height: 50px;" alt="Event Logo"></td>
                                         <td><img src="{{ asset($row->banner) }}" class="card-img-top" style="width: 50px; height: 50px;" alt="Event Banner"></td>
                                         <td>{{ $row->event_name }}</td>
                                        <td>{{ $row->location }}</td>
                                        <td>{{ $row->manager->name }}</td>
                                        <td>{{ $row->contact_no }}</td>
                                        <td>{{ $row->event_date }}</td>
                                        <td>
                                            @foreach ($row->artists as $artist)
                                                {{ $artist->artist_name }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($row->sponsors as $sponsor)
                                                {{ $sponsor->sponsor_name }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $row->status }}</td>
                                        <td>
                                            @if($row->details_docs)
                                                Available docs
                                            @else
                                                No details docs
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{-- <a href="{{ route('manager.events.event_edit', $row->eid) }} ">
                                                <button class="btn btn-sm btn-primary">
                                                    <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                                </button>
                                            </a>
                                            <button class="btn btn-sm btn-danger"
                                                data-url="{{ route('manager.events.delete_event_view', $row->eid) }} "
                                                data-size="md" data-ajax-popup="true"
                                                data-title="{{ __('Delete Event') }}">
                                                <i class="ti ti-trash py-1" data-bs-toggle="tooltip" title="delete"></i>
                                            </button> --}}
                                            @if($row->details_docs)
                                                <a href="{{ route('manager.download.details.docs', $row->eid) }}" class="btn btn-sm btn-info">
                                                    <i class="ti ti-download"></i>
                                                </a>
                                            @endif
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

