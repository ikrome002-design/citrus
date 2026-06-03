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
        <div class="col-md-4 col-md-offset-4 mx-auto login-form">
            <div class="card shadow-sm rounded-0">
                <h2 class="card-heading  heading-primary ">One Time Password</h2>
                
                <div class="card-body p-0">
                    <form action="{{ route('otp') }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="email" value="{{ Session::get('email') }}">
                    <div class="form-group">
                        <label for="email" class="control-label font-16 mb-0">Enter OTP <span style="color: red;">*</span></label>
                        <input type="text" id="otp" name="otp" value="" class="form-control border-light bg-light text-left" required="">
                    </div>
                   
                   
                    <div class="">
                        <button class="btn btn-primary btn-block btn-flat rounded-0" type="submit" name="new1" id="new1">Verify OTP</button>
                    </div>
                
                    </form><br>
                     <span style="color:red;">The OTP will expire in 10 minutes.</span>
                    <form action="{{ route('verify-email') }}" method="post" class="form-horizontal">
                     </span><br>
                        Didn't receive OTP? 
                        {{ csrf_field() }}
                         <input type="hidden" name="email" value="{{ Session::get('email') }}"><button class="btn btn-success" type="submit" name="new" id="new">RESEND</button>
                    </div></form>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

