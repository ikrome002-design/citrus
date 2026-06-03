@extends('layouts.front.app')
@section('content')
@include('layouts.errors-and-messages')
<style type="text/css">
    .form-check{
    border: solid #e4e7ea 2px;
    padding: 6px;
    padding-left: 38px;
}
</style>
<div class="contact_page_section_main">

<div class="row">
<div class="container">
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    @if(\Session::has('message'))
                        <p class="alert alert-info">
                            {{ \Session::get('message') }}
                        </p>
                    @endif
                    
                    <form method="POST" action="{{ route('create-account-form') }}">
                        {{ csrf_field() }}
                        <h3 class="text-center"><b>Select Type Of Account</b></h3>
                        <input type="hidden" name="user_type" value="{{ $_SESSION['user_type'] }}">

                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="account_type" id="gridRadios1" value="0" checked>
                          <label for="gridRadios1">
                            <b>Individual</b>
                            <p>For Freelancets,sole traders and unregistered businesses</p>
                          </label>
                        </div><br>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="account_type" id="gridRadios2" value="1">
                          <label class="form-check-label" for="gridRadios2">
                            <b>Registered Business</b>
                            <p>For Freelancets,sole traders and unregistered businesses</p>
                          </label>
                        </div> <br> 
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="account_type" id="gridRadios3" value="2">
                          <label class="form-check-label" for="gridRadios3">
                           <b> Non-Governmental Organization</b>
                            <p>For Freelancets,sole traders and unregistered businesses</p>
                          </label>
                        </div> <br> 

                        
                        <div class="row ">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary px-4 " >
                                Continue
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <p>Already have an account?<a href="{{ route('vendor.login') }}">Login here</a></p>
                            </div>
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection