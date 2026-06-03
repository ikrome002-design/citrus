@php($title = 'Register')
@extends('layouts.merchant.auth')
@section('css')
    <style>
        @media (max-width: 768px) {
            .wizard .steps ul {
                display: flex;
                flex-direction: column;
            }

            .wizard .content {
                margin-top: 20px;
            }

            .wizard .steps ul li {
                width: 100%;
            }

            .wizard .steps ul li a {
                text-align: center;
                padding: 2px;
            }
        }

        .current a,
        .actions a,
        .current a:hover,
        .actions a:hover {
            color: white !important;
        }

        .wizard>.actions .disabled a,
        .wizard>.actions .disabled a:active,
        .wizard>.actions .disabled a:hover {
            background: #eee !important;
            color: #aaa !important;
        }
    </style>
@endsection
@section('content')
    <div class="row ">
        <div class="col-lg-8 mx-auto">
            <form method="POST" id="vendor-reg-form" action="{{ route('merchant.register.post') }}">
                @csrf
                <h1 class="mb-3 text-center h3"><b>Create Merchant Account</b></h1>
                <h6 class="mb-3 text-primary"> <i class="fa-solid fa-info-circle"></i> If you already have a
                    customer
                    account,
                    please
                    <a href="{{ route('merchant.login') }}" class="text-secondary">login</a> before you create merchant account.
                </h6>
                @include('partial.error-messages')
                <div id="vendor-reg-steps">
                    <h3>Type of Account</h3>
                    <section class="row">
                        <div class="col-md-12">
                            <h5>Select Account type<span class="text-danger">*</span></h5>
                            @foreach ($acc_types as $a)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="account_type" value="Individual"
                                        required {{ old('account_type') == $a ? 'checked' : '' }}>
                                    <label for="gridRadios1">
                                        <b>{{ $a->name }}</b><br>
                                        <small class="text-muted">{{ $a->account_description }}</small>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    <h3>Personal Details</h3>
                    <section class="row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Enter Your First Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control " id="first_name" placeholder="" name="first_name"
                                required="" value="{{ old('first_name') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Enter Your Last Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control " id="inputnew" placeholder="" name="last_name"
                                value="{{ old('last_name') }}" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Enter Your Email Address<span class="text-danger">*</span></label>
                            <input type="email" class="form-control " id="inputEmail4" placeholder="" name="email"
                                required="" value="{{ old('email') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Enter Your Phone Number</label>
                            <input type="text" class="form-control " name="phone_number" required=""
                                value="{{ old('phone_number') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control " id="password" placeholder="" name="password"
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                            <small class="text-muted">Password must contain at least lowercase, uppercase letter,
                                digit and minimum of
                                8 character</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control " id="password-confirm" placeholder=""
                                name="password_confirmation" required>
                        </div>
                    </section>

                    <h3> Business Details</h3>
                    <section class="row">
                        <div class="form-group col-md-6">
                            <label for="inputAddress">Business Name</label>
                            <input type="text" class="form-control " id="inputAddressfg" placeholder=""
                                name="business_name" value="{{ old('business_name') }}" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Type Of Business</label>
                            <select class="form-control" name="business_type" required="">
                                @foreach ($business_types as $b)
                                    <option value="{{ $b->id }}"
                                        {{ old('business_type') == $b->id ? 'selected' : '' }}>
                                        {{ $b->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-md-6">
                            <label for="inputCity">Business Email</label>
                            <input type="text" class="form-control" name="business_email"
                                value="{{ old('business_email') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAddress2">Location Of Business</label>
                            <input type="text" class="form-control " id="inputAddress2" placeholder=""
                                name="business_location" required="" value="{{ old('business_location') }}">
                        </div>
                        <div class="form-group @error('business_about') is-invalid @enderror">
                            <label for="inputZip">What is your business about?</label>
                            <textarea type="text" class="form-control" name="business_about">{{ old('business_about') }}</textarea>

                        </div>
                        <div class="form-group col-md-6">
                            <label>What's your role at this company?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="gridCheck1" name="business_role"
                                    value="Company administrator"
                                    {{ old('business_role') == 'Company administrator' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gridCheck1">
                                    Company administrator
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="gridCheck2" name="business_role"
                                    value="Employee" {{ old('business_role') == 'Employee' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gridCheck2">
                                    Employee
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="gridCheck3" name="business_role"
                                    value="Director/Owner"
                                    {{ old('business_role') == 'Director/Owner' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gridCheck3">
                                    Director/Owner
                                </label>
                            </div>
                        </div>

                    </section>


                    <h3>Finish</h3>
                    <section class="row">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input " required type="checkbox" id="gridCheck" name="agree"
                                    value="1" {{ old('agree') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gridCheck">
                                    Terms and conditions.
                                </label>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            var form = $("#vendor-reg-form");

            // Initialize jQuery validation
            form.validate({
                errorPlacement: function(error, element) {
                    element.before(error);
                },
                rules: {
                    password_confirmation: {
                        equalTo: "#password"
                    }
                }
            });

            // Initialize jQuery Steps
            var steps = $("#vendor-reg-steps").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                autoFocus: true,
                onStepChanging: function(event, currentIndex, newIndex) {
                    form.validate().settings.ignore = ":disabled,:hidden";
                    return form.valid();
                },
                onFinishing: function(event, currentIndex) {
                    form.validate().settings.ignore = ":disabled";
                    return form.valid();
                },
                onFinished: function(event, currentIndex) {
                    form.submit();
                }
            });

            // Move to the next step when an account type is selected
            $('input[name="account_type"]').on('change', function() {
                steps.steps('next');
            });
        });
    </script>
@endsection
