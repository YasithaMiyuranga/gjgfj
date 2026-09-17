@extends('layouts.events')

@section('page-title', __('Events Teams'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.team') }}">{{ __('Teams List') }}</a>
    </li>
@endsection

@section('content')
    <div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Teams List</h3>
                </div>
                <hr>
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <a href="{{ route('useradmin.events.create_team') }}">
                        <button class="btn btn-sm btn-primary me-2">
                            <i class="ti ti-plus py-1" data-bs-toggle="tooltip" title="Create Team"></i>
                            Create Team
                        </button>
                    </a>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>Team ID</th>
                                    <th>Event</th>
                                    <th>Team Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teams as $eventId => $teamGroup)
                                    @php
                                        $event = $teamGroup->first()->event;
                                        $rowspan = $teamGroup->count();
                                    @endphp

                                    @foreach ($teamGroup as $index => $team)
                                        <tr>
                                            <td>{{ $team->team_category_id }}</td>
                                            <td>{{ $event->event_name }}</td>
                                            <td>{{ $team->team_name }}</td>
                                            <td>
                                            <a href="{{ route('useradmin.events.edit_team', ['team_id' => $team->team_category_id]) }}" class="btn btn-primary btn-sm">
                                                  <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="Edit Team"></i>
                                            </a>
                                            <form action="{{ route('useradmin.events.delete_team', ['team_id' => $team->team_category_id]) }}" method="GET" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger show_confirm" >
                                                    <i class="fas fa-trash-alt" data-bs-toggle="tooltip" title="delete"></i>
                                                </button>
                                            </form>
                                        </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">{{ __('Edit Teams') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display errors here -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#teamTable').DataTable({
                "columns": [
                    { "title": "Event", "orderable": true },
                    { "title": "Team Name", "orderable": true },
                    { "title": "Action", "orderable": false }
                ],
                "autoWidth": false, // important to avoid DataTables guessing column widths
                "ordering": true
            });
        });
    </script>

@endsection

