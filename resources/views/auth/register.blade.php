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
        <div class="card-group ">
            <div class="card p-4 register-box">
                <div class="card-body">
                    @if(\Session::has('message'))
                        <p class="alert alert-info">
                            {{ \Session::get('message') }}
                        </p>
                    @endif
                    <form method="POST" action="{{ route('account-type') }}">
                        {{ csrf_field() }}
                        <h3 class="text-center text-primary mb-4"><b>Select Type Of User</b></h3>

                        <div class="form-check mb-3">
                          <input class="form-check-input" type="radio" name="user_type" id="gridRadios1" value="0" checked>
                          <label for="gridRadios1">
                            Customer
                          </label>
                        </div><br>
                        <div class="form-check mb-3">
                          <input class="form-check-input" type="radio" name="user_type" id="gridRadios2" value="1">
                          <label class="form-check-label" for="gridRadios2">
                            Merchant
                          </label>
                        </div> <br> 
                        <div class="row ">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary px-5 br-50">
                                Continue
                                </button>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <p>Already have an account?<a class="text-primary ml-3" href="{{ route('login') }}">Login here</a></p>
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