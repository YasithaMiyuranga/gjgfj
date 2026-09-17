@extends('layouts.events')
@section('page-title', __('Task Templates'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.task_templates.index') }}">{{ __('Task Templates') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>{{ ('Task Templates') }}</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between flex-row">
                        <a href="{{ route('useradmin.task_templates.create') }}" class="btn btn-primary me-2 btn-sm">
                            <i class="ti ti-plus py-1" title="Add Template"></i> {{ ('Create Template') }}
                        </a>
                    </div>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Template Id</th>
                                        <th>Template Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($taskTemplates as $taskTemplate)
                                        <tr>
                                            <td>{{ $taskTemplate->id }}</td>
                                            <td>{{ $taskTemplate->template_name }}</td>
                                            <td>
                                                <a href="{{ route('useradmin.task_templates.edit', $taskTemplate->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                                </a>
                                                <form action="{{ route('useradmin.task_templates.destroy',  $taskTemplate->id) }}"
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
    </div>
@endsection


