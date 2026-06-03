@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default card -->
    @if($orders)
        <div class="card vendor-order-wrapper">
            <div class="card-header vendor-order">
                @if($ordersStatus)
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="pills-all-tab" data-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="true">All</a>
                  </li>
                @foreach($ordersStatus as $status)
                  <li class="nav-item">
                    <a class="nav-link" id="pills-{{str_replace(' ','_',$status->name)}}-tab" data-toggle="pill" href="#pills-{{str_replace(' ','_',$status->name)}}" role="tab" aria-controls="pills-{{str_replace(' ','_',$status->name)}}" aria-selected="true">{{$status->name}}</a>
                  </li>
                @endforeach
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
                                <td>Product SKU</td>
                                <td>Total</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ date('M d, Y', strtotime($order->date)) }}</td>
                                 <?php $shop_id= Request::segment(3);?>
                                <td><a title="Show order" href="{{ route('shop.orders.edit', [$shop_id,$order->order_id]) }}">#{{$order->order_id}}</a></td>
                                <td>
                                    <?php 
                                    $q=0;
                                    for($i=0; $i < count($order->products); $i++ )
                                    { 
                                        $q=$order->products[$i]['product_price']*$order->products[$i]['quantity']+$order->products[$i]['shipping']+$q; ?>

                                        <a title="Show order" href="@if(isset(auth('admin')->user()->id)){{ route('admin.products.edit', $order->products[$i]['id']) }} @elseif(isset(auth('vendor')->user()->id)){{ route('products.edit', $order->products[$i]['id']) }}@endif">{{ $order->products[$i]['sku'] }}<br></a>
                                    <?php }?>
                                </td>
                               
                                <td>
                                    <span class="label-success">{{ config('cart.currency_symbol') }} {{$q}}</span>
                                </td>
                                 <?php $orderStatus = DB::table('order_product')->join('order_statuses', 'order_product.order_status', '=', 'order_statuses.id')->select('order_statuses.id AS oId','order_statuses.*')->where('order_product.order_id', $order->order_id)->first();?>
                                
                               <td><button class="btn btn-success btn-sm text-white vendor-product-bt" style="background-color: {{ $orderStatus->color }};">{{ $orderStatus->name }}</button></td>
                               <?php $shop_id=Request::segment(3);?>
                                <td><a href="{{ route('shop.orders.edit', [$shop_id,$order->order_id]) }}" class="btn btn-primary btn-sm vendor-product-bt"><i class="fa fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @foreach($ordersStatus as $status)
                <div class="table-responsive tab-pane fade" id="pills-{{str_replace(' ','_',$status->name)}}" role="tabpanel" aria-labelledby="pills-{{str_replace(' ','_',$status->name)}}-tab">
                    <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Order ID</td>
                                <td>Product SKU</td>
                                <td>Total</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                        <?php $orderStatus = DB::table('order_product')->join('order_statuses', 'order_product.order_status', '=', 'order_statuses.id')->select('order_statuses.id AS oId','order_statuses.*')->where('order_product.order_id', $order->order_id)->first();?>
                             @if($status->name == $orderStatus->name)
                                <tr>
                                    <td>{{ date('M d, Y', strtotime($order->date)) }}</td>
                                    <td><a title="Show order" href="{{ route('vendor.orders.edit', $order->order_id) }}">#{{$order->order_id}}</a></td>
                                    <td>
                                     <?php 
                                    $q=0;
                                    for($i=0; $i < count($order->products); $i++ )
                                    { 
                                        $q=$order->products[$i]['product_price']*$order->products[$i]['quantity']+$order->products[$i]['shipping']+$q; ?>
                                        <a title="Show order" href="@if(isset(auth('admin')->user()->id)){{ route('admin.products.edit', $order->products[$i]['id']) }} @elseif(isset(auth('vendor')->user()->id)){{ route('products.edit', $order->products[$i]['id']) }}@endif">{{ $order->products[$i]['sku'] }}<br></a>
                                    <?php }?>
                                    </td>
                                   
                                    <td>
                                        <span class="label-success">{{ config('cart.currency_symbol') }} {{ $q }}</span>
                                    </td>
                                   <td><button class="btn btn-success btn-sm text-white vendor-product-bt" style="background-color: {{ $orderStatus->color }};">{{ $orderStatus->name }}</button></td>
                                  <?php $shop_id=Request::segment(3);?>
                                    <td><a href="{{ route('shop.orders.edit',[$shop_id, $order->order_id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a></td>
                                </tr>
                           @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endif

    </section>
    <!-- /.content -->
@endsection
@else
@section('js')
<script type="text/javascript">
   
        window.location="{{ route('vendor.dashboard') }}";
   
</script>
@endsection
@endif