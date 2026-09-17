@extends('layouts.guest')

@section('content')
<div class="container">
    <!-- Display validation errors -->
    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />

    <!-- Display success message -->
    @if (session('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required autofocus class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="password">New Password</label>
            <input type="password" name="password" id="password" required class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
@endsection
