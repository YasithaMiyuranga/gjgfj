@extends('layouts.app')
@section('page-title', __('Cash Flows'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.purchaseorder.view') }}">{{__('Cash Flow Manage') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Cash Flow Manage</h3>
                </div>
                <hr>
                    <div class="card-body table-border-styles">
                        <div class="table-responsive ordertable cash-flows-table order-items">
                            <table class="table data-table-cash-flow">
                                <thead>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($cashFlows as $row)
                                        <tr>
                                            <td>{{ $row->date }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->amount }}</td>
                                            <td>
                                                @if ($row->is_income == 1)
                                                    Income
                                                @elseif ($row->is_expense == 1)
                                                    Expense
                                                @endif
                                            </td>
                                            <td>
                                                <form id="deleteOrderForm" action="{{ route('useradmin.cashflow.delete', $row->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button id="deleteOrderButton" type="button" class="btn btn-sm btn-danger show_confirm" >
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Pagination links -->
                            <div class="cash-flow-pagination">
                                {{ $cashFlows->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
