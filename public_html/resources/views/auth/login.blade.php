@extends('layouts.guest')
@section('page-title')
    Login Page
@endsection
@section('content')
    <div class="">
        {{-- <h2 class="mb-3 f-w-600">{{ __('Sign in') }}</h2> --}}
    </div>
    <div class="">
        <!-- Session Status -->
        {{--  <x-auth-session-status class="mb-4" :status="session('status')" /> --}}
         <!-- Display validation errors -->
        <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
        <!-- Display success message -->
        @if (session('message'))
            <div class="alert alert-success mb-4">
                {{ session('message') }}
            </div>
        @endif
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Email Address') }}</label>
                <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required
                    autofocus />
            </div>
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Password') }}</label>
                <x-input id="password" class="form-control" type="password" name="password" required
                    autocomplete="current-password" />
            </div>
            <div class="my-1 text-end">
                <a href="{{ route('password.request') }}" class="text-primary">{{ __('Forgot Password?') }}</a>
            </div>
            <div class="d-grid">
                {{-- {!! Form::hidden('type', 'admin') !!} --}}
                <button class="btn btn-primary btn-block mt-2"> {{ __('Log in') }} </button>
            </div>
        </form>
    </div>
@endsection
