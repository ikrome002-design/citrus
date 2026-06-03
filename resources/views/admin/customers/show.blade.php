@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <h2 class="top-heading mb-4">User Profile</h2>
        <div class="user-profile-box">
            <div class="row">
                <div class="col-md-3 col-lg-2 col-12">
                   <div class="profile-img customer-pro-img">
                    @if(isset($customer->avatar))
                     <figure><img id="imgPrime" src="{{ asset("storage/profile/customer/$customer->avatar") }}" alt="" height="100" width="100"></figure>
                     
                    @else
                       <figure><img id="imgPrime" src="{{ asset('images/dummy-user.png')}}" alt="" height="100" width="100"></figure>
                    @endif
                   </div>
                </div>
                <div class="col-md-9 col-lg-10 col-12">
                   <div class="profile-info">
                        <table class="table table-responsive">
                          <tbody>
                            <tr>                              
                              <td>First Name</td>
                              <td>{{ $customer->first_name }}</td>                           
                            </tr>
                            <tr>                              
                              <td>Last Name</td>
                              <td>{{ $customer->last_name }}</td>                           
                            </tr>
                            <tr>                              
                              <td>Email </td>
                              <td>{{ $customer->email }}</td>                 
                            </tr>
                             <tr>                              
                              <td>Phone Number</td>
                              <td>{{ $customer->phone_number }}</td>                          
                            </tr>
                            <tr>                              
                              <td>Date Of Birth</td>
                              <td>{{ $customer->dob }}</td>                          
                            </tr>
                             <tr>                              
                              <td>Gender</td>
                              <td>@if($customer->gender==0) Male @else Female @endif</td>                          
                            </tr>
                            <tr>                              
                              <td>Country</td>
                              <td>{{ $customer->cname }}</td>                          
                            </tr>
                            <tr>                              
                              <td>National ID</td>
                              <td>{{ $customer->national_id }}</td>                          
                            </tr>
                            <tr>                              
                              <td>Status</td>
                              <td>@if($customer->status==0) Inactive @else Active @endif</td>                          
                            </tr>
                          </tbody>
                        </table>
                   </div>
                </div>
            </div>
        </div>
        
      <h2 class="top-heading mb-4 d-none">All Orders</h2>
      <?php $a = 0; ?>
      @foreach ($orders as $order)
      <div class="user-order-box">
          <div id="accordion{{$a}}">
            <div class="card mb-5">
              <div class="card-header" id="headingOne{{$a}}">
                    <div class="user-order-table collapsed" data-toggle="collapse" data-target="#collapseOne{{$a}}" aria-expanded="true" aria-controls="collapseOne">
                        <div class="product-img">
                            <img id="imgPrime" src="{{ asset("images/$order->cover")}}" alt="" height="100" width="100">
                        </div>
                        <div class="user-order-box product-name">
                            <p>{{$order->product_name}}</p>
                        </div>
                        <div class="user-order-box order-date">
                           <p> Order Placed <span><?php echo date('d F Y', strtotime('-8 hours', strtotime($order->created_at))); ?></span></p>
                        </div>
                        <div class="user-order-box product-total">
                          <p><?php $totAm = $order->total + $order->total_shipping + $order->tax ; ?>
                            Total<span>${{$totAm}}</span></p>
                        </div>
                        <div class="user-order-box order-number">
                            <p>Order Number <span># {{$order->order_id}}</span></p>
                        </div>
                        <div class="order-detail">
                            <p class="text-success mb-0">View Full Details</p>
                        </div>                
                    </div>
              </div>
              <div id="collapseOne{{$a}}" class="collapse order-detail-box " aria-labelledby="headingOne{{$a}}" data-parent="#accordion{{$a}}">
                   <div class="card-body">
                      <h2 class="top-heading mb-4">Order Details</h2>
                      <div class="row">
                         <div class="col-md-4">
                            <div class="card order-detail-card">
                               <h2 class="shipping-heading text-primery">Shipping Address</h2>                           
                                  <p>{{$order->address_1}}</p>
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class="card order-payment-card">
                               <h2 class="shipping-heading text-black">Payment Method</h2>                           
                                  <p>{{ $order->payment }}</p>
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class="card order-summary-card">
                               <h2 class="shipping-heading text-black">Order Summary</h2> 
                                  <p>Order Summary<br> Item(s) Subtotal: $ {{$order->total_products}}<br> Shipping: ${{$order->total_shipping}}<br> Tax: ${{$order->tax}}<br> Grand Total: ${{$totAm}}</p>
                            </div>
                         </div>
                      </div>
                   </div>
              </div>
            </div>
        </div>
      </div>
      <?php $a++; ?>
      @endforeach
      
       
        <!-- /.box -->
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