@extends('layouts.guest')

@section('page-title')
    Forgot Password
@endsection
@section('content')
    <div >
        <h4 class="mb-3">{{ __('Forgot Your Password?') }}</h4>
        <p class="mb-4">{{ __('Enter your email address to receive a password reset link.') }}</p>
    </div>
  <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
    <!-- Display success message -->
    @if (session('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="email">{{ __('Email Address') }}</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus />
        </div>

        <div class="d-grid">
            <button class="btn btn-primary btn-block">{{ __('Send Password Reset Link') }}</button>
        </div>
    </form>
@endsection
