@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default card -->

        <div class="card vendor-order-edit">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="top-heading">
                           {{$customer->first_name}} {{$customer->last_name}} <br />
                            <small>{{$customer->email}}</small> <br />
                            <small>reference: <strong>{{$order->reference}}</strong></small>
                        </h2>
                    </div>
                    <?php $vendor_id=auth('vendor')->user()->id;?>
                   <!--  <div class="col-md-6 text-right">
                        <a href="{{route('orders.invoice.generate', [$vendor_id,$order->id])}}" class="btn btn-primary">Download Invoice</a>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body order-edit-update-status">
                <h4 class="my-3"> <i class="fa fa-shopping-bag"></i> Order Information</h4>
                <table class="table table-responsive table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td>Date</td>
                            <td>Customer</td>
                            <td>Payment</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                         <?php 
                          $q=0;
                          $r=0;
                         foreach ($items as $order_product_item){

                             $q=($order_product_item->product_price*$order_product_item->quantity)+$order_product_item->shipping +$q;
                             $r=($order_product_item->product_price*$order_product_item->quantity)+$r;

                            ?>

                     <?php }?>

                    <tr>
                        <td>{{ date('M d, Y h:i a', strtotime($order->created_at)) }}</td>
                        <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                        <td><strong>$ {{ $q }}</strong></td>

                        <td>

                            <form action="{{ route('shop.orders.update', $order->id) }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put">
                                <label for="order_status_id" class="hidden">Update status</label>
                                <input type="text" name="total_paid" class="form-control" placeholder="Total paid" style="margin-bottom: 5px; display: none" value="{{$shop_id}}" />

                                <div class="input-group">
                                    <select name="order_status" id="order_status_id" class="form-control">
                                        @foreach($statuses as $status)
                                            <option @if($currentStatus->id == $status->id) selected="selected" @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
    
                                    <span class="input-group-btn"><button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-primary">Update</button></span>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td >Subtotal</td>
                        <td >{{config('cart.currency_symbol') }} {{ $r }}</td>
                    </tr>
                    <!-- <tr>
                        <td></td>
                        <td></td>
                        <td >Tax</td>
                        <td >{{config('cart.currency_symbol') }}</td>
                    </tr> -->
                    <tr>
                        <td></td>
                        <td></td>
                        <td >Shipping</td>
                        <td >{{config('cart.currency_symbol') }} {{ $q-$r }}</td>
                    </tr>
                    
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="bg-danger text-bold" style="background-color: #206080 !important; color:#fff;">Total paid</td>
                            <td class="bg-danger text-bold" style="background-color: #206080 !important; color:#fff;">{{config('cart.currency_symbol') }} {{ $q }}</td>
                        </tr>
                   
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        @if($order)
            
            <div class="card">
                @if(!$items->isEmpty())
                    <div class="card-body table-responsive">
                        <h4 class="my-3"> <i class="fa fa-gift"></i> Items</h4>
                        <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{!! $item->description !!}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{config('cart.currency_symbol') }}{{ $item->product_price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="card-body vendor-edit-order-table">
                    <div class="row">
                      
                        <div class="col-md-12 ">
                            <h4 class="my-3"> <i class="fa fa-map-marker"></i> Address</h4>
                            <table class="table table-responsive table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address </th>
                                    <th>Postal Code</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        {{$address->email}}
                                    </td>
                                    <td>
                                        {{$address->phone}}
                                    </td>
                                    <td>{{$address->address_1}}</td>
                                    
                                    <td>{{ $address->zip }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </section>
    <!-- /.content -->
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            let osElement = $('#order_status_id');
            osElement.change(function () {
                if (+$(this).val() === 1) {
                    $('input[name="total_paid"]').fadeIn();
                } else {
                    $('input[name="total_paid"]').fadeOut();
                }
            });
        })
    </script>
@endsection
@else
@section('js')
<script type="text/javascript">
   
        window.location="{{ route('vendor.dashboard') }}";
   
</script>
@endsection
@endif