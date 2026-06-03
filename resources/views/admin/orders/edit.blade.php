@extends('layouts.admin.app')
@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default card -->

        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">                        
                        <h2 class="font-24">
                            <a href="{{ route('admin.customers.show', $customer->id) }}">{{$customer->name}}</a> <br />
                            <small>{{$customer->email}}</small> <br />
                            <small>reference: <strong>{{$order->reference}}</strong></small>
                        </h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{route('admin.orders.invoice.generate', $order['id'])}}" class="btn btn-primary" target="_blank">Download Invoice</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <h4 class="top-heading mb-5"> <i class="fa fa-shopping-bag text-success"></i> Order Information</h4>
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
                        <td>{{ date('M d, Y h:i a', strtotime('-8 hours', strtotime($order['created_at']))) }}</td>
                        <td><a href="{{ route('admin.customers.show', $customer->id) }}">{{ $customer->name }}</a></td>
                        <td><strong>{{ $order['payment'] }}</strong></td>
                        <td class="order-edit-form">
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put">
                                <label for="order_status_id" class="hidden">Update status</label>
                                <input type="text" name="total_paid" class="form-control" placeholder="Total paid" style="margin-bottom: 5px; display: none" value="{{ old('total_paid') ?? $order->total_paid }}" />
                                <div class="input-group">
                                    <select name="order_status_id" id="order_status_id" class="form-control">
                                        @foreach($statuses as $status)
                                            <option @if($currentStatus->id == $status->id) selected="selected" @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-btn "><button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-primary">Update</button></span>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="">Subtotal</td>
                        <td class="">{{ config('cart.currency_symbol') }} {{ $order['total_products'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="">Tax</td>
                        <td class="">{{ config('cart.currency_symbol') }} {{ $order['tax'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="">Shipping</td>
                        <td class="">{{ config('cart.currency_symbol') }} {{ $order['total_shipping'] }}</td>
                    </tr>
                    <?php $allTotal = $order['total'] +  $order['total_shipping'] + $order['tax'] ; ?>
                    @if($order['total_paid'] != $order['total'])
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="bg-danger text-bold" style="background-color: #206080 !important;color: #fff;">Total paid</td>
                            <td class="bg-danger text-bold" style="background-color: #206080 !important;color: #fff;">{{ config('cart.currency_symbol') }} {{ $allTotal }}</td>
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
                        <h4 class="mb-4"> <i class="fa fa-gift text-success"></i> Items</h4>
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
                        
                        <div class="col-md-12 table-responsive">
                            <h4 class="mb-4"> <i class="fa fa-map-marker text-success"></i> Address</h4>
                            <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <th>Address 1</th>
                                    <th>Address 2</th>
                                    <th>City</th>
                                    <th>Province</th>
                                    <th>Postal Code</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $order->address->address_1 }}</td>
                                    <td>{{ $order->address->address_2 }}</td>
                                    <td>
                                        @if(isset($order->address->city))
                                            {{ $order->address->city }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($order->address->province))
                                            {{ $order->address->province->name }}
                                        @endif
                                    </td>
                                    <td>{{ $order->address->zip }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
            <div class="card-footer pl-0">
                <div class="btn-group">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary">Back</a>
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