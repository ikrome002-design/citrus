<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/vendor.min.css') }}">
    <style>
* {
  box-sizing: border-box;
}

body {
  background-color: #f1f1f1;
}

#regForm {
  background-color: #ffffff;
  margin: 50px auto;
  font-family: Raleway;
    width: 70%;
  min-width: 300px;
}

h1 {
  text-align: center;  
}

input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

button {
  background-color: #4CAF50;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4CAF50;
}
</style>
</head>
<body class="hold-transition skin-purple login-page">
    <div class="login-box">
        <div class="login-logo">
        </div>
        <!-- /.login-logo -->
        @include('layouts.errors-and-messages')
        <div class="login-box-body">
             <img src="{{ url('images/muteweb_logo.svg') }}" alt="Italian Trulli" class="admin_login">
            <h3 class="font-weight-bold">Create your Seller Account</h3>


            <div class="box">
                <form id="regForm" action="{{ route('admin.register') }}" method="post">
                    {{ csrf_field() }}
                  <!-- One "tab" for each step in the form: -->
                  <div class="tab">
                    <h3>Basic info</h3>
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <p><input type="text" placeholder="Name..." oninput="this.className = ''" id="name" name="name" value="{{ old('name') }}"></p>

                    <label for="email">Email <span class="text-danger">*</span></label>
                    <p><input type="text" placeholder="Email..." oninput="this.className = ''" id="email" name="email" value="{{ old('email') }}"></p>
                    <label for="password">Password <span class="text-danger">*</span></label>
                     <p><input type="password" placeholder="password..." oninput="this.className = ''" id="password" name="password"></p>
                    <label for="password">Phone <span class="text-danger">*</span></label>
                     <p><input type="text" placeholder="Phone..." oninput="this.className = ''" name="phone" id="phone" value="{{ old('phone') }}"></p>
                      <input type="hidden" name="role" id="role" class="form-control" value="3">
                  </div>
                  <div class="tab">
                     <h3>Business info</h3>
                    <label for="name">Business name <span class="text-danger">*</span></label>
                    <p><input type="text" placeholder="Business name..." oninput="this.className = ''" id="business_name" name="business_name" value="{{ old('business_name') }}"></p>
                    <label for="office_address">Office Address <span class="text-danger">*</span></label>
                    <p><input type="text" placeholder="Office address" oninput="this.className = ''" id="office_address" name="office_address" value="{{ old('office_address') }}"></p>
                     <label for="logo">Business Logo <span class="text-danger">*</span></label>
                    <p><input type="file" name="business_logo" id="business_logo" placeholder="Logo" class="form-control"></p>
                   
                  </div>
                  <div class="tab">:
                     <h3>Address info</h3>
                    <label for="city">City <span class="text-danger">*</span></label>
                    <p><input type="text" placeholder="city" oninput="this.className = ''" id="city" name="city" value="{{ old('city') }}"></p>

                    <label for="postal_code">Postel Code <span class="text-danger">*</span></label>
                    <p><input type="text" placeholder="Postal code" oninput="this.className = ''" id="postel_code" name="postel_code" value="{{ old('postel_code') }}"></p>

                    <label for="address">Address<span class="text-danger">*</span></label>
                    <p><input type="text" placeholder="Address" oninput="this.className = ''" id="billing_address" name="billing_address" value="{{ old('billing_address') }}"></p>
                   
                  </div>
                  <div style="overflow:auto;">
                    <div style="float:right;">
                      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                    </div>
                  </div>
                  <div style="text-align:center;margin-top:40px;">
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                   
                  </div>
                </form>
            </div>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>
</body>
</html>
<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  fixStepIndicator(n)
}

function nextPrev(n) {
  var x = document.getElementsByClassName("tab");
  if (n == 1 && !validateForm()) return false;
  x[currentTab].style.display = "none";
  currentTab = currentTab + n;
  if (currentTab >= x.length) {
    document.getElementById("regForm").submit();
    return false;
  }
  showTab(currentTab);
}

function validateForm() {
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  for (i = 0; i < y.length; i++) {
    if (y[i].value == "") {
      y[i].className += " invalid";
      valid = false;
    }
  }
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; 
}

function fixStepIndicator(n) {
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  x[n].className += " active";
}
</script>
