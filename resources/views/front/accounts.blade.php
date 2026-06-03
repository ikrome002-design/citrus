@extends('layouts.front.app')
@section('content')
    <!-- Main content -->
    <style type="text/css">
      .my-account-pagination {
          margin: 0 auto;
          margin-top: 40px;
      }
    </style>
  <section class="content">
  <div class="row mb-5 my-account-banner mx-0">
    <div  class="col-12">
      <h2 class="text-center pt-5 pb-5 text-white">
          <?php if($_GET['tab']=='v-pills-dashboard'){ ?>
          Dashboard 
          <?php } elseif($_GET['tab']=='v-pills-account-details'){ ?> Account Details <?php }else{?> My Orders <?php }?></h2>
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
    <div class="row my-account-body">
      <div class="col-xl-3 col-lg-3 col-md-4 mb-5" id="div_id_name" style="display:none;">
        <div class="card">
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="list-group-item list-group-item-action active" id="v-pills-dashboard-tab" data-toggle="pill" href="#v-pills-dashboard" role="tab" aria-controls="v-pills-dashboard" aria-selected="true"><i class="fa fa-tachometer mr-3" aria-hidden="true"></i>Dashboard</a>
            <a class="list-group-item list-group-item-action" id="v-pills-account-details-tab" data-toggle="pill" href="#v-pills-account-details" role="tab" aria-controls="v-pills-account-details" aria-selected="false"><i class="fa fa-user mr-3"></i>Account Details </a>
            <a class="list-group-item list-group-item-action" href="{{ route('shop.listing') }}" ><i class="fa fa-shopping-bag mr-3" aria-hidden="true"></i>Shop</a>
          
            <a class="list-group-item list-group-item-action" id="v-pills-my-order-tab" data-toggle="pill" href="#v-pills-my-order" role="tab" aria-controls="v-pills-my-order" aria-selected="false"><i class="fa fa-first-order mr-3" aria-hidden="true"></i>My orders</a>
            <a href="{{ route('wishlist_detail') }}" class="list-group-item list-group-item-action"><i class="fa fa-heart mr-3" aria-hidden="true"></i>Wishlist</a>
            <a class="nav-link heading-primary" href="{{ route('logout') }}" ><i class="fa fa-sign-out mr-3"></i>Logout</a>
       
         
          </div>
        </div>
      </div>
      <div class="col-xl-12 col-lg-12 col-md-12 mb-5">
        <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-dashboard" role="tabpanel" aria-labelledby="v-pills-dashboard-tab">
            <h3>Hello {!! $customer->first_name ?: old('first_name')  !!} (not {!! $customer->first_name ?: old('first_name')  !!}? <a class="text-success" href="{{ route('logout') }}">logout</a>)</h3>
            <p class="pt-3">Welcome to your Citrus Account.</p>
          </div>
          <div class="tab-pane fade" id="v-pills-my-order" role="tabpanel" aria-labelledby="v-pills-my-order-tab">
            <div class="card shadow-sm rounded-0 mb-5 order-body">
              <div class="card-body">
                <div class="">
                  @if(!$orders->isEmpty())
                  <table class="table table-responsive">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" class="text-dark font-16">Order ID</th>
                        <th scope="col" class="text-dark font-16">Date</th>
                        <th scope="col" class="text-dark font-16">Payment Type</th>
                        <th scope="col" class="text-dark font-16">Total</th>
                        <th scope="col" class="text-dark font-16">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                      @foreach ($orders as $order)
                      <?php 
                      $newTotAmt = $order['total'];

                       ?>
                      <tr>
                        <td><a class="text-success" href="{{ route('track-order-details',$order['id'])}}">#{{$order['reference']}}</a></td>
                        <td>{{ date('d-M-Y', strtotime($order['created_at'])) }}</td>
                        <td>Cash On Delivery</td>
                        <td>${{$newTotAmt}}</td>
                        <td><span class="rounded-pill pt-2 pb-2 pl-3 pr-3 text-white my-account-btn" style="color: #ffffff; background-color: {{ $order['status']->color }}"> {{ $order['status']->name }}</span></td>
                      </tr>
                     @endforeach
                    </tbody>
                  </table>
                  @else
                  <p class="alert alert-warning">No orders yet. <a href="{{ route('home') }}">Shop now!</a></p>
                  @endif
                </div>
              {{ $orders->links() }}
              </div>
            </div>
          </div>

       

          <div class="tab-pane fade" id="v-pills-my-addresses" role="tabpanel" aria-labelledby="v-pills-my-addresses-tab">
            <div class="row">
              <div class="col-md-12">
                <p class="font-16 text-dark pb-4">The following addresses will be used on the checkout page by default</p>
                <a  class="btn btn-success checkout-button mb-2" data-toggle="modal" data-target="#exampleModal" >
                  <i class="fa fa-plus text-white" aria-hidden="true"></i>
                  Add New Address
                </a>

              </div>

              @if(!$addresses->isEmpty())
              
               @foreach($addresses as $address)

                  @if($address->address_type=='billing')

                  <div class="col-md-6 mb-2">
                    <?php $id = $address->id; ?>
                    <div class="card">
                      <div class="card-title card-body bg-light heading-primary font-16 pl-4">Billing Address
                        <a data-toggle="modal" data-target="#exampleModal_{{$address->id}}"><i class="fa fa-pencil-square-o float-right text-success" aria-hidden="true"></i></a>
                      </div>
                      <div class="card-body pl-4">
                        <p>{{$address->first_name.' '.$address->last_name}}</p>
                        <p>{{$address->company_name}}</p>
                        <p>{{$address->alias}} {{$address->address_1}}</p>
                        <p>{{$address->address_2}}</p>
                         <p>{{$address->city}} 
                          @foreach($countries as $country)
                          @if($address->country_id == $country->id)
                          {{ $country->name }}
                          @endif
                          @endforeach
                          {{$address->zip}}</p>
                          <div class="border-dashed text-success mt-5 pt-4">
                           <a class="text-success" href="tel:{{$address->phone}}"><i class="fa fa-phone mr-2 text-dark"></i>{{$address->phone}}</a><br>
                            <a class="text-success" href="mailto:{!! $customer->email ?: old('email')  !!}"><i class="fa fa-envelope mr-2 text-dark"></i>{{$address->email}}</a>
                          </div>
                      </div>
                    </div>
                  </div>
                  @endif
                   @if($address->address_type=='shipping')
                  <?php $id = $address->id; ?>
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-title card-body bg-light heading-primary font-16 pl-4">Shipping Address
                        <a data-toggle="modal" data-target="#exampleModal_{{$address->id}}"><i class="fa fa-pencil-square-o float-right text-success" aria-hidden="true"></i></a>
                      </div>
                      <div class="card-body pl-4">
                        <p>{{$address->first_name.$address->last_name}}</p>
                        <p>{{$address->company_name}}</p>
                        <p>{{$address->alias}} {{$address->address_1}}</p>
                        <p>{{$address->address_2}}</p>
                         <p>{{$address->city}}
                          @foreach($countries as $country)
                          @if($address->country_id == $country->id)
                          {{ $country->name }}
                          @endif
                          @endforeach
                          {{$address->zip}}</p>
                          <div class="border-dashed text-success mt-5 pt-4">
                           <a class="text-success" href="tel:{{$address->phone}}"><i class="fa fa-phone mr-2 text-dark"></i>{{$address->phone}}</a><br>
                            <a class="text-success" href="mailto:{!! $customer->email ?: old('email')  !!}"><i class="fa fa-envelope mr-2 text-dark"></i>{{$address->email}}</a>
                          </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  @if(count($addresses)<1)
                  
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-title card-body bg-light heading-primary font-16 pl-4">Shipping Address
                        <a href="{{ route('customer.address.edit', [auth()->user()->id, $address->id]) }}"><i class="fa fa-pencil-square-o float-right text-success" aria-hidden="true"></i></a>
                      
                      </div>
                      <div class="card-body pl-4">
                        <p>{{$address->first_name.$address->last_name}}</p>
                        <p>{{$address->company_name}}</p>
                        <p>{{$address->alias}} {{$address->address_1}}</p>
                        <p>{{$address->address_2}}</p>
                        <p>{{$address->city}} , IN {{$address->zip}}</p>
                        <p>{{$address->country->name}}</p>
                          <div class="border-dashed text-success mt-5 pt-4">
                           <a class="text-success" href="tel:{{$address->phone}}"><i class="fa fa-phone mr-2 text-dark"></i>{{$address->phone}}</a><br>
                            <a class="text-success" href="mailto:{!! $customer->email ?: old('email')  !!}"><i class="fa fa-envelope mr-2 text-dark"></i>{{$address->email}}</a>
                          </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="exampleModal_{{$address->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Edit address</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                         
                           <form action="{{ route('customer.address.update', [$customer->id, $address->id]) }}" method="post" class="form" enctype="multipart/form-data">
                                <input type="hidden" name="status" value="1">
                                <input type="hidden" id="address_country_id" value="{{ $address->country_id }}">
                                <input type="hidden" id="address_province_id" value="{{ $address->province_id }}">
                                <input type="hidden" id="address_state_code" value="{{ $address->state_code }}">
                                <input type="hidden" id="address_city" value="{{ $address->city }}">
                                <input type="hidden" name="_method" value="put">
                                <div class="box-body">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                       <div class="row">
                                        <div class="col-md-6">
                                          <label for="first_name">First name <span class="text-danger">*</span></label>
                                          <input type="text" name="first_name" id="first_name" placeholder="First name" class="form-control border-light bg-light text-left" value="{{ old('first_name') ?? $address->first_name}}">
                                        </div>
                                        <div class="col-md-6">
                                          <label for="last_name">Last name <span class="text-danger">*</span></label>
                                          <input type="text" name="last_name" id="last_name" placeholder="Last name" class="form-control border-light bg-light text-left" value="{{ old('last_name') ?? $address->last_name }}">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                          <label>Company name(optional)</label>
                                          <input id="company_name" type="text" class="form-control border-light bg-light text-left" name="company_name" value="{{ old('company_name') ?? $address->company_name}}" placeholder="Company name"> 
                                    </div>

                                    <div class="form-group">
                                        <label for="alias">Alias <span class="text-danger">*</span></label>
                                        <input type="text" name="alias" id="alias" placeholder="Home or Office" class="form-control border-light bg-light text-left" value="{{ old('alias') ?? $address->alias }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address_1">Address 1 <span class="text-danger">*</span></label>
                                        <input type="text" name="address_1" id="address_1" placeholder="Address 1" class="form-control border-light bg-light text-left" value="{{ old('address_1') ?? $address->address_1 }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address_2">Address 2 </label>
                                        <input type="text" name="address_2" id="address_2" placeholder="Address 2" class="form-control border-light bg-light text-left" value="{{ old('address_2') ?? $address->address_2 }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="country_id">Country </label><br>
                                        <select name="country_id" id="country_id" class="form-control select2 border-light bg-light text-left">
                                            @foreach($countries as $country)
                                                <option @if($address->country_id == $country->id) selected="selected" @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                      <div class="form-row">
                                      <!-- <div class="col-md-6 form-group">
                                        <label>Town / City <span class="text-danger">*</span></label>
                                        <input id="city" type="text" class="form-control border-mute rounded-0 bg-light text-left city" name="city" value="{{ old('city') ?? $address->city }}">
                                      </div> -->
                                      <div class="col-md-12 form-group">
                                        <label>Postal Code <span class="text-danger">*</span></label>
                                           <input type="text" name="zip" id="zip" placeholder="Postal code" class="form-control border-light bg-light text-left" value="{{ old('zip') ?? $address->zip }}" required>
                                      </div>
                                  </div>
                                    <div class="form-group">
                                        <label for="phone">Your Phone </label>
                                        <input type="text" name="phone" id="phone" placeholder="Phone number" class="form-control border-light bg-light text-left" value="{{ old('phone') ?? $address->phone }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email </label>
                                        <input type="email" name="email" id="email" placeholder="Email" class="form-control border-light bg-light text-left" value="{{ old('email') ?? $address->email }}">
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                 <div class="box-footer">
                                    <div class="btn-group">
                                        <a data-dismiss="modal" aria-label="Close" class="btn btn-default ">Back</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                   <div class="modal fade" id="exampleModal_{{$address->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Edit address</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          @if(!$addresses->isEmpty())
                           
                           <form action="{{ route('customer.address.update', [$customer->id, $address->id]) }}" method="post" class="form" enctype="multipart/form-data">
                                <input type="hidden" name="status" value="1">
                                <input type="hidden" id="address_country_id" value="{{ $address->country_id }}">
                                <input type="hidden" id="address_province_id" value="{{ $address->province_id }}">
                                <input type="hidden" id="address_state_code" value="{{ $address->state_code }}">
                                <input type="hidden" id="address_city" value="{{ $address->city }}">
                                <input type="hidden" name="_method" value="put">
                                <div class="box-body">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="alias">First Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" placeholder="First Name" id="first_name" class="form-control border-light bg-light text-left" value="{{ old('first_name') ?? $address->first_name }}" oninvalid="this.setCustomValidity('Enter first name" oninput="this.setCustomValidity('')" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" placeholder="Last Name" id="last_name"  class="form-control border-light bg-light text-left" value="{{ old('last_name') ?? $address->last_name}}" oninvalid="this.setCustomValidity('Enter last name')" oninput="this.setCustomValidity('')" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="alias">Alias <span class="text-danger">*</span></label>
                                        <input type="text" name="alias" id="alias" placeholder="Home or Office" class="form-control border-light bg-light text-left" value="{{ old('alias') ?? $address->alias }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address_1">Address 1 <span class="text-danger">*</span></label>
                                        <input type="text" name="address_1" id="address_1" placeholder="Address 1" class="form-control border-light bg-light text-left" value="{{ old('address_1') ?? $address->address_1 }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address_2">Address 2 </label>
                                        <input type="text" name="address_2" id="address_2" placeholder="Address 2" class="form-control border-light bg-light text-left" value="{{ old('address_2') ?? $address->address_2 }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="country_id">Country </label><br>
                                        <select name="country_id" id="country_id" class="form-control border-light bg-light text-left select2">
                                            @foreach($countries as $country)
                                                <option @if($address->country_id == $country->id) selected="selected" @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="zip">Postal Code <span class="text-danger">*</span></label>
                                        <input type="text" name="zip" id="zip" placeholder="Postal code" class="form-control border-light bg-light text-left" value="{{ old('zip') ?? $address->zip }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Your Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" id="phone" placeholder="Phone number" class="form-control border-light bg-light text-left" value="{{ old('phone') ?? $address->phone }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Your Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" placeholder="Email" class="form-control border-light bg-light text-left" value="{{ old('email') ?? $address->email }}" required>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                 <div class="box-footer editAddBut">
                                    <div class="btn-group">
                                        <a data-dismiss="modal" aria-label="Close" class="btn btn-danger mr-2">Back</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
              @endforeach
              @else
              <div class="col-md-6">
                  <div class="card">
                    <div class="card-title card-body bg-light heading-primary font-16 pl-4">Billing Address 
                      <a  data-toggle="modal" data-target="#exampleModal" ><i class="fa fa-pencil-square-o float-right text-success" aria-hidden="true"></i></a>
                    </div>
                     
                  </div>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Address</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                           <form action="{{ route('customer.address.store', $customer->id) }}" method="post" class="form" enctype="multipart/form-data">
                                <input type="hidden" name="status" value="1">
                                <div class="box-body">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                       <div class="row">
                                        <div class="col-md-6">
                                          <label for="first_name">First name <span class="text-danger">*</span></label>
                                          <input type="text" name="first_name" id="first_name" placeholder="First name" class="form-control border-light bg-light text-left" value="{{ old('first_name') }}">
                                        </div>
                                        <div class="col-md-6">
                                          <label for="last_name">Last name <span class="text-danger">*</span></label>
                                          <input type="text" name="last_name" id="last_name" placeholder="Last name" class="form-control border-light bg-light text-left" value="{{ old('last_name') }}">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                          <label>Company name(optional)</label>
                                          <input id="company_name" type="text" class="form-control border-light bg-light text-left" name="company_name" value="{{ old('company_name') }}" placeholder="Company name"> 
                                    </div>
                                    <div class="form-group">
                                        <label for="alias">Alias <span class="text-danger">*</span></label>
                                        <input type="text" name="alias" id="alias" placeholder="Home or Office" class="form-control border-light bg-light text-left" value="{{ old('alias') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="country_id">Country </label><br>
                                        <select name="country_id" id="country_id" class="form-control select2 border-light bg-light text-left">
                                            @foreach($countries as $country)
                                                <option @if(env('SHOP_COUNTRY_ID') == $country->id) selected="selected" @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_1">Street address 1<span class="text-danger">*</span></label>
                                        <input type="text" name="address_1" id="address_1" placeholder="Address 1" class="form-control border-light bg-light text-left" value="{{ old('address_1') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address_2">Street address 2 </label>
                                        <input type="text" name="address_2" id="address_2" placeholder="Address 2" class="form-control border-light bg-light text-left" value="{{ old('address_2') }}">
                                    </div>

                                    <div class="form-row">
                                     <!--  <div class="col-md-6 form-group">
                                        <label>Town / City</label>
                                        <input id="city" type="text" class="form-control border-mute rounded-0 bg-light text-left city" name="city">
                                      </div> -->
                                      <div class="col-md-12 form-group">
                                        <label>Postal Code <span class="text-danger">*</span></label>
                                           <input type="text" name="zip" id="zip" placeholder="Postal code" class="form-control border-light bg-light text-left" value="{{ old('zip') }}" required>
                                      </div>
                                  </div>
                                    <div class="form-group">
                                        <label for="phone">Your Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control border-light bg-light text-left" value="{{ old('phone') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" placeholder="Email" class="form-control border-light bg-light text-left" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="btn-group">
                                        <a href="{{ route('accounts', ['tab' => 'address']) }}" class="btn btn-default">Back</a>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
              @endif
            </div>
          </div>
          <div class="tab-pane fade" id="v-pills-account-details" role="tabpanel" aria-labelledby="v-pills-account-details-tab">
          
            <div class="row">
              <div class="col-12">
                  <form class="form-horizontal" role="form" method="POST" action="{{ route('accounts.profile.update') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="put">
                    {{ csrf_field() }}

                    <div class="card shadow-sm rounded-0 my-account-detail-form">

                      <div class="card-body">
                         <h2 class="text-center">Customer Account Details</h2><br>
                        <div class="form-group text-center">
                          <div id="userActions" class="rounded-lg cursor-pointer bg-white mx-auto text-center d-inline-block p-4">   <label for="fileUpload">
                                  @if($customer->avatar !='')         
                                      <img id="imgPrime" src="{{ asset('public/storage/profile/customer/'.$customer->avatar.'') }}" alt="{!! $customer->name ?: old('name')  !!}" height="100" width="100"> 
                                  @else
                                      <img id="imgPrime" src="{{ asset('images/dummy-user.png')}}" alt="{!! $customer->name ?: old('name')  !!}" height="100" width="100">
                                  @endif
                                  <p class="m-2"><!-- Change profile photo --></p>
                              <input type="file" id="fileUpload" name="avatar" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
                              </label>
                          </div>
                        </div>
                       <div class="form-group">
                        <label for="inputAddress">First Name</label>
                        <input type="text" class="form-control" name="first_name" value="{{ $customer->first_name }}" required="">
                      </div>
                       <div class="form-group">
                        <label for="inputAddress">Last Name</label>
                        <input type="text" class="form-control" name="last_name" value="{{ $customer->last_name }}" required="">
                      </div>
                       <div class="form-group">
                        <label for="inputAddress">Email</label>
                        <input type="text" class="form-control" readonly="" value="{{ $customer->email }}" >
                      </div>
                       <div class="form-group">
                        <label for="inputAddress">National ID</label>
                        <input type="text" class="form-control" name="national_id" value="{{ $customer->national_id }}" required="">
                      </div>
                       <div class="form-group">
                        <label for="inputAddress">Date of birth</label>
                        <input type="text" class="form-control" name="dob" value="{{ $customer->dob }}" required="" >
                      </div>

                      <div class="form-group col-md-6">
                         <label for="inputZip">Gender</label>
                        <div class="form-check">
                        <?php if($customer->gender==0){?>
                        <input type="radio" class="form-check-input" name="gender" value="0" checked="">Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <input type="radio" class="form-check-input" name="gender" value="1" >Female
                    <?php }else{?>
                       <input type="radio" class="form-check-input" name="gender" value="0" >Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <input type="radio" class="form-check-input" name="gender" value="1" checked="">Female
                    <?php }?>
                      </div>
                      </div>
                       <div class="form-group">
                        <label for="inputAddress">Phone number</label>
                        <input type="text" class="form-control" readonly="" value="{{ $customer->phone_number }}" >
                      </div>
                       <div class="form-group">
                        <label for="inputAddress">Country</label>
                        <!-- <input type="text" class="form-control" readonly="" value="{{ $customer->country }}" > -->
                         <select id="inputState" class="form-control" name="country" >
                          <option value="{{$customer->cid}}" >{{$customer->cname}}</option>
                             @foreach($countriess as $country)
                            <option value="{{$country->id}}" >{{$country->name}}</option>
                            @endforeach
                          </select>
                      </div>
                       
                        
                        <!-- <div class="form-group">
                          
                          <select class="form-control border-light bg-light text-left" id="newsletter" name="newsletter">
                            <option value="0" {{ $customer->newsletter == 1 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ $customer->newsletter == 1 ? 'selected' : '' }}>Yes</option>
                            
                          </select>
                          <span class="text-muted">Newsletter preferences</span>
                        </div> -->
                          
                   <h2 class="text-success mt-4 pt-3 heading-primary text-uppercase">Change Your Password</h2>
                        <div class="form-group">
                          <input id="password-current" type="password" class="form-control border-light bg-light text-left" name="old-password" placeholder="Current Password">
                        </div>
                        <div class="form-group">
                          <input id="password" type="password" class="form-control border-light bg-light text-left" name="password" placeholder="New Password">
                        </div>
                        <div class="form-group">
                          <input id="password-confirm" type="password" class="form-control border-light bg-light text-left" name="confirm-password" placeholder="Confirm New Password">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-success mt-5 pl-3 pr-3 rounded-0 float-right">
                              SAVE CHANGES
                          </button>
                        </div> 
                      </div>
                    </div>
                  </form>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="v-pills-my-wishlist" role="tabpanel" aria-labelledby="v-pills-my-wishlist-tab">
            <div class="card shadow-sm rounded-0 mb-5 order-body">
              <div class="card-body">
                <div class="table-responsive">
                  @if(!$orders->isEmpty())
                  <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" class="text-dark font-16">Order ID</th>
                        <th scope="col" class="text-dark font-16">Date</th>
                        <th scope="col" class="text-dark font-16">Payment Status</th>
                        <th scope="col" class="text-dark font-16">Total</th>
                        <th scope="col" class="text-dark font-16">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orders as $order)

                      <tr>
                        <td><a class="text-success" href="{{ route('track-order-details',$order['id'])}}">#{{$order['reference']}}</a></td>
                        <td>{{ date('d-M-Y', strtotime($order['created_at'])) }}</td>
                        <td>{{ ucfirst($order['payment']) }}</td>
                        <td>${{$order['total']}}</td>
                        <td><span class="rounded-pill pt-2 pb-2 pl-3 pr-3 text-white my-account-btn" style="color: #ffffff; background-color: {{ $order['status']->color }}"> {{ $order['status']->name }}</span></td>
                      </tr>
                     @endforeach
                    </tbody>
                  </table>
                  @else
                  <p class="alert alert-warning">No orders yet. <a href="{{ route('home') }}">Shop now!</a></p>
                  @endif
                </div>
              {{ $orders->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Address</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <form action="{{ route('customer.address.store', $customer->id) }}" method="post" class="form" enctype="multipart/form-data">
                <input type="hidden" name="status" value="1">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                       <label for="alias">Address Type <span class="text-danger">*</span></label>
                       <select name="address_type" class="form-control border-light bg-light text-left" id="address_type" oninvalid="this.setCustomValidity('Please select address type')" oninput="setCustomValidity('')" required>
                        <option value="">Address Type</option>
                        <option value="billing">Billing</option>
                        <option value="shipping">Shipping</option>
                       
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="alias">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" placeholder="First Name" id="first_name" class="form-control border-light bg-light text-left" value="{{ old('first_name') }}" oninvalid="this.setCustomValidity('Enter first name" oninput="this.setCustomValidity('')" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" placeholder="Last Name" id="last_name"  class="form-control border-light bg-light text-left" value="{{ old('last_name') }}" oninvalid="this.setCustomValidity('Enter last name')" oninput="this.setCustomValidity('')" required>
                    </div>

                    <div class="form-group">
                        <label for="alias">Alias <span class="text-danger">*</span></label>
                        <input type="text" name="alias" id="alias" placeholder="Home or Office" class="form-control border-light bg-light text-left" value="{{ old('alias') }}" oninvalid="this.setCustomValidity('Enter alias')" oninput="this.setCustomValidity('')" required>
                    </div>
                    <div class="form-group">
                        <label for="address_1">Address 1 <span class="text-danger">*</span></label>
                        <input type="text" name="address_1" id="address_1" placeholder="Address 1" class="form-control border-light bg-light text-left" value="{{ old('address_1') }}" oninvalid="this.setCustomValidity('Enter Address 1')" oninput="this.setCustomValidity('')" required>
                    </div>
                    <div class="form-group">
                        <label for="address_2">Address 2 </label>
                        <input type="text" name="address_2" id="address_2" placeholder="Address 2" class="form-control border-light bg-light text-left" value="{{ old('address_2') }}">
                    </div>
                    <div class="form-group">
                        <label for="country_id">Country </label><br>
                        <select name="country_id" id="country_id" class="form-control select2 border-light bg-light text-left">
                            @foreach($countries as $country)
                                <option @if(env('SHOP_COUNTRY_ID') == $country->id) selected="selected" @endif value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="provinces" class="form-group" style="display: none;"></div>
                    <div id="cities" class="form-group" style="display: none;"></div>
                    <div class="form-group">
                        <label for="zip">Postal Code <span class="text-danger">*</span></label>
                        <input type="text" name="zip" id="zip" placeholder="Postal code" class="form-control border-light bg-light text-left" value="{{ old('zip') }}" oninvalid="this.setCustomValidity('Enter zipcode')" oninput="this.setCustomValidity('')" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Your Phone <span class="text-danger">*</span> </label>
                        <input type="text" name="phone" id="phone" placeholder="Phone number" class="form-control border-light bg-light text-left" value="{{ old('phone') }}" oninvalid="this.setCustomValidity('Enter phone')" oninput="this.setCustomValidity('')" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Your Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" placeholder="Email" class="form-control border-light bg-light text-left" value="{{ old('email') }}" oninvalid="this.setCustomValidity('Enter email')" oninput="this.setCustomValidity('')" required>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer editAddBut">
                    <div class="btn-group">
                        <a href="{{ route('accounts', ['tab' => 'address']) }}" class="btn btn-danger mr-2">Back</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
  {{--<div class="modal fade" id="exampleModal_{{$address->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit address</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              @if(!$addresses->isEmpty())
               
               <form action="{{ route('customer.address.update', [$customer->id, $address->id]) }}" method="post" class="form" enctype="multipart/form-data">
                    <input type="hidden" name="status" value="1">
                    <input type="hidden" id="address_country_id" value="{{ $address->country_id }}">
                    <input type="hidden" id="address_province_id" value="{{ $address->province_id }}">
                    <input type="hidden" id="address_state_code" value="{{ $address->state_code }}">
                    <input type="hidden" id="address_city" value="{{ $address->city }}">
                    <input type="hidden" name="_method" value="put">
                    <div class="box-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="alias">Alias <span class="text-danger">*</span></label>
                            <input type="text" name="alias" id="alias" placeholder="Home or Office" class="form-control border-light bg-light text-left" value="{{ old('alias') ?? $address->alias }}">
                        </div>
                        <div class="form-group">
                            <label for="address_1">Address 1 <span class="text-danger">*</span></label>
                            <input type="text" name="address_1" id="address_1" placeholder="Address 1" class="form-control border-light bg-light text-left" value="{{ old('address_1') ?? $address->address_1 }}">
                        </div>
                        <div class="form-group">
                            <label for="address_2">Address 2 </label>
                            <input type="text" name="address_2" id="address_2" placeholder="Address 2" class="form-control border-light bg-light text-left" value="{{ old('address_2') ?? $address->address_2 }}">
                        </div>
                        <div class="form-group">
                            <label for="country_id">Country </label><br>
                            <select name="country_id" id="country_id" class="form-control border-light bg-light text-left select2">
                                @foreach($countries as $country)
                                    <option @if($address->country_id == $country->id) selected="selected" @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="provinces" class="form-group" style="display: none;"></div>
                        <div id="cities" class="form-group" style="display: none;"></div>
                        <div class="form-group">
                            <label for="zip">Postal Code </label>
                            <input type="text" name="zip" id="zip" placeholder="Postal code" class="form-control border-light bg-light text-left" value="{{ old('zip') ?? $address->zip }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Your Phone </label>
                            <input type="text" name="phone" id="phone" placeholder="Phone number" class="form-control border-light bg-light text-left" value="{{ old('phone') ?? $address->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Your Email </label>
                            <input type="email" name="email" id="email" placeholder="Email" class="form-control border-light bg-light text-left" value="{{ old('email') ?? $address->email }}">
                        </div>
                    </div>
                    <!-- /.box-body -->
                     <div class="box-footer">
                        <div class="btn-group">
                            <a href="{{ route('accounts', ['tab' => 'v-pills-my-addresses-tab']) }}" class="btn btn-default">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
              @endif
            </div>
          </div>
        </div>
      </div>--}}
</section>
    <!-- /.content -->
@endsection
@section('js')
<script type="text/javascript">
  var getUrlParameter = function getUrlParameter(sParam) {


    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};
  var tab = getUrlParameter('tab');
  console.log('tab',tab);
  $('#v-pills-tab a[href="#'+tab+'"]').tab('show')
</script>

 
@endsection