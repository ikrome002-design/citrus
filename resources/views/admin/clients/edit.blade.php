@extends('layouts.admin.app')
@section('content')
<!-- Main content -->
<section class="content">
  @include('layouts.errors-and-messages')
  <form action="{{ route('admin.client.update', $client->vendor_id) }}" method="post" enctype="multipart/form-data" id="VendorRegisterForm">
    {{ csrf_field() }}
    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
    <div class="row py-5">
      <div class="col-lg-8 col-md-6 mb-3">
        <div class="card border shadow-sm">
          <div class="card-body register-form-step active" form-step="1" id="step-1">
            <h3 class="text-primary">Vendors Registration</h3>
            
            <div class="form-group">
              <label for="MissionStatement">Mission Statement (please describe your businesses mission statement, this will show up on your business profile for consumers to view)*<span class="text-danger">*</span></label>
              <textarea class="form-control" id="MissionStatement" rows="3" name="mission_description">{{ $client->mission_description }}</textarea>
            </div>
            <div class="form-group">
              <label for="ForYourBusiness">What we can do for your business<span class="text-danger">*</span></label>
              <textarea class="form-control" id="ForYourBusiness" rows="3" name="do_for_you">{{ $client->do_for_you }}</textarea>
            </div>
            <h5>Is your business eligible to advertise and sell on BuyVi.ca? Answer these 5 simple questions yes and you qualify</h5>
            <div class="form-group mt-4">
              <p>1. Is your business owned by a Vancouver Island?<span class="text-danger">*</span></p>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="own_by_vancouver" id="businessOwnYes" value="1" {{ $client->own_by_vancouver == 1 ?'checked':'' }}>
                <label class="form-check-label" for="businessOwnYes">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="own_by_vancouver" id="businessOwnNo" value="0" {{ $client->own_by_vancouver == 0 ?'checked':'' }}>
                <label class="form-check-label" for="businessOwnNo">No</label>
              </div>
            </div>
            <div class="form-group">
              <p>2. Is your storefront/head office on Vancouver Island?<span class="text-danger">*</span></p>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="head_office_vancouver" id="headOfficeYes" value="1" {{ $client->head_office_vancouver == 1 ?'checked':'' }}>
                <label class="form-check-label" for="headOfficeYes">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="head_office_vancouver" id="headOfficeNo" value="0" {{ $client->head_office_vancouver == 0 ?'checked':'' }}>
                <label class="form-check-label" for="headOfficeNo">No</label>
              </div>
            </div>
            <div class="form-group">
              <p>3. Does your business depends on local shoppers? The local community?<span class="text-danger">*</span></p>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="local_community" id="localCommunityYes" value="1" {{ $client->local_community == 1 ?'checked':'' }}>
                <label class="form-check-label" for="localCommunityYes">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="local_community" id="localCommunityNo" value="0" {{ $client->local_community == 0 ?'checked':'' }}>
                <label class="form-check-label" for="localCommunityNo">No</label>
              </div>
            </div>
            <button type="button" id="GoToStep2" class="btn btn-success btn-lg">Continue </button>
          </div>
          <div class="card-body register-form-step" form-step="2" id="step-2">
             <h3 class="text-primary">Vendor Registration</h3>
           
            <div class="form-row">
              <div class="col-12 my-3">
                <label for="vendorEmail">Email(Username)<span class="text-danger">*</span></label>
                <input type="email" class="form-control is-email" id="vendorEmail" value="{{ $client->email }}" readonly>
              </div>
              <div class="col-md-6 my-3">
                <label for="BusinessName">Business Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="business_name" id="BusinessName" value="{{ $client->business_name }}">
              </div>
              <div class="col-md-6 my-3">
                <label for="YearinBusiness">Business Year<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="business_year" id="YearinBusiness" placeholder="" value="{{ $client->business_year }}">
              </div>
              <div class="col-md-6 my-3">
                <label for="OwnerName">Owner's Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="OwnerName" value="{{ $client->name }}">
              </div>
            <div class="col-md-6 my-3">
                <label for="ManagerName">Manager Name</label>
                <input type="text" class="form-control gstCls" name="manager_name" id="ManagerName" value="{{ $client->manager_name }}">
              </div> 
              <div class="col-md-6 my-3">
                <label for="GSTNO">GST No.</label>
                <input type="text" class="form-control gstCls" name="gst_no" id="GSTNO" value="{{ $client->gst_no }}">
              </div>
              <div class="col-md-6 my-3">
                <label for="PSTNO">PST No.</label>
                <input type="text" class="form-control gstCls" name="pst_no" id="PSTNO" value="{{ $client->pst_no }}">
              </div>
              <div class="col-12 my-3">
                <label for="OfficeAddress">Office Store front address<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="address" id="OfficeAddress" value="{{ $client->address }}">
              </div>
              <div class="col-md-6 my-3">
                <label for="OfficeCity">City<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="city" id="OfficeCity" value="{{ $client->city }}">
              </div>
              <div class="col-md-6 my-3">
                <label for="OfficeState">Province<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="state" id="OfficeState" value="{{ $client->state }}">
              </div>
              <div class="col-md-4 my-3">
                <label for="PostalCode">Postal Code<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="postal_code" id="PostalCode" value="{{ $client->postal_code }}">
              </div>
              <div class="col-md-4 my-3">
                <label for="OfficeNumber">Office Number<span class="text-danger">*</span></label>
                <input type="text" class="form-control is-number" name="office_number" id="OfficeNumber" value="{{ $client->office_number }}">
              </div>
              <div class="col-md-4 my-3">
                <label for="CellNumber">Cell Number<span class="text-danger">*</span></label>
                <input type="text" class="form-control is-number" name="cell_number" id="CellNumber" value="{{ $client->cell_number }}">
              </div>
              @if($client->same_office_add==0)
              <div id="vendor-billing-address" class="col-12">
                <div class="row">
                  <div class="col-12 my-3">
                    <label for="BillingAddress">Billing address<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="billing_address" id="BillingAddress" value="{{ $client->billing_address }}">
                  </div>
                  <div class="col-md-6 my-3">
                    <label for="BillingCity">City<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="billing_city" id="BillingCity" value="{{ $client->billing_city }}">
                  </div>
                  <div class="col-md-6 my-3">
                    <label for="BillingState">Province<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="billing_state" id="BillingState" value="{{ $client->billing_state }}">
                  </div>
                  <div class="col-md-4 my-3">
                    <label for="BillingPostalCode">Postal Code<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="billing_postal_code" id="BillingPostalCode" value="{{ $client->billing_postal_code }}">
                  </div>
                  <div class="col-md-4 my-3">
                    <label for="BillingOfficeNumber">Office Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control is-number" name="billing_office_number" id="BillingOfficeNumber" value="{{ $client->billing_office_number }}">
                  </div>
                  <div class="col-md-4 my-3">
                    <label for="BillingCellNumber">Cell Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control is-number" name="billing_cell_number" id="BillingCellNumber" value="{{ $client->billing_cell_number }}">
                  </div>
                </div>
              </div>
              @endif
            </div>
            <button type="button" class="btn btn-secondary btn-lg" id="GoToStep1">Back</button>
            <button type="button" class="btn btn-success btn-lg" id="GoToStep3">Update</button>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mb-3">
        <div class="card shadow-sm border">
          <div class="card-body">
            <h3 class="text-primary">{{ $plan->name }}</h3>
            <p>{{ $plan->description }}</p>
            <hr class="my-4" />
            @if($client->plan_variant == 1)
            <div class="my-3 row text-center" id="planVariantMonthly">
              <div class="col-12">
                <p id="planVariantName">Monthly Subscription</p>
              </div>
              <div class="col-6">
                <small>Initial price</small>
                <p class="text-primary">{{config('cart.currency_symbol')}}{{ $plan->monthly_initial_price }}</p>
              </div>
              <div class="col-6">
                <small>Recurring price</small>
                <p><del>{{config('cart.currency_symbol')}}{{ $plan->monthly_recurring_price }}</del></p>
              </div>
              <div class="col-12">
                <hr class="my-4" />
              </div>
              <div class="col-6 text-left">
                Subtotal
              </div>
              <div class="col-6 text-right">
                {{config('cart.currency_symbol')}}{{ $plan->monthly_initial_price }}/Month
              </div>
              <div class="col-6 text-left">
                Tax
              </div>
              <div class="col-6 text-right">
                {{config('cart.currency_symbol')}}{{ $taxAmt = $tax->rate_percentage*$plan->monthly_initial_price/100 }}/Month
              </div>
              <div class="col-6 text-left">
                Total
              </div>
              <div class="col-6 text-right">
                {{config('cart.currency_symbol')}}{{ $plan->monthly_initial_price+$taxAmt }}/Month
              </div>
            </div>
            @else
            <div class="my-3 row text-center" id="planVariantYearly">
              <div class="col-12">
                <p id="planVariantName">Yearly Subscription</p>
              </div>
              <div class="col-6">
                <small>Initial price</small>
                <p class="text-primary">{{config('cart.currency_symbol')}}{{ $plan->yearly_initial_price }}</p>
              </div>
              <div class="col-6">
                <small>Recurring price</small>
                <p><del>{{config('cart.currency_symbol')}}{{ $plan->yearly_recurring_price }}</del></p>
              </div>
              <div class="col-12">
                <hr class="my-4" />
              </div>
              <div class="col-6 text-left">
                Subtotal
              </div>
              <div class="col-6 text-right">
                {{config('cart.currency_symbol')}}{{ $plan->yearly_initial_price }}/Year
              </div>
              <div class="col-6 text-left">
                Tax
              </div>
              <div class="col-6 text-right">
                {{config('cart.currency_symbol')}}{{ $taxAmt = $tax->rate_percentage*$plan->yearly_initial_price/100 }}/Year
              </div>
              <div class="col-6 text-left">
                Total
              </div>
              <div class="col-6 text-right">
                {{config('cart.currency_symbol')}}{{ $plan->yearly_initial_price+$taxAmt }}/Year
              </div>
            </div>
            @endif
            <div class="form-group">
              <label for="initialDiscount">Initial Discount (%)</label>
              <input class="form-control is-percentage" type="number" max="100" name="initial_discount" class="initialDiscount" value="{{ $client->initial_discount }}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>
@endsection