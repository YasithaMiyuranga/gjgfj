@extends('layouts.guest')

@section('page-title')
    User Login Page
@endsection
@section('content')

    <div class="">

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form action="{{ route('user.loginuser') }}" method="POST" class="mobile responsive">
            @csrf
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Email Address') }}</label>
                <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            </div>
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Password') }}</label>
                <x-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="my-1 text-end">

            </div>

            <div class="d-grid">
                {{-- {!! Form::hidden('type', 'admin') !!} --}}
                <button class="btn btn-primary btn-block mt-2"> {{ __('Sign In') }} </button>
            </div>


            <p class="my-4 text-center">{{ __("Don't have an account?") }}
                <a href="{{route('user.registerstore')}}" class="my-4 text-primary">{{__('Register')}}</a>
            </p>



        </form>


    </div>
@endsection
