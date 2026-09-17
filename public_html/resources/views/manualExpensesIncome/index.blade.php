@extends('layouts.app')
@section('page-title', __('Manual Inc. & Exp.'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.manual.expenses.income.view') }}">{{__('Manual Expenses Income List') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Manual Expenses Income List</h3>
            </div>
            <hr>
            <div class="card-header pb-0">
                <button class="btn btn-sm btn-primary me-2"
                    data-title="{{ __('Add Manual Expenses') }}"
                    data-size="md" data-ajax-popup="true" data-url="{{ route('useradmin.manual.expenses.income.store') }}">
                    <i class="ti ti-plus py-1" title="Add Manual Expenses"></i> {{ ('Add Manual Expenses') }}
                </button>
            </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($manualExpenses as $row)
                                    <tr>
                                        <td>{{$row->date }}</td>
                                        <td>{{$row->name }}</td>
                                        <td>{{$row->amount }}</td>
                                        <td>{{$row->type }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary me-2"
                                            data-url="{{ route('useradmin.manual.expenses.income.edit', $row->id) }}"
                                            data-size="md" data-ajax-popup="true" data-title="{{ __('Edit manual Expenses Income') }}">
                                            <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            <form action="{{ route('useradmin.manual.expenses.income.delete', $row->id) }}" method="POST" class="d-inline">
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
@endsection
