@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default card -->
          <div class="card-body pl-0  ">
            <div class="row mb-2">
                <div class="col-md-12">
                    <h3 class="">Vendor Transaction Report</h3>
                </div>
            </div>
        </div>
    @if($orders)
        <div class="card">
                <div class="card-body shadow-sm pull-right">
                    <!-- <h5>Download Report</h5> -->
                    <form method="post" action="{{ route('vendor.transReport') }}">
                        {{ csrf_field() }}
                        <button type="submit" name="submit" class="btn btn-primary mt-3 pull-right">
                            Download Report
                        </button>
                    </form>
                </div>
            </div>
        <div class="card">
            <div class="card-body tab-content" id="pills-tabContent">
                <div class="table-responsive tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                    <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Order ID</td>
                                <td>Reference NO</td>
                                <td>Product SKU</td>

                                <td>Payment Mode</td>

                                <td>Order Total</td>
                                
                                <td>Stripe Fees</td>
                                <td>Amount</td>
                            </tr>
                        </thead>
                        <tbody>
                            
                        @foreach ($orders as $order)
                        <?php 
                        $flat_deduction = 0.30;
                        $stripe_trns_charges = 2.9;
                        $deduction= ($order->amount - 0.30);
                        $transactionfees = number_format((float)($deduction * $stripe_trns_charges)/100, 2, '.', '');
                       
                        $total_fees = $flat_deduction + $transactionfees;
                        $vendor_amount_after_deduction= ($deduction - $transactionfees);

                        $cod_deduction= $order->amount;
                        $cod_transactionfees = number_format((float)($cod_deduction * $stripe_trns_charges)/100, 2, '.', '');
                        $cod_total_fees = $cod_transactionfees;
                        $cod_vendor_amount_after_deduction= ($cod_deduction - $cod_transactionfees);

                        ?>
                        <tr>
                            <td>{{ date('M d, Y', strtotime($order->created_at)) }}</td>
                            <td>{{$order->token}}</td>
                            <td>
                                 @for($i=0; $i < count($order->products1); $i++ )
                                 {{$order->products1[$i]['reference']}}<br/>
                                 @endfor
                             </td>
                            <td>

                                @for($i=0; $i < count($order->products1); $i++ )
                                    <a title="Show order" >{{ $order->products1[$i]['sku'] }}<br/></a>
                                @endfor
                            </td>
                            
                            <td>
                            @if($order->stripe_id == '')
                                <span class="label label-success">COD</span>
                            @else
                                 <span class="label label-success">Stripe</span>
                            @endif
                            </td>
                            <td>
                                <span class="label label-success">{{ config('cart.currency_symbol') }} {{ $order->amount }}</span>
                            </td>

                            <td> @if($order->stripe_id == '')

                                {{ config('cart.currency_symbol') }} {{$cod_total_fees}}
                                <small>({{ $cod_transactionfees }}) <span data-toggle="tooltip" data-placement="top" data-original-title=" Admin charge - {{ $stripe_trns_charges}} %    Charges apply - {{ $cod_transactionfees }}" ><i class="fa fa-info-circle" style="color:red;"></i></span></small>

                            @else

                                {{ config('cart.currency_symbol') }} {{$total_fees}}
                                <small>( {{ $flat_deduction }} + {{ $transactionfees }}) <span data-toggle="tooltip" data-placement="top" data-original-title=" Stripe charge - {{ $flat_deduction}} Admin_charge - {{ $stripe_trns_charges}} %  " ><i class="fa fa-info-circle" style="color:red;"></i></span> </small>
                            @endif
                            </td>
                            <td>{{ config('cart.currency_symbol') }} <?php if($order->stripe_id == ''){?>{{ $cod_vendor_amount_after_deduction }} <?php }else{?>{{ $vendor_amount_after_deduction }}<?php }?></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
      
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endif

    </section>

    <!-- /.content -->
@endsection