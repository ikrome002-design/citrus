@extends('layouts.front.app')
@section('content')
<!-- banner section start -->
<div class="section">
   <div class="">

      <div class="bg-primary text-center text-white">
         <h2 class="pt-5 font-weight-bold text-green">BUYVI.CA MEMBERSHIP PACKAGES</h2>
         <h5 class="pb-5 font-weight-light text-green">Save 50% off your first year with a 1 year membership – Offer ends March 1st</h5>
      </div>
   </div>
</div>
<!-- plan section start -->
<div id="plan_section">
   <div class="container">
      <div class="row">
         <div class="col text-center mt-3">
            <h1 class="font-weight-bold mt-4 text-blue">CHOOSE THE PACKAGE THAT WORKS BEST FOR YOUR BUSINESS</h1>
         </div>
      </div>
      <div class="row ml-auto py-5">
        @foreach($plans as $plan)
        @php $textClass = $plan->name == 'Gold' ? 'text-warning' : 'text-info'; @endphp
        @php $btnClass = $plan->name == 'Gold' ? 'btn-warning' : 'btn-info'; @endphp
         <div class="col-lg-6">
            <div class="card bg-white vendor-plan-box">
               <h2 class="{{ $textClass }} font-weight-bold heading-primary">{{ strtoupper($plan->name) }}</h2>
               <p class="text-secondary font-weight-bold">{{ $plan->quantity }} product in store</p>
               <p class="text-secondary">{{ $plan->description }}</p>
               <hr>
               <h6 class="font-weight-bold">Monthly Variant</h6>
               <div class="row d-flex">
                  <div class="col-lg-6 ">
                     <p class="text-secondary font-weight-bold">Initial price</p>
                     <p class="{{ $textClass }} font-weight-bold heading-primary">{{config('cart.currency_symbol')}}{{ $plan->monthly_initial_price }}</p>
                  </div>
                  <div class="col-lg-6 ">
                     <p class="text-secondary font-weight-bold">Recurring price</p>
                     <p class="{{ $textClass }} font-weight-bold heading-primary">{{config('cart.currency_symbol')}}{{ $plan->monthly_recurring_price }}</p>
                  </div>
               </div>
               <h6 class="font-weight-bold">Yearly Variant</h6>
               <div class="row d-flex">
                  <div class="col-lg-6 ">
                     <p class="text-secondary font-weight-bold">Initial price</p>
                     <p class="{{ $textClass }} font-weight-bold heading-primary">{{config('cart.currency_symbol')}}{{ $plan->yearly_initial_price }}</p>
                  </div>
                  <div class="col-lg-6 ">
                     <p class="text-secondary font-weight-bold">Recurring price</p>
                     <p class="{{ $textClass }} font-weight-bold heading-primary">{{config('cart.currency_symbol')}}{{ $plan->yearly_recurring_price }}</p>
                  </div>
               </div>

               <hr>
               <div class="mt-3">
                  <h5 class="text-blue custom-heading text-uppercase mb-2 feature-heading font-weight-bold ">Feature List</h5>
                  <ul>
                    @php 
                    $feature_list = explode("\n", $plan->feature_list);
                    @endphp
                    @foreach($feature_list as $feature)
                    <li><i class="fa fa-check text-success p-2 right_mark"></i><span class="heading-primary">{{$feature}}<span></li>
                    @endforeach
                  </ul>
               </div>
                <hr>
              <div class="mt-4">
                  {{--<a type="submit" href="{{ route('vendor.register.form', $plan->id ) }}" class="btn btn-lg {{$btnClass}} rounded font-weight-bold">Sign up now</a>--}}
                  <a type="submit" href="{{ route('vendor.register.form', $plan->id ) }}" class="btn btn-lg btn-primary rounded font-weight-bold">Sign up now</a>

              </div>

            </div>
         </div>
        @endforeach
      </div>
   </div>
</div>
@endsection
