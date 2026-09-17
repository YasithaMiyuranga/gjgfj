@extends('layouts.app')
@section('page-title', ('Agreement Templates'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.agreement_templates.index') }}">{{('Agreement Templates') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>{{ ('Agreement Templates') }}</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between flex-row">
                        <a href="{{ route('useradmin.agreement_templates.create') }}" class="btn btn-primary me-2 btn-sm">
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
                                        <th>Template Description</th>
                                        <th>Default</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agreementTemplates as $agreementTemplate)
                                        <tr>
                                            <td>{{ $agreementTemplate->id }}</td>
                                            <td>{{ $agreementTemplate->name }}</td>
                                            <td style="white-space: normal; word-break: break-word;">{{ $agreementTemplate->content }}</td>
                                            <td>{{ $agreementTemplate->is_default ? 'Yes' : 'No'  }}</td>
                                            <td>
                                                <a href="{{ route('useradmin.agreement_templates.edit', $agreementTemplate->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                                </a>
                                                <form action="{{ route('useradmin.agreement_templates.destroy',  $agreementTemplate->id) }}"
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


