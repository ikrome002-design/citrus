@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default card -->
          <div class="card-body pl-0  ">
            <div class="row mb-2">
                <div class="col-md-10">
                    <h3 class="">Release Transaction History</h3>
                </div>
               
            </div>
        </div>
    @if($orders)
        
        <div class="card">
                
       <div class="card-header">

        @if($order_type)
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
            <a href="{{ route('admin.orders.transaction-History') }}" class="nav-link active" >All</a>
          </li>

        <ul id="nav" >
        <li class="sub-box"><a href="#">Select Vendor </a> 
            <ul class="sub-menu">
                 <li><a class="sub-item" href="{{ route('admin.orders.transaction-History') }}" >All Vendors</a></li>
                @foreach($order_type as $orderr)
                <a class="sub-item" href="{{ route('admin.orders.transaction-Historyy', $orderr->id) }}" ><li>{{ $orderr->name }}</li></a>
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
                               
                                <td>Release Date</td>
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
                            
                            <td>{{ date('M d, Y', strtotime($order->release_date)) }}</td>
                           
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