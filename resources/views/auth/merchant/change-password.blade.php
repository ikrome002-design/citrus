@php($title = 'Reset PAssword')
@extends('layouts.merchant.auth')
@section('content')
    <div class="container">
        <div class="row marchent-loginBox">
            <div class="card  col-xl-4 col-lg-6 col-md-8  mx-auto form py-5 mt-5 rounded-0">

                <div class="row">
                    <div class="col-md-9 mx-auto">

                        <form action="{{ route('password.update') }}" method="post" class="justify-content-center">
                            @csrf
                            <h2 class="card-heading  heading-primary text-secondary">
                                Change Password</h2>
                            <p class="font-18 font-light mb-4 mt-2">Enter your new password</p>
                            @include('layouts.errors-and-messages')
                            <div class="form-group">
                                <span>New Password</span>
                                <input name="password" type="password" class="form-control br-50 bg-light"
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                <small class="text-muted">Password must contain at least lowercase, uppercase letter,
                                    digit and minimum of
                                    8 character</small>
                            </div>
                            <div class="form-group">
                                <span>Enter Password Again</span>
                                <input name="password_confirmation" type="password" class="form-control br-50 bg-light"
                                    required>
                            </div>
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Change</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
