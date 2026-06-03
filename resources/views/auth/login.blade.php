@extends('layouts.front.app')
@section('content')
    <hr>
    <!-- Main content -->

    <section class="contact_page_section_main ">
        <div class="container">
        <div class="col-md-12">
            @include('layouts.errors-and-messages')
            
             @if (session('success'))
                      <div class="alert alert-success alert-dismissable fade show" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h4><i class="icon fa fa-check fa-fw" aria-hidden="true"></i> Success</h4>
                        {{ session('success') }}
                      </div>
                      @endif
                      
        </div>
        <div class="col-md-4 col-md-offset-4 mx-auto customerLogin-box">
            <div class="card p-5">
                <h2 class="card-heading mb-3 heading-primary text-primary text-center">Customer Login</h2>
                <div class="card-title text-center">Get access to your Orders, Wishlist and Recommendations</div>
                <div class="card-body p-0">
                    <form action="{{ route('login') }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="csrf_token" value="">
                    <div class="form-group mb-3">
                        <label for="email" class="control-label font-16 mb-1 ml-2">Email address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="br-50 form-control border-light bg-light text-left" autofocus>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="control-label font-16 mb-1 ml-2">Password</label>
                        <input type="password" name="password" id="password" value="" class=" br-50 form-control border-light bg-light text-left">
                    </div>
                    <div class="">
                        <button class="btn btn-primary btn-block btn-flat" type="submit">Sign in</button>
                    </div>
                    <div class="form-group text-center footer_login mt-4">
                                <a href="{{route('register')}}" class="login_create_link text-primary"><span class="left-arrow"></span>Create an account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

