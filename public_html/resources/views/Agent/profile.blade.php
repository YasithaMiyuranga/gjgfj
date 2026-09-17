@extends('layouts.agent')
@section('page-title', ('Agent Profile'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('agent.profile') }}">{{ __('profile') }}</a>
    </li>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <!-- Profile Update Section -->
            <div class="col-md-8 mt-4">
                <div class="card" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header text-center">
                        <h3>{{ __('Agent Profile') }}</h3>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        <form id="ProfileForm" action="{{ Route('agent.updateprofile') }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-wrapper-one shadow-sm rounded">
                                <div class="mb-3">
                                    <label for="emailForm2" class="form-label">Email</label>
                                    <input type="text" id="emailForm2" name="email" class="form-control" value="{{  Auth::guard('agent')->user()->email  }}" readonly>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') ??  Auth::guard('agent')->user()->name  }}" readonly>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ old('phone_number') ??  Auth::guard('agent')->user()->phone  }}">
                                    @if ($errors->has('phone_number'))
                                        <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="agent_type" class="form-label">Type</label>
                                    <input type="text" id="agent_type" name="agent_type" class="form-control" value="{{  Auth::guard('agent')->user()->type  }}" readonly>
                                    @if ($errors->has('agent_type'))
                                        <span class="text-danger">{{ $errors->first('agent_type') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3 text-end">
                                    <button id="updateBtn" class="btn btn-primary btn-medium" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Password Change Section -->
            <div class="col-md-8 mt-4">
                <div class="card" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header text-center">
                        <h3>{{ __('Agent Password Change') }}</h3>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        <form id="changePasswordForm" action="{{ Route('agent.updatepassword') }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-wrapper-one shadow-sm rounded">
                                <div class="mb-3">
                                    <label for="old_password" class="form-label">Current Password</label>
                                    <input type="password" id="old_password" name="old_password" class="form-control" value="{{ old('old_password') }}">
                                    @if ($errors->has('old_password'))
                                        <span class="text-danger">{{ $errors->first('old_password') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" id="new_password" name="new_password" class="form-control" value="{{ old('new_password') }}">
                                    @if ($errors->has('new_password'))
                                        <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" value="{{ old('confirm_password') }}">
                                    @if ($errors->has('confirm_password'))
                                        <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3 text-end">
                                    <button id="changePasswordBtn" class="btn btn-primary btn-medium" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
