@extends('layouts.events')
@section('page-title', __('Agenda'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.agenda.view') }}">{{ __('Agenda') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Agenda List</h3>
            </div>
            <hr>
            <div class="card-header pb-0">
                <a href="{{ route('useradmin.agenda.add') }}">
                    <button class="btn btn-sm btn-primary me-2 mb-3"
                        data-title="{{ ('Add Agenda') }}">
                        <i class="ti ti-plus py-1" title="Add Agenda"></i> {{ ('Add Agenda') }}
                    </button>
                </a>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table descending-order">
                    <thead>
                        <tr>
                            <th>Agenda Id</th>
                            <th>Event Id And Name</th>
                            <th>Agenda Dates</th>
                            <th>Agenda Date Names</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($eventsWithAgendas as $event) --}}
                        @foreach ($agendas as $agenda)
                            <tr>
                                <td>{{ $agenda->id }}</td>
                                <td>{{ $agenda->event_id }} - {{ $agenda->event_name }}</td>
                                <td>{{ $agenda->date }}</td>
                                <td>{{ $agenda->date_name }}</td>
                                <td>
                                    <a href="{{ route('useradmin.agenda.edit', $agenda->id) }}"
                                        class="btn btn-sm btn-primary"
                                        data-title="{{ __('Edit Agenda') }}">
                                        <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger"
                                        data-url="{{ route('useradmin.agenda.delete_view', $agenda->id) }} "
                                        data-size="md" data-ajax-popup="true"
                                        data-title="{{ __('Delete Agenda') }}">
                                        <i class="ti ti-trash py-1" data-bs-toggle="tooltip" title="delete"></i>
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
@endsection
