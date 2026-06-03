<style type="text/css">
    .zui-table {
        border: solid 1px #DDEEEE;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }
    .zui-table thead th {
        background-color: #000;
        border: solid 1px #DDEEEE;
        color: #fff;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }
    .zui-table tbody td {
        border: solid 1px #DDEEEE;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>
<div class="card-body tab-content" id="pills-tabContent">
    <div class="table-responsive tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
       <center> <h2>Transaction Report</h2></center>
        <table class="table table-striped table-bordered dataTable zui-table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Order ID</th>
                    <th>Reference NO</th>
                    <th>Product SKU</th>
                    <th>Payment Mode</th>
                    <th>Order Total</th>
                    <th>Charges</th>
                    <th>Amount</th>
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
                     <?php 
                     if(isset($order->products1)){
                     for($i=0; $i < count($order->products1); $i++ ) { ?>
                     {{$order->products1[$i]['reference']}}<br/>
                     <?php }  } ?>
                 </td>
                <td>

                    <?php
                    if(isset($order->products1)){
                    for($i=0; $i < count($order->products1); $i++ ) { ?>
                        <a title="Show order" >{{ $order->products1[$i]['sku'] }}<br/></a>
                   <?php } }
                    ?>
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