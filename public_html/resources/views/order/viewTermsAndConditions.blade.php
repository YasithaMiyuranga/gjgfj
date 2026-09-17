@extends('layouts.app')

@section('page-title', __('Terms & Conditions'))

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.viewTermsAndConditions') }}">{{ __('Terms & Conditions') }}</a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Terms & Conditions</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.termsAndConditions.create') }}"
                        data-size="md"
                        data-ajax-popup="true"
                        data-title="{{ __('Add Terms & Conditions') }}">
                        <i class="ti ti-plus py-1" title="Add terms & conditions"></i> {{ __('Add Terms & Conditions') }}
                    </button>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($viewTermsAndConditions as $row)
                                    <tr>
                                        <td>{{ $row->title }}</td>
                                        <td style="white-space: normal; word-wrap: break-word;">{{ $row->description }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                data-url="{{ route('useradmin.termsAndConditions.edit', $row->id) }}"
                                                data-size="md" data-ajax-popup="true"
                                                data-title="{{ __('Edit Terms & Conditions') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            <form action="{{ route('useradmin.termsAndConditions.delete', $row->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                    <i class="fas fa-trash-alt" data-bs-toggle="tooltip" title="delete"></i>
                                                </button>
                                            </form>
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
