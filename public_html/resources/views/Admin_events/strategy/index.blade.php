@extends('layouts.events')

@section('page-title', __('Strategies'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.strategies.index') }}">{{ __('Strategies') }}</a>
    </li>
@endsection

@section('content')
    <div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3>Strategies List</h3>
                </div>
                <hr>
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <a href="{{ route('useradmin.strategies.create') }}">
                        <button class="btn btn-sm btn-primary me-2">
                            <i class="ti ti-plus py-1" data-bs-toggle="tooltip" title="Create Strategy"></i>
                            Create Strategy
                        </button>
                    </a>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Strategy Name</th>
                                    <th>Category</th>
                                    <th>Is Default</th>
                                    <th>Options</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($strategies as $strategy)
                                    <tr>
                                        <td>{{ $strategy->id }}</td>
                                        <td>{{ $strategy->name }}</td>
                                        <td>{{ $strategy->category->category_name ?? 'N/A' }}</td>
                                        <td>{{ $strategy->is_default ? 'Yes' : 'No' }}</td>
                                        <td>
                                            @foreach($strategy->options as $option)
                                                <span class="badge bg-info">{{ $option->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('useradmin.strategies.edit', $strategy->id) }}" class="btn btn-primary btn-sm">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="Edit Strategy"></i>
                                            </a>
                                            <form action="{{ route('useradmin.strategies.destroy', $strategy->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                    <i class="fas fa-trash-alt" data-bs-toggle="tooltip" title="Delete Strategy"></i>
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
