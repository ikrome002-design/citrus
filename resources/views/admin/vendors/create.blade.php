@extends('layouts.admin.app')
@section('content')
<!-- Main content -->
<section class="content">
  @include('layouts.errors-and-messages')

 
      @if(isset($_POST['plan_id']))   
  <form action="{{ route('admin.vendors.add') }}" method="post" enctype="multipart/form-data" id="VendorRegisterForm">
    {{ csrf_field() }}
    <input type="hidden" name="plan_id" value="{{$plan_id}}">
     <input type="hidden" name="plan_variant" value="{{$plan_variant}}">
     <input type="hidden" name="stId" value="{{$StId}}">
    <div class="row py-5">
      <div class="col-lg-8 col-md-6 mb-3">
        <div class="card border shadow-sm">

           <div class="card-body register-form-step active" form-step="1" id="step-1">
            <h3 class="text-primary">Vendor Registration</h3>
            <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rhoncus felis eget ex commodo, quis faucibus sapien dignissim.</p> -->
            <div class="form-group">
               <label for="MissionStatement">Mission Statement (please describe your business story, mission statement and or the nature of your business, this will show up on your business profile page for consumers to see, it can be updated anytime)<span class="text-danger">*</span></label>
              <textarea class="form-control" id="MissionStatement" rows="3" name="mission_description"></textarea>
            </div>
            <div class="form-group">
               <label for="ForYourBusiness">About us (please describe your exchange and refund policy here if applicable as well as any other pertinent information about your business, this will show up on your business profile page for consumers to see, it can be updated anytime)<span class="text-danger">*</span></label>
              <textarea class="form-control" id="ForYourBusiness" rows="3" name="do_for_you"></textarea>
            </div>
            <h5> Is your business eligible to advertise on BuyVi.ca?</h5>
            <div class="form-group mt-4">
              <p>Is your business Vancouver Island Owned and Operated?<span class="text-danger"> *</span></p>
              <div class="form-check form-check-inline">
                <input class="form-check-input radioBtnClass" type="radio" name="own_by_vancouver" id="businessOwnYes" value="1" checked="checked">
                <label class="form-check-label" for="businessOwnYes">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input radioBtnClass" type="radio" name="own_by_vancouver" id="businessOwnNo"  value="0" >
                <label class="form-check-label" for="businessOwnNo">No</label>
              </div>
            </div>
            {{--<div class="form-group">
                  <p>Is your business Vancouver Island Owned and Operated?<span class="text-danger">*</span></p>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="head_office_vancouver" id="headOfficeYes" value="1" checked="checked">
                    <label class="form-check-label" for="headOfficeYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="head_office_vancouver" id="headOfficeNo" value="0" >
                    <label class="form-check-label" for="headOfficeNo">No</label>
                  </div>
                </div>
                <div class="form-group">
                  <p>Does your business depends on local shoppers? The local community?<span class="text-danger">*</span></p>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="local_community" id="localCommunityYes" value="1" checked="checked">
                    <label class="form-check-label" for="localCommunityYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="local_community" id="localCommunityNo" value="0" >
                    <label class="form-check-label" for="localCommunityNo">No</label>
                  </div>
                </div>--}}
                 <div class="form-check">
                <input class="form-check form-check-input terms_conditions" type="checkbox" value="" name="terms_conditions" id="terms_conditions">
                 <p class="" data-toggle="modal" data-target="#myModal">Do you agree to our terms and conditions?<span class="text-danger"> *</span>
                 <div class="term_error" style="color: #dc3c4b;font-size: 80%;"></div>
                </p>

                <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content terms_conditions">
                      <div class="modal-header">
                          <h4 class="modal-title">Terms & Conditions</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      
                      </div>
                      <div class="modal-body">
                        <p>
                          <ol class="form-check" style="list-style-type: decimal;">
                            <li class="mb-3"><h6 class="mb-2">What Cannot be Sold on BuyVi :- </h6> 

                              Vendors may not sell items or services that are illegal or that violate the intellectual property rights of a
                      third party, like alcohol, tobacco, cannabis, firearms, or sexual services. The listing for sale of any such items or services will result in the suspension or termination of your account with us.</li>
                            <li class="mb-3"><h6 class="mb-2">Listing items for sale :- </h6>
                      You are solely responsible for the quality, safety, legality, and accuracy of the items or services you list for
                      sale or promotion and you are responsible for compliance with all applicable laws, as well as for the
                      accuracy and content of your listings in BuyVi.</li>
                            <li class="mb-3"><h6 class="mb-2">Shipping items :- </h6>
                      You are responsible for shipping or delivering your purchased items to the buyers in a timely way. If you
                      have committed to a delivery time, you will honour that schedule to the best of your ability. Shipping and
                      handling policies, timelines, and terms and conditions specific to shipping companies are the responsibility
                      of those shipping companies or entities, including but not limited to Canada Post. It is your responsibility
                      to familiarize yourself with the policies, timelines, and terms and conditions of the shipping companies and
                      entities you use.</li>
                        <li class="mb-4"><h6 class="mb-2">Payments :-</h6>
                      BuyVi shall provide an ecommerce portal for the sale of your items in using the Services (the “Portal”)
                      with all payments processed by the ecommerce payment system, “Stripe” (https://stripe.com/en-
                      ca/connect). To use the Portal, you must provide all required information. BuyVi, utilizing Stripe, shall
                      provide via the Portal electronic means of payments between vendor and buyer via approved credit cards
                      and debit cards. All funds received from buyers shall be held by Stripe for 14 days prior to being eligible
                      for payout to vendors. At any time, Vendors can see all of their funds held by Stripe through their login to
                      their vendor account. As funds are released from hold, they become available and vendors can withdraw
                      via electronic funds transfer directly to their designated bank account. All payments made and received
                      through the Portal and processed by Stripe are subject to Stripe’s terms and conditions, which can be found
                      here: [insert link to Stripe T&C]
                      When Vendors purchase memberships from BuyVi.ca, BuyVi pays the transaction fees to Stripe for those
                      membership transactions. When buyers purchase goods from vendors, the vendors pay transaction fees to
                      Stripe for the items purchased by the buyers.
                      Buyers do not pay fees to Stripe.
                      Stripe fees are $0.30 Canadian + 2.9% of each transaction.
                      BuyVi may replace Stripe as its third party ecommerce payment system at any time without notice. BuyVi
                      may group multiple transactions into a single, aggregate transaction on your payment method based on the
                      nature of the charges and/or the date(s) they were incurred. If you do not recognize a transaction, check
                      your receipts/invoice/payment history.</li>
                        <li class="mb-4"><h6 class="mb-2">Failed Transactions :- </h6>
                      If you cannot honour a purchase, you will promptly communicate that to the buyer and issue a full refund.
                      In the event that the items are not delivered, you will adhere to the applicable sections of the Business
                      Practices and Consumer Protection Act, as may be amended from time to time.
                      All vendors are required to determine and clearly communicate to buyers the vendor’s refund policy. Each
                      vendor is required to have a refund policy. At the vendor’s option, their refund policy may include terms
                      that allow the vendor to keep a portion of the sales price that is equal to but does not exceed the amounts
                      for which the vendor is personally liable in the event of a refund (for example, shipping fees). Refunds are
                      processed by the vendor through the portal and their account access.</li>
                        <li class="mb-4"><h6 class="mb-2">Selling Fees / Service Packages :- </h6>
                      As a vendor with BuyVi, you will be charged for an account with us to use the Services. Information on
                      such fees and service packages can be found here. Failure to renew your service package or to pay for your
                      services shall result in a suspension of your account.
                      All transactions are facilitated through a third-party payment processor (e.g., First Data, Stripe, Inc., or
                      Braintree, a division of PayPal, Inc.). BuyVi.ca may replace its third-party payment processor without
                      notice to you. Charges shall only be made through the BuyVI Site. BuyVi may group multiple Charges into
                      a single aggregate transaction on your payment method based on the nature of the Charges and/or the date(s)
                      they were incurred. If you don't recognize a transaction, then check your ride receipts and payment history.</li>
                         <li class="mb-4"><h6 class="mb-2">Termination :- </h6>
                      If a vendor cancels their membership or account with BuyVi, we do not refund any membership fees,
                      prorated or otherwise, however you will have access to your account until the end of your pre-paid
                      membership term.</li>
                         <li class="mb-4"><h6 class="mb-2">Personal Information :- </h6>
                      In using the services as a vendor, you are responsible for protecting the buyers’ personal information you
                      receive or process, and you must comply with all relevant legislation. This may require that you post and
                      comply with your own privacy policy, which must be accessible to BuyVi users with whom you interact.
                      Your privacy policy must be compatible with our Terms. Such privacy legislation may include but not be
                      limited to the Personal Information Protection Act. You can learn more about your obligations with respect
                      to personal information with the Office of the Information and Privacy Commissioner of BC
                      https://www.oipc.bc.ca/.</li>
                         <li class="mb-4"><h6 class="mb-2">Returns :- </h6>
                      Without limiting the generality of the rest of the Terms, each vendor is responsible for setting out clearly
                      and communicating to buyers, the vendor’s policies and procedures, terms and conditions, with respect to

                       <ol class="form-check" style="    list-style-type: lower-alpha;">
                        <li>returns;</li>
                        <li>time limitations for returns;</li>
                        <li>statement of the required condition of the product in for a return to be accepted;</li>
                        <li>determination of whether the buyer or vendor pays for the cost of the return shipping;</li>
                        <li>whether the vendor will retain a portion of the purchase price to reimburse the vendor for out of pocket, actual fees incurred in processing and returning the buyer’s purchase;</li>
                        <li>anticipated or promised actions if items are damaged or otherwise do not arrive not as expected;</li>
                        <li>estimating how long it will take to process a return; and</li>
                        <li>timeline for accepted returns and when buyers eligible for returns can expect to be reimbursed.</li>
                      </ol>

                    </li>
                  </ol>
                  For greater certainty and without limited the foregoing, BuyVi shall not be responsible for any action or
inaction by the vendor in responding to requests for return by the buyer or for any adherence to the vendor’s
policies.
                   </p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
               
                {{--<div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="local_community" id="localCommunityYes" value="1" checked="checked">
                  <label class="form-check-label" for="localCommunityYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="local_community" id="localCommunityNo" value="0" >
                  <label class="form-check-label" for="localCommunityNo">No</label>
                </div>--}}
              </div>
            <button type="button" id="GoToStep2" class="btn btn-success btn-lg">Continue </button>
          </div>
          <div class="card-body register-form-step" form-step="2" id="step-2">
             <h3 class="text-primary">Vendor Registration</h3>
            <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rhoncus felis eget ex commodo, quis faucibus sapien dignissim.</p> -->
            <div class="form-row">
              <div class="col-md-6 my-3">
                <label for="vendorEmail">Email(Username)<span class="text-danger">*</span></label>
                <input type="email" class="form-control is-email" name="email" id="vendorEmail" value=""  >

              </div>

              <div class="col-md-6 my-3">
                <label for="vendorpassword">Password<span class="text-danger">*</span></label>
                <input type="password" class="form-control " name="password" id="vendorpassword" value="">
              </div>
              <div class="col-md-6 my-3">
                <label for="BusinessName">Business Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="business_name" id="BusinessName" value="">
              </div>
              <div class="col-md-6 my-3">
                <label for="YearinBusiness">Business Year<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="business_year" id="YearinBusiness" placeholder="" value="">
              </div>
              <div class="col-md-6 my-3">
                <label for="OwnerName">Owner's Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="OwnerName" value="">
              </div>
              <div class="col-md-6 my-3">
                <label for="ManagerName">Manager Name</label>
                <input type="text" class="form-control gstCls" name="manager_name" id="ManagerName" value="">
              </div> 
              <div class="col-md-6 my-3">
                <label for="GSTNO">GST No.</label>
                <input type="text" class="form-control gstCls" name="gst_no" id="GSTNO" value="">
              </div>
              <div class="col-md-6 my-3">
                <label for="PSTNO">PST No.</label>
                <input type="text" class="form-control gstCls" name="pst_no" id="PSTNO" value="">
              </div>
              <div class="col-12 my-3">
                <label for="OfficeAddress">Office Store front address<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="address" id="OfficeAddress" value="">
              </div>
              <div class="col-md-6 my-3">
                <label for="OfficeCity">City<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="city" id="OfficeCity" value="">
              </div>
              <div class="col-md-6 my-3">
                <label for="OfficeState">Province<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="state" id="OfficeState" value="">
              </div>
              <div class="col-md-4 my-3">
                <label for="PostalCode">Postal Code<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="postal_code" id="PostalCode" value="">
              </div>
              <div class="col-md-4 my-3">
                <label for="OfficeNumber">Office Number<span class="text-danger">*</span></label>
                <input type="text" class="form-control is-number" name="office_number" id="OfficeNumber" value="">
              </div>
              <div class="col-md-4 my-3">
                <label for="CellNumber">Cell Number<span class="text-danger">*</span></label>
                <input type="text" class="form-control is-number" name="cell_number" id="CellNumber" value="">
              </div>
             
              <div id="vendor-billing-address" class="col-12">
                <div class="row">
                  <div class="col-12 my-3">
                    <label for="BillingAddress">Billing address<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="billing_address" id="BillingAddress" value="">
                  </div>
                  <div class="col-md-6 my-3">
                    <label for="BillingCity">City<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="billing_city" id="BillingCity" value="">
                  </div>
                  <div class="col-md-6 my-3">
                    <label for="BillingState">Province<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="billing_state" id="BillingState" value="">
                  </div>
                  <div class="col-md-4 my-3">
                    <label for="BillingPostalCode">Postal Code<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="billing_postal_code" id="BillingPostalCode" value="">
                  </div>
                  <div class="col-md-4 my-3">
                    <label for="BillingOfficeNumber">Office Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control is-number" name="billing_office_number" id="BillingOfficeNumber" value="">
                  </div>
                  <div class="col-md-4 my-3">
                    <label for="BillingCellNumber">Cell Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control is-number" name="billing_cell_number" id="BillingCellNumber" value="">
                  </div>
                </div>
              </div>
            
            </div>
            <button type="button" class="btn btn-success btn-lg" id="GoToStep3">Create</button>
          </div>
        </div>
      </div>
   <div class="col-lg-4 col-md-6 mb-3">
        <div class="card shadow-sm border">
          <div class="card-body">
            <h3 class="text-primary">{{ $plan->name }}</h3>
            <p>{{ $plan->description }}</p>
            <hr class="my-4" />
             @if($_POST['plan_variant']==1) 
            <div class="my-3 row text-center" id="planVariantMonthly">
              <div class="col-12">
                <p style="font-weight: bold;" id="planVariantName">Monthly Subscription</p>
              </div>
              <div class="col-6 text-left">
                <small>Initial price</small>
                <p class="text-primary">{{config('cart.currency_symbol')}}{{ $plan->monthly_initial_price }}</p>
              </div>
              <div class="col-6 text-right">
                <small>Recurring price</small>
                <p class="text-primary">{{config('cart.currency_symbol')}}{{ $plan->monthly_recurring_price }}</p>
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
                <p style="font-weight: bold;" id="planVariantName">Yearly Subscription</p>
              </div>
              <div class="col-6 text-left">
                <small>Initial price</small>
                <p class="text-primary">{{config('cart.currency_symbol')}}{{ $plan->yearly_initial_price }}</p>
              </div>
              <div class="col-6 text-right">
                <small>Recurring price</small>
                <p class="text-primary">{{config('cart.currency_symbol')}}{{ $plan->yearly_recurring_price }}</p>
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
              <input class="form-control is-percentage" type="number" max="100" name="initial_discount" class="initialDiscount" value="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  @else

   <form action="{{ route('admin.vendors.create1') }}" method="post" enctype="multipart/form-data" id="VendorRegisterForm1">
    {{ csrf_field() }}
    
<div class="card-body register-form-step active " form-step="0" id="step-0">
                <h3 class="text-primary">Choose plan</h3>
<div class="col-md-12">
    <label class="">Plan Name :</label>
                <select name="plan_id" class="form-control">
                    @foreach($memberships as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                   
                </select>
            </div><br>
<div class="col-md-12">
    <label class="">Plan Type :</label>
                <select name="plan_variant" class="form-control">
                    
                    <option value="1">Monthly</option>
                     <option value="2">Yearly</option>
                   
                   
                </select>
            </div><br>
                 <button type="submit" id="GoToStep1" class="btn btn-success btn-lg">Continue </button>
            </div>
        </form>
        @endif
</section>
@endsection
@section('js')
<script>
 $(document).ready(function(){
  $('#GoToStep2').click(function(){
    var a = $("input[name='own_by_vancouver']:checked").val();
    var b = $("input[name='head_office_vancouver']:checked").val();
    var c = $("input[name='local_community']:checked").val();
    if(a == 0 || b==0 || c==0){
      //alert('DO NOT QUALIFY');
      //return false;
    }
  })
 })
</script>
@endsection