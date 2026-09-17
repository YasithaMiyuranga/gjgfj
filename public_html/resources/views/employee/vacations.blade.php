@extends('layouts.app')
@section('page-title', ('Vacations'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.vacations') }}">{{ ('Vacations') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>{{ ('Vacation List') }}</h3>
                </div>
                <hr>
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Get Date</th>
                                    <th>Return  Date</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vacations as $vacation)
                                    <tr>
                                        <td>{{ $vacation->emp_name ?? 'N/A' }}</td>
                                        <td>{{ $vacation->get_date ?? 'N/A' }}</td>
                                        <td>{{ $vacation->return_date ?? 'N/A' }}</td>
                                        <td style="white-space: normal; word-wrap: break-word;">{{ $vacation->reason ?? 'N/A' }}</td>
                                        <td>{{ $vacation->status ?? 'N/A' }}</td>
                                       <td>
                                            <button class="btn btn-sm btn-primary "
                                                data-url="{{ route('useradmin.vacations.edit', $vacation->id) }}"
                                                data-size="md" data-ajax-popup="true"
                                                data-title="{{ ('Edit Vacation') }}">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <form action="{{ route('useradmin.vacations.destroy',  $vacation->id) }}"
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
