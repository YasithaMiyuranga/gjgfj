@extends('layouts.app')
@section('page-title', ('Accounts'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.order.expense.view') }}">{{('Expenses') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Expenses List</h3>
            </div>
            <hr>
            <div class="card-header pb-0">
                <button class="btn btn-primary btn-sm"
                    data-url="{{ route('useradmin.order.expenses.create', 0) }}"
                    data-size="md" data-ajax-popup="true" data-title="{{ ('Add Expense') }}">
                    <i class="ti ti-plus py-1" title="Add"></i>{{ ('Add Expense') }}
                </button>
            </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                            <tr>
                                <th>{{ ('Expense Id') }}</th>
                                <th>{{ ('Event Name') }}</th>
                                <th>{{ ('Order ID') }}</th>
                                <th>{{ ('Expense Name') }}</th>
                                <th>{{ ('Amount') }}</th>
                                <th>{{ ('Expense Date') }}</th>
                                <th>{{ ('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->order->event_name }}</td>
                                        <td>{{ $row->order_id }}</td>
                                        <td>{{ $row->expense_name }}</td>
                                        <td>{{ $row->amount }}</td>
                                        <td>{{ $row->expense_date }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary "
                                                data-title="{{ ('Edit Order Expense') }}"
                                                data-url="{{ route('useradmin.order.expenses.edit', $row->id) }}"
                                                data-size="md"
                                                data-ajax-popup="true">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <form action="{{ route('useradmin.order.expenses.destroy', $row->id) }}"
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






