@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Employee Dashboard') }}</div>

                    <div class="card-body">
                        <p>Welcome to the User dashboard,
                            <strong>{{ Auth::user()->UserName }}</strong>!
                        </p>
                        <form method="POST" action="{{ route('user.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
