@extends('layouts.app')
@section('page-title', ('Permissions'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.permissions.index') }}">{{ ('Permissions') }}</a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Permissions</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    {{-- <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.permissions.create') }}"
                        data-size="md" data-ajax-popup="true" data-title="{{ ('Add Permissions') }}">
                        <i class="ti ti-plus py-1" title="Add Permissions"></i> {{ ('Add Permissions') }}
                    </button> --}}
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Permissions Id</th>
                                        <th>Permissions Name</th>
                                        <th>Permissions Description</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $row)
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td style="white-space: normal; word-wrap: break-word;">{{ $row->description }}</td>
                                            {{-- <td>
                                                <button class="btn btn-sm btn-primary me-2"
                                                    data-url="{{ route('useradmin.permissions.edit', $row->id) }}"
                                                    data-size="md" data-ajax-popup="true"
                                                    data-title="{{ ('Edit Permissions') }}">
                                                    <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                                </button>
                                                <form action=" {{ route('useradmin.permissions.destroy', $row->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                        <i class="fas fa-trash-alt" data-bs-toggle="tooltip" title="delete"></i>
                                                    </button>
                                                </form>
                                            </td> --}}
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
