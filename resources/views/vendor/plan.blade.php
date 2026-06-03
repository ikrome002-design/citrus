@extends('layouts.vendor.app')

@section('content')
@include('layouts.errors-and-messages')
<section class="vendor-plan-wrapper content">
	<div class="container-fluid">
		@if(!empty($plan))
		<div class="row vendor-plan-box">
			<div class="col-lg-5 col-xl-5 col-12">
				<div class="current-plan-box">
					<h2 class="current-plan-h text-white">Current Plan</h2>
					<!-- <p class="text-white">{{ $plan->description }}</p> -->
				</div>	
			</div>
			<div class="col-lg-7 col-xl-7 col-12">
				<div class="plan-info-box bg-white">
					<div class="info-first-box">
						<h2 class="font-weight-bold">{{ $plan->name }}</h2>
						<p class="monthly-text">{{ $plan->description }}</p>
					</div>
					<div class="plan-variant-box">
						<div class="variant-content">
							<div class="row align-items-top pl-4">
								<div class="col-md-5 col-lg-5 col-5">
									<p class="mb-2 plan-type">Plan Type</p>
									<h5 class="font-weight-bold mb-0">Monthly Subscription</h5>
								</div>
								<div class="col-md-7 col-lg-7 col-7">
									<div class="row">
										<div class="col-12 pl-0"><p class="mb-2 plan-type">Monthly Subscription</p></div>
										<div class="col-6 px-0">
											<h6 class="mb-0">Initial price:</h6>
											<p class="plan-price mb-0">{{config('cart.currency_symbol')}}{{ $plan->monthly_initial_price }}</p>
										</div>
										<div class="col-6 px-0">
											<h6 class="mb-0">Recurring price:</h6>
											<p class="plan-price mb-0">{{config('cart.currency_symbol')}}{{ $plan->monthly_recurring_price }}</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php $exdate = $plan->expiry_date; $currdate = date('Y-m-d'); ?>
						@if($currdate == $exdate)
						<form method="post" action="{{ route('vendor.updateplan') }}">
							{{ csrf_field() }}
							<input type="hidden" name="totAmt" value="{{ $plan->monthly_recurring_price}}">
							<input type="hidden" name="plan_id" value="{{ $plan->id}}">
							<input type="hidden" name="plan_name" value="{{ $plan->name}}">
							<input type="hidden" name="plan_variant" value="1">
							<input type="hidden" name="id" value="{{ auth('vendor')->user()->id }}">
							<div class="variant-bt">
								<button type="submit" class="text-uppercase update-bt btn-primary text-white font" >Upgrade your Plan</button> 
							</div>
						</form>	
						@else
						<div class="variant-bt">
							<button type="submit" class="text-uppercase update-bt btn-primary text-white " ><small>RENEWS ON :</small><?php echo date('d-M-Y',strtotime($exdate)); ?> </button> 
						</div>
						@endif

					</div>
					<div class="feature-list-box">
						<h2 class="font-16 font-weight-bold">Features </h2>
						<div class="row">
							<div class="col-md-6 col-md-6 col-12">
								<ul>
									@php 
				                    $feature_list = explode("\n", $plan->feature_list);
				                    @endphp
				                    @foreach($feature_list as $feature)
				                    <li><span class="heading-primary">{{$feature}}<span></li>
				                    @endforeach
								</ul>
								
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
		<!-- --------------------upgrade-pan-here-------------------- -->
		<div class="plan-upgrade-box">
			@if(!empty($plan))
			<div class="row text-center">
				<div class="col-md-12 col-lg-12 col-12">
					<h2 class="vendor-upgrade-heading">Do you want to upgrade your plan?</h2>
				</div>
			</div>
			@else
			<div class="row text-center">
				<div class="col-md-12 col-lg-12 col-12">
					<h2 class="vendor-upgrade-heading">Please select your membership plan </h2>
				</div>
			</div>
			@endif
 	 		<div class="row upgrade-pan-mini mt-4 mb-5">
            @php $i=0; @endphp
            @foreach($allplans as $row)
            <div class="col-md-6 col-12 mx-auto flex-wrap member-box-wrapper">
                <div class="card custom-border-radius shadow-sm">
                    <div class="upgrade-card-header {{ $i%2 == 0 ? : 'bg-yellow'}}">
                    	<i class="fa fa-check"></i>
                        <h3 class="plans-heading text-primery">{{$row->name}}</h3>
                        <!-- <div class="row">
                            <div class="col-9">
                                <p class="store-text m-0">{{$row->quantity}} products on store</p>
                            </div>
                        </div> -->
                    </div>
                    <form method="post" action="{{ route('vendor.updateplan') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="plan_id" value="{{ $row->id }}">
                    <div class="card-body pt-0">
                        <p>{{ $row->description }}</p>                        
                        <h6 class="font-weight-bold font-20 pt-3">Monthly Subscription  <input class="Myradio" type="radio" name="plan_variant" value="1" checked="checked"> </h6>

                        <div class="row d-flex">
                            <div class="col-lg-6">
                                <p class="text-secondary font-13">Initial price</p>
                                <p class="text-blue font-weight-bold">{{config('cart.currency_symbol')}}{{ $row->monthly_initial_price }}</p>
                            </div>
                            <div class="col-lg-6">
                                <p class="text-secondary font-13">Recurring price</p>
                                <p class="text-blue font-weight-bold">{{config('cart.currency_symbol')}}{{ $row->monthly_recurring_price }}</p>
                            </div>
                        </div>
                        <h6 class="font-weight-bold font-20">Yearly Subscription <input class="Myradio" type="radio" name="plan_variant" value="0"> </h6>
                        <div class="row d-flex">
                            <div class="col-lg-6">
                                <p class="text-secondary font-13">Initial price</p>
                                <p class="text-blue font-weight-bold">{{config('cart.currency_symbol')}}{{ $row->yearly_initial_price }}
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <p class="text-secondary font-13">Recurring price</p>
                                <p class="text-blue font-weight-bold">{{config('cart.currency_symbol')}}{{ $row->yearly_recurring_price }}</p>
                            </div>
							</div>
							<div class="row d-flex mt-4">
							<div class="col-lg-12">
								<button class="text-uppercase update-bt btn-primary text-white font" type="submit" name="submit" id="upgradeNow">Upgrade Now</button>
							</div>
							<input type="hidden" name="totAmt" value="{{ $row->monthly_recurring_price}}">
							<input type="hidden" name="plan_id" value="{{ $row->id}}">
							<input type="hidden" name="plan_name" value="{{ $row->name}}">
							<input type="hidden" name="id" value="{{ auth('vendor')->user()->id }}">
							</div>
							<div class="feature-list-box">
								<h2 class="font-18 font-weight-bold">Features</h2>
								<ul>
									@php 
				                    $feature_list = explode("\n", $row->feature_list);
				                    @endphp
				                    @foreach($feature_list as $feature)
				                    <li><span class="heading-primary">{{$feature}}<span></li>
				                    @endforeach
									
								</ul>
							</div>
                   	 	</div>
                	</form>
                </div>
            </div>
            @php $i++; @endphp
            @endforeach
        </div>
		</div>
	</div>
</section>
<!-- /.content -->
@endsection
