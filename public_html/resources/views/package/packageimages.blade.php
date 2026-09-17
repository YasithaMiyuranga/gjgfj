@extends('layouts.app')
@section('page-title', ( 'Package Images'))
@section('action-button')
@endsection
@section('breadcrumb')
@endsection
@section('content')
    <div class="d-flex d-lg-block justify-content-center"><br>
       <h2>{{ $package->package_name }} Images</h2>
        <hr>
        <button class="btn btn-sm btn-primary me-2"
            data-url="{{ route('useradmin.package.images.create', ['id' => $package->package_id]) }}" data-size="md"
            data-ajax-popup="true" data-title="{{ __('Add Package Images') }}">
            <i class="fas fa-user-edit py-1" data-bs-toggle="tooltip" title="Add Package Images"></i>
            Add Package Images
        </button>
    </div>
    <div class="mb-4"></div>
    <div class="row">
        <div class="row">
            @if( $packageImages->isEmpty() )
                <div class="col-lg-12 text-center">
                    <h4>No Package Images </h4>
                </div>
            @endif
            @foreach ( $packageImages as $packageImage )
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex">
                    <div class="card h-100 w-100 d-flex flex-column justify-content-between">
                        <img src="{{ asset($packageImage->image_path) }}" class="card-img-top" alt="Package Image"
                         style="width: 100%; height: 300px; object-fit: cover; margin: 0 auto;">
                        <div class="card-body text-center mt-auto">
                            <button type="button" class="btn btn-danger mb-2" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $packageImage->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Delete Modal --}}
                <div class="modal fade" id="deleteModal{{ $packageImage->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel{{ $packageImage->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $packageImage->aid }}">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this package image?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button"
                                    onclick="window.location.href='{{ route('useradmin.package.images.delete', $packageImage->id) }}'"
                                    class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
