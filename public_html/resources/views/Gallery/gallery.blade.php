
@extends('layouts.app')

@section('page-title', __('Gallery'))
@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.gallery.view') }}">{{__('Gallery') }}</a>
    </li>
@endsection

@section('content')
<div class="row">
    <div class = "col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Manage Gallery</h3>        
            </div> 
            <hr>
            <div class="card-header pb-0">
                <button class="btn btn-sm btn-primary me-2 text-center" data-url="{{ route('useradmin.gallery.create',['id' => 1]) }}" data-size="md"
                    data-ajax-popup="true" data-title="{{ __('Add Gallery') }}">
                    <i class="ti ti-plus py-1" data-bs-toggle="tooltip" title="Add Gallery"></i>
                    Add Gallery
                </button>
            </div>
            <div class="mb-4"></div>
            <div class="row">
                @foreach ($viewgallery as $row)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card">
                            <img  src="{{ asset($row->album_images) }}" class="card-img-top" style="width:100% ; height: 300px;"alt="Album Image">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $row->name }}</h5>
                                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                    data-bs-target="#detailsModal{{ $row->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a type="button" class="btn btn-info" href="{{ route('useradmin.gallery.albumview', $row->id) }}"><i class="fas fa-images"></i></a>

                                <button type="button" class="btn btn-danger mb-2" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $row->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </div>
                        </div>
                    </div>
                    <!-- Details Modal -->
                    <div class="modal fade" id="detailsModal{{ $row->id }}" tabindex="-1"
                        aria-labelledby="detailsModalLabel{{ $row->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailsModalLabel{{ $row->id }}">{{ $row->name }} Details
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset($row->album_images) }}" class="img-fluid mb-3"
                                        alt="Album Image">
                                    <p>{{ $row->description }}</p>
                                    <p>Tags: {{ $row->tags }}</p>
                                    <p>Date: {{ $row->date }}</p>
                                    <p>Event: {{ $row->event }}</p>

                                    <!-- Add "View Full Album" button -->
                                    <button type="button" class="btn btn-info"
                                        onclick="window.location.href='{{ route('useradmin.gallery.albumview', $row->id) }}'">
                                        <i class="fas fa-images"></i> View Full Album
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $row->id }}" tabindex="-1"
                        aria-labelledby="deleteModalLabel{{ $row->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $row->id }}">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this album?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button"
                                        onclick="window.location.href='{{ route('useradmin.gallery.delete', $row->id) }}'"
                                        class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Images Modal -->
                    <div class="modal fade" id="addImagesModal{{ $row->id }}" tabindex="-1"
                        aria-labelledby="addImagesModalLabel{{ $row->id }}" aria-hidden="true">

                    </div>
                @endforeach
            </div>
        </div>       
    </div>
</div>
@endsection
