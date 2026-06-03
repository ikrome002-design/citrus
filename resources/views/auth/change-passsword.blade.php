@php($title = 'Change password')
@extends('layouts.front.app')
@section('content')
    <section class="bg- bg-body-tertiary py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 m-auto">
                    <div class="card py-3 card border shadow-none mb-3">
                        <div class="card-body">
                            <h1 class="card-title text-center mb-3 h5">Change Password</h1>

                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="mb-3 form-floating">
                                    <input type="email" value="{{ old('email') }}" name="email" id="loginName"
                                        class="form-control border-0 border-bottom" placeholder="Enter your email" />
                                    <label class="form-label" for="loginName">Email you registered with</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" name="password" id="loginPassword"
                                        class="form-control border-0 border-bottom"
                                        placeholder="Enter password as required" />
                                    <label class="form-label" for="loginPassword">Enter a New Password</label>
                                    <p class="form-text text-muted small">Password must have minimum of 8 characters,
                                        at least a number, a upper case letter and a lower case letter</p>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" name="password_confirmation" id="loginPasswordConfirm"
                                        class="form-control border-0 border-bottom" placeholder="Enter password again" />
                                    <label class="form-label" for="loginPasswordconfirm">Enter Password Again</label>

                                </div>
                                <button type="submit" class="btn btn-primary w-100  mb-4">Change Password</button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
