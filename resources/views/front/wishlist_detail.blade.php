@extends('layouts.front.app')
@section('content')
    <!-- Main content -->

<section class="content ">
  <div class="row mb-5 my-account-banner">
    <div  class="col-12">
      <h2 class="text-center pt-5 pb-5 text-white font-normal">Wishlist</h2>
    </div>
  </div>
  <div class="container">
   @include('layouts.errors-and-messages')
   
       <div class="row  " >
          <div class="col-md-12">
            <div class="shopList_filter">
              <div class="row align-items-center">
                <div class="col-md-4">
                  <div class="citrus-AccountBox">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Go Live
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          
                          <a class="dropdown-item" href="{{ route('shop.listing') }}">Shop</a>
                          
                        </div>
                      </div>
                  </div>
                </div>
                    <div class="col-md-4">
                  <div class="citrus-AccountBox">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Dashboard
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{ route('accounts', ['tab' =>'v-pills-account-details']) }}">Account Details</a>
                          <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </div>
                      </div>
                  </div>
                </div>
                    <div class="col-md-4">
                  <div class="citrus-AccountBox">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Order
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{ route('accounts', ['tab' =>'v-pills-my-order']) }}">My Orders</a>
                          <a class="dropdown-item" href="{{ route('wishlist_detail') }}">Wishlist</a>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
           
          </div>
        
    </div><br>

    <div class="col-xl-12 col-lg-12 col-md-12 mb-5">
        <div class="card track-order">
              <div class="card shadow-sm rounded-0 mb-5 order-body">
              <div class="card-body">
                <div class="table-responsive">
                  @if(!$wish->isEmpty())
                  <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" class="text-dark font-16">S.NO.</th>
                        <th scope="col" class="text-dark font-16">Product Image</th>
                        <th scope="col" class="text-dark font-16">Product Name</th>
                        <th scope="col" class="text-dark font-16">Product Price</th>
                         <th scope="col" class="text-dark font-16">Date</th>
                          <th scope="col" class="text-dark font-16">Remove</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1;?>
                      @foreach ($wish as $wishlist)
                       <?php $id=$wishlist->oid; ?>
                      <tr>
                        <td>#{{$i}}</td>
                          <td> @if(isset($wishlist->cover))
                            <img class="img-responsive"
                                 src="{{ asset("storage/$wishlist->cover") }}"
                                 alt="{{ $wishlist->name }}" />
                            @else
                            <img class="img-responsive"
                                 src="{{ asset("images/placeholder-square.png") }}"
                                 alt="{{ $wishlist->name }}" />
                            @endif</td>
                        
                        <td>{{ $wishlist->name }}</td>
                        <td>{{ config('cart.currency_symbol') }}{{ isset($wishlist->sale_price) ? $wishlist->sale_price : $wishlist->price}}</td>
                        <td>{{ date('d-M-Y', strtotime($wishlist->date)) }}</td>
                         <td><a href="{{ route('wishlist_destroy',$id) }}"><i class="fa fa-trash"></i></a></td>
                       
                      </tr><?php $i++;?>
                     @endforeach
                    </tbody>
                  </table>
                  @else
                  <p class="alert alert-warning">No Products In Your Wishlist.</p>
                  @endif
                </div>
              
              </div>
            </div>
    
      </div>
    </div>
  </div>
</div>
</section>
<!-- /.content -->
@endsection