@extends('layouts.app')

@section('page-title', __('Gallery'))
@section('action-button')
@endsection

@section('breadcrumb')
@endsection

@section('content')
    <div class="d-flex d-lg-block justify-content-center"><br>
        <h2>Manage Album Images</h2>
        <hr>
        <button class="btn btn-sm btn-primary me-2"
            data-url="{{ route('useradmin.album.create', ['id' => request()->segment(3)]) }}" data-size="md"
            data-ajax-popup="true" data-title="{{ __('Add Gallery') }}">
            <i class="fas fa-user-edit py-1" data-bs-toggle="tooltip" title="Add Gallery"></i>
            Add Album Images
        </button>
    </div>
    <div class="mb-4"></div>
    <div class="row">
        <div class="row">
            @foreach ($view_albums as $row)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex">
                    <div class="card h-100 w-100 d-flex flex-column justify-content-between">
                        <img src="{{ asset($row->image) }}" class="card-img-top" alt="Album Image">

                        <form method="POST"
                            action="{{ route('useradmin.album.updateMeta', ['aid' => $row->aid, 'id' => $row->album_id]) }}">
                            @csrf

                            <div class="mt-3 p-3">
                                <label for="image_name_{{ $row->aid }}" class="form-label">{{ __('Name') }}</label>
                                <input required class="form-control" name="image_name" type="text"
                                    id="image_name_{{ $row->aid }}"
                                    value="{{ $row->meta ? $row->meta->image_name : '' }}">

                                <label for="image_alt_{{ $row->aid }}"
                                    class="form-label mt-2">{{ __('Alt') }}</label>
                                <input required class="form-control" name="image_alt" type="text"
                                    id="image_alt_{{ $row->aid }}"
                                    value="{{ $row->meta ? $row->meta->image_alt : '' }}">


                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <span id="albumImageMetaError"
                                                    style="color: red;">{{ $error }} </span>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif





                                <button type="submit" class="btn btn-sm btn-success mt-3 col-12">Save</button>
                            </div>
                        </form>

                       


                        <div class="card-body text-center mt-auto">
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                data-bs-target="#detailsModal{{ $row->id }}">
                                <i class="fas fa-eye"></i>
                            </button>

                            <button type="button" class="btn btn-danger mb-2" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $row->aid }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Delete Modal --}}
                <div class="modal fade" id="deleteModal{{ $row->aid }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel{{ $row->aid }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $row->aid }}">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this album?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button"
                                    onclick="window.location.href='{{ route('useradmin.album.delete', $row->aid) }}'"
                                    class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@endsection
