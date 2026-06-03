@extends('layouts.admin.app') @section('content')
<!-- Main content -->


<section class="content">
    <section class="container-fluid px-0">
        @include('layouts.errors-and-messages')
        <!-- Default box -->
        @if($memberships)

        <div class="card-body pl-0  ">
            <div class="row mb-2">
                <div class="col-md-12">
                    <h1 class="">Membership Plan</h1>
                </div>
            </div>
        </div>
        <div class="row plan-row mx-0">
                <div class="card plans-box total-plan border-0">
                    <div class="card-body shadow-sm">
                        <div class="d-flex">
                            <div class="col-auto px-0">
                                <div class="plan-icon-box p-3 rounded-circle">
                                    <i class="fa fa-gift text-success fa-2x"></i>
                                </div>
                            </div>
                            <div class="col-auto align-self-center">
                                <p class="text-success">Total {{ count($memberships) }} plans</p>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card plans-box most-plan border-0">
                    <div class="card-body shadow-sm">
                        <div class="d-flex">
                            <div class="col-auto px-0">
                                <div class="plan-icon-box p-3 rounded-circle">
                                    <i class="fa fa-check text-blue fa-2x"></i>
                                </div>
                            </div>
                            <div class="col-auto align-self-center">
                                <p class="text-blue">Most Activated Plan</p>
                                <span class="text-secondary">@if(isset($max_plan) && $max_plan != '') {{ $max_plan->name }} @else No Plan @endif</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card plans-box new-plan border-0">
                    <a href="//localhost:3000/admin/products/create">
                        <div class="card-body shadow-sm bg-success">
                            <div class="d-flex">
                                <div class="col-auto">
                                    <div class="shadow-sm plan-icon-box p-3 rounded-circle bg-white">
                                        <i class="fa fa-pencil text-success fa-2x"></i>
                                    </div>
                                </div>
                                <a href="{{ route('admin.memberships.create') }}">
                                    <div class="col-auto align-self-center text-white">
                                        <p>Create New Plan</p>
                                        <span class="font-weight-light">Click here</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
        </div>
        <div class="row">
            <div class="col">
                <h3 class="mt-4 mb-0">All plans</h3>
            </div>
        </div>
        <div class="row mt-4">
            @php $i=0; @endphp
            @foreach($memberships as $row)
            <div class="col-md-12 col-lg-4 col-12 flex-wrap member-box-wrapper mb-4">
                <div class="card custom-border-radius shadow-sm">
                    <div class="card-header {{ $i%2 == 0 ? 'bg-blue' : 'bg-warning'}}">
                        <div class="dropdown text-right">
                            <a href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu rounded bg-purple" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item text-blue" href="{{ route('admin.memberships.edit', $row->id) }}"><i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                        <h3 class="plans-heading text-white">{{$row->name}}</h3>
                        <div class="row">
                            <div class="col-9">
                                <p class="store-text text-white m-0">{{$row->quantity}} products on store</p>
                                <span class="text-white">Created Date:<?php echo date('d-M-Y', strtotime($row->created_at)) ?></span>
                            </div>
                            <div class="col-3 text-right">
                                <p class="store-tax text-white m-0">Tax:</p>
                                <p class="store-tax text-white m-0">
                                    @foreach($taxs as $tax)
                                        @if($tax->id == $row->tax_id)
                                        {{$tax->rate_percentage}}%
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>{{ $row->description }}</p>
                        <hr />
                        <h6 class="font-weight-bold font-20">Monthly Subscription</h6>
                        <div class="row d-flex">
                            <div class="col-lg-6">
                                <p class="text-secondary">Initial price</p>
                                <p class="text-blue font-weight-bold">{{config('cart.currency_symbol')}}{{ $row->monthly_initial_price }}</p>
                            </div>
                            <div class="col-lg-6">
                                <p class="text-secondary">Recurring price</p>
                                <p class="text-blue font-weight-bold">{{config('cart.currency_symbol')}}{{ $row->monthly_recurring_price }}</p>
                            </div>
                        </div>
                        <h6 class="font-weight-bold font-20">Yearly Subscription</h6>
                        <div class="row d-flex">
                            <div class="col-lg-6">
                                <p class="text-secondary">Initial price</p>
                                <p class="text-blue font-weight-bold">{{config('cart.currency_symbol')}}{{ $row->yearly_initial_price }}</p>
                            </div>
                            <div class="col-lg-6">
                                <p class="text-secondary">Recurring price</p>
                                <p class="text-blue font-weight-bold">{{config('cart.currency_symbol')}}{{ $row->yearly_recurring_price }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php $i++; @endphp
            @endforeach
        </div>
        <!-- /.box -->
        @endif
    </section>
</section>
<!-- /.content -->
@endsection
