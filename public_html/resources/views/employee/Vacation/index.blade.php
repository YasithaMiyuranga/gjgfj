@extends('layouts.employee')
@section('page-title', ('Vacations'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('employee.vacations') }}">{{ ('Vacations') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3 class="pb-1">{{ ('My Vacation List') }}</h3>
                    <p class="mb-0">This page allows employees to request leaves and view their leave history. It displays details such as start and end dates, reasons, status, and actions related to their leave requests.</p>
                </div>
                <hr>
               <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('employee.vacations.create')  }}"
                        data-size="md" data-ajax-popup="true"
                        data-title="{{ ('Request Vacation') }}">
                        <i class="ti ti-plus py-1" title="Request Vacation"></i> {{ ('Request Vacation') }}
                    </button>
                </div>
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vacations as $vacation)
                                    <tr>
                                        <td>{{ $vacation->get_date ?? 'N/A' }}</td>
                                        <td>{{ $vacation->return_date ?? 'N/A' }}</td>
                                        <td style="white-space: normal; word-wrap: break-word;">{{ $vacation->reason ?? 'N/A' }}</td>
                                        <td>{{ $vacation->status ?? 'N/A' }}</td>
                                       <td>
                                           @if($vacation->status == 'pending')
                                                <button class="btn btn-sm btn-primary "
                                                    data-url="{{ route('employee.vacations.edit', $vacation->id) }}"
                                                    data-size="md" data-ajax-popup="true"
                                                    data-title="{{ ('Edit Vacation') }}">
                                                    <i class="ti ti-pencil"></i>
                                                </button>
                                                <form action="{{ route('employee.vacations.destroy',  $vacation->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                        <i class="fas fa-trash-alt" data-bs-toggle="tooltip" title="delete"></i>
                                                    </button>
                                                </form>
                                           @endif
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
