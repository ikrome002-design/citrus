@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default card -->
          <div class="card-body pl-0  ">
            <div class="row mb-2">
                <div class="col-md-10">
                    <h3 class="">Order Transaction Report</h3>
                </div>
                <div class="pull-right">
                    <!-- <h5>Download Report</h5> -->
                    <form method="post" action="{{ route('admin.transReport') }}">
                        {{ csrf_field() }}
                        <button type="submit" name="submit" class="btn btn-primary mt-3 pull-right">
                            Download Report
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @if($orders)
        
        <div class="card">
                
       <div class="card-header">

        @if($order_type)
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
            <a href="{{ route('admin.orders.transaction_report') }}" class="nav-link active" >All</a>
          </li>

        <ul id="nav" >
        <li class="sub-box"><a href="#">Select Vendor </a> 
            <ul class="sub-menu">
                 <li><a class="sub-item" href="{{ route('admin.orders.transaction_report') }}" >All Vendor</a></li>
                @foreach($order_type as $orderr)
                <a class="sub-item" href="{{ route('admin.orders.transaction_reportt', $orderr->id) }}" ><li>{{ $orderr->name }}</li></a>
                @endforeach 
            </ul>
        </li>
       
        </ul>
              
                @endif
            </div>
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

                        
                        <tr class="get">
                            
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
                            <td>
                            @if($order->stripe_id == '')

                                {{ config('cart.currency_symbol') }} {{$cod_total_fees}}
                                <small>({{ $cod_transactionfees }}) <span data-toggle="tooltip" data-placement="top" data-original-title=" Admin charge - {{ $stripe_trns_charges}} %    Charges apply - {{ $cod_transactionfees }}" ><i class="fa fa-info-circle" style="color:red;"></i></span></small>
                            @else
                                {{ config('cart.currency_symbol') }} {{$total_fees}}
                                <small>( {{ $flat_deduction }} + {{ $transactionfees }}) <span data-toggle="tooltip" data-placement="top" data-original-title=" Stripe charge - {{ $flat_deduction}} Admin_charge - {{ $stripe_trns_charges}} % " ><i class="fa fa-info-circle" style="color:red;"></i></span> </small>
                            @endif
                            </td>
                              <td>{{ config('cart.currency_symbol') }} <?php if($order->stripe_id == ''){?>{{ $cod_vendor_amount_after_deduction }} <?php }else{?>{{ $vendor_amount_after_deduction }}<?php }?></td>
                        </tr>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                            <script class="get">
                            /*var payouts='<?php echo $order->payouts;?>';
                            console.log('payouts',payouts);
                            if(payouts=='0'){
                                jQuery(".get").css("background-color", "#ffff0066");
                            }*/
                        </script>
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