@php($title = 'Fogot Password')
@extends('layouts.vendor.auth')
@section('content')
    <div class="container">
        <div class="row marchent-loginBox">
            <div class="row marchent-loginBox">
                <div class="card  col-xl-4 col-lg-6 col-md-8  mx-auto form py-5 mt-5 rounded-0">

                    <div class="row">
                        <div class="col-md-9 mx-auto">

                            <form action="{{ route('password.email') }}" method="post" class="justify-content-center">
                                @csrf
                                <h2 class="card-heading  heading-primary text-secondary">
                                    Forgot Password</h2>
                                <p class="font-18 font-light mb-4 mt-2">Ge a link to change your password.</p>
                                @include('layouts.errors-and-messages')
                                <div class="form-group">
                                    <label class="sr-only">Email address</label>
                                    <span>Email address</span>
                                    <input name="email" type="email" id="email" class="form-control br-50 bg-light"
                                        value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
