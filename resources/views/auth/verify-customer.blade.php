
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
                <h2 class="card-heading  heading-primary ">Verify email</h2>
                <p>Please verify your email address by clicking the link in the mail we just sent you. Thanks!</p>
                <div class="card-body p-0">
                    <form action="{{ route('verification.send') }}" method="post">
                    <button type="submit">Request a new link</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

