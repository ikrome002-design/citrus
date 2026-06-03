@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default card -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h2>
                            <a>{{$customer->name}}</a> <br />
                            <small>{{$customer->email}}</small> <br />
                            <small>reference: <strong>{{$order->reference}}</strong></small>
                        </h2>
                    </div>
                    <div class="col-md-3 col-md-offset-3">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <h4> <i class="fa fa-shopping-bag"></i> Order Information</h4>
                <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td>Date</td>
                            <td>Customer</td>
                            <td>Payment</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ date('M d, Y h:i a', strtotime($order['created_at'])) }}</td>
                        <td>{{ $customer->name }}</td>
                        <td><strong>{{ $order['payment'] }}</strong></td>
                        <td>
                            <button class="btn btn-outline-light btn-sm rounded" style="color: {{ $currentStatus->color }};border-color: {{ $currentStatus->color }}">{{ $currentStatus->name }}</button>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bg-warning">Subtotal</td>

                        <td class="bg-warning">{{config('cart.currency_symbol') }}{{ $order['total_products'] }}</td>

                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bg-warning">Tax</td>

                        <td class="bg-warning">{{config('cart.currency_symbol') }}{{ $order['tax'] }}</td>

                    </tr>
                   <tr>
                        <td></td>
                        <td></td>
                        <td >Shipping</td>

                        <td >{{config('cart.currency_symbol') }}{{ $order['total_shipping'] }}</td>

                    </tr>
                    <?php $allTotal = $order['total'] +  $order['total_shipping'] + $order['tax']; ?>
                    @if($order['total_paid'] != $order['total'])
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="bg-danger text-bold">Total paid</td>
                            <td class="bg-danger text-bold">{{ $order['total_paid'] }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        @if($order)
        
            <div class="card">
                @if(!$items->isEmpty())
                    <div class="card-body table-responsive">
                        <h4> <i class="fa fa-gift"></i> Items</h4>
                        <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <th>SKU</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        {!! $item->description !!}
                                        @php($pattr = \App\Shop\ProductAttributes\ProductAttribute::find($item->product_attribute_id))
                                        @if(!is_null($pattr))<br>
                                            @foreach($pattr->attributesValues as $it)
                                                <p class="label label-primary">{{ $it->attribute->name }} : {{ $it->value }}</p>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $item->pivot->quantity }}</td>
                                    <td>{{config('cart.currency_symbol') }}{{ $item->price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <h4> <i class="fa fa-map-marker"></i> Address</h4>
                            <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <th>Address 1</th>
                                    <th>Address 2</th>
                                    <th>City</th>
                                    <th>Province</th>
                                    <th>Postal Code</th>
                                    <th>Country</th>
                                    <th>Phone</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $order->address->address_1 }}</td>
                                    <td>{{ $order->address->address_2 }}</td>
                                    <td>{{ $order->address->city }}</td>
                                    <td>
                                        @if(isset($order->address->province))
                                            {{ $order->address->province->name }}
                                        @endif
                                    </td>
                                    <td>{{ $order->address->zip }}</td>
                                    <td>{{ $order->address->country->name }}</td>
                                    <td>{{ $order->address->phone }}</td>
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
@else
@section('js')
<script type="text/javascript">
   
        window.location="{{ route('vendor.dashboard') }}";
   
</script>
@endsection
@endif