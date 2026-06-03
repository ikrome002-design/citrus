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
              <?php echo "ghgfh"; die(); ?>
            <div class="card-body tab-content" id="pills-tabContent">
                <div class="table-responsive tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                    <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Order Id</td>
                                <td>Product SKU's</td>
                                <td>Ship To</td>
                                <td>Total</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ date('M d, Y', strtotime($order->date)) }}</td>
                                <td><a title="Show order" href="{{ route('vendor.orders.edit', $order->order_id) }}">{{$order->order_id}}</a></td>
                                <td>
                                    @for($i=0; $i < count($order->products); $i++ )
                                        <a title="Show order" href="@if(isset(auth('admin')->user()->id)){{ route('admin.products.edit', $order->products[$i]['id']) }} @elseif(isset(auth('vendor')->user()->id)){{ route('products.edit', $order->products[$i]['id']) }}@endif">{{ $order->products[$i]['sku'] }}<br></a>
                                    @endfor
                                </td>
                                <td>{{ $order->address_1.', '.$order->city.'-'.$order->zip }}</td>
                                <td>
                                    <span class="label @if($order->total != $order->total_paid) label-danger @else label-success @endif">{{ config('cart.currency_symbol') }} {{ $order->total + $order->total_shipping + $order->tax }}</span>
                                </td>
                                <td><button class="btn btn-success btn-sm text-white vendor-product-bt" style="color: {{ $order->status_color }};">{{ $order->order_status }}</button></td>
                                <td><a href="{{ route('vendor.orders.edit', $order->order_id) }}" class="btn btn-primary btn-sm vendor-product-bt"><i class="fa fa-edit"></i></a></td>
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
                                <td>Order Id</td>
                                <td>Product SKU's</td>
                                <td>Ship To</td>
                                <td>Subtotal</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            @if($status->name == $order->order_status)
                                <tr>
                                    <td>{{ date('M d, Y', strtotime($order->date)) }}</td>
                                    <td><a title="Show order" href="{{ route('vendor.orders.edit', $order->order_id) }}">{{$order->order_id}}</a></td>
                                    <td>
                                    @for($i=0; $i < count($order->products); $i++ )
                                        <a title="Show order" href="@if(isset(auth('admin')->user()->id)){{ route('admin.products.edit', $order->products[$i]['id']) }} @elseif(isset(auth('vendor')->user()->id)){{ route('products.edit', $order->products[$i]['id']) }}@endif">{{ $order->products[$i]['sku'] }}<br></a>
                                    @endfor
                                    </td>
                                    <td>{{ $order->address_1.', '.$order->city.'-'.$order->zip }}</td>
                                    <td>
                                        <span class="label @if($order->total != $order->total_paid) label-danger @else label-success @endif">{{ config('cart.currency_symbol') }} {{ $order->total }}</span>
                                    </td>
                                    <td><button class="btn btn-success btn-sm text-white vendor-product-bt" style="color: {{ $order->status_color }};">{{ $order->order_status }}</button></td>

                                    <td><a href="{{ route('vendor.orders.edit', $order->order_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a></td>
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