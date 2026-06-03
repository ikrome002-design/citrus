@extends('layouts.front.app')
@section('content')
<!-- banner section start -->
<div class="section">
   <div class="">
      <div class="bg-primary text-center text-white">
         <h2 class="pt-5 font-weight-bold">BuyVi.ca Membership Plans</h2>
         <h5 class="pb-5 font-weight-light">Save 50% off your first year with a 1 year membership – Offer ends March 1st</h5>
      </div>
   </div>
</div>
<!-- banner end -->
<!-- plan section start -->
<div id="plan_section">
   <div class="container">
      <div class="row my-5">
         <div class="col-12 text-center mt-3">
            @include('layouts.errors-and-messages')
            <h1 class="font-weight-bold">Make Payment</h1>
         </div>
         <div class="col-12">
            <div class="card mt-5 mx-auto" style="max-width: 50rem">
              <div class="card-body">
                  <h3 class="heading-primary">{{ $plan->name }}</h3>
                  <p>{{ $plan->description }}</p>
                  <hr class="my-4" />
                  <div class="row">
                     <div class="col-md-6">
                        <h6>Plan Type</h6>
                        <h3 class="font-weight-light heading-primary">{{ $vendor->plan_variant == 1 ? 'Monthly' : 'Yearly' }} Subscription</h3>
                     </div>
                     <div class="col-md-6">
                        <h6>Plan Price</h6>
                        <div class="row">
                           <div class="col">
                              @php 
                              $initial_price = $vendor->plan_variant == 1 ? $plan->monthly_initial_price:$plan->yearly_initial_price ;
                              $recurring_price = $vendor->plan_variant == 1 ? $plan->monthly_recurring_price:$plan->yearly_recurring_price ;
                              $initial_discount = 0;
                              @endphp
                              <h6><small>Initial price</small>: <big class="heading-primary"> {{config('cart.currency_symbol')}}{{$initial_price}}</big></h6>
                           </div>
                           <div class="col">
                               <h6><small>Recurring price</small>: <big> {{config('cart.currency_symbol')}}{{$recurring_price }}</big></h6>
                           </div>
                        </div>
                     </div>
                     <div class="col-12">
                        <hr class="my-4" />
                     </div>
                     <div class="col-6 text-left">
                        Subtotal
                     </div>
                     <div class="col-6 text-right">
                        {{config('cart.currency_symbol')}}{{ $initial_price }}/{{ $vendor->plan_variant == 1 ? 'Month' : 'Year' }}
                     </div>
                     @if($vendor->initial_discount > 0)
                      <div class="col-6 text-left">
                        Initial Discount
                     </div>
                     <div class="col-6 text-right text-success">
                       - {{config('cart.currency_symbol')}}{{ $initial_discount = $initial_price*$vendor->initial_discount/100 }} ({{$vendor->initial_discount}}%)
                     </div>
                     @endif
                     <div class="col-6 text-left">
                        Tax
                     </div>
                     <div class="col-6 text-right">
                        {{config('cart.currency_symbol')}}{{ $taxAmt = $tax->rate_percentage*$initial_price/100 }}/{{ $vendor->plan_variant == 1 ? 'Month' : 'Year' }}
                     </div>
                     <div class="col-6 text-left">
                        Total
                     </div>
                     <div class="col-6 text-right">
                        {{config('cart.currency_symbol')}}{{ $initial_price+$taxAmt-$initial_discount }}/{{ $vendor->plan_variant == 1 ? 'Month' : 'Year' }}
                     </div>
                  </div>
              </div>
            </div>
         </div>
         <?php $totAmt = $initial_price+$taxAmt-$initial_discount; ?>
         <div class="col-12 text-center mt-5">
            <form action="{{route('vendor.register.payment')}}" method="post">
               {{ csrf_field() }}
               <input type="hidden" name="totAmt" value="<?php echo $totAmt; ?>">
               <button type="submit"  class="btn btn-success btn-lg">Process Payment</button>
            </form>
         </div>
         <div class="col-12 text-center my-4">
            <span class="badge-light h2 rounded-circle px-2">or</span>
         </div>
         <div class="col-12 text-center">
            <button type="button" data-toggle="modal" data-target="#StaffListModal" class="btn btn-primary btn-lg">Contact Customer Support</a>
         </div>
      </div>
      <div class="row">
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="StaffListModal" tabindex="-1" role="dialog" aria-labelledby="StaffListModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{route('vendor.register.contact')}}">
         {{ csrf_field() }}
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Feel free to conatct us</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
            <select class="custom-select custom-select-lg mb-3" name="staff_id">
              <option selected>Select support member</option>
              @foreach($staffs as $staff)
              <option value="{{$staff->id}}">{{$staff->name}}</option>
              @endforeach
            </select>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           <button type="submit" class="btn btn-success">Send Request</button>
         </div>
      </form>
    </div>
  </div>
</div>
@endsection