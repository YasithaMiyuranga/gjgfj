@extends('layouts.guest')
@section('page-title')
   User Register Page
@endsection
@section('content')
    <div class="">
        <h2 class="mb-3 f-w-600"> User Register</h2>
    </div>
    <div class="">
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <form method="POST" action="{{ route('user.registerstore') }}">
            @csrf
            <div class="form-group mb-3">
                <label class="form-label" for="name">{{ __('Enter Name') }}</label>
                <x-input id="name " class="form-control" type="text" name="name" required autofocus />
            </div>

            <div class="form-group mb-3">
                <label class="form-label" for="email">{{ __('Enter Email') }}</label>
                <x-input id="email" class="form-control" type="email" name="email"  required />
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="password">{{ __('Enter Password') }}</label>
                <x-input id="password" class="form-control" type="password" name="password" required />
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                <x-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required />
            </div>
            <div class="d-grid">
                <button class="btn btn-primary btn-block mt-2" type="submit"> {{ __('Sign Up') }} </button>
            </div>
        </form>
    </div>

    <p class="mb-2 text-center">
        Already have an account?
        <a href="{{ route('user.loginuser') }}" class="f-w-400 text-primary">Signin</a>
    </p>
@endsection
