@extends('layouts.app')
{{-- @section('page-title', ('Cash Flow Order Wise')) --}}
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        @if (Str::endsWith(URL::previous(), '/viewinvoice'))
             <a href="{{ route('useradmin.order.view') }}">{{ ('Order Invoice') }}</a>
        @elseif( Str::endsWith(URL::previous(), '/view'))
            <a href="{{ route('useradmin.order.view') }}">{{ ('Order History') }}</a>
        @endif
        <li class="breadcrumb-item active">{{ ('Cash Flow ') }}</li>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>{{ $title }}</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable" id="cashFlowTable">
                            <thead>
                                <th>Date</th>
                                <th>Name</th>
                                <th class="text-end">Income</th>
                                <th class="text-end">Expence</th>
                                <th class="text-end">Action</th>

                            </thead>
                            <tbody>
                                @foreach ($cashFlows as $row)
                                    <tr>
                                        <td>{{ $row['date'] }}</td>
                                        <td>
                                            <p>{{ $row['name'] }}</p>
                                        </td>
                                        <td class="text-end">
                                            @if ($row['is_income'] == 1)
                                                {{ number_format($row['amount'], 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if ($row['is_expense'] == 1)
                                                {{ number_format($row['amount'], 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if ($row['type'] == 'additional_expense')
                                                <button class="btn btn-sm btn-primary "
                                                    data-title="{{ ('Edit  Expense') }}"
                                                    data-url="{{ route('useradmin.order.expenses.edit', $row['additional_expense_id']) }}"
                                                    data-size="md"
                                                    data-ajax-popup="true">
                                                   <i class="ti ti-pencil"></i>
                                                </button>
                                                <form action="{{ route('useradmin.order.expenses.destroy', $row['additional_expense_id']) }}"
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
                        <!-- Total Row -->
                        <div class="total-summary mt-3">
                            <div class="row mt-3">
                                <div class="col-8 col-md-9 text-end">
                                    <p class="font-weight-bold text-white">Total Income:</p>
                                </div>
                                <div class="col-4 col-md-2 text-end">
                                    <p class=" font-weight-bold text-white"> {{ number_format($totalIncome, 2) }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8 col-md-9 text-end">
                                    <p class="font-weight-bold text-white">Total Expense: </p>
                                </div>

                                <div class="col-4 col-md-2 text-end">
                                    <p class="font-weight-bold text-white"> {{ number_format($totalExpense, 2) }}</p>
                                </div>
                            </div>
                            <div class="row">
                            @if ($profitOrLoss > 0)
                                <div class="col-8 col-md-9 text-end">
                                    <p class="font-weight-bold text-success">Profit: </p>
                                </div>

                                <div class="col-4 col-md-2 text-end">
                                    <p class="font-weight-bold text-success align-middle"> {{ number_format($profitOrLoss, 2) }}</p>
                                </div>
                            @else
                                <div class="col-8 col-md-9 text-end">
                                    <p class="font-weight-bold text-danger">Loss: </p>
                                </div>

                                <div class="col-4 col-md-2 text-end">
                                    <p class="font-weight-bold text-danger"> {{ number_format($profitOrLoss, 2) }}</p>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
