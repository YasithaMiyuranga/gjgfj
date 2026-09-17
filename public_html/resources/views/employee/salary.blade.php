@extends('layouts.app')
@section('page-title', __('Employees'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.emp.salaryview') }}">{{ __('Emp Salary') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Salary List</h3>
            </div>
            <hr>
                <div class="card-header pb-0">
                <button class="btn btn-sm btn-primary me-2"
                    data-url="{{ route('useradmin.emp.salary.create') }}"
                    data-size="md" data-ajax-popup="true" data-title="{{ __('Add Salary') }}">
                  <i class="ti ti-plus py-1" title="Add Salary"></i> {{ __('Add Salary') }}
                </button>
            </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <th>Emp Id</th>
                                <th>Sid</th>
                                <th>Emp Name</th>
                                <th>Basic Amount</th>
                                {{-- <th>Net Amount</th> --}}
                                <th>ETF</th>
                                <th>EPF</th>
                                <th>Job Amount</th>
                                <th>Credit Amount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($details as $row)
                                    <tr>
                                        <td>{{$row->emp_id }}</td>
                                        <td>{{$row->id }}</td>
                                        <td>{{$row->name }}</td>
                                        <td>{{$row->basic_amount }}</td>
                                        {{-- <td>{{$row->net_amount }}</td> --}}
                                        <td>{{$row->etf }}</td>
                                        <td>{{$row->epf }}</td>
                                        <td>{{$row->job_amount }}</td>
                                        <td>{{$row->loan_amount }}</td>
                                        <td>{{$row->start_date }}</td>
                                        <td>{{$row->end_date }}</td>
                                        <td>{{$row->salary_status }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                data-url="{{ route('useradmin.emp.salary.edit', $row->id) }} "
                                                data-size="md" data-ajax-popup="true" data-title="{{ __('Edit Employee Salary') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>

                                            <form action="{{ route('useradmin.emp.salary.delete', $row->id) }} " method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger show_confirm" >
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
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
@endsection
