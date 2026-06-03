@extends('layouts.front.app')

@section('content')
<hr>
<section class="contact_page_section_main ">
    <div class="container">
        <div class="col-md-12">@include('layouts.errors-and-messages')</div>
        <div class="col-md-4 col-md-offset-4 mx-auto login-form">
            <div class="card shadow-sm rounded-0">
                <h2 class="card-heading font-36 heading-primary mb-4">Forgot password</h2>
                <div class="card-body p-0">
                    <form action="{{ route('ResetPasswordUser') }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email" class="control-label font-14 mb-2 ">Enter your email address and we'll send your password on Email.</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control border-light bg-light text-left" placeholder="Enter your email" required>
                        @if ($errors->has('email'))
                            <span class="help-block font-14 text-danger mt-3 d-block">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-0">
                        <button class="btn btn-primary btn-block btn-flat rounded-0" type="submit"> Submit</button>
                    </div>
                     <div class="form-group text-center footer_login">
                            <a href="{{ url('/login') }}" class="login_create_link"><span class="left-arrow"></span>Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
         </div>
    </section>

@endsection
