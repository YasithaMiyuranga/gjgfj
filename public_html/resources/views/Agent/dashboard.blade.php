@extends('layouts.agent')
@section('page-title', ('Dashboard'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('agent.dashboard') }}">{{ __('Overview') }}</a>
@endsection
@section('content')
    <h1>Agent Dashboard</h1>

@endsection
