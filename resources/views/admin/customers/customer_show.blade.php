@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <h2 class="top-heading mb-4">Customer Profile Details</h2>
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
                            @if(!empty($customer->merchant_id))
                            <tr>                              
                              <td>Merchant ID</td>
                              <td>{{ $customer->merchant_id }}</td>                          
                            </tr>
                            @endif
                            @if(!empty($customer->staff_id))
                            <tr>                              
                              <td>Staff ID</td>
                              <td>{{ $customer->staff_id }}</td>                          
                            </tr>
                             @endif
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
        
     
      
       
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection