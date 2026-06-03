@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->

        @if($list_count!=0)
            <div class="card">
                <div class="card-body">
                    <h3>In-Process Clients</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Payment Status</td>
                                    <td>Sign Up Date</td>
                                    <td>Plan</td>
                                    <td>Price</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($clients as $client)
                                @if($client->payment_status == 0)
                                <tr>
                                    <td><a href="{{ route('admin.client.edit', $client->vendor_id) }}"> {{ $client->vendor_name }}</a></td>
                                    <td>@include('layouts.status', ['status' => $client->payment_status])</td>
                                    <td>{{ $today = date("F M, Y", strtotime($client->register_date))}}</td>
                                    <td>
                                        <h6 class="mb-0">{{ $client->membership_name}}</h6>
                                        <small>{{ $client->plan_variant == 1 ?'Monthly ':'Yearly'}} Subscription</small>
                                    </td>
                                    <td>
                                        @php 
                                          $initial_price = $client->plan_variant == 1 ? $client->monthly_initial_price:$client->yearly_initial_price ;
                                          $recurring_price = $client->plan_variant == 1 ? $client->monthly_recurring_price:$client->yearly_recurring_price ;
                                        @endphp
                                        <p class="mb-0">Initial price:{{config('cart.currency_symbol')}}{{ $initial_price}}</p>
                                        <p class="mb-0">Recurring price:{{config('cart.currency_symbol')}}{{ $recurring_price}}</p>
                                        @if($client->initial_discount)
                                        <p class="mb-0 text-success">Initial Discount:{{$client->initial_discount}}%</p>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.client.edit', $client->vendor_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>

                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif
        @if($clients)

            <div class="card mt-3">
                <div class="card-body">
                    <h3>Active clients</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Payment Status</td>
                                    <td>Sign Up Date</td>
                                    <td>Plan</td>
                                    <td>Price</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($clients as $client)
                                @if($client->payment_status == 1)
                                <tr>
                                    <td><a href="{{ route('admin.client.edit', $client->vendor_id) }}"> {{ $client->vendor_name }}</a></td>
                                    <td>@include('layouts.status', ['status' => $client->payment_status])</td>
                                    <td>{{ $today = date("F M, Y", strtotime($client->register_date))}}</td>
                                    <td>
                                        <h6 class="mb-0">{{ $client->membership_name}}</h6>
                                        <small>{{ $client->plan_variant == 1 ?'Monthly ':'Yearly'}} Subscription</small>
                                    </td>
                                    <td>
                                        @php 
                                          $initial_price = $client->plan_variant == 1 ? $client->monthly_initial_price:$client->yearly_initial_price ;
                                          $recurring_price = $client->plan_variant == 1 ? $client->monthly_recurring_price:$client->yearly_recurring_price ;
                                        @endphp
                                        <p class="mb-0">Initial price:{{config('cart.currency_symbol')}}{{ $initial_price}}</p>
                                        <p class="mb-0">Recurring price:{{config('cart.currency_symbol')}}{{ $recurring_price}}</p>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.client.edit', $client->vendor_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection