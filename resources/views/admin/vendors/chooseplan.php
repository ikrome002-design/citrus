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
       
        <div class="row">
            <div class="col">
                <h3 class="mt-4 mb-0">All plans</h3>
            </div>
        </div>
        <div class="row mt-4">
           
            @foreach($memberships as $row)
            <div class="col-auto flex-wrap member-box-wrapper">
                <div class="card custom-border-radius shadow-sm">
                    <div class="card-header {{ $i%2 == 0 ? 'bg-blue' : 'bg-yellow'}}">
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
                                <span class="text-white">Created Date:{{ date('d-M-Y', $row->created_at) }}</span>
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
           
            @endforeach
        </div>


        <!-- /.box -->

        @endif
    </section>
</section>
<!-- /.content -->
@endsection
