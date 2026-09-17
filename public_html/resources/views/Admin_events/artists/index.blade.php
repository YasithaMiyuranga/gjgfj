@extends('layouts.events')

@section('page-title', __('Events Artist'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.artist') }}">{{ __('Artist List') }}</a>
    </li>
@endsection

@section('content')
    <div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Artist List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2" data-url="{{ route('useradmin.events.create_artist') }}" data-size="md"
                        data-ajax-popup="true" data-title="{{ __('Add Artists') }}">
                        <i class="ti ti-plus py-1" data-bs-toggle="tooltip" title="Add Artist"></i>
                        Add Artist
                    </button>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                           <thead>
                                <tr>
                                    <th>{{ __('id') }}</th>
                                    <th>{{ __('Image')  }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Visible') }}</th>
                                    <th>{{ __('State') }}</th>
                                    <th>{{ __('Action') }}</th>

                                </tr>
                           </thead>
                           <tbody>
                            @foreach ($artists as $row)
                            <tr>
                                <td>{{ $row->aid }}</td>
                                <td><img src="{{ asset($row->image) }}" class="card-img-top" style="width: 50px; height: 50px;" alt="Artist Image"></td>
                                <td>{{ $row->artist_name }}</td>
                                <td>{{ $row->phone_no }}</td>
                                <td>{{ $row->visible }}</td>
                                <td>{{ $row->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary"
                                        data-url="{{ route('useradmin.events.edit_artist', [$row->aid]) }} "
                                        data-size="md" data-ajax-popup="true" data-title="{{ __('Edit Artist') }}">
                                        <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger"
                                            data-url="{{ route('useradmin.events.delete_artist_view', $row->aid) }} "
                                            data-size="md" data-ajax-popup="true"
                                            data-title="{{ __('Delete Artist') }}">
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
    </div>

    <!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">{{ __('Edit Artist') }}</h5>
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
@endsection

