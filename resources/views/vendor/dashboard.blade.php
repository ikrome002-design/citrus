@extends('layouts.vendor.app')

@section('content')
<!-- Main content -->
<style type="text/css">
    .dropdown-menu :hover{
    background-color: #e1e3e9;
    color: black;
}
</style>

@if(Session::get('plans_in')!=0)
<section class="content">
  <div class="conrtainer-fliud">
@include('layouts.errors-and-messages')
<div class="row mb-4" >
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="font-weight-bold">Select Branch/Shop</h4><br>
                <div class="row">
                 <div class="col-md-3">
              
                   <div class="dropdown">
                 <?php $shop_title= Request::segment(2);
                    if($shop_title=='shops' && Request::segment(4)=='dashboard'){?>
                       <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{strtoupper($shop_show->business_title)}} ({{$shop_show->citrus_shop_id}})<span class="caret"></span></button>
                   <?php }else{?>
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select Shop<span class="caret"></span></button>
                <?php }?>
                       <ul class="dropdown-menu">
                    <?php $shop_title= Request::segment(2);
                    if($shop_title=='shops' && Request::segment(4)=='dashboard'){?>
                        <a href="{{ route('vendor.dashboard') }}"><li class="text-center" >DEFAULT SHOP ({{auth('vendor')->user()->citrus_shop_id}})</li></a>
                     
                        
                        @if(isset($shops))
                        @foreach($shops as $shop)
                           <a href="{{ route('shop.dashboard', $shop->id) }}"><li class="text-center" >{{strtoupper($shop->business_title)}} ({{$shop->citrus_shop_id}})</li></a>
                           
                           @endforeach
                           @endif

                    <?php }else{?>
                        @if(isset($shops))
                        @foreach($shops as $shop)
                           <a href="{{ route('shop.dashboard', $shop->id) }}"><li class="text-center" >{{strtoupper($shop->business_title)}} ({{$shop->citrus_shop_id}})</li></a>
                           
                           @endforeach
                           @endif
                    <?php }?>
                       </ul>
                   </div>

                     
                 </div>
                </div>
            </div>
        </div>
    </div>

</div>

    <div class="row">
        <?php if(Request::segment(2)=='dashboard'){?>
            <div class="col-md-12 col-lg-8 col-sm-12">
            <?php }else{?>
        <div class="col-md-12 col-lg-12 col-sm-12">
        <?php }?>
            <div class="row mb-4">
                <?php if(Request::segment(2)=='shops' && Request::segment(4)=='dashboard'){?>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card">
                    <div class="card-body shadow-sm">
                        <div class="row mb-3">
                        <div class="col">Total Sales</div>
                        </div>
                        <?php 
                            $q=0;
                            foreach($totalorder as $totalorder1){
                                $v=($totalorder1->product_price * $totalorder1->quantity) + $totalorder1->shipping;
                                $q= $q+$v;
                            }

                        ?>
                        <div class="row">
                        <div class="col d-flex justify-content-between">
                            <h2 class="font-weight-bold mb-0 align-self-center">$ {{ $q }}</h2>
                            <div class="shadow-sm p-3 rounded-circle">
                            <i class="fa fa-dollar text-success fa-2x"></i>
                            </div>
                        </div>
                        </div>
                        <hr>

                        <div class="row">
                        <div class="col d-flex justify-content-between">
                            <span> {{ $total }} Products Sold </span>
                            <span><a href="{{ route('products.shop_index', Request::segment(3)) }}">View Products</a></span>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card">
                    <div class="card-body shadow-sm">
                        <div class="row mb-3">
                        <div class="col">Today's order</div>
                        </div>
                        <?php 
                            $pay=0; 
                            foreach($payout as $payout1){
                                 $v=($payout1->product_price * $payout1->quantity) + $payout1->shipping;
                                $pay= $pay+$v;
                            }
                        ?>


                        <div class="row">
                        <div class="col d-flex justify-content-between">
                            <h2 class="font-weight-bold mb-0 align-self-center">$ {{ $pay }}</h2>
                            <div class="shadow-sm p-3 rounded-circle">
                            <i class="fa fa-shopping-cart text-success fa-2x"></i>
                            </div>
                        </div>
                        </div>
                        <hr>

                        <div class="row">
                        <div class="col d-flex justify-content-between">
                            <span> {{ $orders_count }} Orders </span>
                            <span><a href="">View Report</a></span>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
 
                 <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card">
                    <div class="card-body shadow-sm">
                        <div class="row mb-3">
                        <div class="col">Total Products</div>
                        </div>
                        <div class="row">
                        <div class="col d-flex justify-content-between">
                            <h2 class="font-weight-bold mb-0 align-self-center"> {{ $product_count }}</h2>
                            <div class="shadow-sm p-3 rounded-circle">
                            <i class="fa fa-gift text-success fa-2x"></i>
                            </div>
                        </div>
                        </div>
                        <hr>

                        <div class="row">
                        <div class="col d-flex justify-content-between">
                            <span> {{ $product_count }} Total Products </span>
                            <span><a href="{{ route('products.shop_index', Request::segment(3)) }}">View Products</a></span>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            <?php }else{?>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card">
                    <div class="card-body shadow-sm">
                        <div class="row mb-3">
                        <div class="col">Total Sales</div>
                        </div>
                        <?php 
                            $q=0;
                            foreach($totalorder as $totalorder1){
                                $v=($totalorder1->product_price * $totalorder1->quantity) + $totalorder1->shipping;
                                $q= $q+$v;
                            }

                        ?>
                        <div class="row">
                        <div class="col d-flex justify-content-between">
                            <h2 class="font-weight-bold mb-0 align-self-center">$ {{ $q }}</h2>
                            <div class="shadow-sm p-3 rounded-circle">
                            <i class="fa fa-dollar text-success fa-2x"></i>
                            </div>
                        </div>
                        </div>
                        <hr>

                        <div class="row">
                        <div class="col d-flex justify-content-between">
                            <span> {{ $total }} Products Sold </span>
                            <span><a href="{{ route('products.index') }}">View Products</a></span>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card">
                    <div class="card-body shadow-sm">
                        <div class="row mb-3">
                        <div class="col">Today's order</div>
                        </div>
                        <?php 
                            $pay=0; 
                            foreach($payout as $payout1){
                                 $v=($payout1->product_price * $payout1->quantity) + $payout1->shipping;
                                $pay= $pay+$v;
                            }
                        ?>

                        <div class="row">
                        <div class="col d-flex justify-content-between">
                            <h2 class="font-weight-bold mb-0 align-self-center">$ {{ $pay }}</h2>
                            <div class="shadow-sm p-3 rounded-circle">
                            <i class="fa fa-shopping-cart text-success fa-2x"></i>
                            </div>
                        </div>
                        </div>
                        <hr>

                        <div class="row">
                        <div class="col d-flex justify-content-between">
                            <span> {{ $orders_count }} Orders </span>
                            <span><a href="">View Report</a></span>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            <?php }?>
            </div>
             <div class="row" >
                <div class="col-lg-12 col-md-12" id = "container" >
                </div>
            </div><br>
         <div class="row mb-12">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="font-weight-bold">Best Selling Products</h4><br>
                            <div class="row">
                                @if(isset($best_product))

                                @foreach($best_product as $best_product1)

                                <div class="col-md-3">
                                    <div class="vendor-dashboard-product">
                                    @if(isset($best_product1->cover) && asset("$best_product1->cover") != asset("storage") )

                                    <img class="best-selling-product-img" src="{{ asset("storage/$best_product1->cover")}}" alt="{{ $best_product1->name }}"
                                    class="img-fluid mx-auto" style="object-fit:contain;width: 100%; height:150px;"><br><br>

                                    @else
                                    <img src="{{ asset("images/placeholder-square.png") }}" alt="{{ $best_product1->name }}"
                                    class="img-fluid mr-3" /><br><br>
                                    @endif
                                    <h6>{{ $best_product1->name }}</h6>
                                    <p class="product-price" style="color:green;">$ {{ $best_product1->product_price }}</p>
                                </div>
                                </div>
                                @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        
          
        </div>
<?php if(Request::segment(2)=='dashboard'){?>
        <div class="col-md-12 col-lg-4 col-sm-12">
        <div class="col-lg-12 col-md-12">
  <div class="card shadow-sm mb-4" style="background-color: #1E5671; ">
    <div class="card-body">
      <h3 style="color:#fff;">Need help!</h3>
      <p style="font-size: 14px; color:#fff;">This help box will be to communicate with admin and regarding any
        query with portal.</p>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
        Contact
      </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Send Message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('vendor.add.msg') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="vendor_id" value=" {{ auth('vendor')->user()->id}}">
                <div class="form-group">
                  <label for="exampleInputEmail1">Subject</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="subject"
                    placeholder="Enter subject" required="">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Message</label>
                  <textarea class="form-control" name="msg" required=""></textarea>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Send</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-12 col-md-12">
  <div class="card shadow-sm mb-4">
    <div class="card">
      <div class="py-4">
        <h4 class="font-weight-bold px-4">Recent Messages</h4>
         @if(count($vendor_msg) != '')
        <ul class="list-unstyled recent-messages">
         
          @foreach($vendor_msg as $vendor_msg1)
          <li class="media">
            <div class="media-body">
              <section class="d-flex justify-content-between align-items-center">
                <h5 class="mb-1"> {{ $vendor_msg1->subject }} </h5><small
                  class="text-muted">{{ $vendor_msg1->created_at }}</small>
              </section>
              <p>{{ $vendor_msg1->msg}} </p>
              <section class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ $vendor_msg1->category }}</small>
                <small>
                  <button type="button" class="btn btn-success" disabled=""> @if($vendor_msg1->status ==
                    'replied')
                    Replied
                    @else
                    No Reply
                    @endif
                  </button>
                </small>
              </section>
            </div>
          </li>
          @endforeach
          
        </ul>
        @else
           <h6 class="font-weight-bold px-4" style="color:red;">No message yet..</h6>
        @endif
         @if(count($vendor_msg)!=0)
        <div class="px-4">
        
              @if($vendor_msg_count==0)
            <a href="{{ route('vendor.vendor_messages') }}" class="btn btn-warning">See More</a>
            @else
            <a href="{{ route('vendor.notification') }}" class="btn btn-warning">See More</a>
            @endif
        
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="col-lg-12 col-md-12">

  <div class="card shadow-sm mb-4">
    <div class="card">
      <div class="py-4">
        <h4 class="font-weight-bold px-4">Recent Products</h4>
         @if(count($product)!='')
        <ul class="list-unstyled recent-messages">
         
          @foreach($product as $product1)
          <li class="media">
            @if(isset($product1->cover) && asset("$product1->cover") != asset("storage") )
            <img src="{{ asset("storage/$product1->cover")}}" alt="{{ $product1->name }}" class="img-fluid mr-3">
            @else
            <img src="{{ asset("images/placeholder-square.png") }}" alt="{{ $product1->name }}"
              class="img-fluid mr-3" />
            @endif
            <div class="media-body">
              <section class="d-flex justify-content-between align-items-center flex-wrap">
                <a href="{{ route('products.edit', $product1->id) }}">
                  <p style="font-size:15px; width:205px; color: black;">{{ $product1->name }} </p>
                </a><small style="font-size:15px; color:green;">$
                  {{ number_format(isset($product1->sale_price) ? $product1->sale_price : $product1->price, 2) }}</small>
              </section>
            </div>
          </li>
          @endforeach
         
        </ul> 
        <div class="px-4">
          <a href="{{ route('products.index') }}">view all products</a>
        </div>
        @else
        <h6 class="font-weight-bold px-4" style="color:red;">No product found.</h6>
         @endif
      </div>
    </div>
  </div>



</div>
        </div>
    <?php } else{}?>
    </div>
</section>
<!-- /.content -->

@else
<div class="section">
   <div class="">

      <div class="bg-primary text-center text-white">
         <h2 class="pt-4 font-weight-bold text-green"  style="background-color: #1e5671; padding-bottom: 20px;">CITRUS MEMBERSHIP PACKAGES <a href="{{ route('vendor.logout') }}" style="color: #fff;"><span style="font-size:20px; float:right; padding-right:10px; "><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</span></a></h2> 
    
      </div>
   </div>
</div>
<!-- plan section start -->
<div id="plan_section">
   <div class="container">
      <div class="row">
         <div class="col text-center mt-3">
            <h1 class="font-weight-bold mt-4 text-blue">CHOOSE THE PACKAGE THAT WORKS BEST FOR YOUR BUSINESS</h1>
         </div>
      </div>
      <div class="row ml-auto py-5">
        @foreach($plans as $plan)
      
         <div class="col-lg-4">
            <div class="card bg-white vendor-plan-box">
               <h2 class="font-weight-bold heading-primary">{{ strtoupper($plan->name) }}</h2>
               <p class="text-secondary font-weight-bold">{{ $plan->package_expire }} Package</p>
               <p class="text-secondary">{{ $plan->description }}</p>
               <hr>
               <h6 class="font-weight-bold">Package price</h6>
               <div class="row d-flex">
                  <div class="col-lg-12">
                   
                     <p class="font-weight-bold heading-primary">{{config('cart.currency_symbol')}}{{ $plan->price }}</p>
                  </div>
                 
               </div>
               

               <hr>
               
              <div class="mt-4">
               
                  <a type="submit" href="{{ route('vendor.package', $plan->id ) }}" class="btn btn-lg btn-primary rounded font-weight-bold">Buy now</a>

              </div>

            </div>
         </div>
        @endforeach
      </div>
   </div>
</div>
@endif
@endsection
@section('js')
<script>
         function drawChart() {
            // Define the chart to be drawn.
            var data = google.visualization.arrayToDataTable([
               ['Month', 'Total Orders'],
                <?php echo $newData; ?>
            ]);

            var options = {title: 'Total Orders (per month)'}; 

            // Instantiate and draw the chart.
            var chart = new google.visualization.ColumnChart(document.getElementById('container'));
            chart.draw(data, options);
         }
         google.charts.setOnLoadCallback(drawChart);
</script>

@endsection
