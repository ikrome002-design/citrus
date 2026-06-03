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
                <h2 class="card-heading  heading-primary ">Email Verification </h2>
                
                <div class="card-body p-0">
                    <form action="{{ route('verify-email') }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email" class="control-label font-20 mb-0">Email address<span style="color: red;">*</span></label>
                        <?php if(!empty(Session::get('email'))){?>
                        <input type="email" id="email" name="email" value="{{ Session::get('email') }}" class="form-control border-light bg-light text-left" required="">
                    <?php }else{?>
                        <input type="email" id="email1" name="email" value="" class="form-control border-light bg-light text-left" required="">
                    <?php }?>
                    </div>
                   
                   
                    <div class="">
                        <button class="btn btn-primary btn-block btn-flat rounded-0" type="submit">Continue</button>
                    </div>
                    
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

