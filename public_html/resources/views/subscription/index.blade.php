@extends('layouts.app')
@section('page-title', __('Subscribed Users'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.subscribers.view') }}">{{__('Subscribers') }}</a>
    </li>
@endsection
@section('content')
    <div class="row" style="justify-content: center">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Subscriber List</h3>
                </div>
                <hr>
                    <div class="card-body table-border-styles">
                        <div class="table-responsive">
                            <table class="table dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscribers as $subscriber)
                                        <tr>
                                            <td>{{ $subscriber->id ?? 'N/A' }}</td>
                                            <td>{{ $subscriber->email ?? 'N/A' }}</td>
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
