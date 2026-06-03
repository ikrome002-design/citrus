@extends('layouts.admin.auth')
@section('content')
    <div class="container mt-5">
        <div class=" row text-black adminLogin-box">
            <div class="card col-xl-4 col-lg-6 col-md-8 col-sm-10 mx-auto form p-4  rounded-0">
                <div class="px-2">

                    <form action="{{ route('admin.login.post') }}" method="post" class="justify-content-center">
                        @csrf
                        <h2 class="h2 text-secondary text-center">
                            Admin Login
                        </h2>
                        @include('layouts.errors-and-messages')
                        <div class="form-group">
                            <label class="sr-only">Email address</label>
                            <span class="mb-2 ml-2">Email address</span>
                            <input name="email" type="email" id="email" class="form-control br-50 bg-light"
                                value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <span class="font-normal mb-2 ml-2">Password</span>
                            <input name="password" type="password" id="password" class="form-control br-50 bg-light">
                        </div>
                        <div class="row pb-3">
                            <input type="text" hidden name="redirect"
                                value="{{ request()->redirect ?? old('redirect') }}">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-block br-50 btn-flat">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
