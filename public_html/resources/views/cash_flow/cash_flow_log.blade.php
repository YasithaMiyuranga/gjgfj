@extends('layouts.app')
@section('page-title', ('Cash Flow Log'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.cashflow.logs') }}">{{('Cash Flow Log') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Cash Flow Logs</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>{{ ('Log Id') }}</th>
                                    <th>{{ ('Cash Flow Id') }}</th>
                                    <th>{{ ('Action') }}</th>
                                    <th>{{ ('Date') }}</th>
                                    <th>{{ ('Previous Amount') }}</th>
                                    <th>{{ ('New Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cashFlowLogs as $log)
                                    <tr>
                                        <td>{{ $log->id }}</td>
                                        <td>{{ $log->cashflow_id }}</td>
                                        <td>{{ $log->action }}</td>
                                        <td>{{ $log->date }}</td>
                                        <td>
                                            @if(isset($log->previous_amount))
                                                {{ number_format($log->previous_amount, 2) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($log->current_amount))
                                                {{ number_format($log->current_amount, 2) }}
                                            @else
                                                N/A
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
